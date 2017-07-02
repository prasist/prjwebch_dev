@extends('principal.master')

@section('content')

{{ \Session::put('titulo', 'Relatório de Cursos / Eventos') }}
{{ \Session::put('subtitulo', 'Listagem') }}
{{ \Session::put('route', 'relcursos') }}
{{ \Session::put('id_pagina', '69') }}

<div class = 'row'>

 <div class="col-md-12">

  <form method = 'POST'  class="form-horizontal" action = "{{ url('/' . \Session::get('route') . '/pesquisar/celulas')}}">

  {!! csrf_field() !!}

    <div class="box box-default">

          <div class="box-body">

            <div class="row">
                <div class="col-md-12">

                 <!-- Custom Tabs -->
                  <div class="nav-tabs-custom">

                    <ul class="nav nav-tabs">
                      <li class="active"><a href="#tab_1" data-toggle="tab">Filtros Básicos</a></li>
                      <li><a href="#tab_2" data-toggle="tab">Filtrar Estrutura de Células</a></li>
                    </ul>

                    <div class="tab-content">
                      <div class="tab-pane active" id="tab_1">

                          <div class="row">

                                <div class="col-xs-6">
                                        <label for="lideres" class="control-label">Célula</label>
                                        <select id="lideres" placeholder="(Selecionar)" name="lideres" data-live-search="true" data-none-selected-text="Nenhum item selecionado" class="form-control selectpicker" style="width: 100%;">
                                              <option  value="0"></option>
                                                @foreach($lideres as $item)
                                                       <option  value="{{$item->id . '|' . $item->nome}}" >{{$item->nome}}</option>
                                                @endforeach
                                        </select>
                                </div>

                                <div class="col-xs-6">
                                        <label for="participante" class="control-label">Pessoa</label>
                                        <div class="input-group">
                                               <div class="input-group-addon">
                                                  <button  id="buscarpessoa" type="button"  data-toggle="modal" data-target="#participante_myModal" >
                                                         <i class="fa fa-search"></i> ...
                                                   </button>
                                                   &nbsp;<a href="#" onclick="remover_pessoa('participante');" title="Limpar Campo"><spam class="fa fa-close"></spam></a>
                                                </div>

                                                @include('modal_buscar_pessoas', array('qual_campo'=>'participante', 'modal' => 'participante_myModal'))

                                                <input id="participante"  name = "participante" type="text" class="form-control" placeholder="Clica na lupa ao lado para consultar uma pessoa" value="" readonly >

                                        </div>
                               </div>

                          </div>

                            <div class="row">
                                  <div class="col-xs-6">
                                        <label for="curso" class="control-label">Curso / Evento :</label>
                                         <select id="curso"  name="curso"  data-live-search="true" data-none-selected-text="(Selecionar)" class="form-control selectpicker" style="width: 100%;">
                                         <option  value="">(Selecionar)</option>
                                         @foreach ($cursos as $item)
                                                <option  value="{{$item->id . '|' . $item->nome}}" >{{$item->nome}}</option>
                                         @endforeach
                                         </select>
                                 </div>

                                <div class="col-xs-6">
                                        <label for="ministrante" class="control-label">Ministrante</label>
                                        <div class="input-group">
                                               <div class="input-group-addon">
                                                  <button  id="buscarpessoa" type="button"  data-toggle="modal" data-target="#ministrante_myModal" >
                                                         <i class="fa fa-search"></i> ...
                                                   </button>
                                                   &nbsp;<a href="#" onclick="remover_pessoa('ministrante');" title="Limpar Campo"><spam class="fa fa-close"></spam></a>
                                                </div>

                                                @include('modal_buscar_pessoas', array('qual_campo'=>'ministrante', 'modal' => 'ministrante_myModal'))

                                                <input id="ministrante"  name = "ministrante" type="text" class="form-control" placeholder="Clica na lupa ao lado para consultar uma pessoa" value="" readonly >

                                        </div>
                               </div>
                          </div>


                          <div class="row">

                                  <div class="col-xs-3">
                                        <label for="data_inicio" class="control-label">Data Início</label>
                                        <div class="input-group">
                                               <div class="input-group-addon">
                                                    <i class="fa fa-calendar"></i>
                                                </div>

                                                <input id ="data_inicio" name = "data_inicio" onblur="validar_data(this)" type="text" class="form-control" data-inputmask='"mask": "99/99/9999"' data-mask  value="">
                                        </div>
                                  </div>

                                  <div class="col-xs-3">
                                        <label for="data_fim" class="control-label">Data Fim</label>
                                        <div class="input-group">
                                               <div class="input-group-addon">
                                                    <i class="fa fa-calendar"></i>
                                                </div>

                                                <input id ="data_fim" name = "data_fim" onblur="validar_data(this)" type="text" class="form-control" data-inputmask='"mask": "99/99/9999"' data-mask  value="">
                                        </div>
                                  </div>

                          </div>


                          <div class="row">

                              <div class="col-xs-6">

                                    <label for="resultado" class="control-label">Formato de Saída : </label>
                                    <select id="resultado" name="resultado" class="form-control selectpicker">
                                    <option  value="pdf" data-icon="fa fa-file-pdf-o" selected>PDF (.pdf)</option>
                                    <option  value="xlsx" data-icon="fa fa-file-excel-o">Planilha Excel (.xls)</option>
                                    <option  value="csv" data-icon="fa fa-file-excel-o">CSV (.csv)</option>
                                    <option  value="docx" data-icon="fa fa-file-word-o">Microsoft Word (.docx)</option>
                                    <option  value="html" data-icon="fa fa-file-word-o">HTML (.html)</option>
                                    </select>


                                     @if ($var_download=="")

                                           @if ($var_mensagem=="Nenhum Registro Encontrado")
                                                  <br/>
                                                  <br/>
                                                   <div class="alert2 alert-info">
                                                      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                                      <h4>
                                                      <i class="icon fa fa-check"></i> {{$var_mensagem}}</h4>
                                                  </div>
                                                  {{$var_mensagem}}
                                           @endif

                                     @else
                                        <br/>
                                        <br/>
                                        <div class="alert2 alert-info">
                                          <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                          <h4><i class="icon fa fa-check"></i> Relatório gerado com Sucesso!</h4>
                                          Clique no link abaixo para baixar o arquivo.
                                        </div>
                                        <a href="{!! url($var_download) !!}" class="text" target="_blank">
                                          CLIQUE AQUI PARA VISUALIZAR / BAIXAR
                                          @if (substr($var_download,-3)=="pdf")
                                            <img src="{{ url('/images/pdf.png') }}" alt="Baixar Arquivo" />
                                          @elseif (substr($var_download,-4)=="xlsx")
                                            <img src="{{ url('/images/excel.png') }}" alt="Baixar Arquivo" />
                                          @elseif (substr($var_download,-3)=="csv")
                                            <img src="{{ url('/images/csv.jpg') }}" alt="Baixar Arquivo" />
                                          @elseif (substr($var_download,-4)=="docx")
                                             <img src="{{ url('/images/microsoft-word-icon.png') }}" alt="Baixar Arquivo" />
                                          @endif
                                        </a>
                                      @endif

                              </div>

                              <div class="col-xs-3">
                                    <label for="tipo" class="control-label">Agrupar por </label>
                                    <select id="tipo"  name="tipo" class="form-control">
                                        <option  value="1">Participante</option>
                                        <option  value="2">Curso / Evento</option>
                                        <option  value="3">Data + Curso / Evento</option>
                                    </select>
                              </div>

                          </div>

                      </div>
                      <!-- /.tab-pane -->

                      <div class="tab-pane" id="tab_2">
                            <!-- Horizontal Form -->
                             <div class="box box-default">
                                  <div class="box-header with-border">
                                    <h3 class="box-title">Estrutura de Células</h3>
                                  </div>

                                    <div class="box-body">

                                      <!-- NIVEL 1-->
                                      <div class="form-group">
                                          <label for="nivel1_up" class="col-sm-2 control-label">{{Session::get('nivel1')}}</label>
                                          <div class="col-sm-10">
                                                <select id="nivel1_up" placeholder="(Selecionar)" name="nivel1_up" data-live-search="true" data-none-selected-text="Nenhum item selecionado" class="form-control" style="width: 100%;">
                                                <option  value="0"></option>
                                                @foreach($nivel1 as $item)
                                                       <option  value="{{$item->id . '|' . $item->nome}}" >{{$item->nome}}</option>
                                                @endforeach
                                                </select>
                                          </div>
                                      </div>

                                      <!-- NIVEL 2 -->
                                      <div class="form-group">
                                          <label for="nivel2_up" class="col-sm-2 control-label">{{Session::get('nivel2')}}</label>
                                          <div class="col-sm-10">
                                                  <select id="nivel2_up" placeholder="(Selecionar)" name="nivel2_up" data-live-search="true" data-none-selected-text="Nenhum item selecionado" class="form-control" style="width: 100%;">
                                                  <option  value="0"></option>
                                                   @foreach($nivel2 as $item)
                                                       <option  value="{{$item->id . '|' . $item->nome}}" >{{$item->nome}}</option>
                                                   @endforeach
                                                  </select>
                                          </div>
                                      </div>

                                      <!-- NIVEL 3-->
                                      <div class="form-group">
                                        <label for="nivel3_up" class="col-sm-2 control-label">{{Session::get('nivel3')}}</label>
                                        <div class="col-sm-10">
                                              <select id="nivel3_up" placeholder="(Selecionar)" name="nivel3_up" data-live-search="true" data-none-selected-text="Nenhum item selecionado" class="form-control" style="width: 100%;">
                                              <option  value="0"></option>
                                                @foreach($nivel3 as $item)
                                                       <option  value="{{$item->id . '|' . $item->nome}}" >{{$item->nome}}</option>
                                                @endforeach
                                              </select>
                                        </div>
                                      </div>

                                      <!-- NIVEL 4-->
                                      <div class="form-group">
                                        <label for="nivel4_up" class="col-sm-2 control-label">{{Session::get('nivel4')}}</label>

                                        <div class="col-sm-10">
                                              <select id="nivel4_up" placeholder="(Selecionar)" name="nivel4_up" data-live-search="true" data-none-selected-text="Nenhum item selecionado" class="form-control" style="width: 100%;">
                                              <option  value="0"></option>
                                                @foreach($nivel4 as $item)
                                                       <option  value="{{$item->id . '|' . $item->nome}}" >{{$item->nome}}</option>
                                                @endforeach
                                              </select>
                                        </div>
                                      </div>

                                      <!-- NIVEL 5-->
                                      <div class="form-group">
                                        <label for="nivel5_up" class="col-sm-2 control-label">{!!Session::get('nivel5') !!}</label>
                                        <div class="col-sm-10">
                                                <select id="nivel5_up" placeholder="(Selecionar)" name="nivel5_up" data-live-search="true" data-none-selected-text="Nenhum item selecionado" class="form-control" style="width: 100%;">
                                                <option  value="0"></option>
                                                @foreach($nivel5 as $item)
                                                       <option  value="{{$item->id . '|' . $item->nome}}" >{{$item->nome}}</option>
                                                @endforeach
                                                </select>
                                        </div>
                                      </div>

                                    </div>

                            <!-- FIM Horizontal Form -->
                      </div>
                      <!-- /.tab-pane -->

                    </div>
                    <!-- /.tab-content -->
                  </div>
                  <!-- nav-tabs-custom -->
                </div>
                <!-- /.col -->
            </div><!-- /.row -->

        <div class="overlay modal" style="display: none">
            <i class="fa fa-refresh fa-spin"></i>
        </div>

         </div><!-- fim box-body"-->
     </div><!-- box box-primary -->

        <div class="box-footer">
            <button class = 'btn btn-primary' type ='submit' onclick="myApp.showPleaseWait();">Pesquisar</button>
            <a href="{{ url('/' . \Session::get('route') )}}" class="btn btn-default">Limpar</a>
        </div>

        </form>

    </div>

</div>


<script type="text/javascript">

    var myApp;
    myApp = myApp || (function () {
          return {
              showPleaseWait: function() {
                  $(".overlay").show();
              }
          };
    })();

    function remover_pessoa(var_objeto)
    {
        $('#' + var_objeto).val('');
    }

</script>

@include('configuracoes.script_estruturas')
@endsection