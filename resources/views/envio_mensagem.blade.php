<div class = 'row'>

    <div class="col-md-12">

        <form method = 'POST' class="form-horizontal" onsubmit="return validar();" action = "{{ url('/' . \Session::get('route') . '/' .  'enviar')}}">

        {!! csrf_field() !!}

            <div class="box box-primary">

                 <div class="box-body"> <!--anterior box-body-->

                          <div class="row">
                                      <div class="col-xs-10">
                                          <label for="tipo_envio" class="control-label">Tipo Envio</label>
                                          <select id="tipo_envio" placeholder="(Selecionar)" name="tipo_envio" data-live-search="true" data-none-selected-text="Nenhum item selecionado" class="form-control selectpicker" style="width: 100%;">
                                                @if ($parametros[0]->sms_corporativo=="S")
                                                <option  value="2" data-icon="fa fa-envelope-square">SMS Corporativo</option>
                                                @endif

                                                @if ($parametros[0]->sms_marketing=="S")
                                                <option  value="0" data-icon="fa fa-envelope-square">SMS Marketing</option>
                                                @endif

                                                @if ($parametros[0]->whatsapp=="S")
                                                    <option  value="5" data-icon="fa fa-whatsapp">Whatsapp - Texto</option>
                                                    <option  value="6" data-icon="fa fa-whatsapp">Whatsapp - Link Imagem</option>
                                                    <option  value="7" data-icon="fa fa-whatsapp">Whatsapp - Link Audio</option>
                                                    <option  value="8" data-icon="fa fa-whatsapp">Whatsapp - Link Video</option>
                                                @endif

                                          </select>
                                      </div>
                          </div>


                          <!--
                          <div class="row">
                                      <div class="col-xs-10">
                                          <label for="lista" class="control-label">Tema padrão</label>
                                          <select id="lista" placeholder="(Selecionar)" name="lista" data-live-search="true" data-none-selected-text="Nenhum item selecionado" class="form-control selectpicker" style="width: 100%;">
                                                <option  value=""></option>
                                                <option  value="1">Aniversariantes</option>
                                                <option  value="2">Aniversario de Casamento</option>
                                                <option  value="3">Aniversario de Batismo</option>
                                                <option  value="4">Visitantes</option>
                                                <option  value="5">Parabenização Batismo</option>
                                                <option  value="6">Parabenização Conclução Curso</option>
                                          </select>
                                      </div>
                          </div>
                          -->


                            <div id="div_sms" class="row{{ $errors->has('mensagem') ? ' has-error' : '' }}" >
                                    <div class="col-xs-10">
                                          <label for="mensagem" class="control-label">Mensagem (Máximo 160 caracteres sem acentuação)</label>

                                          <textarea id="mensagem" name="mensagem" class="form-control" rows="3" maxlength="160" onkeypress="retira_acentos(this.value, this)" placeholder="Digite a mensagem (Máximo 160 caracteres, sem acentuação)" ></textarea>

                                             <!-- se houver erros na validacao do form request -->
                                             @if ($errors->has('mensagem'))
                                              <span class="help-block">
                                                  <strong>{{ $errors->first('mensagem') }}</strong>
                                              </span>
                                             @endif

                                    </div>

                            </div>
                            <div id="MsgCount"></div>

                            <div id="div_whats" class="row{{ $errors->has('whatsapp') ? ' has-error' : '' }}" style="display: none">
                                    <div class="col-xs-10">
                                          <label for="whatsapp" class="control-label">Mensagem</label>

                                          <textarea id="whatsapp" name="whatsapp" class="form-control" rows="4" maxlength="490" placeholder="Digite a mensagem (Máximo 490 caracteres)" ></textarea>

                                             <!-- se houver erros na validacao do form request -->
                                             @if ($errors->has('whatsapp'))
                                              <span class="help-block">
                                                  <strong>{{ $errors->first('whatsapp') }}</strong>
                                              </span>
                                             @endif

                                    </div>

                            </div>

                          <div class="row {{ $errors->has('link') ? ' has-error' : '' }}" id="div_whats_link" style="display: none">
                                  <div class="col-xs-10">
                                       <label for="link" class="control-label">Link Vídeo/Audio/Imagem</label>
                                       <input type="text" name="link" id="link" maxlength="490"  class="form-control" value=''>
                                  </div>

                                   <!-- se houver erros na validacao do form request -->
                                    @if ($errors->has('link'))
                                     <span class="help-block">
                                         <strong>{{ $errors->first('whatsapp') }}</strong>
                                     </span>
                                    @endif
                          </div>


                            <div class="row{{ $errors->has('telefone') ? ' has-error' : '' }}">
                                    <div class="col-xs-10">
                                          <label for="telefone" class="control-label">Telefone(s) (Separar por ponto e vírgula ( ; )  caso queira enviar para vários...)</label>

                                          @if (isset($listagem))

                                              <textarea class="form-control" rows="10" name="telefone" onkeyup="verifica_fones(this.value)" id="telefone">@foreach($listagem as $item)@if (rtrim(ltrim($item->fone_celular))!=""){!! str_replace('(','',str_replace(')','',str_replace('-','',str_replace(' ','',$item->fone_celular)))) !!}; @endif @endforeach</textarea>

                                          @else
                                                  <textarea id="telefone" name="telefone" class="form-control" onkeyup="verifica_fones(this.value)" rows="2" placeholder="Informe o(s) número(s) de telefone(s) com DDD" ></textarea>
                                          @endif


                                             <!-- se houver erros na validacao do form request -->
                                             @if ($errors->has('telefone'))
                                              <span class="help-block">
                                                  <strong>{{ $errors->first('telefone') }}</strong>
                                              </span>
                                             @endif

                                    </div>
                            </div>


            </div><!-- fim box-body"-->
        </div><!-- box box-primary -->

        <div class="box-footer">
            <button class = 'btn btn-primary' type ='submit'><i class="fa fa-save"></i> Enviar</button>
            <a href="{{ url('/' . \Session::get('route') )}}" class="btn btn-default">Cancelar</a>
        </div>

       </form>

    </div><!-- <col-md-12 -->

