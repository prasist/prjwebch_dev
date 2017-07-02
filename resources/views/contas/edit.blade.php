@extends('principal.master')

@section('content')

{{ \Session::put('titulo', 'Contas Correntes') }}
{{ \Session::put('subtitulo', 'Alteração / Visualização') }}
{{ \Session::put('route', 'contas') }}
{{ \Session::put('id_pagina', '48') }}

<div class = 'row'>

    <div class="col-md-12">

        <div>
            <a href="{{ url('/' . \Session::get('route')) }}" class="btn btn-default"><i class="fa fa-arrow-circle-left"></i> Voltar</a>
        </div>

        <form method = 'POST' class="form-horizontal"  action = "{{ url('/' . \Session::get('route') . '/' . $dados->id . '/update')}}">

        {!! csrf_field() !!}

            <div class="box box-primary">

                 <div class="box-body"> <!--anterior box-body-->

                            <div class="row{{ $errors->has('nome') ? ' has-error' : '' }}">
                                    <div class="col-xs-7">
                                          <label for="nome" class="control-label">Descrição</label>

                                          <input id="nome" maxlength="60"  name = "nome" type="text" class="form-control" value="{{ $dados->nome }}">

                                             <!-- se houver erros na validacao do form request -->
                                             @if ($errors->has('nome'))
                                              <span class="help-block">
                                                  <strong>{{ $errors->first('nome') }}</strong>
                                              </span>
                                             @endif

                                    </div>

                                    <div class="col-xs-3">
                                           <label for="codigo_contabil" class="control-label">Código Contábil</label>
                                           <input id="codigo_contabil"  name = "codigo_contabil" type="text" class="form-control" value="{{$dados->codigo_contabil}}">
                                    </div>


                            </div>

                             <div class="row">
                                    <div class="col-xs-2">
                                         <label for="saldo" class="control-label">Saldo Inicial</label>
                                         <div class="input-group">
                                            <span class="input-group-addon">R$</span>
                                            <input id="saldo" maxlength="14"  placeholder="" name = "saldo" type="text" class="formata_valor form-control" value="{{$dados->saldo }}">
                                         </div>
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