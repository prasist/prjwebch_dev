       <div class = 'row'>

                                   <div class="col-md-12">

                                    <form method = 'POST'  class="form-horizontal" action = "{{ url('/relcelulas/pesquisar/encontro')}}">

                                    {!! csrf_field() !!}

                                     <input  id= "ckExibir" name="ckExibir" type="hidden"  value="" />

                                      <div class="box box-default">

                                            <div class="box-body">

                                              <div class="row">
                                                  <div class="col-md-12">

                                                   <!-- Custom Tabs -->
                                                    <div class="nav-tabs-custom">

                                                      <ul class="nav nav-tabs">
                                                        <li class="active"><a href="#tab_filtros" data-toggle="tab">Filtros Básicos</a></li>
                                                        <li><a href="#tab_estruturas" data-toggle="tab">Filtrar Estrutura de {!! \Session::get('label_celulas') !!}</a></li>
                                                      </ul>

                                                      <div class="tab-content">
                                                        <div class="tab-pane active" id="tab_filtros">

                                                            <div class="row">

                                                                 <div class="col-xs-3">
                                                                         <label for="tiporel" class="control-label">Tipo Relatório</label>
                                                                         <select id="tiporel" placeholder="(Selecionar)" onchange="exibir_campos();" name="tiporel" data-none-selected-text="Nenhum item selecionado" class="form-control" style="width: 100%;">
                                                                            <option  value="0" selected>Relatório Padrão</option>
                                                                            <option  value="1">Resumo Anual</option>
                                                                            <option  value="2">Resumo Mensal</option>
                                                                            <option  value="3">Visitantes</option>
                                                                         </select>
                                                                 </div>


                                                                <div id="div_part" class="col-xs-3">
                                                                      <label for="ckExibir" class="control-label">Listar {!! \Session::get('label_participantes') !!}</label>
                                                                      <div class="input-group">
                                                                             <div class="input-group-addon">
                                                                                  <input  id= "ckExibir" name="ckExibir" type="checkbox" class="ckExibir" data-group-cls="btn-group-sm" />
                                                                             </div>
                                                                      </div>
                                                                </div>

                                                                @if ($encontro)

                                                                <div id="div_cursos" class="col-xs-3">
                                                                      <label for="ckExibirCurso" class="control-label">Listar Resumo Cursos/Eventos</label>
                                                                      <div class="input-group">
                                                                             <div class="input-group-addon">
                                                                                  <input  id= "ckExibirCurso" name="ckExibirCurso" type="checkbox" class="ckExibir" data-group-cls="btn-group-sm" />
                                                                             </div>
                                                                      </div>
                                                                </div>

                                                                @endif


                                                                 <div id="div_grafico" class="col-xs-3" style="display: none">
                                                                      <label for="ckExibirGraf" class="control-label">Exibir Gráfico</label>
                                                                      <div class="input-group">
                                                                             <div class="input-group-addon">
                                                                                  <input  id= "ckExibirGraf" name="ckExibirGraf" type="checkbox" class="ckExibir" data-group-cls="btn-group-sm" checked />
                                                                             </div>
                                                                      </div>
                                                                </div>


                                                            </div> <!-- end row -->


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

                                                                    <div id="div_mes_inicial" class="col-xs-3">
                                                                         <label for="mes" class="control-label">Mês</label>
                                                                         <select id="mes" placeholder="(Selecionar)" name="mes" data-none-selected-text="Nenhum item selecionado" class="form-control" style="width: 100%;">
                                                                         <option  value=""></option>
                                                                         <option  value="01" {{ (date('m')==1 ? 'selected' : '') }} >Janeiro</option>
                                                                         <option  value="02" {{ (date('m')==2 ? 'selected' : '') }} >Fevereiro</option>
                                                                         <option  value="03" {{ (date('m')==3 ? 'selected' : '') }} >Março</option>
                                                                         <option  value="04" {{ (date('m')==4 ? 'selected' : '') }} >Abril</option>
                                                                         <option  value="05" {{ (date('m')==5 ? 'selected' : '') }} >Maio</option>
                                                                         <option  value="06" {{ (date('m')==6 ? 'selected' : '') }} >Junho</option>
                                                                         <option  value="07" {{ (date('m')==7 ? 'selected' : '') }} >Julho</option>
                                                                         <option  value="08" {{ (date('m')==8 ? 'selected' : '') }} >Agosto</option>
                                                                         <option  value="09" {{ (date('m')==9 ? 'selected' : '') }} >Setembro</option>
                                                                         <option  value="10" {{ (date('m')==10 ? 'selected' : '') }} >Outubro</option>
                                                                         <option  value="11" {{ (date('m')==11 ? 'selected' : '') }} >Novembro</option>
                                                                         <option  value="12" {{ (date('m')==12 ? 'selected' : '') }} >Dezembro</option>
                                                                          </select>
                                                                    </div>

                                                                    <div id="div_mes_final" class="col-xs-3" style="display: none">
                                                                         <label for="mes_final" class="control-label">Mês Final</label>
                                                                         <select id="mes_final" placeholder="(Selecionar)" name="mes_final" data-none-selected-text="Nenhum item selecionado" class="form-control" style="width: 100%;">
                                                                         <option  value=""></option>
                                                                         <option  value="01">Janeiro</option>
                                                                         <option  value="02">Fevereiro</option>
                                                                         <option  value="03">Março</option>
                                                                         <option  value="04">Abril</option>
                                                                         <option  value="05">Maio</option>
                                                                         <option  value="06">Junho</option>
                                                                         <option  value="07">Julho</option>
                                                                         <option  value="08">Agosto</option>
                                                                         <option  value="09">Setembro</option>
                                                                         <option  value="10">Outubro</option>
                                                                         <option  value="11">Novembro</option>
                                                                         <option  value="12">Dezembro</option>
                                                                          </select>
                                                                    </div>

                                                                    <div id="div_ano_inicial" class="col-xs-2">
                                                                          <label for="ano" class="control-label">Ano</label>
                                                                          <input id="ano"  name = "ano" type="number" class="form-control" value="{{date('Y')}}">
                                                                    </div>

                                                                    <div id="div_ano_final" class="col-xs-2"  style="display: none">
                                                                          <label for="ano_final" class="control-label">Ano Final</label>
                                                                          <input id="ano_final"  name = "ano_final" type="number" class="form-control" value="{{date('Y')}}">
                                                                    </div>

                                                            </div>

                                                            <div class="row">
                                                                    <div class="col-xs-12">
                                                                          <label for="regiao" class="control-label">Região</label>
                                                                          <input id="regiao"  placeholder="(Opcional)" name = "regiao" type="text" class="form-control" value="">
                                                                    </div>
                                                            </div>

                                                           <div class="row">
                                                                <div class="col-xs-6">
                                                                      <label for="publico_alvo" class="control-label">Público Alvo</label>
                                                                      <select id="publico_alvo" placeholder="(Selecionar)" name="publico_alvo" data-live-search="true" data-none-selected-text="Nenhum item selecionado" class="form-control selectpicker" style="width: 100%;">
                                                                            <option  value="0"></option>
                                                                              @foreach($publicos as $item)
                                                                                     <option  value="{{$item->id . '|' . $item->nome}}" >{{$item->nome}}</option>
                                                                              @endforeach
                                                                      </select>
                                                                </div>

                                                                <div class="col-xs-6">
                                                                      <label for="faixa_etaria" class="control-label">Faixa Etária</label>
                                                                      <select id="faixa_etaria" placeholder="(Selecionar)" name="faixa_etaria" data-live-search="true" data-none-selected-text="Nenhum item selecionado" class="form-control selectpicker" style="width: 100%;">
                                                                            <option  value="0"></option>
                                                                              @foreach($faixas as $item)
                                                                                     <option  value="{{$item->id . '|' . $item->nome}}" >{{$item->nome}}</option>
                                                                              @endforeach
                                                                      </select>
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

                                                        <div class="tab-pane" id="tab_estruturas">
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

      $("#tiporel").prop("selectedIndex", 0); //POSICIONE NO PADRAO

      function exibir_campos() {

            if ($('#tiporel').val()=="1") { //RESUMO ANUAL
                $('#div_ano_final').show();
                $('#div_ano_inicial').show();
                $('#div_mes_inicial').hide();
                $('#div_mes_final').hide();
                $('#div_part').hide();
                $('#div_cursos').hide();
                $('#div_grafico').show();

            } else if ($('#tiporel').val()=="2") { //RESUMO MENSAL

                $('#div_ano_final').hide();
                $('#div_ano_inicial').show();
                $('#div_mes_inicial').show();
                $('#div_mes_final').show();
                $('#div_part').hide();
                $('#div_cursos').hide();
                $('#div_grafico').show();

            } else if ($('#tiporel').val()=="0") { //PADRAO

                $('#div_ano_final').hide();
                $('#div_ano_inicial').show();
                $('#div_mes_inicial').show();
                $('#div_mes_final').hide();
                $('#div_part').show();
                $('#div_cursos').show();
                $('#div_grafico').hide();

            } else if ($('#tiporel').val()=="3") { //PADRAO

                $('#div_ano_final').hide();
                $('#div_ano_inicial').show();
                $('#div_mes_inicial').show();
                $('#div_mes_final').hide();
                $('#div_part').hide();
                $('#div_cursos').hide();
                $('#div_grafico').hide();

            }



      }

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

