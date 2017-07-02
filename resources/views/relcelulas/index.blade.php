@extends('principal.master')

@section('content')

{{ \Session::put('titulo', 'Relatório de ' . \Session::get('label_celulas')) }}
{{ \Session::put('subtitulo', 'Listagem') }}
{{ \Session::put('route', 'relcelulas') }}
{{ \Session::put('id_pagina', '46') }}

<div class = 'row'>

 <div class="col-md-12">

  <form method = 'POST'  class="form-horizontal" action = "{{ url('/' . \Session::get('route') . '/pesquisar/celulas')}}">

  {!! csrf_field() !!}

    <div class="box box-default">

          <div class="box-body">

            <div class="row">
                <div class="col-md-12">

                <input  id= "ckEstruturas" name="ckEstruturas" type="hidden" class="minimal" />
                <input  id= "ckExibir" name="ckExibir" type="hidden" class="minimal"  />
                <input  id= "ckExibirDadosParticipantes" name="ckExibirDadosParticipantes" type="hidden" class="minimal"  />

                 <!-- Custom Tabs -->
                  <div class="nav-tabs-custom">

                    <ul class="nav nav-tabs">
                      <li class="active"><a href="#tab_1" data-toggle="tab">Filtros Básicos</a></li>
                      <li><a href="#tab_2" data-toggle="tab">Filtrar Estrutura de {!! \Session::get('label_celulas') !!}</a></li>
                    </ul>

                    <div class="tab-content">
                      <div class="tab-pane active" id="tab_1">

                          <div class="row">
                                  <div class="col-xs-3">
                                        <label for="tipo" class="control-label">Tipo Relatório</label>
                                        <select id="tipo"  name="tipo" class="form-control">
                                            <option  value="S">Sintético (Nome {!! \Session::get('label_celulas_singular') !!} / {!! \Session::get('label_lider_singular') !!})</option>
                                            <option  value="C">Completo (Nome {!! \Session::get('label_celulas_singular') !!} / {!! \Session::get('label_lider_singular') !!}, Endereço, Telefone e Email do {!! \Session::get('label_lider_singular') !!})</option>
                                        </select>
                                  </div>

                                <div class="col-xs-3">
                                      <label for="ckEstruturas" class="control-label">Listar Estruturas {!! \Session::get('label_celulas') !!}</label>
                                      <div class="input-group">
                                             <div class="input-group-addon">
                                                  <input  id= "ckEstruturas" name="ckEstruturas" data-group-cls="btn-group-sm" type="checkbox" class="ckEstruturas" checked />
                                             </div>
                                      </div>
                                </div>

                                <div class="col-xs-3">
                                      <label for="ckExibir" class="control-label">Listar {!! \Session::get('label_participantes') !!}</label>
                                      <div class="input-group">
                                             <div class="input-group-addon">
                                                  <input  id= "ckExibir" name="ckExibir" type="checkbox" class="ckExibir" data-group-cls="btn-group-sm" checked />
                                             </div>
                                      </div>
                                </div>

                                <div class="col-xs-3">
                                      <label for="ckExibirDadosParticipantes" class="control-label">Exibir Dados {!! \Session::get('label_participantes') !!}</label>
                                      <div class="input-group">
                                             <div class="input-group-addon">
                                                  <input  id= "ckExibirDadosParticipantes" name="ckExibirDadosParticipantes" type="checkbox" class="ckExibir" data-group-cls="btn-group-sm" checked  />
                                             </div>
                                      </div>
                                </div>

                          </div>

                          <div class="row">

                                <div class="col-xs-6">
                                        <label for="lideres" class="control-label">{!! \Session::get('label_lider_singular') !!}</label>
                                        <select id="lideres" placeholder="(Selecionar)" name="lideres" data-live-search="true" data-none-selected-text="Nenhum item selecionado" class="form-control selectpicker" style="width: 100%;">
                                              <option  value="0"></option>
                                                @foreach($lideres as $item)
                                                       <option  value="{{$item->id . '|' . $item->nome}}" >{{$item->nome}}</option>
                                                @endforeach
                                        </select>
                                </div>

                                <div class="col-xs-6">
                                        <label for="vice_lider" class="control-label">{!! \Session::get('label_lider_treinamento') !!}</label>
                                        <select id="vice_lider" placeholder="(Selecionar)" name="vice_lider" data-live-search="true" data-none-selected-text="Nenhum item selecionado" class="form-control selectpicker" style="width: 100%;">
                                              <option  value="0"></option>
                                                @foreach($vice_lider as $item)
                                                       <option  value="{{$item->id . '|' . $item->nome}}" >{{$item->nome}}</option>
                                                @endforeach
                                        </select>
                                </div>

                          </div>

                          <div class="row">

                                  <div class="col-xs-3">
                                        <label for="dia_encontro" class="control-label">Dia Encontro</label>
                                        <select id="dia_encontro" placeholder="(Selecionar)" name="dia_encontro" data-live-search="true" data-none-selected-text="Nenhum item selecionado" class="form-control" style="width: 100%;">
                                        <option  value=""></option>
                                        <option  value="1">Segunda-Feira</option>
                                        <option  value="2">Terça-Feira</option>
                                        <option  value="3">Quarta-Feira</option>
                                        <option  value="4">Quinta-Feira</option>
                                        <option  value="5">Sexta-Feira</option>
                                        <option  value="6">Sábado</option>
                                        <option  value="0">Domingo</option>
                                        </select>
                                  </div>

                                  <div class="col-xs-3">
                                        <label for="turno" class="control-label">Turno</label>
                                        <select id="turno" placeholder="(Selecionar)" name="turno" data-live-search="true" data-none-selected-text="Nenhum item selecionado" class="form-control" style="width: 100%;">
                                        <option  value=""></option>
                                        <option  value="M">Manhã</option>
                                        <option  value="T">Tarde</option>
                                        <option  value="N">Noite</option>
                                        </select>
                                  </div>

                                  <div class="col-xs-3">
                                        <label for="regiao" class="control-label">Região</label>
                                        <input id="regiao"  placeholder="(Opcional)" name = "regiao" type="text" class="form-control" value="">
                                  </div>

                                  <div class="col-xs-3">
                                        <label for="segundo_dia_encontro" class="control-label">Segundo Dia Encontro</label>
                                        <select id="segundo_dia_encontro" placeholder="(Selecionar)" name="segundo_dia_encontro" data-live-search="true" data-none-selected-text="Nenhum item selecionado" class="form-control" style="width: 100%;">
                                        <option  value=""></option>
                                        <option  value="1">Segunda-Feira</option>
                                        <option  value="2">Terça-Feira</option>
                                        <option  value="3">Quarta-Feira</option>
                                        <option  value="4">Quinta-Feira</option>
                                        <option  value="5">Sexta-Feira</option>
                                        <option  value="6">Sábado</option>
                                        <option  value="0">Domingo</option>
                                        </select>
                                  </div>
                          </div>

                          <div class="row">

                              <div class="col-xs-3">
                                    <label for="publico_alvo" class="control-label">Público Alvo</label>
                                    <select id="publico_alvo" placeholder="(Selecionar)" name="publico_alvo" data-live-search="true" data-none-selected-text="Nenhum item selecionado" class="form-control selectpicker" style="width: 100%;">
                                          <option  value="0"></option>
                                            @foreach($publicos as $item)
                                                   <option  value="{{$item->id . '|' . $item->nome}}" >{{$item->nome}}</option>
                                            @endforeach
                                    </select>
                              </div>

                              <div class="col-xs-3">
                                    <label for="faixa_etaria" class="control-label">Faixa Etária</label>
                                    <select id="faixa_etaria" placeholder="(Selecionar)" name="faixa_etaria" data-live-search="true" data-none-selected-text="Nenhum item selecionado" class="form-control selectpicker" style="width: 100%;">
                                          <option  value="0"></option>
                                            @foreach($faixas as $item)
                                                   <option  value="{{$item->id . '|' . $item->nome}}" >{{$item->nome}}</option>
                                            @endforeach
                                    </select>
                              </div>

                              <div class="col-xs-3">
                                    <label for="qtd_inicial" class="control-label">Qtd. Multiplicações - Inicial</label>
                                    <input type="number" name="qtd_inicial" value="" class="form-control">
                              </div>

                              <div class="col-xs-3">
                                    <label for="qtd_final" class="control-label">Qtd. Multiplicações - Final</label>
                                    <input type="number" name="qtd_final" value="" class="form-control">
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
                          </div>

                      </div>
                      <!-- /.tab-pane -->

                      <div class="tab-pane" id="tab_2">
                            <!-- Horizontal Form -->
                             <div class="box box-default">
                                  <div class="box-header with-border">
                                    <h3 class="box-title">Estrutura de {!! \Session::get('label_celulas') !!}</h3>
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

        /*Prepara checkbox bootstrap*/
       $(function () {

            $("#menu_celulas").addClass("treeview active");

            $('.ckEstruturas').checkboxpicker({
                offLabel : 'Não',
                onLabel : 'Sim',
            });

            $('.ckExibir').checkboxpicker({
                offLabel : 'Não',
                onLabel : 'Sim',
            });

      });


</script>

@include('configuracoes.script_estruturas')
@endsection