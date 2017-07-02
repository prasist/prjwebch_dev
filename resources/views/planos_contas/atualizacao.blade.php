@extends('principal.master')

@section('content')

{{ \Session::put('titulo', 'Planos de Contas') }}
@if ($tipo_operacao=="incluir")
    {{ \Session::put('subtitulo', 'Inclusão') }}
@else
    {{ \Session::put('subtitulo', 'Alteração / Visualização') }}
@endif

{{ \Session::put('route', 'planos_contas') }}
{{ \Session::put('id_pagina', '49') }}


<div class = 'row'>

    <div class="col-md-12">

        <div>
            <a href="{{ url('/' . \Session::get('route')) }}" class="btn btn-default"><i class="fa fa-arrow-circle-left"></i> Voltar</a>
        </div>

        @if ($tipo_operacao=="incluir")
            <form method = 'POST'  class="form-horizontal" action = "{{ url('/' . \Session::get('route') . '/gravar')}}">
        @else
            <form method = 'POST' class="form-horizontal"  action = "{{ url('/' . \Session::get('route') . '/' . $dados->id . '/update')}}">
        @endif

        {!! csrf_field() !!}

            <div class="box box-primary">

                 <div class="box-body"> <!--anterior box-body-->

                            <div class="row{{ $errors->has('nome') ? ' has-error' : '' }}">
                                    <div class="col-xs-7">
                                          <label for="nome" class="control-label">Descrição</label>

                                          @if ($tipo_operacao=="incluir")
                                            <input id="nome" maxlength="60"  name = "nome" type="text" class="form-control" value="{{ old('nome') }}">
                                          @else
                                            <input id="nome" maxlength="60"  name = "nome" type="text" class="form-control" value="{{ $dados->nome }}">
                                          @endif

                                             <!-- se houver erros na validacao do form request -->
                                             @if ($errors->has('nome'))
                                              <span class="help-block">
                                                  <strong>{{ $errors->first('nome') }}</strong>
                                              </span>
                                             @endif

                                    </div>

                                    <div class="col-xs-3">
                                           <label for="codigo_contabil" class="control-label">Código Contábil</label>
                                           @if ($tipo_operacao=="incluir")
                                                <input id="codigo_contabil"  name = "codigo_contabil" type="text" class="form-control" value="{{old('codigo_contabil')}}">
                                           @else
                                                <input id="codigo_contabil"  name = "codigo_contabil" type="text" class="form-control" value="{{$dados->codigo_contabil}}">
                                           @endif
                                    </div>


                            </div>


            </div><!-- fim box-body"-->
        </div><!-- box box-primary -->

        <div class="box-footer">
            <button class = 'btn btn-primary' type ='submit' {{ ($preview=='true' ? 'disabled=disabled' : "" ) }}><i class="fa fa-save"></i> Salvar</button>
            <a href="{{ url('/' . \Session::get('route') )}}" class="btn btn-default">Cancelar</a>
        </div>

       </form>

    </div><!-- <col-md-12 -->

</div><!-- row -->


@endsection