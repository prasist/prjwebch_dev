@extends('principal.master')

@section('content')

{{ \Session::put('titulo', 'Tipos de Pessoas') }}
{{ \Session::put('subtitulo', 'Inclusão') }}
{{ \Session::put('route', 'tipospessoas') }}
{{ \Session::put('id_pagina', '29') }}

<div class = 'row'>

    <div class="col-md-12">

    <div>
            <a href={{ url('/' . \Session::get('route')) }} class="btn btn-default"><i class="fa fa-arrow-circle-left"></i> Voltar</a>
    </div>

     <form method = 'POST'  class="form-horizontal" action = {{ url('/' . \Session::get('route') . '/gravar')}}>

        {!! csrf_field() !!}

            <div class="box box-primary">

                 <div class="box-body"> <!--anterior box-body-->

                          <input  name="fisica" type="hidden"  value="false" />
                          <input  name="juridica" type="hidden"  value="false" />
                          <input  name="membro" type="hidden"  value="false" />

                           <div class="row">
                                    <div class="col-xs-3">
                                          <label for="fisica" class="control-label">Pessoa Física</label>
                                          <input  name="fisica" type="checkbox" class="acessar" value="true"  />
                                    </div>

                                    <div class="col-xs-3">
                                          <label for="juridica" class="control-label">Pessoa Jurídica</label>
                                          <input  name="juridica" type="checkbox" class="acessar" value="true"  />
                                    </div>

                                    <div class="col-xs-3">
                                          <label for="membro" class="control-label">Membro</label>
                                          <input  name="membro" type="checkbox" class="acessar" value="true" />
                                    </div>

                            </div>


                            <div class="row{{ $errors->has('name') ? ' has-error' : '' }}">
                                    <div class="col-xs-10">
                                          <label for="name" class="control-label">Descrição</label>

                                          <input id="name" maxlength="50"  name = "name" type="text" class="form-control" value="{{ old('descricao') }}">

                                             <!-- se houver erros na validacao do form request -->
                                             @if ($errors->has('name'))
                                              <span class="help-block">
                                                  <strong>{{ $errors->first('name') }}</strong>
                                              </span>
                                             @endif

                                    </div>
                            </div>


            </div><!-- fim box-body"-->
        </div><!-- box box-primary -->

        <div class="box-footer">
            <button class = 'btn btn-primary' type ='submit'><i class="fa fa-save"></i> Salvar</button>
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