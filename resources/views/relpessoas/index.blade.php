@extends('principal.master')

@section('content')

{{ \Session::put('titulo', 'Relatório de Pessoas') }}
{{ \Session::put('subtitulo', 'Listagem') }}
{{ \Session::put('route', 'relpessoas') }}
{{ \Session::put('id_pagina', '47') }}

<div class = 'row'>

 <div class="col-md-12">

  <form method = 'POST'  class="form-horizontal" onsubmit="return validar_datas();"  action ="{{ url('/' . \Session::get('route') . '/pesquisar')}}">

  {!! csrf_field() !!}

    <div class="box box-default">

          <div class="box-body">

            <div class="row">
                <div class="col-md-12">

                     <!-- Custom Tabs -->
                      <div class="nav-tabs-custom">
                        <ul class="nav nav-tabs">
                          <li class="active"><a href="#tab_1" data-toggle="tab">Filtros Básicos</a></li>
                          <li><a href="#tab_2" data-toggle="tab">Por Períodos</a></li>
                          <li><a href="#tab_3" data-toggle="tab">Estrutura de Células</a></li>
                          <li><a href="#tab_4" data-toggle="tab">Pesquisa Avançada</a></li>
                        </ul>
                        <div class="tab-content">

                          <div class="tab-pane active" id="tab_1">

                                <div  class="row">
                                              <div class="col-md-12">

                                                    <div class="box box-default">

                                                          <div class="box-body"><!-- box-body-->

                                                             <div class="row">

                                                                 <div class="col-xs-3">

                                                                          <label for="status" class="control-label">Status Cadastro</label>
                                                                            <select id="status" name="status" data-live-search="true" data-none-selected-text="(Selecionar)" class="form-control selectpicker" style="width: 100%;">
                                                                                <option  value="">Ambos</option>
                                                                                <option  value="S">Ativo</option>
                                                                                <option  value="N">Inativo</option>
                                                                            </select>

                                                                    </div><!-- col-xs-5-->

                                                                      <div class="col-xs-3">

                                                                          <label for="tipos" class="control-label">Tipo Pessoa</label>

                                                                          <select id="tipos" placeholder="(Selecionar)" name="tipos" data-live-search="true" data-none-selected-text="(Selecionar)" class="form-control selectpicker" style="width: 100%;">
                                                                          <option  value=""></option>

                                                                          @foreach($tipos as $item)
                                                                                 <option  value="{{$item->id . '|' . $item->nome}}">{{$item->nome}}</option>
                                                                          @endforeach
                                                                          </select>
                                                                      </div><!-- col-xs-5-->

                                                                      <div class="col-xs-3">
                                                                          <label for="estadoscivis" class="control-label">Estado Civil</label>

                                                                          <select id="estadoscivis" placeholder="(Selecionar)" name="estadoscivis" data-live-search="true" data-none-selected-text="(Selecionar)" class="form-control selectpicker" style="width: 100%;">
                                                                          <option  value=""></option>

                                                                          @foreach($estadoscivis as $item)
                                                                                 <option  value="{{$item->id . '|' . $item->nome}}">{{$item->nome}}</option>
                                                                          @endforeach
                                                                          </select>
                                                                      </div><!-- col-xs-5-->

                                                                      <div class="col-xs-3">
                                                                          <label for="sexo" class="control-label">Sexo</label>
                                                                            <select id="sexo" name="sexo" data-live-search="true" data-none-selected-text="(Selecionar)" class="form-control selectpicker" style="width: 100%;">
                                                                                <option  value="">Ambos</option>
                                                                                <option  value="M">Masculino</option>
                                                                                <option  value="F">Feminino</option>
                                                                            </select>
                                                                      </div>


                                                                 </div> <!-- end row -->

                                                                 <div class="row">
                                                                      <div class="col-xs-3">
                                                                          <label for="grupo" class="control-label">Grupo</label>

                                                                          <select id="grupo" placeholder="(Selecionar)" name="grupo" data-live-search="true" data-none-selected-text="(Selecionar)" class="form-control selectpicker" style="width: 100%;">
                                                                          <option  value=""></option>
                                                                          @foreach($grupos as $item)
                                                                                 <option  value="{{$item->id . '|' . $item->nome}}">{{$item->nome}}</option>
                                                                          @endforeach
                                                                          </select>
                                                                      </div><!-- col-xs-5-->

                                                                      <div class="col-xs-3">

                                                                        <label for="situacoes" class="control-label">Situação</label>

                                                                          <select id="situacoes" placeholder="(Selecionar)" name="situacoes" data-live-search="true" data-none-selected-text="(Selecionar)" class="form-control selectpicker" style="width: 100%;">
                                                                          <option  value=""></option>

                                                                          @foreach($situacoes as $item)
                                                                                 <option  value="{{$item->id . '|' . $item->nome}}">{{$item->nome}}</option>
                                                                          @endforeach
                                                                          </select>
                                                                    </div><!-- col-xs-5-->

                                                                    <div class="col-xs-3">
                                                                            <label for="status_id" class="control-label">Status</label>

                                                                          <select id="status_id" placeholder="(Selecionar)" name="status_id" data-live-search="true" data-none-selected-text="(Selecionar)" class="form-control selectpicker" style="width: 100%;">
                                                                          <option  value=""></option>

                                                                          @foreach($status as $item)
                                                                                 <option  value="{{$item->id . '|' . $item->nome}}">{{$item->nome}}</option>
                                                                          @endforeach
                                                                          </select>
                                                                    </div>


                                                             </div> <!-- end row -->

                                                        <div class="row"><!-- row entrada-->

                                                                    <input  id="possui_necessidades_especiais" name="possui_necessidades_especiais" type="hidden" value="" />
                                                                    <input  id="ckExibirCelula" name="ckExibirCelula" type="hidden" value="" />
                                                                    <input  id= "ckEstruturas" name="ckEstruturas" type="hidden" class="minimal" />

                                                                      <div class="col-xs-3">
                                                                            <label for="mes" class="control-label">Mês Aniversário</label>
                                                                            <select id="mes" name="mes" data-live-search="true" data-none-selected-text="(Selecionar)" class="form-control selectpicker" style="width: 100%;">
                                                                                <option  value=""></option>
                                                                                <option  value="12">Dezembro</option>
                                                                                <option  value="11">Novembro</option>
                                                                                <option  value="10">Outubro</option>
                                                                                <option  value="09">Setembro</option>
                                                                                <option  value="08">Agosto</option>
                                                                                <option  value="07">Julho</option>
                                                                                <option  value="06">Junho</option>
                                                                                <option  value="05">Maio</option>
                                                                                <option  value="04">Abril</option>
                                                                                <option  value="03">Março</option>
                                                                                <option  value="02">Fevereiro</option>
                                                                                <option  value="01">Janeiro</option>
                                                                            </select>
                                                                    </div>

                                                                    <div class="col-xs-3">
                                                                    <label for="mes" class="control-label">Tipo Aniversariante</label>
                                                                    <div class="form-group">

                                                                        <label>
                                                                          <input type="radio" name="r1" class="minimal" value = "1" checked>
                                                                          Nascimento
                                                                        </label>
                                                                        <label>
                                                                          <input type="radio" name="r1" class="minimal" value = "2">
                                                                          Casamento
                                                                        </label>
                                                                        <label>
                                                                          <input type="radio" name="r1" class="minimal" value = "3">
                                                                          Batismo
                                                                        </label>
                                                                      </div>
                                                                    </div>

                                                                    <div class="col-xs-3">
                                                                        <label for="ano_inicial" class="control-label">Ano Nascimento Inicial :</label>
                                                                        <input type="text" id="ano_inicial" name="ano_inicial" class="form-control" placeholder="Ano Inicial"  data-inputmask='"mask": "9999"' data-mask>
                                                                    </div><!-- col-xs-5-->

                                                                    <div class="col-xs-3">
                                                                        <label for="ano_final" class="control-label">Ano Nascimento Final :</label>
                                                                        <input type="text" id="ano_final" name="ano_final" placeholder="Ano Final" class="form-control"  data-inputmask='"mask": "9999"' data-mask>
                                                                    </div><!-- col-xs-5-->

                                                                 </div><!-- end row -->


                                                          <div class="row">

                                                              <div class="col-xs-3">

                                                                    <label for="resultado" class="control-label">Formato de Saída : </label>

                                                                    <!--
                                                                    <select id="resultado" name="resultado" class="form-control selectpicker">
                                                                    <option  value="html">(Padrão)</option>
                                                                    <option  value="email" data-icon="fa fa-envelope-o">Listagem de E-mails</option>
                                                                    <option  value="celular" data-icon="fa fa-whatsapp">Número Celular (Envio Mensagens)</option>
                                                                    </select>
                                                                    -->

                                                                    <select id="resultado" name="resultado" class="form-control selectpicker">
                                                                    <option  value="pdf" data-icon="fa fa-file-pdf-o" selected>PDF (.pdf)</option>
                                                                    <option  value="xlsx" data-icon="fa fa-file-excel-o">Planilha Excel (.xls)</option>
                                                                    <option  value="csv" data-icon="fa fa-file-excel-o">CSV (.csv)</option>
                                                                    <option  value="docx" data-icon="fa fa-file-word-o">Microsoft Word (.docx)</option>
                                                                    <option  value="rtf" data-icon="fa fa-file-text-o">Rich Text Format (.rtf)</option>
                                                                    <option  value="html" data-icon="fa fa-file-word-o">HTML (.html)</option>
                                                                    <option  value="email" data-icon="fa fa-envelope-o">Listagem de E-mails</option>
                                                                    <option  value="celular" data-icon="fa fa-whatsapp">Número Celular (Envio Mensagens)</option>
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
                                                                    <label for="ordem" class="control-label">Ordem</label>
                                                                    <select id="ordem" name="ordem" class="form-control selectpicker">
                                                                    <option  value="razaosocial"  selected>Nome</option>
                                                                    <option  value="datanasc" >Data Nasc. (Dia/Mês)</option>
                                                                    <option  value="idade" >Idade</option>
                                                                    <option  value="ano" >Ano</option>
                                                                    </select>
                                                             </div>

                                                             <div class="col-xs-3">

                                                                    <!--
                                                                    <label for="ckEstruturas">Listar Estruturas Células </label>
                                                                    <div class="input-group">
                                                                           <div class="input-group-addon">
                                                                                    <input  id= "ckEstruturas" name="ckEstruturas" type="checkbox" data-group-cls="btn-group-sm" class="ckEstruturas" />
                                                                            </div>
                                                                      </div>
                                                                      -->
                                                                      <label for="possui_necessidades_especiais">Pessoas com Necessidades Especiais ?</label>
                                                                      <div class="input-group">
                                                                           <div class="input-group-addon">
                                                                                    <input  id="possui_necessidades_especiais" data-group-cls="btn-group-sm" name="possui_necessidades_especiais" type="checkbox" class="possui_necessidades_especiais" value="true" />
                                                                            </div>
                                                                      </div>
                                                              </div>

                                                              <div class="col-xs-3">

                                                                      <label for="ckExibirCelula">Exibir {!! \Session::get('label_celulas_singular') !!} ?</label>
                                                                      <div class="input-group">
                                                                           <div class="input-group-addon">
                                                                                    <input  id="ckExibirCelula" data-group-cls="btn-group-sm" name="ckExibirCelula" type="checkbox" class="possui_necessidades_especiais" value="true" />
                                                                            </div>
                                                                      </div>
                                                              </div>


                                                            <!--<div class="col-xs-3"></div>-->

                                                          </div> <!-- end row-->

                                                          <div class="row">
                                                                <div class="col-xs-3">
                                                                      <label for="modelo" class="control-label">Modelo Relatório</label>
                                                                        <select id="modelo" name="modelo" data-live-search="true" data-none-selected-text="(Selecionar)" class="form-control selectpicker" style="width: 100%;">
                                                                            <option  value="1">Listagem Pessoas</option>
                                                                            <option  value="2">Agenda de Visitas</option>
                                                                        </select>
                                                                </div><!-- col-xs-5-->
                                                          </div>

                                                       </div> <!-- enb box-body-->
                                                     </div> <!-- end box box-default -->
                                               </div>
                                </div><!-- end row -->

                          </div>

                          <!-- /.tab-pane -->
                          <div class="tab-pane" id="tab_2">

                                <div  class="row">
                                              <div class="col-md-12">

                                                    <div class="box box-default">

                                                          <div class="box-body"><!-- box-body-->

                                                                <div  class="row">
                                                                        <div class="col-xs-3">
                                                                                <label  for="data_entrada" class="control-label">Data Entrada</label>
                                                                                <div class="input-group">
                                                                                       <div class="input-group-addon">
                                                                                        <i class="fa fa-calendar"></i>
                                                                                        </div>
                                                                                        <input id ="data_entrada" name = "data_entrada" onblur="validar_data(this);" type="text" class="form-control" data-inputmask='"mask": "99/99/9999"' data-mask  value="">
                                                                                </div>

                                                                       </div>

                                                                       <div class="col-xs-3">
                                                                                <label  for="data_entrada_ate" class="control-label">Até</label>
                                                                                <div class="input-group">
                                                                                       <div class="input-group-addon">
                                                                                        <i class="fa fa-calendar"></i>
                                                                                        </div>
                                                                                        <input id ="data_entrada_ate" name = "data_entrada_ate" onblur="validar_data(this)" type="text" class="form-control" data-inputmask='"mask": "99/99/9999"' data-mask  value="">
                                                                                </div>
                                                                       </div>

                                                                      <div class="col-xs-4">
                                                                               <label for="motivoentrada" class="control-label">Motivo Entrada</label>
                                                                                <select id="motivoentrada" placeholder="(Selecionar)" name="motivoentrada" data-live-search="true" data-none-selected-text="(Selecionar)" class="form-control selectpicker" style="width: 100%;">
                                                                                <option  value=""></option>
                                                                                @foreach($motivos as $item)
                                                                                       <option  value="{{$item->id . '|' . $item->nome}}">{{$item->nome}}</option>
                                                                                @endforeach
                                                                                </select>
                                                                      </div><!-- col-xs-5-->


                                                                </div><!-- end row -->


                                                                <div class="row"><!-- row saida-->

                                                                     <div class="col-xs-3">
                                                                              <label  for="data_saida" class="control-label">Data Saída</label>
                                                                              <div class="input-group">
                                                                                     <div class="input-group-addon">
                                                                                      <i class="fa fa-calendar"></i>
                                                                                      </div>
                                                                                      <input id ="data_saida" name = "data_saida" onblur="validar_data(this)" type="text" class="form-control" data-inputmask='"mask": "99/99/9999"' data-mask  value="">
                                                                              </div>
                                                                     </div>

                                                                     <div class="col-xs-3">
                                                                              <label  for="data_saida_ate" class="control-label">Até</label>

                                                                              <div class="input-group">
                                                                                     <div class="input-group-addon">
                                                                                      <i class="fa fa-calendar"></i>
                                                                                      </div>
                                                                                      <input id ="data_saida_ate" name = "data_saida_ate" onblur="validar_data(this)" type="text" class="form-control" data-inputmask='"mask": "99/99/9999"' data-mask  value="">
                                                                              </div>

                                                                     </div>

                                                                      <div class="col-xs-4">
                                                                                <label for="motivosaida" class="control-label">Motivo Saída</label>

                                                                                <select id="motivosaida" placeholder="(Selecionar)" name="motivosaida" data-live-search="true" data-none-selected-text="(Selecionar)" class="form-control selectpicker" style="width: 100%;">
                                                                                <option  value=""></option>

                                                                                @foreach($motivos as $item)
                                                                                       <option  value="{{$item->id . '|' . $item->nome}}">{{$item->nome}}</option>
                                                                                @endforeach
                                                                                </select>
                                                                      </div><!-- col-xs-5-->

                                                                 </div><!-- end row -->

                                                                 <div class="row"><!-- row saida-->

                                                                      <div class="col-xs-3">
                                                                              <label  for="data_batismo" class="control-label">Data Batismo</label>

                                                                              <div class="input-group">
                                                                                     <div class="input-group-addon">
                                                                                      <i class="fa fa-calendar"></i>
                                                                                      </div>

                                                                                      <input id ="data_batismo" name = "data_batismo" onblur="validar_data(this)" type="text" class="form-control" data-inputmask='"mask": "99/99/9999"' data-mask  value="">
                                                                              </div>

                                                                     </div>

                                                                     <div class="col-xs-3">
                                                                              <label  for="data_batismo_ate" class="control-label">Até</label>

                                                                              <div class="input-group">
                                                                                     <div class="input-group-addon">
                                                                                      <i class="fa fa-calendar"></i>
                                                                                      </div>

                                                                                      <input id ="data_batismo_ate" name = "data_batismo_ate" onblur="validar_data(this)" type="text" class="form-control" data-inputmask='"mask": "99/99/9999"' data-mask  value="">
                                                                              </div>

                                                                     </div>

                                                                 </div><!-- end row -->


                                                                 <div class="row"><!-- row saida-->

                                                                      <div class="col-xs-3">
                                                                              <label  for="data_casamento" class="control-label">Data Casamento</label>

                                                                              <div class="input-group">
                                                                                     <div class="input-group-addon">
                                                                                      <i class="fa fa-calendar"></i>
                                                                                      </div>

                                                                                      <input id ="data_casamento" name = "data_casamento" onblur="validar_data(this)" type="text" class="form-control" data-inputmask='"mask": "99/99/9999"' data-mask  value="">
                                                                              </div>

                                                                     </div>

                                                                     <div class="col-xs-3">
                                                                              <label  for="data_casamento_ate" class="control-label">Até</label>

                                                                              <div class="input-group">
                                                                                     <div class="input-group-addon">
                                                                                      <i class="fa fa-calendar"></i>
                                                                                      </div>

                                                                                      <input id ="data_casamento_ate" name = "data_casamento_ate" onblur="validar_data(this)" type="text" class="form-control" data-inputmask='"mask": "99/99/9999"' data-mask  value="">
                                                                              </div>

                                                                     </div>

                                                                 </div><!-- end row -->

                                                            </div>

                                                    </div>
                                              </div>
                                </div>

                          </div>

                          <!-- /.tab-pane -->
                          <div class="tab-pane" id="tab_3">

                                    <div class="box box-default">
                                        <div class="box-header with-border">
                                          <h3 class="box-title">Estrutura de Células</h3>
                                        </div>

                                          <div class="box-body">

                                          <!-- NIVEL 1-->
                                            <div class="form-group">
                                                <label for="nivel1_up" class="col-sm-2 control-label">{{Session::get('nivel1')}}</label>
                                                <div class="col-sm-10">
                                                      <select id="nivel1_up" placeholder="(Selecionar)" name="nivel1_up" data-live-search="true" data-none-selected-text="(Selecionar)" class="form-control" style="width: 100%;">
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
                                                        <select id="nivel2_up" placeholder="(Selecionar)" name="nivel2_up" data-live-search="true" data-none-selected-text="(Selecionar)" class="form-control" style="width: 100%;">
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
                                                    <select id="nivel3_up" placeholder="(Selecionar)" name="nivel3_up" data-live-search="true" data-none-selected-text="(Selecionar)" class="form-control" style="width: 100%;">
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
                                                    <select id="nivel4_up" placeholder="(Selecionar)" name="nivel4_up" data-live-search="true" data-none-selected-text="(Selecionar)" class="form-control" style="width: 100%;">
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
                                                      <select id="nivel5_up" placeholder="(Selecionar)" name="nivel5_up" data-live-search="true" data-none-selected-text="(Selecionar)" class="form-control" style="width: 100%;">
                                                      <option  value="0"></option>
                                                      @foreach($nivel5 as $item)
                                                             <option  value="{{$item->id . '|' . $item->nome}}" >{{$item->nome}}</option>
                                                      @endforeach
                                                      </select>
                                              </div>
                                            </div>

                                         </div>

                                     </div>
                          </div>
                          <!-- /.tab-pane -->

                          <div class="tab-pane" id="tab_4">

                              <div  class="row">
                                      <div class="col-md-12">
                                            <div class="box box-default">
                                                  <div class="box-body"><!-- box-body-->

                                                         <div class="row">
                                                              <div class="col-xs-10">
                                                                   <label for="igrejas_id" class="control-label">Igreja</label>
                                                                          <select id="igrejas_id" placeholder="(Selecionar)" name="igrejas_id" data-live-search="true" data-none-selected-text="(Selecionar)" class="form-control selectpicker" style="width: 100%;">
                                                                          <option  value=""></option>
                                                                          @foreach($igrejas as $item)
                                                                                 <option  value="{{$item->id . '|' . $item->nome}}">{{$item->nome}}</option>
                                                                          @endforeach
                                                                          </select>
                                                              </div>
                                                         </div>

                                                         <div class="row">
                                                              <div class="col-xs-5">
                                                                   <label for="doador_sangue" class="control-label">Doador Sangue</label>
                                                                   <select id="doador_sangue" placeholder="(Selecionar)" name="doador_sangue" data-live-search="true" data-none-selected-text="(Selecionar)" class="form-control selectpicker" style="width: 100%;">
                                                                         <option  value=""></option>
                                                                         <option  value="1">SIM</option>
                                                                         <option  value="0">NÃO</option>
                                                                   </select>

                                                             </div>

                                                             <div class="col-xs-5">
                                                                     <label for="doador_orgaos" class="control-label">Doador Orgãos</label>

                                                                     <select id="doador_orgaos" placeholder="(Selecionar)" name="doador_orgaos" data-live-search="true" data-none-selected-text="(Selecionar)" class="form-control selectpicker" style="width: 100%;">
                                                                           <option  value=""></option>
                                                                           <option  value="1">SIM</option>
                                                                           <option  value="0">NÃO</option>
                                                                     </select>

                                                             </div>


                                                         </div>

                                                         <div class="row"><!-- row-->
                                                                   <div class="col-xs-5">

                                                                        <label for="tipo_sangue" class="control-label">Tipo Sanguíneo :</label>
                                                                        <input type="text" id="tipo_sangue" maxlength="50" name="tipo_sangue" class="form-control" placeholder="Tipo Sanguíneo" >

                                                                   </div><!-- col-xs-5-->

                                                                   <div class="col-xs-5">
                                                                          <label for="religioes_id" class="control-label">Religião</label>
                                                                          <select id="religioes_id" placeholder="(Selecionar)" name="religioes_id" data-live-search="true" data-none-selected-text="(Selecionar)" class="form-control selectpicker" style="width: 100%;">
                                                                          <option  value=""></option>
                                                                          @foreach($religioes as $item)
                                                                                 <option  value="{{$item->id . '|' . $item->nome}}">{{$item->nome}}</option>
                                                                          @endforeach
                                                                          </select>
                                                                   </div><!-- col-xs-5-->
                                                           </div><!-- end row-->

                                                         <div class="row"><!-- row-->

                                                                   <div class="col-xs-5">
                                                                          <label for="graus_id" class="control-label">Grau de Instrução</label>
                                                                          <select id="graus_id" placeholder="(Selecionar)" name="graus_id" data-live-search="true" data-none-selected-text="(Selecionar)" class="form-control selectpicker" style="width: 100%;">
                                                                          <option  value=""></option>
                                                                          @foreach($graus as $item)
                                                                                 <option  value="{{$item->id . '|' . $item->nome}}">{{$item->nome}}</option>
                                                                          @endforeach
                                                                          </select>
                                                                   </div><!-- col-xs-5-->

                                                                   <div class="col-xs-5">
                                                                          <label for="idiomas_id" class="control-label">Idioma</label>
                                                                          <select id="idiomas_id" placeholder="(Selecionar)" name="idiomas_id" data-live-search="true" data-none-selected-text="(Selecionar)" class="form-control selectpicker" style="width: 100%;">
                                                                          <option  value=""></option>
                                                                          @foreach($idiomas as $item)
                                                                                 <option  value="{{$item->id . '|' . $item->nome}}">{{$item->nome}}</option>
                                                                          @endforeach
                                                                          </select>
                                                                   </div><!-- col-xs-5-->

                                                          </div><!-- end row-->

                                                           <div class="row"><!-- row-->
                                                                   <div class="col-xs-5">
                                                                          <label for="formacoes_id" class="control-label">Áreas de Formação</label>
                                                                          <select id="formacoes_id" placeholder="(Selecionar)" name="formacoes_id" data-live-search="true" data-none-selected-text="(Selecionar)" class="form-control selectpicker" style="width: 100%;">
                                                                          <option  value=""></option>
                                                                          @foreach($formacoes as $item)
                                                                                 <option  value="{{$item->id . '|' . $item->nome}}">{{$item->nome}}</option>
                                                                          @endforeach
                                                                          </select>
                                                                   </div><!-- col-xs-5-->

                                                                   <div class="col-xs-5">
                                                                          <label for="profissoes_id" class="control-label">Profissão</label>
                                                                          <select id="profissoes_id" placeholder="(Selecionar)" name="profissoes_id" data-live-search="true" data-none-selected-text="(Selecionar)" class="form-control selectpicker" style="width: 100%;">
                                                                          <option  value=""></option>
                                                                          @foreach($profissoes as $item)
                                                                                 <option  value="{{$item->id . '|' . $item->nome}}">{{$item->nome}}</option>
                                                                          @endforeach
                                                                          </select>
                                                                   </div><!-- col-xs-5-->
                                                           </div><!-- end row-->

                                                           <div class="row"><!-- row-->
                                                                   <div class="col-xs-5">
                                                                          <label for="ramos_id" class="control-label">Ramos de Atividade</label>
                                                                          <select id="ramos_id" placeholder="(Selecionar)" name="ramos_id" data-live-search="true" data-none-selected-text="(Selecionar)" class="form-control selectpicker" style="width: 100%;">
                                                                          <option  value=""></option>
                                                                          @foreach($ramos as $item)
                                                                                 <option  value="{{$item->id . '|' . $item->nome}}">{{$item->nome}}</option>
                                                                          @endforeach
                                                                          </select>
                                                                   </div><!-- col-xs-5-->

                                                                   <div class="col-xs-5">
                                                                          <label for="cargos_id" class="control-label">Cargo / Função</label>
                                                                          <select id="cargos_id" placeholder="(Selecionar)" name="cargos_id" data-live-search="true" data-none-selected-text="(Selecionar)" class="form-control selectpicker" style="width: 100%;">
                                                                          <option  value=""></option>
                                                                          @foreach($cargos as $item)
                                                                                 <option  value="{{$item->id . '|' . $item->nome}}">{{$item->nome}}</option>
                                                                          @endforeach
                                                                          </select>
                                                                   </div><!-- col-xs-5-->
                                                           </div><!-- end row-->


                                                          <div class="row"><!-- row-->
                                                                   <div class="col-xs-5">
                                                                          <label for="disponibilidades_id" class="control-label">Disponibilidade de Tempo</label>
                                                                          <select id="disponibilidades_id" placeholder="(Selecionar)" name="disponibilidades_id" data-live-search="true" data-none-selected-text="(Selecionar)" class="form-control selectpicker" style="width: 100%;">
                                                                          <option  value=""></option>
                                                                          @foreach($disponibilidades as $item)
                                                                                 <option  value="{{$item->id . '|' . $item->nome}}">{{$item->nome}}</option>
                                                                          @endforeach
                                                                          </select>
                                                                   </div><!-- col-xs-5-->

                                                                   <div class="col-xs-5">
                                                                          <label for="tiposrelacionamentos_id" class="control-label">Tipo de Relacionamento</label>
                                                                          <select id="tiposrelacionamentos_id" placeholder="(Selecionar)" name="tiposrelacionamentos_id" data-live-search="true" data-none-selected-text="(Selecionar)" class="form-control selectpicker" style="width: 100%;">
                                                                          <option  value=""></option>
                                                                          @foreach($tiposrelacionamentos as $item)
                                                                                 <option  value="{{$item->id . '|' . $item->nome}}">{{$item->nome}}</option>
                                                                          @endforeach
                                                                          </select>
                                                                   </div><!-- col-xs-5-->
                                                           </div><!-- end row-->


                                                             <div class="row"><!-- row-->
                                                                   <div class="col-xs-5">
                                                                          <label for="dons_id" class="control-label">Dons</label>
                                                                          <select id="dons_id" placeholder="(Selecionar)" name="dons_id" data-live-search="true" data-none-selected-text="(Selecionar)" class="form-control selectpicker" style="width: 100%;">
                                                                          <option  value=""></option>
                                                                          @foreach($dons as $item)
                                                                                 <option  value="{{$item->id . '|' . $item->nome}}">{{$item->nome}}</option>
                                                                          @endforeach
                                                                          </select>
                                                                   </div><!-- col-xs-5-->

                                                                   <div class="col-xs-5">
                                                                          <label for="habilidades_id" class="control-label">Habilidades</label>
                                                                          <select id="habilidades_id" placeholder="(Selecionar)" name="habilidades_id" data-live-search="true" data-none-selected-text="(Selecionar)" class="form-control selectpicker" style="width: 100%;">
                                                                          <option  value=""></option>
                                                                          @foreach($habilidades as $item)
                                                                                 <option  value="{{$item->id . '|' . $item->nome}}">{{$item->nome}}</option>
                                                                          @endforeach
                                                                          </select>
                                                                   </div><!-- col-xs-5-->
                                                           </div><!-- end row-->

                                                              <div class="row"><!-- row-->
                                                                   <div class="col-xs-5">
                                                                          <label for="atividades_id" class="control-label">Atividades</label>
                                                                          <select id="atividades_id" placeholder="(Selecionar)" name="atividades_id" data-live-search="true" data-none-selected-text="(Selecionar)" class="form-control selectpicker" style="width: 100%;">
                                                                          <option  value=""></option>
                                                                          @foreach($atividades as $item)
                                                                                 <option  value="{{$item->id . '|' . $item->nome}}">{{$item->nome}}</option>
                                                                          @endforeach
                                                                          </select>
                                                                   </div><!-- col-xs-5-->

                                                                   <div class="col-xs-5">
                                                                          <label for="ministerios_id" class="control-label">Ministérios</label>
                                                                          <select id="ministerios_id" placeholder="(Selecionar)" name="ministerios_id" data-live-search="true" data-none-selected-text="(Selecionar)" class="form-control selectpicker" style="width: 100%;">
                                                                          <option  value=""></option>
                                                                          @foreach($ministerios as $item)
                                                                                 <option  value="{{$item->id . '|' . $item->nome}}">{{$item->nome}}</option>
                                                                          @endforeach
                                                                          </select>
                                                                   </div><!-- col-xs-5-->
                                                           </div><!-- end row-->

                                                  </div><!-- end row -->

                                             </div>
                                     </div>
                               </div>

                          </div>

                          </div>

                        </div>
                        <!-- /.tab-content -->
                     </div>

                 </div>
                      <!-- nav-tabs-custom -->

                  <div class="overlay modal" style="display: none">
                      <i class="fa fa-refresh fa-spin"></i>
                  </div>

            </div><!-- /.col -->
        </div><!-- /.row -->

    </div><!-- fim box-body"-->

 </div><!-- box box-primary -->

        <div class="box-footer">
            &nbsp;&nbsp;<button class = 'btn btn-primary' type ='submit'>Pesquisar</button>
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


      function validar_datas()
      {

         if (($('#data_entrada').val()!="" && $('#data_entrada_ate').val()=="") || ($('#data_entrada').val()=="" && $('#data_entrada_ate').val()!=""))
         {
              alert('Informe a Data de Entrada Inicial e Final');
              return false;
         }

         if (($('#data_batismo').val()!="" && $('#data_batismo_ate').val()=="") || ($('#data_batismo').val()=="" && $('#data_batismo_ate').val()!=""))
         {
              alert('Informe a Data de Batismo Inicial e Final');
              return false;
         }

         if (($('#data_saida').val()!="" && $('#data_saida_ate').val()=="") || ($('#data_saida').val()=="" && $('#data_saida_ate').val()!=""))
         {
              alert('Informe a Data de Saída Inicial e Final');
              return false;
         }

          myApp.showPleaseWait();
          return true;

       }

      /*Prepara checkbox bootstrap*/
       $(function () {

            $('.ckEstruturas').checkboxpicker({
                offLabel : 'Não',
                onLabel : 'Sim',
            });

            $('.possui_necessidades_especiais').checkboxpicker({
                offLabel : 'Não',
                onLabel : 'Sim',
            });

      });

</script>

@include('configuracoes.script_estruturas')

@endsection