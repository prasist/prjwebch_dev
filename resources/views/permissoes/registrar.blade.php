@extends('principal.master')

@section('content')

{{ \Session::put('titulo', 'Permissões do Grupo') }}
{{ \Session::put('subtitulo', 'Inclusão') }}
{{ \Session::put('route', 'permissoes') }}


<div class = 'row'>

    <div class="col-md-12">

      <div>
            <a href="{{ url('/permissoes')}}" class="btn btn-default"><i class="fa fa-arrow-circle-left"></i> Voltar</a>
      </div>

        <form method = 'POST'  class="form-horizontal" action = {{ url('/permissoes/gravar')}}>
            <!--<input type = 'hidden' name = '_token' value = '{{Session::token()}}'>-->
            {!! csrf_field() !!}

        <div class="box box-primary">

                 <div class="box-body">

                            <div class="row{{ $errors->has('nome') ? ' has-error' : '' }}">
                                    <div class="col-xs-10">

                                        <label for="nome" class="control-label">Grupo</label>
                                        <select id="nome" placeholder="(Selecionar)" name="nome" data-live-search="true" data-none-selected-text="Nenhum item selecionado" class="form-control selectpicker" style="width: 100%;">
                                              <option  value=""></option>
                                                @foreach($dados as $item)
                                                       <option  value="{{$item->id}}" >{{$item->nome}}</option>
                                                @endforeach
                                        </select>

                                        <!-- se houver erros na validacao do form request -->
                                         @if ($errors->has('nome'))
                                          <span class="help-block">
                                              <strong>{{ $errors->first('nome') }}</strong>
                                          </span>
                                         @endif

                                    </div>
                            </div>

                            <div class="row">

                                  <div class="box-header">

                                                <div class="box-body">

                                                <div id="tour6"></div>
                                                <div id="tour4_1"></div>

                                                 <b>
                                                 <p>
                                                 <i class="fa fa-refresh"></i>&nbsp;&nbsp;Selecionar Tudo&nbsp;&nbsp;<input  id= "selecionar_todos" name="selecionar_todos" type="checkbox"  />
                                                 </p>
                                                 </b>

                                                    <table class="table table-bordered table-hover">
                                                              <tr>
                                                                <td>Selecionar Todos (Por Função)</td>
                                                                <td>Acessar</td>
                                                                <td>Incluir</td>
                                                                <td>Alterar</td>
                                                                <td>Excluir</td>
                                                                <!--<td>Visualizar</td>
                                                                <td>Exportar</td>-->
                                                                <td>Imprimir</td>
                                                              </tr>
                                                              <tr>
                                                                <td></td>
                                                                <td><i class="fa  fa-long-arrow-down"></i>&nbsp;&nbsp;<input  id= "selecionar_acessar" name="selecionar_acessar" type="checkbox" data-group-cls="btn-group-sm" class="selecionar_acessar" /></td>
                                                                <td><i class="fa  fa-long-arrow-down"></i>&nbsp;&nbsp;<input  id= "selecionar_incluir" name="selecionar_incluir" type="checkbox" data-group-cls="btn-group-sm" class="selecionar_incluir" /></td>
                                                                <td><i class="fa  fa-long-arrow-down"></i>&nbsp;&nbsp;<input  id= "selecionar_alterar" name="selecionar_alterar" type="checkbox" data-group-cls="btn-group-sm" class="selecionar_alterar" /></td>
                                                                <td><i class="fa  fa-long-arrow-down"></i>&nbsp;&nbsp;<input  id= "selecionar_excluir" name="selecionar_excluir" type="checkbox" data-group-cls="btn-group-sm" class="selecionar_excluir" /></td>
                                                                <!--<td><i class="fa  fa-long-arrow-down"></i>&nbsp;&nbsp;<input  id= "selecionar_visualizar" name="selecionar_visualizar" type="checkbox" data-group-cls="btn-group-sm" class="selecionar_visualizar" /></td>
                                                                <td><i class="fa  fa-long-arrow-down"></i>&nbsp;&nbsp;<input  id= "selecionar_exportar" name="selecionar_exportar" type="checkbox" data-group-cls="btn-group-sm" class="selecionar_exportar" /></td>-->
                                                                <td><i class="fa  fa-long-arrow-down"></i>&nbsp;&nbsp;<input  id= "selecionar_imprimir" name="selecionar_imprimir" type="checkbox" data-group-cls="btn-group-sm" class="selecionar_imprimir" /></td>
                                                              </tr>
                                                          </table>

                                                              <?php $var_paginas = ''; ?>

                                                              @foreach($paginas as $value)

                                                                @if ($value->menu!=$var_paginas)

                                                                   @if ($var_paginas!="")
                                                                                    </tbody>
                                                                              </table>
                                                                          </div>
                                                                        <!-- /.box-body -->
                                                                      </div>
                                                                      <!-- /.box -->
                                                                    </div>
                                                                   @endif

                                                                  <div class="col-md-12">
                                                                    <div class="box box-warning">
                                                                      <div class="box-header with-border">
                                                                        <h3 class="box-title">Módulo : {{$value->menu}}</h3>

                                                                        <div class="box-tools pull-right">
                                                                          <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                                                                          </button>
                                                                        </div>
                                                                        <!-- /.box-tools -->
                                                                      </div>
                                                                      <!-- /.box-header -->
                                                                      <div class="box-body">

                                                                          <table id="{{$value->menu}}" class="table table-bordered table-hover">
                                                                          <thead>
                                                                              <tr>
                                                                              <th>ID</th>
                                                                              <th>Página</th>
                                                                              <th>Acessar</th>
                                                                              <th>Incluir</th>
                                                                              <th>Alterar</th>
                                                                              <th>Excluir</th>
                                                                              <!--<th>Visualizar</th>
                                                                              <th>Exportar</th>-->
                                                                              <th>Imprimir</th>
                                                                              </tr>
                                                                          </thead>
                                                                          <tbody>


                                                                    <?php $var_paginas=$value->menu; ?>

                                                                @endif

                                                                         <tr>
                                                                                  <td>
                                                                                      <input name="pagina[{{ $value->id }}]" type="text" value="{{ $value->id }}" hidden>{{ $value->id }}
                                                                                  </td>

                                                                                  <td>
                                                                                      {{ $value->nome }}
                                                                                  </td>

                                                                                  <td>
                                                                                      <input  name="acessar[{{ $value->id }}]" type="hidden"  value="0" />
                                                                                      <input  name="acessar[{{ $value->id }}]" type="checkbox" class="acessar" data-group-cls="btn-group-sm" value="1" />
                                                                                  </td>

                                                                                  <td>
                                                                                      <input  name="incluir[{{ $value->id }}]" type="hidden" value="0" />
                                                                                      <input  name="incluir[{{ $value->id }}]" type="checkbox" class="incluir" data-group-cls="btn-group-sm" value="1" />
                                                                                  </td>
                                                                                  <td>
                                                                                  <input  name="alterar[{{ $value->id }}]" type="hidden" value="0" />
                                                                                  <input  name="alterar[{{ $value->id }}]" type="checkbox" class="alterar" data-group-cls="btn-group-sm" value="1"  /></td>
                                                                                  <td>
                                                                                  <input  name="excluir[{{ $value->id }}]" type="hidden" value="0" />
                                                                                  <input  name="excluir[{{ $value->id }}]" type="checkbox" class="excluir" data-group-cls="btn-group-sm" value="1"  /></td>

                                                                                  <!--
                                                                                  <td>
                                                                                  <input  name="visualizar[{{ $value->id }}]" type="hidden" value="0" />
                                                                                  <input  name="visualizar[{{ $value->id }}]" type="checkbox" class="visualizar"  data-group-cls="btn-group-sm" value="1" /></td>
                                                                                  <td>
                                                                                  <input  name="exportar[{{ $value->id }}]" type="hidden" value="0" />
                                                                                  <input  name="exportar[{{ $value->id }}]" type="checkbox" class="exportar" data-group-cls="btn-group-sm" value="1" /></td>
                                                                                  -->
                                                                                  <td>
                                                                                  <input  name="imprimir[{{ $value->id }}]" type="hidden" value="0" />
                                                                                  <input  name="imprimir[{{ $value->id }}]" type="checkbox" class="imprimir" data-group-cls="btn-group-sm" value="1"  /></td>

                                                                            </tr>

                                                              @endforeach

                                                              @if ($var_paginas!="")
                                                                                    </tbody>
                                                                              </table>
                                                                          </div>
                                                                        <!-- /.box-body -->
                                                                      </div>
                                                                      <!-- /.box -->
                                                                    </div>
                                                            @endif

                                                </div>
                                  </div>

                            </div>

            </div><!-- fim box-body"-->
        </div><!-- box box-primary -->

        <div class="box-footer">
            <button class = 'btn btn-primary' type ='submit'><i class="fa fa-save"></i> Salvar</button>
            <a href="{{ url('/permissoes')}}" class="btn btn-default">Cancelar</a>
        </div>

        </form>

    </div>

