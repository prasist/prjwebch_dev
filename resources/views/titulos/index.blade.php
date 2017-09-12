@extends('principal.master')

@section('content')

@if ($tipo=="P")
      {{ \Session::put('titulo', 'Contas à Pagar') }}
@else
      {{ \Session::put('titulo', 'Contas à Receber') }}
@endif

{{ \Session::put('subtitulo', 'Listagem') }}
{{ \Session::put('route', 'titulos') }}
{{ \Session::put('id_pagina', '52') }}

        <div id="_token" class="hidden" data-token="{{ csrf_token() }}"></div>
        <div>{{{ $errors->first('erros') }}}</div>

        <div class="row">
              <div class="col-xs-2">
              @can('verifica_permissao', [ \Session::get('id_pagina'),'incluir'])
                 <form method = 'get' class="form-horizontal" action = "{{ url('/' . \Session::get('route') . '/registrar/' . $tipo)}}">
                      <button class = 'btn btn-success btn-flat' type ='submit'><span class="fa fa-plus"></span> {!! ($tipo=="P" ? "Nova Despesa" : "Nova Receita")!!}</button>
                 </form>
              @endcan
              </div>

              <form method = 'post' class="form-horizontal" action = "{{ url('/' . \Session::get('route') . '/filtrar/' . $tipo)}}">
              {!! csrf_field() !!}

                <div class="col-xs-3">
                         <select name="status" id="status" class="form-control selectpicker" data-style="btn-primary" style="width: 100%;">
                         <option  style="background: #2A4F6E; color: #fff;" value="T" {{ $post_status == 'T' ? 'selected' : ''}}>Mostrar Todos</option>
                         <option  style="background: #F1E8B8; color: #000;" value="A" {{ $post_status == 'A' ? 'selected' : ''}} selected>Somente em Aberto</option>
                         <option  style="background: #2A7E43; color: #fff;" value="B"{{ $post_status == 'B' ? 'selected' : ''}}>Somente Baixados</option>
                         </select>
                </div>

                <div class="col-xs-3">
                         <select name="mes" id="mes" class="form-control selectpicker" data-style="btn-info" style="width: 100%;">
                         <option  value="" >(Nenhum Filtro)</option>
                         <option  value="C" {{ $post_mes == 'C' ? 'selected' : ''}}>Mês Corrente</option>
                         <option  value="E" {{ $post_mes == 'E' ? 'selected' : ''}}>Período Específico...</option>
                         <option  value="M" {{ $post_mes == 'M' ? 'selected' : ''}}>Mais opções...</option>
                         </select>
                         <div id="div_periodo" style="display: none">
                                <div class="input-group">
                                     <div class="input-group-addon">
                                      <i class="fa fa-calendar"></i>
                                      </div>
                                      <input id ="data_inicial" name = "data_inicial" onblur="validar_data(this);" type="text" class="form-control" data-inputmask='"mask": "99/99/9999"' data-mask  value="">
                                      <input id ="data_final" name = "data_final" onblur="validar_data(this);" type="text" class="form-control" data-inputmask='"mask": "99/99/9999"' data-mask  value="">
                              </div>
                         </div>

                         <div id="div_opcoes" style="display: none">

                                 <div class="row">
                                         <select id="pesq_plano_contas"  name="pesq_plano_contas" data-live-search="true" data-none-selected-text="Plano de Contas" class="form-control selectpicker" style="width: 100%;">
                                          <option  value=""></option>
                                          @foreach($plano_contas as $item)
                                                 <option  value="{{$item->id}}" >{{$item->nome}}</option>
                                          @endforeach
                                          </select>
                                 </div>

                                 <div class="row">
                                         <select id="pesq_centros_custos"  name="pesq_centros_custos" data-live-search="true" data-none-selected-text="Centro de Custo" class="form-control selectpicker" style="width: 100%;">
                                          <option  value=""></option>
                                          @foreach($centros_custos as $item)
                                                 <option  value="{{$item->id}}" >{{$item->nome}}</option>
                                          @endforeach
                                          </select>
                                 </div>

                                 <div class="row">

                                        <div class="input-group">
                                                 <div class="input-group-addon">
                                                    <button  id="buscarpessoa" type="button"  data-toggle="modal" data-target="#modal_fornecedor" >
                                                           <i class="fa fa-search"></i> ...
                                                     </button>
                                                  </div>

                                                  @include('modal_buscar_pessoas', array('qual_campo'=>'pesq_fornecedor', 'modal' => 'modal_fornecedor'))

                                                  <input id="pesq_fornecedor"  name = "pesq_fornecedor" type="text" class="form-control" placeholder="Cliente / Fornecedor..." value="" readonly >

                                          </div>
                                 </div>

                         </div>

                </div>

                <div class="col-xs-2">
                        <button class = 'btn btn-default btn-flat' type ='submit' onclick="myApp.showPleaseWait();"><span class="glyphicon glyphicon-new-window"></span> Aplicar Filtro</button>
                </div>

                </form>


        </div>

      <p></p>

      <form id="lote" method = 'post' class="form-horizontal" action = "{{ url('/' . \Session::get('route') . '/acao_lote/' . $tipo)}}">
        {!! csrf_field() !!}

        <input type="hidden" id="quero_fazer" name="quero_fazer" value="">
        <input type="hidden" id="data_pagto_lote" name="data_pagto_lote" value="">

        <div class="row">

          <div class="col-xs-5">

              <!--
                <a href="#" id="queromais"><i class="fa fa-cog"></i> Alterar dados para Baixa Automática (Data de Pagamento / Conta Corrente)</a>

                <div id="div_opcoes_baixa" style="display: none">

                      <div class="row">
                            <div class="col-xs-3">
                                  <label for="dt_pagto" class="control-label">Data Pagamento</label>
                                  <input id ="dt_pagto" name = "dt_pagto" onblur="validar_data(this);" type="text" class="form-control" data-inputmask='"mask": "99/99/9999"' data-mask  value="{{ date('d-m-Y')}}">
                            </div>

                            <div class="col-xs-5">
                                  <label for="contacorrente" class="control-label">Conta Corrente</label>
                                  <select id="contacorrente" name="contacorrente" placeholder="(Selecionar)" data-live-search="true" data-none-selected-text="Nenhum item selecionado" class="form-control selectpicker" style="width: 100%;">
                                  <option  value=""></option>
                                  @foreach($contas as $item)
                                         <option  value="{{$item->id}}">{{$item->nome}}</option>
                                  @endforeach
                                  </select>
                            </div>
                      </div>
                      <p></p>

                </div>
                -->

