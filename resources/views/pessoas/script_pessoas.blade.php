@section('tela_pessoas')
     <script type="text/javascript">

                  $(function ()
                  {

                       $('[data-toggle="tooltip"]').tooltip();

                        /*checkbox se utiliza endereco de cobranca exibe a DIV*/
                        $('#endcobranca').click(function()
                        {
                            if ($(this).prop('checked'))
                            {
                                $("#exibir_endereco_cobranca").show();
                            } else
                            {
                                $("#exibir_endereco_cobranca").hide();
                            }
                        });

                        /*Se clicar em pessoa fisica*/
                        $('.opFisica').click(function()
                        {
                              $("#lb_cnpj_cpf").text('CPF');
                              $("#lb_inscricaoestadual_rg").text('RG');
                              $("#lb_datanasc").text('Data Nasc.');
                              $(".cpf").show();
                              $(".cnpj").hide();
                        });

                        /*Se clicar em pessoa juridica*/
                        $('.opJuridica').click(function()
                        {
                              $("#lb_cnpj_cpf").text('CNPJ');
                              $("#lb_inscricaoestadual_rg").text('Insc. Estadual');
                              $("#lb_datanasc").text('Data Fundação');
                              $(".cpf").hide();
                              $(".cnpj").show();
                        });


                        //Verifica se cpf é único no banco de dados
                        $(".cpf").blur(function()
                        {

                            if ($(this).val()!="") //se foi preenchido o campo
                            {

                                    var strValor = $(this).val(); //Pega conteudo campo cpf
                                    var urlGetUser = '{!! url("/funcoes/' +  strValor +  '") !!}'; //Route funcoes = FuncoesController@index passando cpf como parametro

                                    $.ajax(
                                    {
                                        url: urlGetUser,
                                         success: function (response) { //Encontrando a rota e a funcao retornando dados, exibe alerta

                                             if (response!="") //Só exibe mensagem se encontrar CPF para outra pessoa
                                             {

                                                /*Só exibir mensagem se realmente estiver sendo cadastrado uma nova pessoa*/
                                                if ($("#razaosocial").val()!=response)
                                                {
                                                    alert('CPF já cadastrado para : ' + response);
                                                    $(".cpf").val(""); //Limpa campo
                                                }

                                             }

                                         }
                                    });
                            }

                       });


                        //Verifica se CNPJ é único no banco de dados
                        $(".cnpj").blur(function()
                        {

                            if ($(this).val()!="") //se foi preenchido o campo
                            {

                                    var strValor = $(this).val(); //Pega conteudo campo cpf
                                    var urlGetUser = '{!! url("/funcoes/' +  strValor.replace('/', '') +  '") !!}'; //Route funcoes = FuncoesController@index passando cpf como parametro

                                    $.ajax(
                                    {
                                        url: urlGetUser,
                                         success: function (response) { //Encontrando a rota e a funcao retornando dados, exibe alerta

                                             if (response!="") //Só exibe mensagem se encontrar CPF para outra pessoa
                                             {

                                                /*Só exibir mensagem se realmente estiver sendo cadastrado uma nova pessoa*/
                                                if ($("#razaosocial").val()!=response)
                                                {
                                                    alert('CNPJ já cadastrado para : ' + response);
                                                    $(".cnpj").val(""); //Limpa campo
                                                }

                                             }

                                         }
                                    });
                            }

                       });


                   });
     </script>
@endsection

    <script type="text/javascript">

            /*Inicializa Webcam*/
            function ativar_webcam()
            {
                  Webcam.attach( '#my_camera' );
            }

            /*Tirar foto pela webcam*/
            function take_snapshot() {
                    Webcam.snap( function(data_uri)
                    {
                        document.getElementById('my_result').innerHTML = '<img name="caminhologo" id="caminhologo" src="'+data_uri+'"/>';
                        var raw_image_data = data_uri.replace(/^data\:image\/\w+\;base64\,/, '');

                        document.getElementById('mydata').value = raw_image_data;
                    });
                }

                /*Validação da imagem que será enviada*/
                function checkPhoto(target)
                {

                    /*Verificar formato*/
                    if(target.files[0].type.indexOf("image") == -1) {
                        document.getElementById("msg").innerHTML = "Formato não reconhecido";
                        document.getElementById("caminhologo").value = "";
                        alert("Formato não reconhecido, favor selecionar outra imagem.");
                        return false;
                    }

                    /*Tamanho maximo 2Mg*/
                    if(target.files[0].size > 2000000) {
                        document.getElementById("msg").innerHTML = "Imagem muito grande (max 2000Kb)";
                        document.getElementById("caminhologo").value = "";
                        alert("Imagem muito grande (max 2000Kb), favor selecionar outra imagem.");
                        return false;
                    }

                    /*Chegou ate aqui beleza...*/
                    document.getElementById("msg").innerHTML = "";
                    return true;
                }

    </script>

