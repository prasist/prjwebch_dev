@extends('principal.master')
@section('content')

{{ \Session::put('titulo', 'Dashboard - ' . \Session::get('label_celulas')) }}
{{ \Session::put('subtitulo', 'Visão Geral') }}
{{ \Session::put('route', 'celulas') }}
{{ \Session::put('id_pagina', '42') }}

<style type="text/css">

    @media print
    {
         body *
         {
           visibility: hidden;
         }

        #printable, #printable *
        {
            visibility: visible;
        }

        #nao_imprimir_1
        {
            display:none;
        }

        #nao_imprimir_2
        {
            display:none;
        }

        #nao_imprimir_3
        {
            display:none;
        }

        #nao_imprimir_4
        {
            display:none;
        }


        #printable
        {
          page-break-inside: auto;
          page-break-after: avoid;
          left: 0;
          top: 0;
          bottom: 0;
          margin: 0;
          padding: 0;
        }
    }

</style>


<!-- Small boxes (Stat box) -->
<div id="nao_imprimir_1" class="row">
  <div class="col-md-12">
    <!-- Widget: user widget style 1 -->
    <div id="arvore" class="box box-widget" style="display: none">

      <div class="box-footer no-padding">

       <div class="row">
          <div class="col-md-12">
             <div class="box-header with-border">
                 <h3 class="box-title">Árvore Hierárquica da Rede</h3>&nbsp;(<i class="text-info">Clique no nível para expandir e exibir os relatório disponíveis.</i>){!! $gerar_treeview !!}
             </div>
          </div>


         <!--
            <div class="col-xs-6">

                  <label for="resultado" class="control-label">Formato de Saída : </label>
                  <select id="resultado" name="resultado" class="form-control selectpicker">
                  <option  value="pdf" data-icon="fa fa-file-pdf-o" selected>PDF (.pdf)</option>
                  <option  value="xlsx" data-icon="fa fa-file-excel-o">Planilha Excel (.xls)</option>
                  <option  value="csv" data-icon="fa fa-file-excel-o">CSV (.csv)</option>
                  <option  value="docx" data-icon="fa fa-file-word-o">Microsoft Word (.docx)</option>
                  <option  value="html" data-icon="fa fa-file-word-o">HTML (.html)</option>
                  <option  value="email" data-icon="fa fa-envelope-o">Listagem de E-mails</option>
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
            -->


      </div>

    </div>
  </div>


</div>
</div>

<div id="nao_imprimir_2" class="row">
          <div class="col-lg-4 col-xs-7">
                    <div class="inner">
                         <center><h4>Total {!! \Session::get('label_participantes') !!}</h4>
                         </center>
                    </div>
                    <div id="tipo_pessoa" style="height: 250px;"></div>
          </div>

          <div class="col-lg-4 col-xs-7">
                    <div class="inner">
                         <center><h4>Quantidade de Visitantes</h4>
                         <p>Últimos 3 meses</p>
                         </center>
                    </div>
                    <div id="visitantes" style="height: 250px;"></div>
          </div>

          <!--
           <div class="col-lg-4 col-xs-7">

                <div class="input-group margin">
                  <div class="input-group-btn">
                    <button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown"><span class="fa fa-print"></span>  Estatísticas
                        <span class="fa fa-caret-down"></span></button>
                        <ul class="dropdown-menu">

                              <li><a href="#" onclick="abrir_relatorio('1');">Total Geral de Células</a></li>
                              <li><a href="#" onclick="abrir_relatorio('2');">Resumo</a></li>

                        </ul>
                  </div>
                  <br/>
              </div>

            </div>-->

</div>


