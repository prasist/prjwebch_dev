@extends('principal.master')

@section('content')

{{ \Session::put('titulo', $interface->nome) }}
{{ \Session::put('subtitulo', 'Alteração / Visualização') }}
{{ \Session::put('route', 'pessoas') }}
{{ \Session::put('id_pagina', '28') }}

<!--

In this obsession with the things this world says make us happy
Can't see the slaves we are in all the searching all the grasping
Like we deserve much more than all these blessing we're holding
So now I'm running free into an ocean of mercy unending

So come and empty me
So that it's you I breathe
I want my life to be
Only Christ in me
So I will fix my eyes
'Cause you're my source of life
I need the world to see
That it's Christ in me
That it's Christ in me

Done with what holds me down the things I once was chasing after
Throw off these heavy chains that I have let become my master
So now I'm running free into an ocean of mercy unending

So come and empty me
So that it's you I breathe
I want my life to be
Only Christ in me
So I will fix my eyes
'Cause you're my source of life
I need the world to see
That it's Christ in me
That it's Christ in me

In this obsession with the things this world says make us happy
Can't see the slaves we are in all the searching all the grasping

So come and empty me
So that it's you I breathe
I want my life to be
Only Christ in me
So I will fix my eyes
'Cause you're my source of life
I need the world to see
Only Christ in me
Only Christ in me
Only Christ in me
Christ in me



Read more: Jeremy Camp - Christ In Me Lyrics | MetroLyrics