@section('busca_endereco')
<script type="text/javascript">

                  $(function ()
                  {

                            function limpa_formulario_cep()
                            {
                                // Limpa valores do formulário de cep.
                                $("#endereco").val("");
                                $("#bairro").val("");
                                $("#cidade").val("");
                                $("#estado").val("");
                            }

                             function limpa_formulario_cep_cobranca()
                            {
                                // Limpa valores do formulário de cep.
                                $("#endereco_cobranca").val("");
                                $("#bairro_cobranca").val("");
                                $("#cidade_cobranca").val("");
                                $("#estado_cobranca").val("");
                            }

                            function limpa_formulario_cep_profissional()
                            {
                                // Limpa valores do formulário de cep.
                                $("#endereco_prof").val("");
                                $("#bairro_prof").val("");
                                $("#cidade_prof").val("");
                                $("#estado_prof").val("");
                            }


                            function limpa_formulario_cep_igreja()
                            {
                                // Limpa valores do formulário de cep.
                                $("#endereco_igreja_anterior").val("");
                                $("#bairro_igreja_anterior").val("");
                                $("#cidade_igreja_anterior").val("");
                                $("#estado_igreja_anterior").val("");
                            }

                                        //Quando o campo cep perde o foco.
                                        $("#cep").blur(function() {

                                            //Nova variável "cep" somente com dígitos.
                                            var cep = $(this).val().replace(/\D/g, '');

                                            //Verifica se campo cep possui valor informado.
                                            if (cep != "") {

                                                //Expressão regular para validar o CEP.
                                                var validacep = /^[0-9]{8}$/;

                                                //Valida o formato do CEP.
                                                if(validacep.test(cep)) {

                                                    //Preenche os campos com "..." enquanto consulta webservice.
                                                    $("#endereco").val("...")
                                                    $("#bairro").val("...")
                                                    $("#cidade").val("...")
                                                    $("#estado").val("...")

                                                    //Consulta o webservice viacep.com.br/
                                                    $.getJSON("//viacep.com.br/ws/"+ cep +"/json/?callback=?", function(dados) {

                                                        if (!("erro" in dados)) {
                                                            //Atualiza os campos com os valores da consulta.
                                                            $("#endereco").val(dados.logradouro);
                                                            $("#bairro").val(dados.bairro);
                                                            $("#cidade").val(dados.localidade);
                                                            $("#estado").val(dados.uf);
                                                        } //end if.
                                                        else {
                                                            //CEP pesquisado não foi encontrado.
                                                            limpa_formulario_cep();
                                                            alert("CEP não encontrado.");
                                                        }
                                                    });
                                                } //end if.
                                                else {
                                                    //cep é inválido.
                                                    limpa_formulario_cep();
                                                    alert("Formato de CEP inválido.");
                                                }
                                            } //end if.
                                            else {
                                                //cep sem valor, limpa formulário.
                                                limpa_formulario_cep();
                                            }
                                        });


                                        //Quando o campo cep perde o foco.
                                        $("#cep_cobranca").blur(function() {

                                            //Nova variável "cep" somente com dígitos.
                                            var cep = $(this).val().replace(/\D/g, '');

                                            //Verifica se campo cep possui valor informado.
                                            if (cep != "") {

                                                //Expressão regular para validar o CEP.
                                                var validacep = /^[0-9]{8}$/;

                                                //Valida o formato do CEP.
                                                if(validacep.test(cep)) {

                                                    //Preenche os campos com "..." enquanto consulta webservice.
                                                    $("#endereco_cobranca").val("...")
                                                    $("#bairro_cobranca").val("...")
                                                    $("#cidade_cobranca").val("...")
                                                    $("#estado_cobranca").val("...")

                                                    //Consulta o webservice viacep.com.br/
                                                    $.getJSON("//viacep.com.br/ws/"+ cep +"/json/?callback=?", function(dados) {

                                                        if (!("erro" in dados)) {
                                                            //Atualiza os campos com os valores da consulta.
                                                            $("#endereco_cobranca").val(dados.logradouro);
                                                            $("#bairro_cobranca").val(dados.bairro);
                                                            $("#cidade_cobranca").val(dados.localidade);
                                                            $("#estado_cobranca").val(dados.uf);

                                                        } //end if.
                                                        else {
                                                            //CEP pesquisado não foi encontrado.
                                                            limpa_formulario_cep_cobranca();
                                                            alert("CEP não encontrado.");
                                                        }
                                                    });
                                                } //end if.
                                                else {
                                                    //cep é inválido.
                                                    limpa_formulario_cep_cobranca();
                                                    alert("Formato de CEP inválido.");
                                                }
                                            } //end if.
                                            else {
                                                //cep sem valor, limpa formulário.
                                                limpa_formulario_cep_cobranca();
                                            }
                                        });


                                        //Quando o campo cep perde o foco.
                                        $("#cep_prof").blur(function() {

                                            //Nova variável "cep" somente com dígitos.
                                            var cep = $(this).val().replace(/\D/g, '');

                                            //Verifica se campo cep possui valor informado.
                                            if (cep != "") {

                                                //Expressão regular para validar o CEP.
                                                var validacep = /^[0-9]{8}$/;

                                                //Valida o formato do CEP.
                                                if(validacep.test(cep)) {

                                                    //Preenche os campos com "..." enquanto consulta webservice.
                                                    $("#endereco_prof").val("...")
                                                    $("#bairro_prof").val("...")
                                                    $("#cidade_prof").val("...")
                                                    $("#estado_prof").val("...")

                                                    //Consulta o webservice viacep.com.br/
                                                    $.getJSON("//viacep.com.br/ws/"+ cep +"/json/?callback=?", function(dados) {

                                                        if (!("erro" in dados))
                                                        {
                                                            //Atualiza os campos com os valores da consulta.
                                                            $("#endereco_prof").val(dados.logradouro);
                                                            $("#bairro_prof").val(dados.bairro);
                                                            $("#cidade_prof").val(dados.localidade);
                                                            $("#estado_prof").val(dados.uf);
                                                        } //end if.
                                                        else
                                                        {
                                                            //CEP pesquisado não foi encontrado.
                                                            limpa_formulario_cep_profissional();
                                                            alert("CEP não encontrado.");
                                                        }
                                                    });
                                                } //end if.
                                                else {
                                                    //cep é inválido.
                                                    limpa_formulario_cep_profissional();
                                                    alert("Formato de CEP inválido.");
                                                }
                                            } //end if.
                                            else {
                                                //cep sem valor, limpa formulário.
                                                limpa_formulario_cep_profissional();
                                            }
                                        });



                                        //Quando o campo cep perde o foco.
                                        $("#cep_igreja_anterior").blur(function() {

                                            //Nova variável "cep" somente com dígitos.
                                            var cep = $(this).val().replace(/\D/g, '');

                                            //Verifica se campo cep possui valor informado.
                                            if (cep != "") {

                                                //Expressão regular para validar o CEP.
                                                var validacep = /^[0-9]{8}$/;

                                                //Valida o formato do CEP.
                                                if(validacep.test(cep)) {

                                                    //Preenche os campos com "..." enquanto consulta webservice.
                                                    $("#endereco_igreja_anterior").val("...")
                                                    $("#bairro_igreja_anterior").val("...")
                                                    $("#cidade_igreja_anterior").val("...")
                                                    $("#estado_igreja_anterior").val("...")

                                                    //Consulta o webservice viacep.com.br/
                                                    $.getJSON("//viacep.com.br/ws/"+ cep +"/json/?callback=?", function(dados) {

                                                        if (!("erro" in dados)) {
                                                            //Atualiza os campos com os valores da consulta.
                                                            $("#endereco_igreja_anterior").val(dados.logradouro);
                                                            $("#bairro_igreja_anterior").val(dados.bairro);
                                                            $("#cidade_igreja_anterior").val(dados.localidade);
                                                            $("#estado_igreja_anterior").val(dados.uf);
                                                        } //end if.
                                                        else {
                                                            //CEP pesquisado não foi encontrado.
                                                            limpa_formulario_cep_igreja();
                                                            alert("CEP não encontrado.");
                                                        }
                                                    });
                                                } //end if.
                                                else {
                                                    //cep é inválido.
                                                    limpa_formulario_cep_igreja();
                                                    alert("Formato de CEP inválido.");
                                                }
                                            } //end if.
                                            else {
                                                //cep sem valor, limpa formulário.
                                                limpa_formulario_cep_igreja();
                                            }
                                        });

                   });
</script>

@endsection