<div class="row">
    <div class="col-md-12">

     <div id="printable" class="row">
        <div class="col-md-12">
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">Visão Geral - {!!$mostrar_texto!!}</h3>

              <div id="nao_imprimir_4" class="box-tools pull-right">

                <!--<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>-->
                <!--<button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>-->
                <button type="button" class="btn btn-box-tool"><a href="#" onclick="window.print();"><i class="fa fa-print"></i>&nbsp;Clique Aqui para Imprimir</a></button>

            </div>
          </div>

        <!-- /.box-header -->
        <div class="box-body">
          <div class="row">
            <div class="col-md-12">
              <!-- Widget: user widget style 1 -->
              <div class="box box-widget">

                <div class="box-footer no-padding">

                 <div class="row">

                        <div class="col-xs-4">
                              <h4>&nbsp;&nbsp;&nbsp;&nbsp;{!! \Session::get('label_celulas') !!}</h4>
                              <ul class="nav nav-stacked">

                                    <li>
                                        <a href="#">&nbsp;{!! \Session::get('label_celulas') !!} em Atividade
                                            <span class="pull-left badge bg-blue">{!! $total_celulas !!}</span>
                                        </a>
                                    </li>

                                    <li>
                                        <a href="#">{!! \Session::get('label_participantes') !!} :
                                            <span class="pull-right badge bg-green">{!! $total_participantes !!}</span>
                                        </a>

                                        @if ($resumo_tipo_pessoas)
                                        <ul style="list-style-type:none">
                                            @foreach($resumo_tipo_pessoas as $item)
                                            <li>
                                                {!! $item->nome !!}
                                                    <span class="pull-right badge bg-blue">{!! $item->total !!}</span>
                                            </li>
                                            @endforeach

                                        </ul>
                                        @endif
                                    </li>


                                   @if ($celulas_faixas)
                                         <h4>&nbsp;&nbsp;&nbsp;&nbsp;Por Faixa Etária</h4>

                                          @foreach($celulas_faixas as $item)
                                          <li>
                                              <a href="#">&nbsp;{!! $item->nome !!}
                                                  <span class="pull-left badge bg-blue">{!! $item->total !!}</span>
                                              </a>
                                          </li>
                                          @endforeach
                                    @endif

                                    @if ($celulas_publicos)
                                          <h4>&nbsp;&nbsp;&nbsp;&nbsp;Público Alvo</h4>

                                          @foreach($celulas_publicos as $item)
                                          <li>
                                              <a href="#">&nbsp;{!! $item->nome !!}
                                                  <span class="pull-left badge bg-blue">{!! $item->total !!}</span>
                                              </a>
                                          </li>
                                          @endforeach
                                    @endif

                                </ul>
                          </div>

                          <div id="nao_imprimir_3">
                             <input id="ano"  name = "ano" type="number" value="" placeholder="Ano">
                             <select id="mes" placeholder="(Selecionar Mês)" name="mes" onchange="filtrar_resumos(this);" data-none-selected-text="Nenhum item selecionado" >
                             <option  value="">(Selecionar Mês)</option>
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


                          @if ($resumo)
                          <div class="col-xs-6">

                              <h4>&nbsp;&nbsp;&nbsp;&nbsp;Resumo {!! \Session::get('label_encontros') !!}</h4>
                              <ul class="nav nav-stacked">

                                    <li>
                                        <a href="#">&nbsp;Total Geral Presentes
                                            <span class="pull-right badge bg-green">{!! $resumo[0]->total_geral !!}</span>
                                        </a>
                                    </li>

                                    <ul style="list-style-type:none">
                                          <li>
                                              Visitantes<span class="pull-right badge bg-blue">{!! $resumo[0]->total_visitantes !!}</span>
                                          </li>

                                          <li>
                                              Membros
                                              <span class="pull-right badge bg-yellow">{!! $resumo[0]->total_membros !!}</span>
                                          </li>

                                    </ul>

                                    <br/>
                                    @foreach($resumo_perguntas as $item)
                                    <li>
                                        <a href="#">&nbsp;{!! $item->pergunta !!}
                                            <span class="pull-right badge bg-blue">{!! $item->total !!}</span>
                                        </a>
                                    </li>
                                    @endforeach

                                </ul>
                          </div>
                          @else
                           <div class="col-xs-6">

                                  <h4>&nbsp;&nbsp;&nbsp;&nbsp;Resumo {!! \Session::get('label_encontros') !!} (Mês Corrente)</h4>
                                  <ul class="nav nav-stacked">

                                        <li>
                                            Sem dados estatísticos de {!! \Session::get('label_encontros') !!} até o momento.
                                        </li>
                                  </ul>
                           </div>

                          @endif

                </div> <!-- end row-->


             </div>
          </div>

      </div>

          <div class="overlay modal" style="display: none">
              <i class="fa fa-refresh fa-spin"></i>
          </div>


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


