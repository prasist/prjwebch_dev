<script type="text/javascript">
    /*Prepara checkbox bootstrap*/
    //Abre menu
    $(document).ready(function(){

            //Expande menu
            $("#financ").addClass("treeview active");

            //Remove linha da tabela de rateios
            $("#mais_rateios").on("click", ".remover", function(e){
                $(this).closest('tr').remove();
                verificar_valores_rateados(); //Recalcula
            });

            //Atualiza campos com valores default
            if ($("#data_vencimento").val()=="")
            {
                $("#data_vencimento").val(moment().format('DD/MM/YYYY')); //Data de pagamento dia
                $("#data_vencimento").trigger( "change" );
            }

            if ($("#data_emissao").val()=="")
            {
                $("#data_emissao").val(moment().format('DD/MM/YYYY')); //Data de pagamento dia
                $("#data_emissao").trigger( "change" );
            }

            $("#valor_original").val($("#valor").val());
            $("#valor_restante").val($("#valor").val());

            verificar_valores_rateados(); //Recalcula valores se já vierem carregados

            /*Inicializa check como botoes sim e nao*/
            $('.ckpago').checkboxpicker({
                offLabel : 'Não',
                onLabel : 'Sim',
            });

            /*Se clicar check pago, exibi informacoes do pagamento*/
            if ($('.ckpago').prop('checked'))
            {
                $("#esconder").show();
            }

            //Se houver pagamentos parciais, exibir campos
            if ($('#saldo').val()>0 && $('#saldo').val() != $('#valor').val())
            {
                $("#esconder").show();
            }

            /*Quando clicar no check pago*/
            $('.ckpago').change(function()
            {
                  if ($(this).prop('checked'))
                  {
                      $("#esconder").show();
                      $("#data_pagamento").val(moment().format('DD/MM/YYYY')); //Data de pagamento dia
                      $('#valor_pago').val($('#valor').val()); //Mesmo valor do titulo
                      $('.ckpago').val('true'); //Mesmo valor do titulo
                  }
                  else
                  {

                    if (confirm('Deseja estornar o pagamento ? O valor acumulado de pagamentos será zerado e o saldo devedor retornará integralmente.'))
                    {
                        $("#data_pagamento").val('');
                        $('#valor_pago').val(''); //zera
                        $('#total_pago').val('0'); //zerar
                        $('#saldo').val($('#valor').val()); //Mesmo valor do titulo
                        $('#acrescimo').val('');
                        $('#desconto').val('');
                        $("#esconder").hide();
                        $('.ckpago').val('');
                    }
                    else
                    {
                        location.reload(); //Reflesh na pagina para recarregar valores atualizados apos update
                    }
                  }
            });
    });


     function onblur_valor() {
            if ($("#valor").val()!="")
            {
                atualizar_valor_rateio();
                $("#valor_rateio").val('0');
                $("#soma_rateio").val('0');
                $("#valor_restante").val($("#valor_original").val());
            }
     }


     //Quando informar o valor do titulo, atualizar o valor de rateio
     function atualizar_valor_rateio() {
          $("#valor_original").val($("#valor").val().replace('.', '').replace(',', '.'));
          $("#valor_restante").val($("#valor").val().replace('.', '').replace(',', '.'));
     }


      //Calcula valor rateado, saldo remanescente e validacoes
      function calcular_rateio() {

           //Verifica se foi informado valor do titulo
           if ($("#valor_original").val()=="")
           {
                alert("Não foi informado valor do título, a tela de rateio não poderá ser exibida.");
                $('#myModal').modal('toggle'); //Fecha modal
                return;
           }

            //Percentual já rateado até o momento
            var_percentual_informado = (parseFloat($("#soma_rateio").val()) /  parseFloat($("#valor_original").val())) * 100;

            //Se houver valor do rateio informado, verifica se nao ultrapassa 100%
            if ($("#perc_rateio").val()!="") {
                  if (parseFloat($("#perc_rateio").val())>100)
                  {
                      alert("Percentual do Rateio superior a 100%");
                      $("#perc_rateio").val('');
                      return;
                  }

                  //Verifica se nao ultrapassa o % já rateado
                  if (parseFloat($("#perc_rateio").val()) > (100-var_percentual_informado))
                  {
                      alert("Percentual do Rateio superior ao % já rateado");
                      $("#perc_rateio").val('');
                      return;
                  }

                  var var_resultado = (parseFloat($("#valor_original").val())  * parseFloat($("#perc_rateio").val().replace('.', '').replace(',', '.')));

                  //Calcula valor do rateio a partir do percentual
                  var var_valor_formatado = parseFloat(var_resultado).toFixed(2)/100;

                  $("#valor_rateio").val(var_valor_formatado.toString().replace('.', ',')); //Formata para exibicao

            }

            //Se houver valor informado e o percentual nao
            if ($("#valor_rateio").val()!="" && $("#perc_rateio").val()=="")   {
                //Verifica se nao é maior que o valor original e maior que o saldo remanescente
                if ((parseFloat($("#valor_rateio").val())>parseFloat($("#valor_original").val())) || (parseFloat($("#valor_rateio").val())>parseFloat($("#valor_restante").val())))
                {
                    alert("Valor do Rateio é superior ao valor original / valor restante do rateio");
                    $("#valor_rateio").val('');
                    return;
                }

                var var_resultado = ( (parseFloat($("#valor_rateio").val().replace('.', '').replace(',', '.')) / parseFloat($("#valor_original").val())));
                var_resultado = var_resultado*100;
                $("#perc_rateio").val(var_resultado.toString().replace('.', ','));

            }

      }

      //Verificar se centro de custo não foi inserido
      function validar_cc(valor) {
          $.each($('input[class="form-control ccusto"]'),function() {
                if ($(this).val()==valor && $(this).val()!="") //verifica se item selecionado na combo ja foi adicionado
                {
                   alert("Centro de Custo já informado.");
                   $("#rateio_cc").val(''); //limpa combo
                   $("#rateio_cc").trigger('change'); //dispara change para limpar campo
                   return;
                }
          });
      }

      function remover_todos() {
            table = $('#mais_rateios');
              table.find('input').each(function (){
                $(this).val("");
                $(this).closest('tr').remove();
              });
              verificar_valores_rateados(); //Recalcula
       }

       //Percorre valores adicionados
       function verificar_valores_rateados() {

           var percentual=0;
           var valor=0;

           //Percorre inputs com a classe especificada
           $.each($('input[class="form-control valores"]'),function(){

                if ( $(this).attr('id')=="inc_perc[]") //Pega percentual
                {
                    percentual = percentual + parseFloat($(this).val().replace('.', '').replace(',', '.'));
                }

                if ( $(this).attr('id')=="inc_valor[]") //Pega valor
                {
                    valor = valor + parseFloat($(this).val().replace('.', '').replace(',', '.'));
                }

           });


           $("#soma_rateio").val(valor);
           $("#valor_restante").val(($("#valor_original").val()-$("#soma_rateio").val()));

           //Desabilita botão se já alcancou 100%
           if (percentual>=100)
           {
              $('#botao').attr('disabled', 'disabled');
              $('#salvar').removeAttr('disabled');
           }
           else
           {
              $('#botao').removeAttr('disabled');
              $('#salvar').attr('disabled', 'disabled');
           }

      }


      //Adiciona novo valor de rateio
      function incluir_rateio() {
            //Centro de custo
            if ($("#rateio_cc").val() == "")
            {
                alert("Informe o Centro de Custo");
                return false;
            }

            //Ou valor ou percentual
            if ($("#valor_rateio").val() == "" && $("#perc_rateio").val()=="")
            {
                alert("Informe o valor ou percentual para rateio");
                return false;
            }

            //Pega dados dos campos
            var ind_centrocusto = document.getElementById("rateio_cc").selectedIndex;
            var texto_rateio = document.getElementById("rateio_cc").options;

            //Criar campos dinamicamente
            var sCentroCustoID = '<tr><input id="hidden_id_rateio_cc[]" name = "hidden_id_rateio_cc[]" type="hidden" class="form-control" value=" ' + ind_centrocusto + '">';
            var sCentroCusto = '<td><input id="inc_cc[]" readonly name = "inc_cc[]" type="text" class="form-control" value="' + texto_rateio[ind_centrocusto].text + '"></td>';
            var sPercentual = '<td><input id="inc_perc[]" readonly name = "inc_perc[]" type="text" class="form-control valores" value="' + document.getElementById("perc_rateio").value + '"></td>';
            var sValor = '<td><input id="inc_valor[]" readonly name = "inc_valor[]" type="text" class="form-control valores" value="' + document.getElementById("valor_rateio").value + '"></td>';
            var sBotao = '<td><button data-toggle="tooltip" data-placement="top" title="Excluir Ítem"  class="btn btn-danger btn-sm remover"><spam class="glyphicon glyphicon-trash"></spam></button></td>';

            /*Gera codigo HTML*/
            document.getElementById("mais_rateios").innerHTML = document.getElementById("mais_rateios").innerHTML + sCentroCustoID + sCentroCusto + sPercentual + sValor + sBotao + '</tr>';

            /*Limpar campos*/
            $("#rateio_cc").val('');
            $("#rateio_cc").trigger('change');
            $("#perc_rateio").val('');
            $("#valor_rateio").val('');

            verificar_valores_rateados();
      }


      //Recalcula ao informar percentual ou valor
      function recalcula() {
             var_acrescimo=0;
             var_desconto=0;
             var_saldo=0;

             //Pega valor de acrescimo se houver, troca ponto por virgula (milhar) e virgula por ponto (decimal)
             if ($('#acrescimo').val()!="")   var_acrescimo = $('#acrescimo').val().replace( '.', '' ).replace( ',', '.' );

             var_acrescimo = parseFloat(var_acrescimo)*100;

             //Pega valor de desconto se houver, troca ponto por virgula (milhar) e virgula por ponto (decimal)
             if ($('#desconto').val()!="")   var_desconto = $('#desconto').val().replace( '.', '' ).replace( ',', '.' );

             var_desconto = parseFloat(var_desconto)*100;

             //Pega valor de desconto se houver, troca ponto por virgula (milhar) e virgula por ponto (decimal)
             if ($('#saldo').val()!="")  var_saldo = $('#saldo').val().replace( '.', '' ).replace( ',', '.' );

             var_saldo = parseFloat(var_saldo)*100;

             //Calculo do valor pago
             var_resultado = ((var_saldo + var_acrescimo) - var_desconto)/100;

            if (parseFloat(var_resultado)>0)
            {
                  $('#valor_pago').val(var_resultado.toFixed(2).replace('.', ',')); //Mesmo valor do titulo
            }
      }


</script>