</div>

@endsection

@section('tela_permissoes')

<script type="text/javascript">

                  $(function () {


                         $("#menu_seguranca").addClass("treeview active");

                         $('.acessar').checkboxpicker({
                              offLabel : 'Não',
                              onLabel : 'Sim',
                         });

                         $('.incluir').checkboxpicker({
                              offLabel : 'Não',
                              onLabel : 'Sim',
                         });

                         $('.excluir').checkboxpicker({
                              offLabel : 'Não',
                              onLabel : 'Sim',
                         });

                         /*
                         $('.visualizar').checkboxpicker({
                              offLabel : 'Não',
                              onLabel : 'Sim',
                         });

                         $('.exportar').checkboxpicker({
                              offLabel : 'Não',
                              onLabel : 'Sim',
                         });
                         */

                         $('.imprimir').checkboxpicker({
                              offLabel : 'Não',
                              onLabel : 'Sim',
                         });

                         $('.alterar').checkboxpicker({
                              offLabel : 'Não',
                              onLabel : 'Sim',
                         });


                          $('#selecionar_todos').checkboxpicker({
                              offLabel : 'Não',
                              onLabel : 'Sim',
                         });

                          $('#selecionar_todos').change(function() {

                            if ($(this).prop('checked')) {
                                $('.acessar').prop('checked', true);
                            } else {
                                $('.acessar').prop('checked', false);
                            }

                            if ($(this).prop('checked')) {
                                $('.incluir').prop('checked', true);
                            } else {
                                $('.incluir').prop('checked', false);
                            }

                            if ($(this).prop('checked')) {
                                $('.alterar').prop('checked', true);
                            } else {
                                $('.alterar').prop('checked', false);
                            }

                            if ($(this).prop('checked')) {
                                $('.excluir').prop('checked', true);
                            } else {
                                $('.excluir').prop('checked', false);
                            }

                            /*
                            if ($(this).prop('checked')) {
                                $('.visualizar').prop('checked', true);
                            } else {
                                $('.visualizar').prop('checked', false);
                            }

                            if ($(this).prop('checked')) {
                                $('.exportar').prop('checked', true);
                            } else {
                                $('.exportar').prop('checked', false);
                            }
                            */

                            if ($(this).prop('checked')) {
                                $('.imprimir').prop('checked', true);
                            } else {
                                $('.imprimir').prop('checked', false);
                            }

                             if ($(this).prop('checked')) {
                                $('.selecionar_acessar').prop('checked', true);
                            } else {
                                $('.selecionar_acessar').prop('checked', false);
                            }

                            if ($(this).prop('checked')) {
                                $('.selecionar_incluir').prop('checked', true);
                            } else {
                                $('.selecionar_incluir').prop('checked', false);
                            }

                            if ($(this).prop('checked')) {
                                $('.selecionar_alterar').prop('checked', true);
                            } else {
                                $('.selecionar_alterar').prop('checked', false);
                            }

                            if ($(this).prop('checked')) {
                                $('.selecionar_excluir').prop('checked', true);
                            } else {
                                $('.selecionar_excluir').prop('checked', false);
                            }

                            /*
                            if ($(this).prop('checked')) {
                                $('.selecionar_visualizar').prop('checked', true);
                            } else {
                                $('.selecionar_visualizar').prop('checked', false);
                            }

                            if ($(this).prop('checked')) {
                                $('.selecionar_exportar').prop('checked', true);
                            } else {
                                $('.selecionar_exportar').prop('checked', false);
                            }
                            */

                            if ($(this).prop('checked')) {
                                $('.selecionar_imprimir').prop('checked', true);
                            } else {
                                $('.selecionar_imprimir').prop('checked', false);
                            }

                        });

                        $('.selecionar_acessar').checkboxpicker({
                              offLabel : 'Não',
                              onLabel : 'Sim',
                         });

                        $('#selecionar_acessar').change(function() {
                            if ($(this).prop('checked')) {
                                $('.acessar').prop('checked', true);
                            } else {
                                $('.acessar').prop('checked', false);
                            }
                        });

                        $('.selecionar_incluir').checkboxpicker({
                              offLabel : 'Não',
                              onLabel : 'Sim',
                         });

                        $('#selecionar_incluir').change(function() {
                            if ($(this).prop('checked')) {
                                $('.incluir').prop('checked', true);
                            } else {
                                $('.incluir').prop('checked', false);
                            }
                        });


                        $('.selecionar_alterar').checkboxpicker({
                              offLabel : 'Não',
                              onLabel : 'Sim',
                         });

                        $('#selecionar_alterar').change(function() {
                            if ($(this).prop('checked')) {
                                $('.alterar').prop('checked', true);
                            } else {
                                $('.alterar').prop('checked', false);
                            }
                        });


                        $('.selecionar_excluir').checkboxpicker({
                              offLabel : 'Não',
                              onLabel : 'Sim',
                         });

                        $('#selecionar_excluir').change(function() {
                            if ($(this).prop('checked')) {
                                $('.excluir').prop('checked', true);
                            } else {
                                $('.excluir').prop('checked', false);
                            }
                        });

                        /*
                        $('.selecionar_visualizar').checkboxpicker({
                              offLabel : 'Não',
                              onLabel : 'Sim',
                         });

                        $('#selecionar_visualizar').change(function() {
                            if ($(this).prop('checked')) {
                                $('.visualizar').prop('checked', true);
                            } else {
                                $('.visualizar').prop('checked', false);
                            }
                        });


                        $('.selecionar_exportar').checkboxpicker({
                              offLabel : 'Não',
                              onLabel : 'Sim',
                         });

                        $('#selecionar_exportar').change(function() {
                            if ($(this).prop('checked')) {
                                $('.exportar').prop('checked', true);
                            } else {
                                $('.exportar').prop('checked', false);
                            }
                        });
                      */

                        $('.selecionar_imprimir').checkboxpicker({
                              offLabel : 'Não',
                              onLabel : 'Sim',
                         });

                        $('#selecionar_imprimir').change(function() {
                            if ($(this).prop('checked')) {
                                $('.imprimir').prop('checked', true);
                            } else {
                                $('.imprimir').prop('checked', false);
                            }
                        });

               });

   </script>
@endsection