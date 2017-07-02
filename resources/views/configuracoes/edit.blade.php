@extends('principal.master')

@section('content')

{{ \Session::put('titulo', 'Configurações') }}
{{ \Session::put('subtitulo', 'Inclusão') }}
{{ \Session::put('route', 'configuracoes') }}
{{ \Session::put('id_pagina', '41') }}

<div class = 'row'>

    <div class="col-md-12">

    <div>
            <a href={{ url('/' . \Session::get('route')) }} class="btn btn-default"><i class="fa fa-arrow-circle-left"></i> Voltar</a>
    </div>

     <form method = 'POST' class="form-horizontal"  action = {{ url('/' . \Session::get('route') . '/' . $dados->id . '/update')}}>

       {!! csrf_field() !!}

        <div class="box box-primary">

                 <div class="box-body">

                            <div class="row {{ $errors->has('nivel1') ? ' has-error' : '' }}">
                                    <div class="col-xs-10">
                                          <label for="nivel1" class="control-label">Label Estrutura Células - Nível I</label>
                                          <input id="nivel1"  name = "nivel1" type="text" class="form-control" value="{{ $dados->celulas_nivel1_label }}">

                                            <!-- se houver erros na validacao do form request -->
                                             @if ($errors->has('nivel1'))
                                              <span class="help-block">
                                                  <strong>{{ $errors->first('nivel1') }}</strong>
                                              </span>
                                             @endif
                                    </div>
                            </div>

                            <div class="row {{ $errors->has('nivel2') ? ' has-error' : '' }}">
                                    <div class="col-xs-10">
                                          <label for="nivel2" class="control-label">Label Estrutura Células - Nível II</label>
                                          <input id="nivel2"  name = "nivel2" type="text" class="form-control" value="{{ $dados->celulas_nivel2_label }}">

                                          <!-- se houver erros na validacao do form request -->
                                             @if ($errors->has('nivel2'))
                                              <span class="help-block">
                                                  <strong>{{ $errors->first('nivel1') }}</strong>
                                              </span>
                                             @endif

                                    </div>
                            </div>

                            <div class="row {{ $errors->has('nivel3') ? ' has-error' : '' }}">
                                    <div class="col-xs-10">
                                          <label for="nivel3" class="control-label">Label Estrutura Células - Nível III</label>
                                          <input id="nivel3"  name = "nivel3" type="text" class="form-control" value="{{ $dados->celulas_nivel3_label }}">
                                          <!-- se houver erros na validacao do form request -->
                                             @if ($errors->has('nivel3'))
                                              <span class="help-block">
                                                  <strong>{{ $errors->first('nivel3') }}</strong>
                                              </span>
                                             @endif
                                    </div>
                            </div>

                            <div class="row {{ $errors->has('nivel4') ? ' has-error' : '' }}">
                                    <div class="col-xs-10">
                                          <label for="nivel4" class="control-label">Label Estrutura Células - Nível IV</label>
                                          <input id="nivel4"  name = "nivel4" type="text" class="form-control" value="{{ $dados->celulas_nivel4_label }}">
                                          <!-- se houver erros na validacao do form request -->
                                             @if ($errors->has('nivel4'))
                                              <span class="help-block">
                                                  <strong>{{ $errors->first('nivel4') }}</strong>
                                              </span>
                                             @endif
                                    </div>
                            </div>

                            <div class="row {{ $errors->has('nivel5') ? ' has-error' : '' }}">
                                    <div class="col-xs-10">
                                          <label for="nivel5" class="control-label">Label Estrutura Células - Nível V</label>
                                          <input id="nivel5"  name = "nivel5" type="text" class="form-control" value="{{ $dados->celulas_nivel5_label }}">
                                          <!-- se houver erros na validacao do form request -->
                                             @if ($errors->has('nivel5'))
                                              <span class="help-block">
                                                  <strong>{{ $errors->first('nivel5') }}</strong>
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


    </div>

</div>
<script type="text/javascript">
    $(document).ready(function() {
        $("#menu_celulas").addClass("treeview active");
    });
</script>
@endsection