/*
FILTRAR RESUMOS ESTATISTICO CONFORME MES ANO SELECIONADOS
*/
function filtrar_resumos(objeto) {
        var selectBox =  objeto;
        var selectedValue = selectBox.options[selectBox.selectedIndex].value;
        var ano = $('#ano').val();

        if (selectedValue!="" && ano !="") {
            myApp.showPleaseWait();
            chamar_dashboard(selectedValue, ano);
        }

}



function changeFunc(objeto, nivel, valor, nome) {

      var selectBox =  objeto;
      var selectedValue = selectBox.options[selectBox.selectedIndex].value;

      //var selectSaida =  document.getElementById("resultado");
      //var saida = selectSaida.options[selectSaida.selectedIndex].value;

      if (selectedValue!="") {
          //Abre Relatorio conforme parametros passados
          myApp.showPleaseWait();
          abrir_relatorio_nivel(selectedValue, nivel, valor, nome, "pdf");
      }
}

/*
CHAMADA ROUTE DASHBOARD COM MES ANO ESPECIFICOS
*/
 function chamar_dashboard(mes, ano) {
         var urlGetUser = '';
         urlGetUser = '{!! url("/dashboard_celulas/' +  mes + '/' + ano + '") !!}';
         window.location.href =urlGetUser;
 }


  //resumo anual por estrutura
 function abrir_relatorio_nivel(tipo, nivel, valor, nome, saida)  {
         var urlGetUser = '';
         urlGetUser = '{!! url("/estatisticas_nivel/' +  tipo + '/' + nivel+ '/' + valor + '/' + nome + '/' + saida + '") !!}';
         window.location.href =urlGetUser;
  }

  //resumo anual
  function abrir_relatorio(tipo)
  {
          var urlGetUser = '{!! url("/estatisticas/' +  tipo + '") !!}';
          window.location.href =urlGetUser;
  }

 function chamar_grafico(mes, ano) {

   //-------------------------Grafico visitantes
      var var_json = (function () {


            var var_json = null;

            var urlGetUser = '{!! url("/grafico_celulas/visitantes/' +  mes + '/' + ano + '") !!}';

            $.ajax({
                'async': false,
                'global': false,
                'url': urlGetUser,
                'dataType': "json",
                'success': function (data) {
                    var_json = data;
                }
            });
            return var_json;
        })
        ();

         Morris.Bar({
          element: 'visitantes',
          data: var_json,
          xkey: 'mes',
          ykeys: ['total'],
          labels: ['Visitantes']
        });
     //---------------------FIM


 }


 function chamar_grafico_2(mes, ano) {

    //-----------------------Grafico Total Por Tipo de Pessoa
      var var_json = (function () {
            var var_json = null;

            var urlGetUser = '{!! url("/grafico_celulas/tipo_pessoa/' +  mes + '/' + ano + '") !!}';

            $.ajax({
                'async': false,
                'global': false,
                'url': urlGetUser,
                'dataType': "json",
                'success': function (data) {
                    var_json = data;
                }
            });
            return var_json;
        })
        ();

        Morris.Donut({
          element: 'tipo_pessoa',
           colors: [
            '#0BA462',
            '#39B580',
            '#67C69D',
            '#95D7BB'
          ],
          data: var_json
        });

        //---------------------FIM
 }


    $(document).ready(function(){

      //so mostrat div quando load pagina
       $('#arvore').show();

       //expandir menu
       $("#menu_celulas").addClass("treeview active");

       var var_month = moment().format('M');
       var var_year = moment().format('YYYY');

       chamar_grafico(var_month, var_year); //MONTA GRAFICOS
       chamar_grafico_2(var_month, var_year);  //MONTA GRAFICOS


     });
 //}


</script>


@include('configuracoes.script_estruturas')


@endsection