</div><!-- row -->

<script type="text/javascript">

  function validar() {

      if ($("#telefone").val()=="")
      {
            alert("Informe o(s) número(s) do(s) telefone(s)");
            return false;
      }

      if ($("#tipo_envio").val()=="2" || $("#tipo_envio").val()=="0") //SMS
      {
          if ($("#mensagem").val().trim()=="")
          {
              alert("Informe o texto da mensagem.");
              return false;
          }

      }
      else if ($("#tipo_envio").val()=="5")
      {

          if ($("#whatsapp").val().trim()=="")
          {
              alert("Informe o texto da mensagem whatsapp.");
              return false;
          }

      }
      else
      {
          if ($("#link").val().trim()=="")
          {
              alert("Informe o link");
              return false;
          }

      }


      return true;


  }


        $("#tipo_envio").change(function()
        {
            if ($(this).val()=="2" || $(this).val()=="0") //SMS
            {
                $("#div_whats").hide();
                $("#div_whats_link").hide();
                $("#div_sms").show();
            } else {
                $("#div_sms").hide();

                if ($(this).val()=="5")
                {
                      $("#div_whats_link").hide();
                      $("#div_whats").show();
                } else {
                      $("#div_whats_link").show();
                      $("#div_whats").hide();
                }

            }

        });


          /**
           * O evento keyup dispara quando uma tecla do teclado é liberado.
           */
          $("#mensagem").keyup(function (event) {
           /**
            * Quando o evento keyup é acionado almenta a largura e altura da textarea
            * mudando sua propriedade css
            */
           $("#mensagem").css({width: "342px",
                 height: "100px"});
           /**
            * Obtem o valor da textarea
            */
           $Msg = $(this).val();

           /**
            * Aqui você define o número máximo de caracteres
            */
           var maxText     = 160;

           /**
            * Obtem a quantidade de caracteres
            */
           var numChar = $Msg.length;

           /**
            * "Exibe" na div somando "um a um" a quantidade de caracteres digitados
            */
           $("#MsgCount").text(numChar);

           /**
            * Testa se o total de caracteres é inferior ao permitido
            * Mudando a cor da fonte do div para azul
            */
           if ( numChar < maxText )
           {
            $("#MsgCount").css("color","#0000ff");
           }
           else
           {
            /**
             * Caso chegue no limite alerta
             */
            if ( numChar == maxText)
            {
             alert("Limite de caracteres excedido!\n So e permitido no máximo: " + numChar + " Caracteres");
            }
            else if ( numChar > maxText)
            {
             /**
              * Apos o alerta se for precionado a tecla diferente da backspace do teclado
              * disabilita a textarea e "Exibe" na div o teste "Desabilitado" com a cor vermelha
              */
             if (event.keyCode != 8)
             {
              $("#mensagem").attr("disabled","disabled");
              $("#MsgCount").text("Desabilitado").css("color","#ff0000");
             }
            }
           }
          });

        //onblur="verifica_fones(this.value)"
        function verifica_fones(palavra)
        {
              palavra = palavra.replace(",", ";");
              $('#telefone').val(palavra);

        }

        function retira_acentos(palavra, campo) {

            palavra = palavra.replace("?", "");

            com_acento = "áàãâäéèêëíìîïóòõôöúùûüçÁÀÃÂÄÉÈÊËÍÌÎÏÓÒÕÖÔÚÙÛÜÇ";
            sem_acento = "aaaaaeeeeiiiiooooouuuucAAAAAEEEEIIIIOOOOOUUUUC";
            nova="";

            for(i=0;i<palavra.length;i++)
                {
                  if (com_acento.search(palavra.substr(i,1))>=0)
                    {
                    nova+=sem_acento.substr(com_acento.search(palavra.substr(i,1)),1);
                    //alert(nova)
                    }
                else
                    {
                    nova+=palavra.substr(i,1);
                    }
                }
            $(campo).val(nova);
            return nova;
        }


</script>