<!-- MODAL PARA BAIXA AUTOMATICA -->
                  <!-- Modal -->
                      <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                            <div class="modal-dialog  modal-lg" role="document">
                              <div class="modal-content">
                                <div class="modal-header">
                                  <!--<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>-->
                                  <h4 class="modal-title" id="myModalLabel">Dados para Baixa Automática</h4>
                                </div>
                                <div class="modal-body">

                                      <div class="row">
                                          <div class="col-xs-3">
                                                <label for="dt_pagto" class="control-label">Data Pagamento</label>
                                                <input id ="dt_pagto" name = "dt_pagto" onblur="validar_data(this);" type="text" class="form-control" data-inputmask='"mask": "99/99/9999"' data-mask  value="{{ date('d-m-Y')}}">
                                          </div>

                                          <div class="col-xs-5">
                                                <label for="contacorrente" class="control-label">Conta Corrente <i>(Opcional)</i></label>
                                                <select id="contacorrente" name="contacorrente" placeholder="(Selecionar)" data-live-search="true" data-none-selected-text="Nenhum item selecionado" class="form-control selectpicker" style="width: 100%;">
                                                <option  value=""></option>
                                                @foreach($contas as $item)
                                                       <option  value="{{$item->id}}">{{$item->nome}}</option>
                                                @endforeach
                                                </select>
                                          </div>
                                    </div>

                                </div>

                                </div>
                                <div class="modal-footer">
                                    <button id="fechar" type="button" class="btn btn-default" data-dismiss="modal" ><i class="fa fa-close"></i> Cancelar</button>
                                    <button id="salvar" type="button" class="btn btn-primary" data-dismiss="modal" onclick="if(confirm('Confirma o Pagamento dos Títulos Selecionados ?')) acao('baixar');"><i class="fa fa-save"></i> Ok</button>
                                </div>
                              </div>
                            </div>
                   <!-- fim modal -->

                <div class="btn-group">
                  <button type="button" class="btn btn-default">Ações (Selecionados)</button>
                  <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                    <span class="caret"></span>
                    <span class="sr-only">Toggle Dropdown</span>
                  </button>
                  <ul class="dropdown-menu" role="menu">
                      <!--<li><a href="#" onclick="if(confirm('Confirma o Pagamento dos Títulos Selecionados ?')) acao('baixar');"><i class="fa fa-thumbs-o-up"></i> Definir como Pago</a></li>-->

                      <li>
                            <a href="#" data-toggle="modal" data-target="#myModal"><i class="fa fa-thumbs-o-up"></i> Definir como Pago</a>
                      </li>

                      <li><a href="#" onclick="if(confirm('Deseja marcar os Títulos Selecionados como NÃO PAGO ?')) acao('estornar');"><i class="fa fa-thumbs-o-down"></i> Definir como NÃO Pago</a></li>
                      <!--<li><a href="#" onclick="if(confirm('ATENÇÃO !!! Confirma a exclusão dos Títulos Selecionados ? Essa ação não tem reversão')) baixar_todos(event);"><i class="glyphicon glyphicon-trash"></i> Excluir</a></li>-->
                  </ul>
                </div>

          </div>



        <div class="col-md-12">
          <div class="box">
            <div class="box-header">

                <div class="box-body">

                    <table id="table_titulos" class="table table-bordered table-hover">
                    <thead>
                        <tr>
                        <th><input  id="check_todos" name="check_todos" type="checkbox" /></th>
                        <th>Data Venc.</th>
                        <th>Descrição</th>
                        <th>Valor</th>
                        <th>Data Pagto.</th>
                        <th>Dias Atraso</th>
                        <th>Acrésc.</th>
                        <th>Desc.</th>
                        <th>Valor Pago</th>
                        <th>Pago</th>
                        <th>Saldo</th>
                        <th>Editar</th>
                        <th>Excluir</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($dados as $value)

                        <tr>

                            <td><input  id="check_id[{!!$value->id!!}]" name="check_id[{!!$value->id!!}]" type="checkbox" class="check_id"  /></td>
                            <td>

                                    <a href="#" class="data_venc" data-type="text" data-column="data_venc" data-url="{{ url('/titulos/' . $value->id . '/update_inline/data_venc/' . $tipo)}}" data-pk="{!!$value->id!!}" data-title="change" data-name="data_venc">
                                    {{$value->data_vencimento}}
                                    </a>

                                    <input type="hidden" id = "campo_data_vencimento[{!!$value->id!!}]" name="campo_data_vencimento[{!!$value->id!!}]" value="{{$value->data_vencimento}}">

                            </td>
                            <td>
                                    <a href="#" id="descricao" name="descricao" class="descricao"  data-type="text" data-column="descricao" data-url="{{ url('/titulos/' . $value->id . '/update_inline/descricao/' . $tipo)}}" data-pk="{!!$value->id!!}" data-title="change" data-name="descricao">
                                        {{$value->descricao}}
                                    </a>
                                    <input type="hidden" id = "campo_descricao[{!!$value->id!!}]" name="campo_descricao[{!!$value->id!!}]" value="{{$value->descricao}}">
                            </td>
                            <td>
                                    <a href="#" id="valor[{!!$value->id!!}]" class="valor"  data-type="text" data-column="valor" data-url="{{ url('/titulos/' . $value->id . '/update_inline/valor/' . $tipo)}}" data-pk="{!!$value->id!!}" data-title="change" data-name="valor">
                                        {{ str_replace(".", ",", $value->valor) }}
                                    </a>
                                    <input type="hidden" id = "campo_valor[{!!$value->id!!}]" name="campo_valor[{!!$value->id!!}]" value='{{ str_replace(".", ",", $value->valor) }}'>
                            </td>
                            <td>
                                    <a href="#" id="data_pagto[{!!$value->id!!}]" name="data_pagto[{!!$value->id!!}]" class="data_pagto"  data-type="text" data-column="data_pagto" data- data-url="{{ url('/titulos/' . $value->id . '/update_inline/data_pagto/' . $tipo)}}" data-pk="{!!$value->id!!}" data-title="change" data-name="data_pagto">
                                         {{$value->data_pagamento}}
                                    </a>
                                    <input type="hidden" id = "campo_data_pagto[{!!$value->id!!}]" name="campo_data_pagto[{!!$value->id!!}]" value="{{$value->data_pagamento}}">
                            </td>

                            <td>
                                         @if ($value->dias_atraso>0 && $value->data_pagamento=="")
                                                <span class="text-danger">{{$value->dias_atraso}}</span>
                                         @endif
                            </td>

                            <td>
                                    <a href="#" class="acrescimo"  data-type="text" data-column="acrescimo" data-url="{{ url('/titulos/' . $value->id . '/update_inline/acrescimo/' . $tipo)}}" data-pk="{!!$value->id!!}" data-title="change" data-name="acrescimo">
                                        {{ str_replace(".", ",", $value->acrescimo) }}
                                    </a>
                                    <input type="hidden" id = "campo_acrescimo[{!!$value->id!!}]" name="campo_acrescimo[{!!$value->id!!}]" value='{{ str_replace(".", ",", $value->acrescimo) }}'>
                            </td>
                            <td>
                                    <a href="#" class="desconto"  data-type="text" data-column="desconto" data-url="{{ url('/titulos/' . $value->id . '/update_inline/desconto/' . $tipo)}}" data-pk="{!!$value->id!!}" data-title="change" data-name="desconto">
                                        {{ str_replace(".", ",", $value->desconto) }}
                                    </a>
                                    <input type="hidden" id = "campo_desconto[{!!$value->id!!}]" name="campo_desconto[{!!$value->id!!}]" value='{{ str_replace(".", ",", $value->desconto) }}'>
                            </td>
                            <td>
                                    <a href="#" id="valor_pago[{!!$value->id!!}]" class="valor_pago"  data-type="text" data-column="valor_pago" data-url="{{ url('/titulos/' . $value->id . '/update_inline/valor_pago/' . $tipo)}}" data-pk="{!!$value->id!!}" data-title="change" data-name="valor_pago">
                                        {{ str_replace(".", ",", $value->valor_pago) }}
                                    </a>
                                     <input type="hidden" id = "campo_valor_pago[{!!$value->id!!}]" name="campo_valor_pago[{!!$value->id!!}]" value='{{ str_replace(".", ",", $value->valor_pago) }}'>
                            </td>

                            <td>

                                   <a href="#" id="check_pago[{!!$value->id!!}]"
                                    class="check_pago"
                                    data-type="select" data-column="check_pago"
                                    data-url="{{ url('/titulos/' . $value->id . '/update_inline/check_pago/' . $tipo)}}"
                                    data-pk="{!!$value->id!!}"
                                    data-title="change"
                                    data-name="check_pago">
                                        @if ($value->status =="B")
                                        <!--<i class='fa fa-thumbs-o-up text-green'></i>-->
                                        <p class='fa fa-thumbs-o-up text-green'> Sim</p>
                                        @else
                                        <!--<i class='fa fa-thumbs-o-down text-red'></i>-->
                                        <p class='fa fa-thumbs-o-down text-red'>

                                              @if (trim($value->alteracao_status)!="")
                                                  @if ($value->saldo_a_pagar==0)
                                                        Sim
                                                  @elseif ($value->saldo_a_pagar==$value->valor)
                                                        Não
                                                  @else
                                                        Parcial
                                                  @endif
                                              @else
                                                  Não
                                              @endif

                                        </p>
                                        @endif
                                   </a>

                            </td>

                            <td>
                                     <p class="text-info"> {{ str_replace(".", ",", $value->saldo_a_pagar) }}</p>
                            </td>

                            <td class="col-xs-1">
                                      @can('verifica_permissao', [\Session::get('id_pagina') ,'alterar'])
                                          @if ($value->status !="B")
                                            <a href = "{{ URL::to(\Session::get('route') .'/' . $value->id . '/edit/' . $tipo) }}" class = 'btn  btn-info btn-sm'><spam class="glyphicon glyphicon-pencil"></spam></a>
                                          @endif
                                      @endcan
                            </td>

                           </form>

                            <td class="col-xs-1">

                                    @can('verifica_permissao', [ \Session::get('id_pagina') ,'excluir'])
                                    <form id="excluir{{$value->id}}" class="excluir" action="{{ URL::to(\Session::get('route') . '/' . $value->id . '/delete/' . $tipo) }}" method="DELETE">

                                          <button
                                              data-toggle="tooltip"
                                              data-placement="top"
                                              title="Excluir Ítem"
                                              type="submit"
                                              class="btn btn-danger btn-sm"
                                              onclick="if(confirm('Confirma a exclusão do Título ?'));">
                                              <spam class="glyphicon glyphicon-trash"></spam>
                                          </button>

                                    </form>
                                    @endcan

                            </td>

                        </tr>
                        @endforeach
                    </tbody>
                    </table>
                </div>

                <div class="overlay modal" style="display: none">
                    <i class="fa fa-refresh fa-spin"></i>
                </div>


            </div>
          </div>
         </div>
        </div>