-->
<div class = 'row'>

    <div class="col-md-12">

        <form name="form_endereco" method="get" action=".">
        </form>

        <form method = 'POST' class="form-horizontal"  enctype="multipart/form-data" action = {{ url('/' . \Session::get('route') . '/' . $pessoas[0]->id . '/update')}}>

        {!! csrf_field() !!}

        <div class="box-footer">
            <button class = 'btn btn-primary' type ='submit' {{ ($preview=='true' ? 'disabled=disabled' : "" ) }}><i class="fa fa-save"></i> Salvar</button>
            <a href="{{ url('/' . \Session::get('route') )}}" class="btn btn-default">Cancelar</a>
        </div>

        <br/>


          <div>

                 <div class="nav-tabs-custom"> <!--anterior box-body-->

                        <!-- Guarda ID tipo pessoa-->

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
                                                              <input type="radio" name="opStatus" class="minimal"  value="S" {{ $pessoas[0]->ativo=='S' ? 'checked' : '' }}>
                                                              Ativo
                                                         </label>

                                                         <label>
                                                              <input type="radio" name="opStatus" class="minimal" value="N" {{ $pessoas[0]->ativo=='N' ? 'checked' : '' }}>
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
                                                              <input type="radio" id="opFisica" name="opPessoa" value="F" class="opFisica" {{ ( ($pessoas[0]->tipopessoa=="F") ? 'checked' : '') }}>
                                                              Física
                                                         </label>
                                                         @endif

                                                         @if ($interface->juridica)
                                                         <label>
                                                              <input type="radio" id="opJuridica" name="opPessoa" value="J" class="opJuridica" {{ ( ($pessoas[0]->tipopessoa=="J") ? 'checked' : '') }}>
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


                                                @if ($pessoas[0]->caminhofoto!="")
                                                  <div class="col-xs-3">
                                                      <label for="fotodocamarada" class="control-label">Foto</label>
                                                       <div class="row" style="width:90px; height:80px; border:double;">
                                                             <img id="fotodocamarada" src="{{ url('/images/persons/' . $pessoas[0]->caminhofoto) }}" width="85px" height="75px">
                                                        </div>
                                                  </div>
                                                @endif

                                        </div>
                                        <div class="row">
                                                <div class="col-xs-6">
                                                     @include('carregar_combos', array('dados'=>$grupos, 'titulo' =>'Grupo', 'id_combo'=>'grupo', 'complemento'=>'', 'comparar'=>$pessoas[0]->grupos_pessoas_id, 'id_pagina'=> '31'))
                                                     @include('modal_cadastro_basico', array('qual_campo'=>'grupo', 'modal' => 'modal_grupo', 'tabela' => 'grupos_pessoas'))
                                                </div>

                                                <div class="col-xs-6">
                                                     <label for="tipos_pessoas_id" class="control-label">Tipos Pessoas</label>
                                                     <select id="tipos_pessoas_id" placeholder="(Selecionar)" name="tipos_pessoas_id" data-live-search="true" data-none-selected-text="Nenhum item selecionado" class="form-control" style="width: 100%;">
                                                      <option  value="">(Selecionar)</option>
                                                      @foreach($tipos_pessoas as $item)
                                                             <option  value="{{$item->id}}" {{ ($pessoas[0]->tipos_pessoas_id== $item->id ? 'selected' : '') }}>{{$item->nome}}</option>
                                                      @endforeach
                                                      </select>
                                                </div>
                                        </div>

                                        <div class="row{{ $errors->has('razaosocial') ? ' has-error' : '' }}">
                                                <div class="col-xs-6">

                                                      <label for="razaosocial" class="control-label">{{ $interface->fisica==true ? 'Nome' : 'Razão Social'}}</label>

                                                      <input id="razaosocial" maxlength="150"  placeholder="Campo Obrigatório" name = "razaosocial" type="text" class="form-control" value="{{$pessoas[0]->razaosocial }}">

                                                         <!-- se houver erros na validacao do form request -->
                                                         @if ($errors->has('razaosocial'))
                                                          <span class="help-block">
                                                              <strong>{{ $errors->first('razaosocial') }}</strong>
                                                          </span>
                                                         @endif

                                                </div>

                                               <div class="col-xs-6">
                                                    <label for="nomefantasia" class="control-label">{{ $interface->fisica==true ? 'Nome Abrev.' : 'Nome Fantasia'}}</label>
                                                    <input id="nomefantasia" maxlength="100" name = "nomefantasia" type="text" class="form-control" value="{{$pessoas[0]->nomefantasia}}">
                                               </div>

                                        </div>

                                        <input id="cnpj" type="hidden" name="cnpj" value="">
                                        <input id="cpf"  type="hidden" name="cpf"  value="">

                                        <div class="row">

                                                    <div class="col-xs-3  {{ $errors->has('cpf') ? ' has-error' : '' }} {{ $errors->has('cnpj') ? ' has-error' : '' }}">
                                                           <label id="lb_cnpj_cpf" for="cnpj_cpf" class="control-label">{{ $pessoas[0]->tipopessoa=="F" ? 'CPF' : 'CNPJ'}}</label>

                                                           <input id="cnpj" style='{{ $pessoas[0]->tipopessoa=='F' ? 'display:none' : '' }}' data-inputmask='"mask": "99.999.999/9999-99"' data-mask name="cnpj" type="text" class="cnpj form-control" value="{{ $pessoas[0]->tipopessoa=='F' ? '' : $pessoas[0]->cnpj_cpf }}">
                                                           <input id="cpf"  style='{{ $pessoas[0]->tipopessoa=='J' ? 'display:none' : '' }}' data-inputmask='"mask": "999.999.999-99"' data-mask name="cpf" type="text" class="cpf form-control" value="{{ $pessoas[0]->tipopessoa=='J' ? '' : $pessoas[0]->cnpj_cpf }}">

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
                                                         <label id="lb_inscricaoestadual_rg" for="inscricaoestadual_rg" class="control-label">{{ $pessoas[0]->tipopessoa=='F' ? 'RG' : 'Insc. Estadual'}}</label>
                                                         <input id="inscricaoestadual_rg"  maxlength="15" name = "inscricaoestadual_rg" type="text" class="form-control" value="{{ $pessoas[0]->inscricaoestadual_rg }}">
                                                    </div>

                                                    <div class="col-xs-3">
                                                              <label id="lb_datanasc" for="datanasc" class="control-label">{{ $pessoas[0]->tipopessoa=='F' ? 'Data Nasc.' : 'Data Fundação'}}</label>

                                                              <div class="input-group">
                                                                     <div class="input-group-addon">
                                                                      <i class="fa fa-calendar"></i>
                                                                      </div>

                                                                      <input id ="datanasc" name = "datanasc" onblur="validar_data(this)" type="text" class="form-control" data-inputmask='"mask": "99/99/9999"' data-mask  value="{{$pessoas[0]->datanasc_formatada}}">
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

                                                            <input id="foneprincipal"  name = "foneprincipal" type="text" class="form-control" value="{{$pessoas[0]->fone_principal}}"  >

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

                                                                <input id="fonesecundario" name = "fonesecundario" type="text" class="form-control"   value="{{$pessoas[0]->fone_secundario}}">
                                                        </div>

                                                 </div>

                                                <div class="col-xs-3">
                                                        <label for="fonerecado" class="control-label">Fone Recado</label>

                                                        <div class="input-group">
                                                               <div class="input-group-addon">
                                                                <i class="fa fa-phone"></i>
                                                                </div>

                                                                <input id="fonerecado" name = "fonerecado" type="text" class="form-control"   value="{{$pessoas[0]->fone_recado}}">
                                                        </div>

                                                 </div>

                                                <div class="col-xs-3">
                                                    <label for="celular" class="control-label">Celular</label>

                                                    <div class="input-group">
                                                               <div class="input-group-addon">
                                                                <i class="fa fa-phone"></i>
                                                                </div>
                                                                <input id="celular"   name = "celular" type="text" class="form-control" value="{{$pessoas[0]->fone_celular}}">
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
                                                                    <input id="emailprincipal" maxlength="150" name = "emailprincipal" type="text" class="form-control" value="{{$pessoas[0]->emailprincipal}}">

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
                                                                    <input id="emailsecundario" maxlength="150" name = "emailsecundario" type="text" class="form-control" value="{{$pessoas[0]->emailsecundario}}">

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
                                            <div class="col-xs-12">
                                                      <label for="website" class="control-label">Website</label>
                                                      <input id="website" maxlength="255" name = "website" type="text" class="form-control" value="{{$pessoas[0]->website}}">
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

                                                                <input id="cep" maxlength="8" name = "cep" type="text" class="form-control" value="{{$pessoas[0]->cep}}">
                                                        </div>
                                           </div>


                                            <div class="col-xs-7">
                                                    <label for="endereco" class="control-label">Endereço</label>
                                                    <input id="endereco" maxlength="150" name = "endereco" type="text" class="form-control" value="{{$pessoas[0]->endereco}}">
                                            </div>

                                            <div class="col-xs-2">
                                                    <label for="numero" class="control-label">Número</label>
                                                    <input id="numero" maxlength="10" name = "numero" type="text" class="form-control" value="{{$pessoas[0]->numero}}">
                                            </div>
                                      </div>

                                      <div class="row">
                                            <div class="col-xs-5">
                                                  <label for="bairro" class="control-label">Bairro</label>
                                                  <input id="bairro" maxlength="50" name = "bairro" type="text" class="form-control" value="{{$pessoas[0]->bairro}}">
                                             </div>

                                            <div class="col-xs-5">
                                                <label for="complemento" class="control-label">Complemento</label>
                                                <input id="complemento" name = "complemento" type="text" class="form-control" value="{{$pessoas[0]->complemento}}">
                                            </div>

                                      </div>

                                    <div class="row">
                                            <div class="col-xs-5">
                                                    <label for="cidade" class="control-label">Cidade</label>
                                                    <input id="cidade" maxlength="60" name = "cidade" type="text" class="form-control" value="{{$pessoas[0]->cidade}}">
                                            </div>

                                            <div class="col-xs-2">
                                                <label for="estado" class="control-label">Estado</label>
                                                <input id="estado" maxlength="2" name = "estado" type="text" class="form-control" value="{{$pessoas[0]->estado}}">
                                            </div>
                                    </div>

                                </div><!-- FIM TAB ENDERECO-->



                                <!-- TAB FINANCEIRO-->
                                <div class="tab-pane fade" id="panel_financ">
                                    <br/>

                                      <div class="row">
                                                <div class="col-xs-3">
                                                       <label for="codigo_contabil" class="control-label">Código Contábil</label>
                                                       <input id="codigo_contabil"  name = "codigo_contabil" type="text" class="form-control" value="{{$pessoas[0]->codigo_contabil}}">
                                                </div>
                                      </div>

                                      <div class="row">
                                            <div class="col-xs-8">
                                                  @include('carregar_combos', array('dados'=>$bancos, 'titulo' =>'Banco Emissão Boleto', 'id_combo'=>'banco', 'complemento'=>'', 'comparar'=>$pessoas[0]->bancos_id, 'id_pagina'=>'35'))
                                            </div>
                                      </div>

                                      <div class="row">
                                                <div class="col-xs-5">
                                                            <p></p>
                                                            <label for="check_endcobranca">
                                                                  <input  id="check_endcobranca" name="check_endcobranca" type="checkbox" class="minimal-red" {{ ($pessoas[0]->endereco_cobranca!="" ? 'checked' : '') }} value="1" />
                                                                  Endereço de Cobrança diferente do principal
                                                            </label>
                                                </div>
                                      </div>

                                      <div id="exibir_endereco_cobranca" {{ ($pessoas[0]->endereco_cobranca!="" ? "": "style='display: none'") }} >
                                              <div class="row">

                                                      <div class="col-xs-3">
                                                           <label for="cep_cobranca" class="control-label">CEP</label>
                                                           <input id="cep_cobranca" maxlength="8" name = "cep_cobranca" type="text" class="form-control" value="{{$pessoas[0]->cep_cobranca}}">
                                                      </div>

                                                      <div class="col-xs-7">
                                                              <label for="endereco_cobranca" class="control-label">Endereço para Cobrança</label>
                                                              <input id="endereco_cobranca" maxlength="150" name = "endereco_cobranca" type="text" class="form-control" value="{{$pessoas[0]->endereco_cobranca}}">
                                                      </div>

                                                      <div class="col-xs-2">
                                                              <label for="numero_cobranca" class="control-label">Número</label>
                                                              <input id="numero_cobranca" maxlength="10" name = "numero_cobranca" type="text" class="form-control" value="{{$pessoas[0]->numero_cobranca}}">
                                                      </div>
                                              </div>

                                              <div class="row">
                                                      <div class="col-xs-5">
                                                            <label for="bairro_cobranca" class="control-label">Bairro</label>
                                                            <input id="bairro_cobranca" maxlength="50" name = "bairro_cobranca" type="text" class="form-control" value="{{$pessoas[0]->bairro_cobranca}}">
                                                       </div>

                                                      <div class="col-xs-5">
                                                          <label for="complemento_cobranca" class="control-label">Complemento</label>
                                                          <input id="complemento_cobranca" name = "complemento_cobranca" type="text" class="form-control" value="{{$pessoas[0]->complemento_cobranca}}">
                                                      </div>


                                              </div>

                                              <div class="row">
                                                      <div class="col-xs-5">
                                                              <label for="cidade_cobranca" class="control-label">Cidade</label>
                                                              <input id="cidade_cobranca" maxlength="60" name = "cidade_cobranca" type="text" class="form-control" value="{{$pessoas[0]->cidade_cobranca}}">
                                                      </div>

                                                      <div class="col-xs-2">
                                                          <label for="estado_cobranca" class="control-label">Estado</label>
                                                          <input id="estado_cobranca" maxlength="2" name = "estado_cobranca" type="text" class="form-control" value="{{$pessoas[0]->estado_cobranca}}">
                                                      </div>
                                              </div>
                                       </div>

                                </div><!--  FIM TAB FINANCEIRO-->



                                <!-- TAB OBSERVACOES -->
                                <div class="tab-pane fade" id="obs">

                                        <div class="row">
                                                <div class="col-xs-10">

                                                    <label for="obs" class="control-label">Observações</label>
                                                    <textarea name="obs" class="form-control" rows="6" placeholder="Digite o texto...">{{$pessoas[0]->obs}}</textarea>

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
                                                                            <input type="file" id="caminhologo" name = "caminhologo"  onchange="checkPhoto(this)">
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

                                                      <div class="box-body"><!-- box-body-->
                                                            <div class="row"><!-- row entrada-->
                                                                @if ($pessoas[0]->caminhofoto!="")

                                                                        <div class="col-xs-4">
                                                                              <center>
                                                                              <label class="control-label">Foto Atual</label>

                                                                              <!--<div  style="width:320px; height:240px; border:dotted;">-->
                                                                              <div  style="border:dotted;">
                                                                                    <img src="{{ url('/images/persons/' . $pessoas[0]->caminhofoto) }}" width="150px" height="120px">
                                                                                    <!--width="315px" height="235px"-->
                                                                              </div>
                                                                              @can('verifica_permissao', [ \Session::get('id_pagina') ,'excluir'])
                                                                                 <a href="{{ url('/pessoas/' . $pessoas[0]->id . '/remover')}}" class="btn btn-danger"><i class="fa fa-trash"></i> Remover Imagem</a></center>
                                                                              @endcan
                                                                        </div>

                                                                  @endif

                                                                  <p class="text-warning">Importante! A WebCam apresenta problemas de funcionamento no Google Chrome. Sugerimos utilizar o navegador Firefox.</p>

                                                                    <div class="col-xs-4">
                                                                          <center>
                                                                          <label class="control-label"></label>
                                                                          <center><a href="javascript:void(ativar_webcam())" class="btn btn-primary"><i class="fa fa-power-off"></i> Iniciar WebCam</a></center>
                                                                          <!--<div id="my_camera" style="width:320px; height:240px; border:dotted;"></div>-->
                                                                          <div id="my_camera" style="width:150px; height:120px; border:dotted;"></div>
                                                                          <a href="javascript:void(take_snapshot())" class="btn btn-success"><i class="fa fa-camera"></i> Tirar Foto pela WebCam</a></center>
                                                                    </div>

                                                                    <div class="col-xs-4">
                                                                            <center>
                                                                                <label class="control-label">Foto WebCam</label>
                                                                                <!--<div id="my_result" class="row" style="width:320px; height:240px; border:dotted;"></div>-->
                                                                                <div id="my_result" class="row" style="width:150px; height:120px; border:dotted;"></div>
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
                                     @include('pessoas.dados_eclesiasticos', array('tipo_operacao'=>'alteracao'))
                               @endif


                         </div><!-- Fim tab panes-->

            </div><!-- fim box-body"-->

       </div>

        <div class="box-footer">
            <button class = 'btn btn-primary' type ='submit' {{ ($preview=='true' ? 'disabled=disabled' : "" ) }}><i class="fa fa-save"></i> Salvar</button>
            <a href="{{ url('/' . \Session::get('route') )}}" class="btn btn-default">Cancelar</a>
        </div>

        </form>

    </div>

</div>

@endsection

@include('pessoas.script_pessoas')