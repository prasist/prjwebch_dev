@extends('principal.master')

@section('content')

{{ \Session::put('titulo', 'Cursos / Eventos') }}
@if ($tipo_operacao=="incluir")
    {{ \Session::put('subtitulo', 'Inclusão') }}
@else
    {{ \Session::put('subtitulo', 'Alteração / Visualização') }}
@endif
{{ \Session::put('route', 'cursos') }}
{{ \Session::put('id_pagina', '66') }}


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
                                    <div class="col-xs-10">
                                          <label for="nome" class="control-label">Descrição</label>

                                          @if ($tipo_operacao=="incluir")
                                                <input id="nome"  name = "nome" type="text" class="form-control" value="">
                                          @else
                                                <input id="nome"  name = "nome" type="text" class="form-control" value="{{ $dados->nome }}">
                                          @endif

                                             <!-- se houver erros na validacao do form request -->
                                             @if ($errors->has('nome'))
                                              <span class="help-block">
                                                  <strong>{{ $errors->first('nome') }}</strong>
                                              </span>
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
<script type="text/javascript">
    $(document).ready(function() {
        $("#menu_cadastros_base").addClass("treeview active");
    });
</script>
@endsection