<script type="text/javascript">

      //Abre menu
      $(document).ready(function(){
         $("#financ").addClass("treeview active");

      });

      var myApp;
      myApp = myApp || (function () {

          return {
              showPleaseWait: function() {
                  $(".overlay").show();
              }
          };
      })();

       //Quando selecionar titulos baixados, selecionar o periodo do mes corrente. Para evitar pesquisas longas trazendo todos titulos baixados
       $('#status').change(function() {
            if ($(this).val()=="B") //baixado
            {
                  $('#mes').val("C"); //selecionar o filtro MES CORRENTE
                  $("#mes").trigger('change'); //dispara change para setar o campo
            }

        });


        /*Quando informar um valor de acrescimo ou desconto, atualiza o valor pago*/
        function recalcula()
        {

             var_acrescimo=0;
             var_desconto=0;
             var_saldo=0;

             //Pega valor de acrescimo se houver, troca ponto por virgula (milhar) e virgula por ponto (decimal)
             if ($('#campo_acrescimo').val()!="")   var_acrescimo = $('#campo_acrescimo').val().replace( '.', '' ).replace( ',', '.' );

             var_acrescimo = parseFloat(var_acrescimo)*100;

             //Pega valor de desconto se houver, troca ponto por virgula (milhar) e virgula por ponto (decimal)
             if ($('#campo_desconto').val()!="")   var_desconto = $('#campo_desconto').val().replace( '.', '' ).replace( ',', '.' );

             var_desconto = parseFloat(var_desconto)*100;

             //Pega valor de desconto se houver, troca ponto por virgula (milhar) e virgula por ponto (decimal)
             if ($('#campo_saldo').val()!="")  var_saldo = $('#campo_saldo').val().replace( '.', '' ).replace( ',', '.' );

             var_saldo = parseFloat(var_saldo)*100;

             //Calculo do valor pago
             var_resultado = ((var_saldo + var_acrescimo) - var_desconto)/100;

            if (parseFloat(var_resultado)>0)
            {
                  $('#campo_valor_pago').val(var_resultado.toFixed(2).replace('.', ',')); //Mesmo valor do titulo
            }
            else //Provavelmente negativo
            {
               alert("Valor calculado incorreto : " + var_resultado + "\nVerifique o valor do Acréscimo/Desconto");
               $('#campo_desconto').val('');
               $('#campo_acrescimo').val('');
            }

       }

       //Selecionar todos titulos
       $('#check_todos').change(function() {
            if ($(this).prop('checked')) {
                $('.check_id').prop('checked', true);
            } else {
                $('.check_id').prop('checked', false);
            }
        });

        //Forma da edicao no table'
        $.fn.editable.defaults.mode = 'inline';

        //Submit dos dados quando selecionado botão de açao em lote.
        function acao(e)
        {

             if (e=="baixar") //Solicita data baixa, informando a data atual
             {
                /*
                var var_data=window.prompt("Informe a Data para Pagamento dos Títulos : ", moment().format('DD/MM/YYYY'));

                 if (var_data!="")
                 {
                     //Validar data
                     if (validar_data_prompt(var_data)=="")
                     {
                          return;
                     }
                     else //Ok, lets do it
                     {
                        $('#data_pagto_lote').val(var_data);
                     }
                 }
                 else //Deixou em branco
                 {
                    alert("Data Inválida.");
                    return;
                 }
                 */

             }

             myApp.showPleaseWait();
             $('#quero_fazer').val(e);
             $('#lote')[0].submit();
        }

        function validar_data_prompt(who)
            {
                if (who!="")
                {
                    str=who;
                    str=str.split('/');
                    dte=new Date(str[1]+'/'+str[0]+'/'+str[2]);
                    mStr=''+(dte.getMonth()+1);
                    mStr=(mStr<10)?'0'+mStr:mStr;

                    if(mStr!=str[1]||isNaN(dte))
                    {
                        alert('Data Inválida!');
                        return "";
                    }
                }
            }


        /*Validacao dos campos alterados inline */
        $(document).ready(function() {


            $('#queromais').click(function (){
                $("#div_opcoes_baixa").toggle();
            });

            $('#mes').change(function()
            {
                  if ($(this).prop('value')=="E")
                     $("#div_periodo").show();
                  else
                    $("#div_periodo").hide();


                  if ($(this).prop('value')=="M")
                    $("#div_opcoes").show();
                  else
                    $("#div_opcoes").hide();

            });

              /*Monetarios - class*/
            $('.formata_valor').autoNumeric("init",{
                aSep: '.',
                aDec: ','
            });

            $('.chkpago').checkboxpicker({
                offLabel : 'Não',
                onLabel : 'Sim',
            });

            $('.check_pago').editable({
                 value: [0, 1],
                 source: [
                    {value: 0, text: ''},
                    {value: 0, text: 'Sim'},
                    {value: 1, text: 'Não'}
                ],
               validate: function(value)
               {
                      location.reload(); //Reflesh na pagina para recarregar valores atualizados apos update
               },
                params: function(params) {
                    // add additional params from data-attributes of trigger element
                    params.name = $(this).editable().data('check_pago');
                    params._token = $("#_token").data("token");
                    return params;
                },
                error: function(response, newValue) {
                    if(response.status === 500) {
                        return 'Server error. Check entered data.';
                    } else {
                        return response.responseText;
                        // return "Error.";
                    }
                }
            });

            $('.descricao').editable({
                validate: function(value) {

                    if($.trim(value) == '') {
                        return 'Campo Obrigatório';
                    }

                    //Atualiza o campo input hidden com novo valor....
                    $("input[name='campo_descricao[" + $(this).editable().data('pk') + "]']").val(value);

                },
                params: function(params) {
                    // add additional params from data-attributes of trigger element
                    params.name = $(this).editable().data('descricao');
                    params._token = $("#_token").data("token");
                    return params;
                },
                error: function(response, newValue) {
                    if(response.status === 500) {
                        return 'Server error. Check entered data.';
                    } else {
                        return response.responseText;
                        // return "Error.";
                    }
                }
            });

            /*Tabela editavel - colunas*/
            $('.data_venc').editable({
                validate: function(value) {

                    if($.trim(value) == '') {
                        return 'Campo Obrigatório';
                    }

                    //Atualiza o campo input hidden com novo valor....
                    $("input[name='campo_data_vencimento[" + $(this).editable().data('pk') + "]']").val(value);

                },
                params: function(params) {
                    // add additional params from data-attributes of trigger element
                    params.name = $(this).editable().data('data_venc');
                    params._token = $("#_token").data("token");
                    return params;
                },
                error: function(response, newValue) {
                    if(response.status === 500) {
                        return 'Server error. Check entered data.';
                    } else {
                        return response.responseText;
                        // return "Error.";
                    }
                }
            });

                /*Tabela editavel - colunas*/
            $('.data_pagto').editable({

               validate: function(value) {

                    //Atualiza o campo input hidden com novo valor....
                    $("input[name='campo_data_pagto[" + $(this).editable().data('pk') + "]']").val(value);

                },
                params: function(params) {
                    // add additional params from data-attributes of trigger element
                    params.name = $(this).editable().data('data_pagto');
                    params._token = $("#_token").data("token");
                    return params;
                },
                error: function(response, newValue) {
                    if(response.status === 500) {
                        return 'Server error. Check entered data.';
                    } else {
                        return response.responseText;
                        // return "Error.";
                    }
                }
            });


            /*Tabela editavel - colunas*/
            $('.valor').editable({
                validate: function(value) {
                    if($.trim(value) == '') {
                        return 'Campo Obrigatório';
                    }

                    //Atualiza o campo input hidden com novo valor....
                    $("input[name='campo_valor[" + $(this).editable().data('pk') + "]']").val(value);

                },
                params: function(params) {
                    // add additional params from data-attributes of trigger element
                    params.name = $(this).editable().data('valor');
                    params._token = $("#_token").data("token");
                    return params;
                },
                error: function(response, newValue) {
                    if(response.status === 500) {
                        return 'Server error. Check entered data.';
                    } else {
                        return response.responseText;
                        // return "Error.";
                    }
                }
            });


            $('.valor_pago').editable({
              validate: function(value) {

                    //Atualiza o campo input hidden com novo valor....
                    $("input[name='campo_valor_pago[" + $(this).editable().data('pk') + "]']").val(value);
                    location.reload(); //Reflesh na pagina para recarregar valores atualizados apos update

                },
                params: function(params) {
                    // add additional params from data-attributes of trigger element
                    params.name = $(this).editable().data('valor_pago');
                    params._token = $("#_token").data("token");

                    return params;
                },
                error: function(response, newValue) {
                    if(response.status === 500) {
                        return 'Server error. Check entered data.';
                    } else {
                        return response.responseText;
                        // return "Error.";
                    }
                }
            });


            $('.acrescimo').editable({
                validate: function(value) {

                    //Atualiza o campo input hidden com novo valor....
                    $("input[name='campo_acrescimo[" + $(this).editable().data('pk') + "]']").val(value);
                    location.reload(); //Reflesh na pagina para recarregar valores atualizados apos update

                },
                params: function(params) {
                    // add additional params from data-attributes of trigger element
                    params.name = $(this).editable().data('acrescimo');
                    params._token = $("#_token").data("token");
                    return params;
                },
                error: function(response, newValue) {
                    if(response.status === 500) {
                        return 'Server error. Check entered data.';
                    } else {
                        return response.responseText;
                        // return "Error.";
                    }
                }
            });

            $('.desconto').editable({
                validate: function(value) {

                    //Atualiza o campo input hidden com novo valor....
                    $("input[name='campo_desconto[" + $(this).editable().data('pk') + "]']").val(value);
                    location.reload(); //Reflesh na pagina para recarregar valores atualizados apos update

                },
                params: function(params) {
                    // add additional params from data-attributes of trigger element
                    params.name = $(this).editable().data('desconto');
                    params._token = $("#_token").data("token");
                    return params;
                },
                error: function(response, newValue) {
                    if(response.status === 500) {
                        return 'Server error. Check entered data.';
                    } else {
                        return response.responseText;
                        // return "Error.";
                    }
                }
            });

        });

</script>

@endsection