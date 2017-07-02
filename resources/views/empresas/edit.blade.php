@extends('principal.master')

@section('content')

{{ \Session::put('titulo', 'Igrejas / Instituições') }}
{{ \Session::put('subtitulo', 'Alteração / Visualização') }}
{{ \Session::put('route', 'empresas') }}
{{ \Session::put('id_pagina', '27') }}

<div class = 'row'>

    <div class="col-md-12">

        <div>
            <a href="{{ url('/empresas')}}" class="btn btn-default"><i class="fa fa-arrow-circle-left"></i> Voltar</a>
        </div>

        <form method = 'POST' class="form-horizontal" enctype="multipart/form-data" action = {{ url('/empresas/' . $empresas->id . '/update')}}>
            <!--<input type = 'hidden' name = '_token' value = '{{Session::token()}}'>-->
            {!! csrf_field() !!}

            <div class="">

                 <div class="nav-tabs-custom"> <!--anterior box-body-->

                         <!-- Nav tabs -->
                          <ul class="nav nav-tabs" role="tablist">
                                  <li class="active">
                                      <a href="#home" role="tab" data-toggle="tab">
                                          <icon class="fa fa-user"></icon> Dados Cadastrais
                                      </a>
                                  </li>
                                  <li>
                                        <a href="#panel_endereco" role="tab" data-toggle="tab">
                                            <i class="fa fa-map-marker"></i> Endereço
                                        </a>
                                  </li>
                                   <li>
                                        <a href="#compl" role="tab" data-toggle="tab">
                                            <i class="fa fa-cog"></i> Complementos
                                        </a>
                                   </li>
                          </ul>

                              <!-- Tab panes -->
                              <!-- DADOS CADASTRAIS-->
                           <div class="tab-content">

                                  <div class="tab-pane active in" id="home">

                                        <br/>

                                        <div class="row{{ $errors->has('razaosocial') ? ' has-error' : '' }}">
                                                <div class="col-xs-6">
                                                      <label for="razaosocial" class="control-label">Razão Social</label>

                                                      <input id="razaosocial" maxlength="150"  name = "razaosocial" type="text" class="form-control" value="{{ $empresas->razaosocial }}">

                                                         <!-- se houver erros na validacao do form request -->
                                                         @if ($errors->has('razaosocial'))
                                                          <span class="help-block">
                                                              <strong>{{ $errors->first('razaosocial') }}</strong>
                                                          </span>
                                                         @endif

                                                </div>

                                                <div class="col-xs-6">
                                                    <label for="nomefantasia" class="control-label">Nome Fantasia</label>
                                                    <input id="nomefantasia" maxlength="100" name = "nomefantasia" type="text" class="form-control" value="{{$empresas->nomefantasia}}">
                                              </div>


                                        </div>


                                        <div class="row">

                                                <div class="col-xs-3">
                                                       <label for="cnpj" class="control-label">CNPJ</label>
                                                       <input id="cnpj" data-inputmask='"mask": "99.999.999/9999-99"' data-mask name = "cnpj" type="text" class="form-control" value="{{$empresas->cnpj}}">
                                                </div>

                                                <div class="col-xs-3">
                                                     <label for="inscricaoestadual" class="control-label">Inscr. Estadual</label>
                                                     <input id="inscricaoestadual"  maxlength="15" name = "inscricaoestadual" type="text" class="form-control" value="{{$empresas->inscricaoestadual}}">
                                                </div>

                                                <div class="col-xs-3">
                                                    <label for="foneprincipal" class="control-label">Fone Principal</label>

                                                    <div class="input-group{{ $errors->has('foneprincipal') ? ' has-error' : '' }}">
                                                           <div class="input-group-addon">
                                                            <i class="fa fa-phone"></i>
                                                            </div>

                                                            <input id="foneprincipal" name = "foneprincipal" type="text" class="form-control" value="{{$empresas->foneprincipal}}"  data-inputmask='"mask": "(99) 9999-9999"' data-mask >

                                                             <!-- se houver erros na validacao do form request -->
                                                             @if ($errors->has('foneprincipal'))
                                                              <span class="help-block">
                                                                  <strong>{{ $errors->first('foneprincipal') }}</strong>
                                                              </span>
                                                             @endif

                                                    </div>

                                              </div>

                                                 <div class="col-xs-3">
                                                        <label for="fonesecundario" class="control-label">Fone Secundário</label>

                                                        <div class="input-group">
                                                               <div class="input-group-addon">
                                                                <i class="fa fa-phone"></i>
                                                                </div>

                                                                <input id="fonesecundario" name = "fonesecundario" type="text" class="form-control" data-inputmask='"mask": "(99) 9999-9999"' data-mask  value="{{$empresas->fonesecundario}}">
                                                        </div>

                                                 </div>

                                         </div>


                                        <div class="row">
                                                <div class="col-xs-3">
                                                    <label for="nomecontato" class="control-label">Contato</label>
                                                    <input id="nomecontato" maxlength="45" name = "nomecontato" type="text" class="form-control" value="{{$empresas->nomecontato}}">
                                                </div>

                                                <div class="col-xs-3">
                                                    <label for="celular" class="control-label">Celular</label>

                                                    <div class="input-group">
                                                               <div class="input-group-addon">
                                                                <i class="fa fa-phone"></i>
                                                                </div>
                                                                <input id="celular" data-inputmask='"mask": "(99) 9999-9999"' data-mask  name = "celular" type="text" class="form-control" value="{{$empresas->celular}}">
                                                    </div>
                                                </div>
                                        </div>

                                        <div class="row">
                                                  <div class="col-xs-6">
                                                        <label for="emailprincipal" class="control-label">Email</label>

                                                        <div class="input-group{{ $errors->has('emailprincipal') ? ' has-error' : '' }}">
                                                                   <div class="input-group-addon">
                                                                    <i class="fa fa-envelope"></i>
                                                                    </div>
                                                                    <input id="emailprincipal" maxlength="150" name = "emailprincipal" type="text" class="form-control" value="{{$empresas->emailprincipal}}">

                                                                     <!-- se houver erros na validacao do form request -->
                                                                     @if ($errors->has('emailprincipal'))
                                                                      <span class="help-block">
                                                                          <strong>{{ $errors->first('emailprincipal') }}</strong>
                                                                      </span>
                                                                     @endif

                                                        </div>

                                                   </div>

                                                    <div class="col-xs-6">
                                                            <label for="emailsecundario" class="control-label">Email Secundário</label>

                                                             <div class="input-group{{ $errors->has('emailsecundario') ? ' has-error' : '' }}">
                                                                   <div class="input-group-addon">
                                                                         <i class="fa fa-envelope"></i>
                                                                    </div>
                                                                    <input id="emailsecundario" maxlength="150" name = "emailsecundario" type="text" class="form-control" value="{{$empresas->emailsecundario}}">

                                                                     <!-- se houver erros na validacao do form request -->
                                                                     @if ($errors->has('emailsecundario'))
                                                                      <span class="help-block">
                                                                             <strong>{{ $errors->first('emailsecundario') }}</strong>
                                                                      </span>
                                                                     @endif
                                                            </div>

                                                    </div>
                                        </div>


                                  </div> <!-- FIM DADOS CADASTRAIS-->

                                 <!-- ENDEREÇO-->
                                 <div class="tab-pane" id="panel_endereco">
                                    <br/>

                                     <div class="row">

                                           <!-- Inicio do formulario -->
                                           <div class="col-xs-2">
                                                      <label for="cep" class="control-label">CEP</label>
                                                      <div class="input-group">
                                                               <div class="input-group-addon">
                                                                  <a href="#" data-toggle="tooltip" title="Digite o CEP para buscar automaticamente o endereço. Não informar pontos ou traços.">
                                                                        <img src="{{ url('/images/help.png') }}" class="user-image" alt="Ajuda"  />
                                                                   </a>
                                                                </div>

                                                                <input id="cep" maxlength="8" name = "cep" type="text" class="form-control" value="{{$empresas->cep}}">
                                                        </div>
                                           </div>

                                            <div class="col-xs-7">
                                                    <label for="endereco" class="control-label">Endereço</label>
                                                    <input id="endereco" maxlength="150" name = "endereco" type="text" class="form-control" value="{{$empresas->endereco}}">
                                            </div>

                                            <div class="col-xs-2">
                                                    <label for="numero" class="control-label">Número</label>
                                                    <input id="numero" maxlength="10" name = "numero" type="text" class="form-control" value="{{$empresas->numero}}">
                                            </div>
                                      </div>

                                      <div class="row">
                                            <div class="col-xs-5">
                                                  <label for="bairro" class="control-label">Bairro</label>
                                                  <input id="bairro" maxlength="50" name = "bairro" type="text" class="form-control" value="{{$empresas->bairro}}">
                                             </div>

                                            <div class="col-xs-5">
                                                <label for="complemento" class="control-label">Complemento</label>
                                                <input id="complemento" name = "complemento" type="text" class="form-control" value="{{$empresas->complemento}}">
                                            </div>

                                      </div>

                                    <div class="row">
                                            <div class="col-xs-5">
                                                    <label for="cidade" class="control-label">Cidade</label>
                                                    <input id="cidade" maxlength="60" name = "cidade" type="text" class="form-control" value="{{$empresas->cidade}}">
                                            </div>

                                            <div class="col-xs-2">
                                                <label for="estado" class="control-label">Estado</label>
                                                <input id="estado" maxlength="2" name = "estado" type="text" class="form-control" value="{{$empresas->estado}}">
                                            </div>
                                    </div>

                             </div><!-- FIM TAB ENDERECO-->


                                <!-- TAB COMPLEMENTO-->
                                <div class="tab-pane" id="compl">
                                    <br/>

                                    <!--
                                    <div class="row">
                                            <div class="col-xs-1">
                                                    <label for="ativo" class="control-label">Ativo</label>
                                                    <input id="ativo" maxlength="1" name = "ativo" type="text" class="form-control" value="{{$empresas->ativo}}" >
                                            </div>
                                    </div>
                                    -->

                                    <div class="row">
                                            <div class="col-xs-9">
                                                <label for="website" class="control-label">Website</label>
                                                <input id="website" maxlength="255" name = "website" type="text" class="form-control" value="{{$empresas->website}}">
                                            </div>
                                    </div>

                                    <div class="row">
                                            <div class="col-xs-5">
                                                    <label for="caminhologo" class="control-label">Logo</label>
                                                    <input type="file" id="caminhologo" maxlength="255" name = "caminhologo" >
                                            </div>

                                              @if ($empresas->caminhologo!="")
                                                  <p></p>
                                                  <div class="col-xs-3">
                                                        <img src="{{ url('/images/clients/' . $empresas->caminhologo) }}" width="200px" height="100px">

                                                        @can('verifica_permissao', [ \Session::get('id_pagina') ,'excluir'])
                                                        <a href="{{ url('/empresas/' . $empresas->id . '/remover')}}"><i class="fa fa-remove"> Remover Imagem</i> </a>
                                                        @endcan
                                                  </div>

                                              @endif
                                    </div>


                                </div><!--  FIM TAB COMPLEMENTO-->

                         </div><!-- Fim tab panes-->

            </div><!-- fim box-body"-->
        </div><!-- box box-primary -->

        <div class="box-footer">
            <button class = 'btn btn-primary' type ='submit' {{ ($preview=='true' ? 'disabled=disabled' : "" ) }}><i class="fa fa-save"></i> Salvar</button>
            <a href="{{ url('/empresas')}}" class="btn btn-default">Cancelar</a>
        </div>

       </form>

    </div><!-- <col-md-12 -->

</div><!-- row -->

@endsection

@section('busca_endereco')

<script type="text/javascript">

                  $(function ()
                  {

                            $("#menu_config").addClass("treeview active");

                            $('[data-toggle="tooltip"]').tooltip();

                            function limpa_formulario_cep()
                            {
                                // Limpa valores do formulário de cep.
                                $("#endereco").val("");
                                $("#bairro").val("");
                                $("#cidade").val("");
                                $("#estado").val("");
                                $("#ibge").val("");
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
                                                    $("#ibge").val("...")

                                                    //Consulta o webservice viacep.com.br/
                                                    $.getJSON("//viacep.com.br/ws/"+ cep +"/json/?callback=?", function(dados) {

                                                        if (!("erro" in dados)) {
                                                            //Atualiza os campos com os valores da consulta.
                                                            $("#endereco").val(dados.logradouro);
                                                            $("#bairro").val(dados.bairro);
                                                            $("#cidade").val(dados.localidade);
                                                            $("#estado").val(dados.uf);
                                                            $("#ibge").val(dados.ibge);
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

                   });
</script>


@endsection