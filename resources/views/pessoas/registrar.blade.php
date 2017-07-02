@extends('principal.master')

@section('content')

{{ \Session::put('titulo', $interface->nome) }}
{{ \Session::put('subtitulo', 'Inclusão') }}
{{ \Session::put('route', 'pessoas') }}
{{ \Session::put('id_pagina', '28') }}


<div class = 'row'>

    <div class="col-md-12">

        <form name="form_endereco" method="get" action=".">
        </form>


        <form name ="form_principal" method = 'POST' class="form-horizontal"  enctype="multipart/form-data" action = {{ url('/' . \Session::get('route') . '/gravar')}}>

        <div class="box-footer">
            <button class = 'btn btn-primary' type ='submit'><i class="fa fa-save"></i> Salvar</button>
            <a href="{{ url('/' . \Session::get('route') )}}" class="btn btn-default">Cancelar</a>
        </div>
        <br/>

        {!! csrf_field() !!}

          <div>

                 <div class="nav-tabs-custom"> <!--anterior box-body-->

                        <!-- Guarda ID tipo pessoa-->
                        <input  name="tipos_pessoas_id" type="hidden"  value="{{ $interface->id }}" />

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
                                        <a href="#panel_financ" role="tab" data-toggle="tab">
                                            <i class="fa fa-money"></i> Dados Financeiros
                                        </a>
                                   </li>

                                   <li>
                                        <a href="#obs" role="tab" data-toggle="tab">
                                            <i class="fa fa-edit"></i> Observações
                                        </a>
                                   </li>

                                   @if ($interface->membro)
                                   <li>
                                        <a href="#eclesia" role="tab" data-toggle="tab">
                                            <i class="fa fa-child"></i> Dados Eclesiásticos
                                        </a>
                                   </li>
                                   @endif

                                   <li>
                                        <a href="#foto" role="tab" data-toggle="tab">
                                            <i class="fa fa-photo"></i> Foto
                                        </a>
                                   </li>

                          </ul>

                           <!-- Tab panes -->
                            <!-- DADOS CADASTRAIS-->
                           <div class="tab-content">

                                  <div class="tab-pane fade active in" id="home">

                                        <div class="row">
                                                <div class="col-xs-3{{ $errors->has('opStatus') ? ' has-error' : '' }}">
                                                    <label for="opStatus" class="control-label">Status :</label>
                                                    <br/>
                                                         <label>
                                                              <input type="radio" name="opStatus" class="minimal" value="S" checked>
                                                              Ativo
                                                         </label>

                                                         <label>
                                                              <input type="radio" name="opStatus" class="minimal" value="N">
                                                              Inativo
                                                         </label>

                                                           <!-- se houver erros na validacao do form request -->
                                                         @if ($errors->has('opStatus'))
                                                          <span class="help-block">
                                                              <strong>{{ $errors->first('opStatus') }}</strong>
                                                          </span>
                                                         @endif
                                                </div>

                                                <div class="col-xs-3 {{ $errors->has('opPessoa') ? ' has-error' : '' }}">


                                                      <label for="opPessoa" class="control-label">Tipo Pessoa :</label>
                                                      <br/>

                                                        @if ($interface->fisica)
                                                         <label>
                                                              <input type="radio" id="opFisica" name="opPessoa" value="F" class="opFisica" {{ ( ($interface->fisica==true && $interface->juridica==false) ? 'checked' : '') }}>
                                                              Física
                                                         </label>
                                                         @endif

                                                         @if ($interface->juridica)
                                                         <label>
                                                              <input type="radio" id="opJuridica" name="opPessoa" value="J" class="opJuridica" {{ ( ($interface->fisica==false && $interface->juridica==true) ? 'checked' : '') }}>
                                                              Jurídica
                                                         </label>
                                                         @endif

                                                         <!-- se houver erros na validacao do form request -->
                                                         @if ($errors->has('opPessoa'))
                                                          <span class="help-block">
                                                              <strong>{{ $errors->first('opPessoa') }}</strong>
                                                          </span>
                                                         @endif

                                                </div>


                                        </div>

                                        <div class="row">
                                              <div class="col-xs-6">
                                                  @include('carregar_combos', array('dados'=>$grupos, 'titulo' =>'Grupo', 'id_combo'=>'grupo', 'complemento'=>'', 'comparar'=>'', 'id_pagina'=> '31'))
                                                  @include('modal_cadastro_basico', array('qual_campo'=>'grupo', 'modal' => 'modal_grupo', 'tabela' => 'grupos_pessoas'))
                                              </div><!-- col-xs-5-->

                                              <div class="col-xs-6">
                                                    <label for="tipos_pessoas_id" class="control-label">Tipos Pessoas</label>
                                                    <select id="tipos_pessoas_id" placeholder="(Selecionar)" name="tipos_pessoas_id" data-live-search="true" data-none-selected-text="Nenhum item selecionado" class="form-control" style="width: 100%;">
                                                    <option  value="">(Selecionar)</option>
                                                      @foreach($tipos_pessoas as $item)
                                                             <option  value="{{$item->id}}" {{ ($interface->id==$item->id ? "selected" : "") }}>{{$item->nome}}</option>
                                                      @endforeach
                                                    </select>
                                              </div>

                                        </div>

                                        <div class="row">
                                                <div class="col-xs-6 {{ $errors->has('razaosocial') ? ' has-error' : '' }}">

                                                      <label for="razaosocial" class="control-label">{{ $interface->fisica==true ? 'Nome' : 'Razão Social'}}</label>

                                                      <input id="razaosocial" maxlength="150"  placeholder="Campo Obrigatório" name = "razaosocial" type="text" class="form-control" value="{{ old('razaosocial') }}">

                                                         <!-- se houver erros na validacao do form request -->
                                                         @if ($errors->has('razaosocial'))
                                                          <span class="help-block">
                                                              <strong>{{ $errors->first('razaosocial') }}</strong>
                                                          </span>
                                                         @endif

                                                </div>

                                               <div class="col-xs-6">
                                                    <label for="nomefantasia" class="control-label">{{ $interface->fisica==true ? 'Nome Abrev.' : 'Nome Fantasia'}}</label>
                                                    <input id="nomefantasia" maxlength="100" name = "nomefantasia" type="text" class="form-control" value="{{old('nomefantasia')}}">
                                               </div>

                                        </div>

                                        <input id="cnpj" type="hidden" name="cnpj" value="">
                                        <input id="cpf"  type="hidden" name="cpf"  value="">

                                        <div class="row">

                                                    <div class="col-xs-3 {{ $errors->has('cpf') ? ' has-error' : '' }} {{ $errors->has('cnpj') ? ' has-error' : '' }}">
                                                           <label id="lb_cnpj_cpf" for="cnpj_cpf" class="control-label">{{ $interface->fisica==true ? 'CPF' : 'CNPJ'}}</label>

                                                           <input id="cnpj" style='{{ $interface->fisica==true ? 'display:none' : '' }}' data-inputmask='"mask": "99.999.999/9999-99"' data-mask name="cnpj" type="text" class="cnpj form-control" value="{{old('cnpj_cpf')}}">
                                                           <input id="cpf"  style='{{ $interface->juridica==true ? 'display:none' : '' }}' data-inputmask='"mask": "999.999.999-99"' data-mask name="cpf" type="text" class="cpf form-control" value="{{old('cnpj_cpf')}}">

                                                         <!-- se houver erros na validacao do form request -->
                                                         @if ($errors->has('cpf'))
                                                          <span class="help-block">
                                                              <strong>{{ $errors->first('cpf') }}</strong>
                                                          </span>
                                                         @endif

                                                         @if ($errors->has('cnpj'))
                                                          <span class="help-block">
                                                              <strong>{{ $errors->first('cnpj') }}</strong>
                                                          </span>
                                                         @endif


                                                    </div>

                                                    <div class="col-xs-3">
                                                         <label id="lb_inscricaoestadual_rg" for="inscricaoestadual_rg" class="control-label">{{ $interface->fisica==true ? 'RG' : 'Insc. Estadual'}}</label>
                                                         <input id="inscricaoestadual_rg"  maxlength="15" name = "inscricaoestadual_rg" type="text" class="form-control" value="{{ old('inscricaoestadual_rg') }}">
                                                    </div>

                                                    <div class="col-xs-3">
                                                              <label id="lb_datanasc" for="datanasc" class="control-label">{{ $interface->fisica==true ? 'Data Nasc.' : 'Data Fundação'}}</label>

                                                              <div class="input-group">
                                                                     <div class="input-group-addon">
                                                                      <i class="fa fa-calendar"></i>
                                                                      </div>

                                                                      <input id ="datanasc" name = "datanasc" onblur="validar_data(this)" type="text" class="form-control" data-inputmask='"mask": "99/99/9999"' data-mask  value="{{old('datanasc')}}">
                                                              </div>

                                                     </div>

                                       </div>

                                       <div class="row">
                                                <div class="col-xs-3">
                                                    <label for="foneprincipal" class="control-label">Fone Principal</label>

                                                    <div class="input-group{{ $errors->has('foneprincipal') ? ' has-error' : '' }}">
                                                           <div class="input-group-addon">
                                                            <i class="fa fa-phone"></i>
                                                            </div>

                                                            <input id="foneprincipal" name = "foneprincipal" type="text" class="form-control" value="{{old('foneprincipal')}}">

                                                    </div>

                                              </div>

                                                 <div class="col-xs-3">
                                                        <label for="fonesecundario" class="control-label">Fone Secundário</label>

                                                        <div class="input-group">
                                                               <div class="input-group-addon">
                                                                <i class="fa fa-phone"></i>
                                                                </div>

                                                                <input id="fonesecundario" name = "fonesecundario" type="text" class="form-control"  value="{{old('fonesecundario')}}">
                                                        </div>

                                                 </div>

                                                <div class="col-xs-3">
                                                        <label for="fonerecado" class="control-label">Fone Recado</label>

                                                        <div class="input-group">
                                                               <div class="input-group-addon">
                                                                <i class="fa fa-phone"></i>
                                                                </div>

                                                                <input id="fonerecado" name = "fonerecado" type="text" class="form-control"  value="{{old('fonerecado')}}">
                                                        </div>

                                                 </div>

                                                <div class="col-xs-3">
                                                    <label for="celular" class="control-label">Celular</label>

                                                    <div class="input-group">
                                                               <div class="input-group-addon">
                                                                <i class="fa fa-phone"></i>
                                                                </div>
                                                                <input id="celular"  name = "celular" type="text" class="form-control" value="{{old('celular')}}">
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
                                                                    <input id="emailprincipal" maxlength="150" name = "emailprincipal" type="text" class="form-control" value="{{old('emailprincipal')}}">

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
                                                                    <input id="emailsecundario" maxlength="150" name = "emailsecundario" type="text" class="form-control" value="{{old('emailsecundario')}}">

                                                                     <!-- se houver erros na validacao do form request -->
                                                                     @if ($errors->has('emailsecundario'))
                                                                      <span class="help-block">
                                                                             <strong>{{ $errors->first('emailsecundario') }}</strong>
                                                                      </span>
                                                                     @endif
                                                            </div>

                                                    </div>


                                        </div>

                                        <div class="row">
                                                    <div class="col-xs-6">
                                                        <label for="website" class="control-label">Website</label>
                                                        <input id="website" maxlength="255" name = "website" type="text" class="form-control" value="{{old('website')}}">
                                                    </div>
                                        </div>


                                  </div> <!-- FIM DADOS CADASTRAIS-->


                                 <!-- ENDEREÇO-->
                                 <div class="tab-pane fade" id="panel_endereco">

                                      <div class="row">

                                           <div class="col-xs-3">
                                                      <label for="cep" class="control-label">CEP</label>
                                                      <div class="input-group">
                                                               <div class="input-group-addon">
                                                                  <a href="#" data-toggle="tooltip" title="Digite o CEP para buscar automaticamente o endereço. Não informar pontos ou traços.">
                                                                        <img src="{{ url('/images/help.png') }}" class="user-image" alt="Ajuda"  />
                                                                   </a>
                                                                </div>

                                                                <input id="cep" maxlength="8" name = "cep" type="text" class="form-control" value="{{old('cep')}}">
                                                        </div>
                                           </div>

                                            <div class="col-xs-7">
                                                    <label for="endereco" class="control-label">Endereço</label>
                                                    <input id="endereco" maxlength="150" name = "endereco" type="text" class="form-control" value="{{old('endereco')}}">
                                            </div>

                                            <div class="col-xs-2">
                                                    <label for="numero" class="control-label">Número</label>
                                                    <input id="numero" maxlength="10" name = "numero" type="text" class="form-control" value="{{old('numero')}}">
                                            </div>
                                      </div>

                                      <div class="row">
                                            <div class="col-xs-5">
                                                  <label for="bairro" class="control-label">Bairro</label>
                                                  <input id="bairro" maxlength="50" name = "bairro" type="text" class="form-control" value="{{old('bairro')}}">
                                             </div>

                                            <div class="col-xs-5">
                                                <label for="complemento" class="control-label">Complemento</label>
                                                <input id="complemento" name = "complemento" type="text" class="form-control" value="{{old('complemento')}}">
                                            </div>

                                      </div>

                                    <div class="row">
                                            <div class="col-xs-5">
                                                    <label for="cidade" class="control-label">Cidade</label>
                                                    <input id="cidade" maxlength="60" name = "cidade" type="text" class="form-control" value="{{old('cidade')}}">
                                            </div>

                                            <div class="col-xs-2">
                                                <label for="estado" class="control-label">Estado</label>
                                                <input id="estado" maxlength="2" name = "estado" type="text" class="form-control" value="{{old('estado')}}">
                                            </div>
                                    </div>


                                </div><!-- FIM TAB ENDERECO-->


                                <!-- TAB FINANCEIRO-->
                                <div class="tab-pane" id="panel_financ">
                                    <br/>

                                      <div class="row">
                                                <div class="col-xs-3">
                                                       <label for="codigo_contabil" class="control-label">Código Contábil</label>
                                                       <input id="codigo_contabil"  name = "codigo_contabil" type="text" class="form-control" value="{{old('codigo_contabil')}}">
                                                </div>
                                      </div>

                                      <div class="row">
                                            <div class="col-xs-8">
                                                  @include('carregar_combos', array('dados'=>$bancos, 'titulo' =>'Banco Emissão Boleto', 'id_combo'=>'banco', 'complemento'=>'', 'comparar'=>old('banco'), 'id_pagina'=>'35'))
                                            </div>
                                      </div>

                                      <div class="row">
                                                <div class="col-xs-5">
                                                            <p></p>
                                                            <label for="endcobranca">
                                                                  <input  id="endcobranca" name="endcobranca" type="checkbox" class="minimal-red" value="1" />
                                                                  Endereço de Cobrança diferente do principal
                                                            </label>
                                                </div>
                                      </div>

                                      <div id="exibir_endereco_cobranca" style="display: none">
                                              <div class="row">

                                                      <div class="col-xs-2">

                                                          <label for="cep_cobranca" class="control-label">CEP</label>
                                                          <div class="input-group">
                                                                   <div class="input-group-addon">
                                                                      <a href="#" data-toggle="tooltip" title="Digite o CEP para buscar automaticamente o endereço. Não informar pontos ou traços.">
                                                                            <img src="{{ url('/images/help.png') }}" class="user-image" alt="Ajuda"  />
                                                                       </a>
                                                                    </div>

                                                                    <input id="cep_cobranca" maxlength="8" name = "cep_cobranca" type="text" class="form-control" value="{{old('cep')}}">
                                                            </div>

                                                      </div>

                                                      <div class="col-xs-7">
                                                              <label for="endereco_cobranca" class="control-label">Endereço para Cobrança</label>
                                                              <input id="endereco_cobranca" maxlength="150" name = "endereco_cobranca" type="text" class="form-control" value="{{old('endereco')}}">
                                                      </div>

                                                      <div class="col-xs-1">
                                                              <label for="numero_cobranca" class="control-label">Número</label>
                                                              <input id="numero_cobranca" maxlength="10" name = "numero_cobranca" type="text" class="form-control" value="{{old('numero_cobranca')}}">
                                                      </div>
                                              </div>

                                              <div class="row">
                                                      <div class="col-xs-5">
                                                            <label for="bairro_cobranca" class="control-label">Bairro</label>
                                                            <input id="bairro_cobranca" maxlength="50" name = "bairro_cobranca" type="text" class="form-control" value="{{old('bairro')}}">
                                                       </div>

                                                      <div class="col-xs-5">
                                                          <label for="complemento_cobranca" class="control-label">Complemento</label>
                                                          <input id="complemento_cobranca" name = "complemento_cobranca" type="text" class="form-control" value="{{old('complemento')}}">
                                                      </div>


                                              </div>

                                              <div class="row">
                                                      <div class="col-xs-5">
                                                              <label for="cidade_cobranca" class="control-label">Cidade</label>
                                                              <input id="cidade_cobranca" maxlength="60" name = "cidade_cobranca" type="text" class="form-control" value="{{old('cidade')}}">
                                                      </div>

                                                      <div class="col-xs-2">
                                                          <label for="estado_cobranca" class="control-label">Estado</label>
                                                          <input id="estado_cobranca" maxlength="2" name = "estado_cobranca" type="text" class="form-control" value="{{old('estado')}}">
                                                      </div>
                                              </div>
                                       </div>

                                </div><!--  FIM TAB FINANCEIRO-->


                                <!-- TAB OBSERVACOES -->
                                <div class="tab-pane fade" id="obs">

                                        <div class="row">
                                                <div class="col-xs-10">

                                                    <label for="obs" class="control-label">Observações</label>
                                                    <textarea name="obs" class="form-control" rows="6" placeholder="Digite o texto..." value="{{old('obs')}}"></textarea>

                                                </div>
                                         </div>
                                </div><!-- FIM - TAB OBSERVACOES -->


                                <!-- TAB FOTO -->
                                <div class="tab-pane fade" id="foto">
                                      <input id="mydata" type="hidden" name="mydata" value=""/>

                                      <div class="row">
                                         <div class="col-md-12">
                                                <div class="box box-default">

                                                      <div class="box-header">
                                                              <h3 class="box-title">Enviar foto à partir do computador</h3>
                                                      </div>

                                                      <div class="box-body"><!-- box-body-->
                                                            <div class="row"><!-- row entrada-->

                                                                     <div class="col-xs-5">
                                                                            <input type="file" id="caminhologo"  name = "caminhologo" onchange="checkPhoto(this)">
                                                                            <label id="msg" class="text-danger"></label>
                                                                     </div>
                                                           </div>
                                                      </div>

                                               </div>
                                         </div>
                                   </div>


                                 <div class="row">
                                         <div class="col-md-12">
                                                <div class="box box-default">

                                                      <!--
                                                      <div class="box-header">
                                                              <h3 class="box-title">Tirar foto pela WebCam</h3>
                                                      </div>
                                                      -->

                                                      <p class="text-warning">Importante! A WebCam apresenta problemas de funcionamento no Google Chrome. Sugerimos utilizar o navegador Firefox.</p>

                                                      <div class="box-body"><!-- box-body-->
                                                            <div class="row"><!-- row entrada-->

                                                                    <div class="col-xs-4">
                                                                          <center>
                                                                          <label class="control-label"></label>
                                                                          <center><a href="javascript:void(ativar_webcam())" class="btn btn-primary"><i class="fa fa-power-off"></i> Iniciar WebCam</a></center>
                                                                          <div id="my_camera" style="width:320px; height:240px; border:dotted;"></div>
                                                                          <a href="javascript:void(take_snapshot())" class="btn btn-success"><i class="fa fa-camera"></i> Tirar Foto</a></center>
                                                                    </div>

                                                                    <div class="col-xs-4">
                                                                            <center>
                                                                                <label class="control-label">Foto WebCam</label>
                                                                                <div id="my_result" class="row" style="width:320px; height:240px; border:dotted;"></div>
                                                                            </center>
                                                                    </div>

                                                          </div>

                                                   </div> <!-- fim body-->
                                           </div>
                                      </div>
                                   </div>

                                </div><!-- FIM - TAB FOTO -->

                               <!--
                               Somente se estiver cadastrado no tipo de pessoa para exibir MEMBROS
                               AQUI INCLUI ABAS DE DADOS ECLESIASTICOS
                               Será o mesmo include para edicao e inclusao, diferenciando pela variavel tipo_operacao. Quando inclusao mostra no campo
                               value os dados de post value = old('nomecampo'), quando edição mostra os dados do banco de dados value = $tabela->campo
                               -->
                               @if ($interface->membro)
                                     @include('pessoas.dados_eclesiasticos', array('tipo_operacao'=>'inclusao'))
                               @endif


                         </div><!-- Fim tab panes-->

            </div><!-- fim box-body"-->

       </div>


        <div class="box-footer">
            <button class = 'btn btn-primary' type ='submit'><i class="fa fa-save"></i> Salvar</button>
            <a href="{{ url('/' . \Session::get('route') )}}" class="btn btn-default">Cancelar</a>
        </div>

        </form>

    </div>

</div>

@endsection

@include('pessoas.script_pessoas')