@extends('principal.master')

@section('content')

{{ \Session::put('titulo', 'Questionários') }}
@if ($tipo_operacao=="incluir")
    {{ \Session::put('subtitulo', 'Inclusão') }}
@else
    {{ \Session::put('subtitulo', 'Alteração / Visualização') }}
@endif
{{ \Session::put('route', 'questionarios') }}
{{ \Session::put('id_pagina', '57') }}


<div class = 'row'>

    <div class="col-md-12">

        <div>
            <a href={{ url('/' . \Session::get('route')) }} class="btn btn-default"><i class="fa fa-arrow-circle-left"></i> Voltar</a>
        </div>

        @if ($tipo_operacao=="incluir")
            <form method = 'POST'  class="form-horizontal" action = "{{ url('/' . \Session::get('route') . '/gravar')}}">
        @else
            <form method = 'POST' class="form-horizontal"  action = "{{ url('/' . \Session::get('route') . '/' . $dados->id . '/update')}}">
        @endif


        {!! csrf_field() !!}

            <div class="box box-primary">

                 <div class="box-body"> <!--anterior box-body-->


                            <div class="row{{ $errors->has('pergunta') ? ' has-error' : '' }}">
                                    <div class="col-xs-10">
                                          <label for="pergunta" class="control-label">Pergunta</label>

                                          @if ($tipo_operacao=="incluir")
                                                <input id="pergunta" maxlength="60"  name = "pergunta" type="text" class="form-control" value="">
                                          @else
                                                <input id="pergunta" maxlength="60"  name = "pergunta" type="text" class="form-control" value="{{ $dados->pergunta }}">
                                          @endif

                                             <!-- se houver erros na validacao do form request -->
                                             @if ($errors->has('pergunta'))
                                              <span class="help-block">
                                                  <strong>{{ $errors->first('pergunta') }}</strong>
                                              </span>
                                             @endif

                                    </div>
                            </div>

                            <div class="row">
                                  <div class="col-xs-10">
                                      <label for="tipo" class="control-label">Como deseja que seja a resposta ?</label>
                                      @if ($tipo_operacao=="incluir")
                                            <select id="tipo" name="tipo" placeholder="(Selecionar)" data-live-search="true" data-none-selected-text="Nenhum item selecionado" class="form-control selectpicker" style="width: 100%;">
                                            <option  value="1">Campo de Seleção : Sim / Não</option>
                                            <option  value="2">Campo Numérico (Aparecerá sumarizado em relatórios e estatísticas)</option>
                                            <option  value="3">Campo Texto</option>
                                            </select>
                                      @else
                                            <select id="tipo" name="tipo" placeholder="(Selecionar)" data-live-search="true" data-none-selected-text="Nenhum item selecionado" class="form-control selectpicker" style="width: 100%;">
                                            <option  value=""></option>
                                            <option  value="1" {{($dados->tipo_resposta==1 ? "selected" : "")}}>Campo de Seleção : Sim / Não</option>
                                            <option  value="2" {{($dados->tipo_resposta==2 ? "selected" : "")}}>Campo Numérico</option>
                                            <option  value="3" {{($dados->tipo_resposta==3 ? "selected" : "")}}>Campo Texto</option>
                                            </select>
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