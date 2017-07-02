<!-- DADOS ECLISIASTICOS-->
   <div class="tab-pane fade" id="eclesia">

      <div class="row">
              <div class="col-md-12">

                <div class="box box-solid">

                  <div class="box-header with-border">
                          <h3 class="box-title">Clique nas opções abaixo para preencher os dados</h3>
                  </div>

                  <!-- /.box-header -->
                  <div class="box-body">

                    <div class="box-group" id="accordion">

                      <!-- we are adding the .panel class so bootstrap.js collapse plugin detects it -->
                      <div class="panel box box-primary">
                        <div class="box-header with-border">
                          <h5 class="box-title">
                            <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne">
                              <span class="fa fa-user-plus"></span> Dados Pessoais
                            </a>
                          </h5>
                        </div>
                        <div id="collapseOne" class="panel-collapse collapse">
                          <div class="box-body">

                          <input type="hidden" name="situacoes[]" class="minimal" value="">

                                <div class="row">

                                        <div class="col-md-12">
                                                <div class="box box-default">
                                                    <div class="box-body">

                                                         <div class="col-xs-6">
                                                                      <label for="familia" class="control-label">Resp. Família</label>
                                                                      <div class="input-group">
                                                                               <div class="input-group-addon">
                                                                                   <button  id="buscarpessoa" type="button"  data-toggle="modal" data-target="#familia_myModal" >
                                                                                         <i class="fa fa-search"></i> ...
                                                                                   </button>
                                                                                   &nbsp;<a href="#" onclick="remover_pessoa('familia');" title="Limpar Campo"><spam class="fa fa-close"></spam></a>
                                                                                </div>

                                                                                @include('modal_buscar_pessoas', array('qual_campo'=>'familia', 'modal' => 'familia_myModal'))

                                                                                @if (isset($membros_dados_pessoais))
                                                                                      <input id="familia"  name = "familia" type="text" class="form-control" placeholder="Clica na lupa ao lado para consultar uma pessoa" value="{!! ($membros_dados_pessoais[0]->familias_id!="" ? str_repeat('0', (9-strlen($membros_dados_pessoais[0]->familias_id))) . $membros_dados_pessoais[0]->familias_id . ' - ' . $membros_dados_pessoais[0]->razaosocial  : '') !!}" readonly >
                                                                                @else
                                                                                      <input id="familia"  name = "familia" type="text" class="form-control" placeholder="Clica na lupa ao lado para consultar uma pessoa" value="" readonly >
                                                                                @endif

                                                                        </div>
                                                         </div>

                                                         <div class="col-xs-6">
                                                                 @include('carregar_combos', array('dados'=>$status, 'titulo' =>'Status', 'id_combo'=>'status', 'complemento'=>'', 'comparar'=>($tipo_operacao=='inclusao' ? '' : (isset($membros_dados_pessoais) ? $membros_dados_pessoais[0]->status_id : '') ), 'id_pagina'=> '8'))
                                                                 @include('modal_cadastro_basico', array('qual_campo'=>'status', 'modal' => 'modal_status', 'tabela' => 'status'))
                                                         </div><!-- col-xs-5-->

                                                         <div class="col-xs-6">
                                                                 @include('carregar_combos_multiple', array('dados'=>$situacoes, 'titulo' =>'Situações', 'id_combo'=>'situacoes[]', 'complemento'=>'multiple="multiple"', 'comparar'=>(isset($membros_situacoes) ? $membros_situacoes : ''), 'id_pagina'=> '26'))
                                                         </div><!-- col-xs-5-->
                                                   </div>
                                                </div>
                                         </div>

                                </div><!-- end row-->


                                <div class="row">

                                <!-- campos hidden -->

                                <input type="hidden" name="ck_necessidades" class="minimal" value="false">

                                         <div class="col-md-6">
                                                <div class="box box-default">
                                                    <div class="box-body">

                                                       <div class="col-xs-4">
                                                             <label for="opSexo" class="control-label">Sexo</label>
                                                             <select name="opSexo" id="opSexo" class="form-control select2" style="width: 100%;">
                                                             <option  value="">(Selecionar)</option>
                                                                   @if (isset($membros_dados_pessoais))
                                                                      <option  value="M"  {{ ($tipo_operacao=='inclusao' ? '' : ($membros_dados_pessoais[0]->sexo=='M' ? 'selected=selected' : '') )  }}>Masculino</option>
                                                                      <option  value="F" {{ ($tipo_operacao=='inclusao' ? '' : ($membros_dados_pessoais[0]->sexo=='F' ? 'selected=selected' : '') )  }}>Feminino</option>
                                                                   @else
                                                                      <option  value="M">Masculino</option>
                                                                      <option  value="F">Feminino</option>
                                                                   @endif
                                                             </select>
                                                       </div>

                                                       <div class="col-xs-4">
                                                             <label for="opDoadorSangue" class="control-label">Doador Sangue</label>

                                                             <select name="opDoadorSangue" class="form-control select2" style="width: 100%;">
                                                             <option  value="">(Selecionar)</option>
                                                                   @if (isset($membros_dados_pessoais))
                                                                      <option  value="1"  {{ ($tipo_operacao=='inclusao' ? '' : ($membros_dados_pessoais[0]->doador_sangue==true ? 'selected=selected' : '') )  }}>SIM</option>
                                                                      <option  value="0" {{ ($tipo_operacao=='inclusao' ? '' : ($membros_dados_pessoais[0]->doador_sangue==false ? 'selected=selected' : '') )  }}>NÃO</option>
                                                                   @else
                                                                      <option  value="1">SIM</option>
                                                                      <option  value="0">NÃO</option>
                                                                   @endif
                                                             </select>

                                                       </div>

                                                       <div class="col-xs-4">
                                                               <label for="opDoadorOrgaos" class="control-label">Doador Orgãos</label>

                                                               <select name="opDoadorOrgaos" class="form-control select2" style="width: 100%;">
                                                               <option  value="">(Selecionar)</option>
                                                                     @if (isset($membros_dados_pessoais))
                                                                        <option  value="1" {{ ($tipo_operacao=='inclusao' ? '' : ($membros_dados_pessoais[0]->doador_orgaos==true ? 'selected=selected' : '') )  }}>SIM</option>
                                                                        <option  value="0" {{ ($tipo_operacao=='inclusao' ? '' : ($membros_dados_pessoais[0]->doador_orgaos==false ? 'selected=selected' : '') )  }}>NÃO</option>
                                                                     @else
                                                                        <option  value="1">SIM</option>
                                                                        <option  value="0">NÃO</option>
                                                                     @endif
                                                               </select>

                                                       </div>

                                                     </div>
                                                </div>
                                          </div>

                                           <div class="col-md-6">
                                                  <div class="box box-default">
                                                        <div class="box-body">

                                                                 <div class="col-xs-4">
                                                                          <label for="grpsangue" class="control-label">Grupo Sanguínio</label>
                                                                          <input id="grpsangue" name = "grpsangue" type="text" class="form-control"  value="{{ ($tipo_operacao=='inclusao' ? old('gruposanguinio') : (isset($membros_dados_pessoais) ? $membros_dados_pessoais[0]->grupo_sanguinio : '') ) }}">
                                                                  </div>

                                                                  <div class="col-xs-7">

                                                                          <label for="ck_necessidades">Possui Necessidades Especiais ?</label>
                                                                          <div class="input-group">
                                                                               <div class="input-group-addon">
                                                                                        <input  id="ck_necessidades" name="ck_necessidades" type="checkbox" class="minimal-red" value="true" {{ ($tipo_operacao=='inclusao' ? '' : (isset($membros_dados_pessoais) ? ($membros_dados_pessoais[0]->possui_necessidades_especiais==1 ? 'checked' : '') : '')  ) }} />
                                                                                </div>

                                                                                <input id="necessidades" name = "necessidades" type="text" class="form-control" placeholder="Descrição Tipo Necessidade"  value="{{ ($tipo_operacao=='inclusao' ? old('necessidades') : (isset($membros_dados_pessoais) ? $membros_dados_pessoais[0]->descricao_necessidade_especial : '') ) }}">
                                                                          </div>

                                                                 </div>

                                                       </div>
                                                  </div>
                                            </div>

                           </div> <!-- end row-->

                           <div  class="row">

                                              <div class="col-md-6">

                                                    <div class="box box-default">

                                                          <div class="box-body">

                                                                <div class="col-xs-4">
                                                                          <label for="naturalidade" class="control-label">Naturalidade</label>
                                                                          <input id="naturalidade" name = "naturalidade" type="text" class="form-control"  value="{{ ($tipo_operacao=='inclusao' ? old('naturalidade') : (isset($membros_dados_pessoais) ? $membros_dados_pessoais[0]->naturalidade : '') ) }}">
                                                                </div>

                                                                <div class="col-xs-3">
                                                                          <label for="ufnaturalidade" class="control-label">UF</label>
                                                                          <input id="ufnaturalidade" name = "ufnaturalidade" maxlength="2" type="text" class="form-control"  value="{{ ($tipo_operacao=='inclusao' ? old('ufnaturalidade') : (isset($membros_dados_pessoais) ? trim($membros_dados_pessoais[0]->uf_naturalidade) : '')  ) }}">
                                                                </div>

                                                                  <div class="col-xs-3">
                                                                            <label for="nacionalidade" class="control-label">Nacionalidade</label>
                                                                            <input id="nacionalidade" name = "nacionalidade" type="text" class="form-control"  value="{{ ($tipo_operacao=='inclusao' ? old('nacionalidade') : (isset($membros_dados_pessoais) ? $membros_dados_pessoais[0]->nacionalidade : '') ) }}">
                                                                  </div>

                                                                  <div class="col-xs-4">
                                                                          @include('carregar_combos', array('dados'=>$idiomas, 'titulo' =>'Lingua Oficial', 'id_combo'=>'lingua', 'complemento'=>'', 'comparar'=>($tipo_operacao=='inclusao' ? '' : (isset($membros_dados_pessoais) ? $membros_dados_pessoais[0]->idiomas_id : '') ), 'id_pagina'=> '9'))
                                                                          @include('modal_cadastro_basico', array('qual_campo'=>'lingua', 'modal' => 'modal_lingua', 'tabela' => 'idiomas'))
                                                                  </div>

                                                          </div>

                                                    </div>
                                              </div>

                                              <div class="col-md-6">

                                                    <div class="box box-default">

                                                          <div class="box-body">

                                                                 <div class="col-xs-7">
                                                                          @include('carregar_combos', array('dados'=>$igrejas, 'titulo' =>'Igreja', 'id_combo'=>'igreja', 'complemento'=>'', 'comparar'=>($tipo_operacao=='inclusao' ? '' : (isset($membros_dados_pessoais) ? $membros_dados_pessoais[0]->igrejas_id : '') ), 'id_pagina'=> '7'))
                                                                          @include('modal_cadastro_basico', array('qual_campo'=>'igreja', 'modal' => 'modal_igreja', 'tabela' => 'igrejas'))
                                                                 </div>

                                                          </div>

                                                    </div>
                                              </div>


                           </div><!-- end row-->


                           <!-- REDES SOCIAIS -->
                           <div  class="row">

                                              <div class="col-md-12">

                                                    <div class="box box-default">
                                                          <div class="box-header">
                                                            <h3 class="box-title">Redes Sociais</h3>
                                                          </div>

                                                          <div class="box-body">

                                                                <div class="col-xs-10">
                                                                          <label for="facebook" class="control-label">Facebook</label>
                                                                          <input id="facebook" name = "facebook" type="text" class="form-control"  value="{{ ($tipo_operacao=='inclusao' ? old('facebook') : (isset($membros_dados_pessoais) ? $membros_dados_pessoais[0]->link_facebook : '') ) }}">
                                                                </div>

                                                                <div class="col-xs-10">
                                                                          <label for="google" class="control-label">Google+</label>
                                                                          <input id="google" name = "google" type="text" class="form-control"  value="{{ ($tipo_operacao=='inclusao' ? old('google') : (isset($membros_dados_pessoais) ? $membros_dados_pessoais[0]->link_google : '') ) }}">
                                                                </div>

                                                                  <div class="col-xs-10">
                                                                            <label for="instagram" class="control-label">Instagram</label>
                                                                            <input id="instagram" name = "instagram" type="text" class="form-control"  value="{{ ($tipo_operacao=='inclusao' ? old('instagram') : (isset($membros_dados_pessoais) ? $membros_dados_pessoais[0]->link_instagram : '') ) }}">
                                                                  </div>

                                                                  <div class="col-xs-10">
                                                                            <label for="linkedin" class="control-label">LinkedIn</label>
                                                                            <input id="linkedin" name = "linkedin" type="text" class="form-control"  value="{{ ($tipo_operacao=='inclusao' ? old('linkedin') : (isset($membros_dados_pessoais) ? $membros_dados_pessoais[0]->link_linkedin : '') ) }}">
                                                                  </div>


                                                          </div>

                                                    </div>
                                              </div>

                              </div><!-- end row-->

                          </div><!-- end box-body-->

                        </div> <!-- end collapse-->

                      </div>

                      <!-- TAB Dados Profissionais -->
                      <div class="panel box box-primary">
                        <div class="box-header with-border">
                          <h5 class="box-title">
                            <a data-toggle="collapse" data-parent="#accordion" href="#tab2">
                              <span class="fa fa-user-md"></span> Dados Profissionais
                            </a>
                          </h5>
                        </div>
                        <div id="tab2" class="panel-collapse collapse">
                          <div class="box-body">

                               <div  class="row">

                                     <div class="col-md-12">

                                              <div class="box box-default">

                                                    <div class="box-body"><!-- box-body-->

                                                           <div class="row">

                                                                <div class="col-xs-10">
                                                                        <label for="nome_empresa" class="control-label">Empresa</label>
                                                                        @if (isset($membros_profissionais))
                                                                              <input id="nome_empresa" maxlength="150" name = "nome_empresa" type="text" class="form-control" value="{{ ($tipo_operacao=='inclusao' ? old('nome_empresa') : $membros_profissionais[0]->nome_empresa) }}">
                                                                        @else
                                                                              <input id="nome_empresa" maxlength="150" name = "nome_empresa" type="text" class="form-control" value="">
                                                                        @endif
                                                                </div>
                                                           </div>

                                                           <div class="row">

                                                                  <div class="col-xs-3">
                                                                              <label for="cep_prof" class="control-label">CEP</label>
                                                                              <div class="input-group">
                                                                                       <div class="input-group-addon">
                                                                                          <a href="#" data-toggle="tooltip" title="Digite o CEP para buscar automaticamente o endereço. Não informar pontos ou traços.">
                                                                                                <img src="{{ url('/images/help.png') }}" class="user-image" alt="Ajuda"  />
                                                                                           </a>
                                                                                        </div>

                                                                                        @if (isset($membros_profissionais))
                                                                                             <input id="cep_prof" maxlength="8" name = "cep_prof" type="text" class="form-control" value="{{ ($tipo_operacao=='inclusao' ? old('cep_prof') : $membros_profissionais[0]->cep) }}">
                                                                                        @else
                                                                                             <input id="cep_prof" maxlength="8" name = "cep_prof" type="text" class="form-control" value="">
                                                                                        @endif
                                                                                </div>
                                                                  </div>

                                                                    <div class="col-xs-7">
                                                                            <label for="endereco_prof" class="control-label">Endereço</label>
                                                                            @if (isset($membros_profissionais))
                                                                                  <input id="endereco_prof" maxlength="150" name = "endereco_prof" type="text" class="form-control" value="{{ ($tipo_operacao=='inclusao' ? old('endereco_prof') : $membros_profissionais[0]->endereco) }}">
                                                                            @else
                                                                                  <input id="endereco_prof" maxlength="150" name = "endereco_prof" type="text" class="form-control" value="">
                                                                            @endif
                                                                    </div>

                                                                    <div class="col-xs-2">
                                                                            <label for="numero_prof" class="control-label">Número</label>
                                                                            <input id="numero_prof" maxlength="10" name = "numero_prof" type="text" class="form-control" value="{{ (isset($membros_profissionais) ? $membros_profissionais[0]->numero : '') }}">
                                                                    </div>

                                                             </div>

                                                            <div class="row">
                                                                  <div class="col-xs-5">
                                                                        <label for="bairro_prof" class="control-label">Bairro</label>
                                                                        <input id="bairro_prof" maxlength="50" name = "bairro_prof" type="text" class="form-control" value="{{ (isset($membros_profissionais) ? $membros_profissionais[0]->bairro : '') }}">
                                                                   </div>

                                                                  <div class="col-xs-5">
                                                                      <label for="complemento_prof" class="control-label">Complemento</label>
                                                                      <input id="complemento_prof" name = "complemento_prof" type="text" class="form-control" value="{{ (isset($membros_profissionais) ? $membros_profissionais[0]->complemento : '') }}">
                                                                  </div>
                                                             </div>

                                                            <div class="row">
                                                                    <div class="col-xs-5">
                                                                            <label for="cidade_prof" class="control-label">Cidade</label>
                                                                            <input id="cidade_prof" maxlength="60" name = "cidade_prof" type="text" class="form-control" value="{{ (isset($membros_profissionais) ? $membros_profissionais[0]->cidade : '') }}">
                                                                    </div>

                                                                    <div class="col-xs-2">
                                                                        <label for="estado_prof" class="control-label">Estado</label>
                                                                        <input id="estado_prof" maxlength="2" name = "estado_prof" type="text" class="form-control" value="{{ (isset($membros_profissionais) ? $membros_profissionais[0]->estado : '') }}">
                                                                    </div>

                                                                    <div class="col-xs-6"><!-- col-xs-6-->
                                                                        <label for="emailprofissional" class="control-label">Email</label>

                                                                        <div class="input-group{{ $errors->has('emailprofissional') ? ' has-error' : '' }}">
                                                                                   <div class="input-group-addon">
                                                                                    <i class="fa fa-envelope"></i>
                                                                                    </div>
                                                                                    <input id="emailprofissional" maxlength="150" name = "emailprofissional" type="text" class="form-control" value="{{ (isset($membros_profissionais) ?  $membros_profissionais[0]->emailprofissional : '') }}">

                                                                                     <!-- se houver erros na validacao do form request -->
                                                                                     @if ($errors->has('emailprofissional'))
                                                                                      <span class="help-block">
                                                                                          <strong>{{ $errors->first('emailprofissional') }}</strong>
                                                                                      </span>
                                                                                     @endif
                                                                        </div>
                                                                   </div><!-- end col-xs-6-->

                                                            </div>

                                                            <div class="row"><!-- row-->

                                                                   <div class="col-xs-12">
                                                                          @include('carregar_combos', array('dados'=>$cargos, 'titulo' =>'Cargo/Função', 'id_combo'=>'cargos', 'complemento'=>'', 'comparar'=>(isset($membros_profissionais) ? $membros_profissionais[0]->cargos_id : '') , 'id_pagina'=> '20'))
                                                                          @include('modal_cadastro_basico', array('qual_campo'=>'cargos', 'modal' => 'modal_cargos', 'tabela' => 'cargos'))
                                                                   </div><!-- col-xs-5-->
                                                            </div>
                                                            <div class="row"><!-- row-->
                                                                   <div class="col-xs-12">
                                                                          @include('carregar_combos', array('dados'=>$ramos, 'titulo' =>'Ramos de Atividade', 'id_combo'=>'ramos', 'complemento'=>'', 'comparar'=>(isset($membros_profissionais) ? $membros_profissionais[0]->ramos_id : ''), 'id_pagina'=> '21'))
                                                                          @include('modal_cadastro_basico', array('qual_campo'=>'ramos', 'modal' => 'modal_ramos', 'tabela' => 'ramos_atividades'))
                                                                   </div><!-- col-xs-5-->
                                                            </div>
                                                            <div class="row"><!-- row-->

                                                                   <div class="col-xs-12">
                                                                          @include('carregar_combos', array('dados'=>$profissoes, 'titulo' =>'Profissão', 'id_combo'=>'profissoes', 'complemento'=>'', 'comparar'=>(isset($membros_profissionais) ? $membros_profissionais[0]->profissoes_id : ''), 'id_pagina'=> '11'))
                                                                          @include('modal_cadastro_basico', array('qual_campo'=>'profissoes', 'modal' => 'modal_profissoes', 'tabela' => 'profissoes'))
                                                                   </div><!-- col-xs-5-->

                                                            </div><!-- end row-->

                                                     </div><!-- end box-body-->

                                               </div><!-- end box-default-->

                                        </div>

                               </div><!-- end row-->

                          </div>
                        </div>
                      </div><!-- FIM TAB Dados Profissionais -->



                      <!-- TAB FORMAÇÃO-->
                      <div class="panel box box-primary">
                          <div class="box-header with-border">
                            <h5 class="box-title">
                              <a data-toggle="collapse" data-parent="#accordion" href="#tab3">
                                <span class="fa fa-institution"></span> Formação
                              </a>
                            </h5>
                          </div>
                          <div id="tab3" class="panel-collapse collapse">
                            <div class="box-body">

                             <div  class="row">

                                     <div class="col-md-12">

                                              <div class="box box-default">

                                                    <div class="box-body"><!-- box-body-->

                                                            <input type="hidden" name="graus" class="minimal" value="">
                                                            <input type="hidden" name="formacoes[]" class="minimal" value="">
                                                            <input type="hidden" name="idiomas[]" class="minimal" value="">

                                                            <div class="row"><!-- row-->
                                                                   <div class="col-xs-10">
                                                                          @include('carregar_combos', array('dados'=>$graus, 'titulo' =>'Grau de Instrução', 'id_combo'=>'graus', 'complemento'=>'', 'comparar'=>($tipo_operacao=='inclusao' ? '' : (isset($membros_dados_pessoais) ? $membros_dados_pessoais[0]->graus_id : '') ), 'id_pagina'=> '10'))
                                                                          @include('modal_cadastro_basico', array('qual_campo'=>'graus', 'modal' => 'modal_graus', 'tabela' => 'graus_instrucao'))
                                                                   </div><!-- col-xs-5-->
                                                           </div>

                                                           <div class="row"><!-- row-->
                                                                   <div class="col-xs-10">
                                                                          @include('carregar_combos_multiple', array('dados'=>$formacoes, 'titulo' =>'Áreas de Formação', 'id_combo'=>'formacoes[]', 'complemento'=>'multiple="multiple"', 'comparar'=>(isset($membros_formacoes) ? $membros_formacoes : ''), 'id_pagina'=> '12'))
                                                                   </div><!-- col-xs-5-->
                                                           </div>

                                                            <div class="row"><!-- row-->
                                                                   <div class="col-xs-10">
                                                                          @include('carregar_combos_multiple', array('dados'=>$idiomas, 'titulo' =>'Idiomas', 'id_combo'=>'idiomas[]', 'complemento'=>'multiple="multiple"', 'comparar'=>(isset($membros_idiomas) ? $membros_idiomas : ''), 'id_pagina'=> '9'))
                                                                   </div><!-- col-xs-5-->
                                                           </div><!-- end row-->

                                                     </div><!-- end box-body-->

                                               </div><!-- end box-default-->

                                     </div>

                               </div><!-- end row-->

                            </div>

                          </div>
                      </div><!-- FIM TAB FORMAÇÃO-->



                      <!-- TAB FAMILIAR-->
                      <div class="panel box box-primary">
                          <div class="box-header with-border">
                            <h5 class="box-title">
                              <a data-toggle="collapse" data-parent="#accordion" href="#tab4">
                                <span class="fa fa-users"></span> Familiar
                              </a>
                            </h5>
                          </div>
                          <div id="tab4" class="panel-collapse collapse">
                            <div class="box-body">

                               <div class="row">
                                <div class="col-md-12">
                                    <div class="box box-default">
                                        <div class="box-body"><!-- box-body-->
                                                  <div class="col-xs-3">
                                                        @include('carregar_combos', array('dados'=>$estadoscivis, 'titulo' =>'Estado Civil', 'id_combo'=>'estadoscivis', 'complemento'=>'', 'comparar'=>($tipo_operacao=='inclusao' ? '' : (isset($membros_dados_pessoais) ? $membros_dados_pessoais[0]->estadoscivis_id : '') ), 'id_pagina'=> '22'))
                                                        @include('modal_cadastro_basico', array('qual_campo'=>'estadoscivis', 'modal' => 'modal_estadoscivis', 'tabela' => 'estados_civis'))
                                                  </div><!-- col-xs-->
                                        </div>
                                    </div>
                                   </div>
                               </div>


                               <div class="row">

                                       <div class="col-md-12">

                                              <div class="box box-default">

                                                    <div class="box-header">
                                                            <h3 class="box-title">Conjuge</h3>
                                                    </div>

                                                    <div class="box-body"><!-- box-body-->

                                                          <div class="row"><!-- row entrada-->

                                                                  <div class="col-xs-12">
                                                                      <label for="conjuge" class="control-label">Selecionar Conjuge já cadastrado</label>
                                                                      <div class="input-group">
                                                                               <div class="input-group-addon">
                                                                                  <button  id="buscarpessoa" type="button"  data-toggle="modal" data-target="#conjuge_myModal" >
                                                                                         <i class="fa fa-search"></i> ...
                                                                                   </button>
                                                                                   &nbsp;<a href="#" onclick="remover_pessoa('conjuge');" title="Limpar Campo"><spam class="fa fa-close"></spam></a>
                                                                                </div>

                                                                                @include('modal_buscar_pessoas', array('qual_campo'=>'conjuge', 'modal' => 'conjuge_myModal'))

                                                                                @if (isset($membros_familiares))
                                                                                      <input id="conjuge"  name = "conjuge" type="text" class="form-control" placeholder="Clica na lupa ao lado para consultar uma pessoa" value="{!! ($membros_familiares[0]->conjuge_id!="" ? str_repeat('0', (9-strlen($membros_familiares[0]->conjuge_id))) . $membros_familiares[0]->conjuge_id . ' - ' . $membros_familiares[0]->razaosocial  : '') !!}" readonly >
                                                                                @else
                                                                                      <input id="conjuge"  name = "conjuge" type="text" class="form-control" placeholder="Clica na lupa ao lado para consultar uma pessoa" value="" readonly >
                                                                                @endif

                                                                        </div>
                                                                  </div>
                                                          </div>
                                                          <div class="row"><!-- row-->


                                                                   <div class="col-xs-5">
                                                                      <label for="nome_conjuge" class="control-label">ou Informar Nome Conjuge</label>
                                                                      <input id="nome_conjuge" name = "nome_conjuge" type="text" onblur="validar_conjuge();" class="form-control" value="{{ ($tipo_operacao=='inclusao' ? old('nome_conjuge') : (isset($membros_familiares) ? $membros_familiares[0]->nome_conjuge : '') ) }}">
                                                                   </div>

                                                                   <div class="col-xs-3">
                                                                      <label for="igrejacasamento" class="control-label">Igreja Casamento</label>
                                                                      <input id="igrejacasamento" name = "igrejacasamento" type="text" class="form-control" value="{{ ($tipo_operacao=='inclusao' ? old('igrejacasamento') : (isset($membros_familiares) ? $membros_familiares[0]->igreja_casamento : '') ) }}">
                                                                   </div>

                                                                   <div class="col-xs-4">
                                                                        <label for="datacasamento" class="control-label">Data Casamento</label>

                                                                        <div class="input-group">
                                                                               <div class="input-group-addon">
                                                                                <i class="fa fa-calendar"></i>
                                                                                </div>

                                                                                <input id ="datacasamento" name = "datacasamento" onblur="validar_data(this);" type="text" class="form-control" data-inputmask='"mask": "99/99/9999"' data-mask  value="{{ ($tipo_operacao=='inclusao' ? old('datacasamento') : (isset($membros_familiares) ? $membros_familiares[0]->data_casamento : '') ) }}">
                                                                        </div>

                                                                   </div>

                                                          </div>

                                                          <input type="hidden" name="status_conjuge" class="minimal" value="">
                                                          <input type="hidden" name="profissao_conjuge" class="minimal" value="">
                                                          <input type="hidden" name="datanasc_conjuge" class="minimal" value="">
                                                          <input type="hidden" name="datafalecimento" class="minimal" value="">

                                                          <div id="dados_conjuge" class="row" style="display: none">

                                                               <div class="col-xs-3">
                                                                        @include('carregar_combos', array('dados'=>$status, 'titulo' =>'Status', 'id_combo'=>'status_conjuge', 'complemento'=>'', 'comparar'=>(isset($membros_familiares) ? $membros_familiares[0]->status_id : ''), 'id_pagina'=> '8'))
                                                                        @include('modal_cadastro_basico', array('qual_campo'=>'status_conjuge', 'modal' => 'modal_status_conjuge', 'tabela' => 'status'))
                                                               </div>

                                                               <div class="col-xs-3">
                                                                      @include('carregar_combos', array('dados'=>$profissoes, 'titulo' =>'Profissão', 'id_combo'=>'profissao_conjuge', 'complemento'=>'', 'comparar'=>(isset($membros_familiares) ? $membros_familiares[0]->profissoes_id : '') , 'id_pagina'=> '11'))
                                                                      @include('modal_cadastro_basico', array('qual_campo'=>'profissao_conjuge', 'modal' => 'modal_profissao_conjuge', 'tabela' => 'profissoes'))
                                                               </div>

                                                                   <div class="col-xs-3">
                                                                        <label for="datanasc_conjuge" class="control-label">Data Nascimento</label>

                                                                        <div class="input-group">
                                                                               <div class="input-group-addon">
                                                                                    <i class="fa fa-calendar"></i>
                                                                                </div>

                                                                                <input id ="datanasc_conjuge" onblur="validar_data(this)" name = "datanasc_conjuge" type="text" class="form-control" data-inputmask='"mask": "99/99/9999"' data-mask  value="{{ ($tipo_operacao=='inclusao' ? old('datanasc_conjuge') : (isset($membros_familiares) ? $membros_familiares[0]->data_nasc : '') ) }}">
                                                                        </div>

                                                                   </div>

                                                                   <div class="col-xs-3">
                                                                        <label for="datafalecimento" class="control-label">Data Falecimento</label>

                                                                        <div class="input-group">
                                                                               <div class="input-group-addon">
                                                                                    <i class="fa fa-calendar"></i>
                                                                                </div>

                                                                                <input id ="datafalecimento" name = "datafalecimento" onblur="validar_data(this)" type="text" class="form-control" data-inputmask='"mask": "99/99/9999"' data-mask  value="{{ ($tipo_operacao=='inclusao' ? old('datafalecimento') : (isset($membros_familiares) ? $membros_familiares[0]->data_falecimento : '') ) }}">
                                                                        </div>

                                                                   </div>

                                                           </div><!-- end row-->



                                                    </div>
                                              </div>
                                           </div>
                               </div><!-- end row-->

                               <div class="row">

                                       <div class="col-md-12">

                                              <div class="box box-default">

                                                    <div class="box-header">
                                                            <h3 class="box-title">Filhos</h3>
                                                    </div>

                                                    <input type="hidden" name="filhos[]" class="minimal" value="">

                                                    <div class="box-body"><!-- box-body-->

                                                          <div class="row">

                                                               <div class="col-xs-10">
                                                                    <label for="filho_cadastro" class="control-label">Selecionar filhos(as) do cadastro</label>
                                                                    <div class="input-group">
                                                                             <div class="input-group-addon">
                                                                                <button  id="buscarpessoa" type="button"  data-toggle="modal" data-target="#filho_cadastro_myModal" >
                                                                                       <i class="fa fa-search"></i> ...
                                                                                 </button>
                                                                                 &nbsp;<a href="#" onclick="remover_pessoa('filho_cadastro');" title="Limpar Campo"><spam class="fa fa-close"></spam></a>
                                                                              </div>

                                                                              @include('modal_buscar_pessoas', array('qual_campo'=>'filho_cadastro', 'modal' => 'filho_cadastro_myModal'))

                                                                              <input id="filho_cadastro"  name = "filho_cadastro" type="text" class="form-control" placeholder="Clica na lupa ao lado para consultar uma pessoa" value="" readonly >

                                                                      </div>
                                                                      <a href="javascript: incluir_filho_cadastro();" class="btn btn-primary">Clique aqui para confirmar a seleção acima...</a>
                                                                </div>


                                                                   <div class="col-xs-10">

                                                                      <label for="novofilho" class="control-label">Inclusão Filhos(as) sem cadastro</label>
                                                                      <br/>

                                                                       <button  id="novofilho" type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal">
                                                                              Incluir dados...
                                                                       </button>

                                                                   </div>
                                                          </div>

                                                          <div class="row">
                                                               <br/>

                                                                   <div class="col-xs-2">
                                                                      <label for="inc_filhos[]" class="control-label">Nome</label>
                                                                   </div>
                                                                   <div class="col-xs-1">
                                                                          <label for="inc_filhos2[]" class="control-label">Sexo</label>
                                                                   </div>
                                                                   <div class="col-xs-2">
                                                                          <label for="inc_filhos3[]" class="control-label">Status</label>
                                                                   </div>
                                                                   <div class="col-xs-2">
                                                                          <label for="inc_filhos4[]" class="control-label">Estado Civil</label>
                                                                   </div>
                                                                   <div class="col-xs-2">
                                                                          <label for="inc_filhos5[]" class="control-label">Data Nascimento</label>
                                                                   </div>
                                                                   <div class="col-xs-2">
                                                                          <label for="inc_filhos6[]" class="control-label">Data Falecimento</label>
                                                                   </div>

                                                               <div id="mais_filhos">
                                                               </div>

                                                          </div>

                                                         @if (isset($membros_filhos))
                                                             @if ($membros_filhos==null)
                                                                  <input type="hidden" name="inc_filhos[]" class="minimal" value="">
                                                             @endif
                                                         @endif


                                                         <div class="row">

                                                              <table id="tab_filhos" class="table table-bordered table-hover">

                                                              @if (isset($membros_filhos))
                                                                          @foreach($membros_filhos as $item)

                                                                                <tr id="{{$item->id_seq}}">
                                                                                    <td class="col-xs-2"><input id="inc_filhos[]" name = "inc_filhos[]" type="text" class="form-control" readonly value="{{$item->nome_filho}}"></td>
                                                                                    <td class="col-xs-1"><input id="inc_sexo[]" name = "inc_sexo[]" type="text" class="form-control" readonly value="{{$item->sexo}}"></td>
                                                                                    <td class="col-xs-2"><input id="inc_status[]" name = "inc_status[]" type="text" class="form-control" readonly value="{{$item->desc_status}}"></td>
                                                                                    <td class="col-xs-2"><input id="inc_estadocivl[]" name = "inc_estadocivl[]" type="text" class="form-control" readonly value="{{$item->desc_estcivil}}"></td>
                                                                                    <td class="col-xs-2"><input id="inc_datanasc[]" name = "inc_datanasc[]" type="text" class="form-control" readonly value="{{$item->data_nasc}}"></td>
                                                                                    <td class="col-xs-2"><input id="inc_datafalec[]" name = "inc_datafalec[]" type="text" class="form-control" readonly value="{{$item->data_falecimento}}"></td>
                                                                                    <td class="col-xs-2">
                                                                                            <input id="hidden_id_filhos[]" name = "hidden_id_filhos[]" type="hidden" class="form-control" value="{{$item->id}}">
                                                                                            <input id="hidden_sexo[]" name = "hidden_sexo[]" type="hidden" class="form-control" value="{{$item->sexo}}">
                                                                                            <input id="hidden_status[]" name = "hidden_status[]" type="hidden" class="form-control" value="{{$item->id_status}}">
                                                                                            <input id="hidden_estadocivl[]" name = "hidden_estadocivl[]" type="hidden" class="form-control" value="{{$item->id_estadocivil}}">
                                                                                            <a href="#" class="deleteLink"><i class="glyphicon glyphicon-trash"></i> Remover</a>
                                                                                   </td>
                                                                                </tr>

                                                                          @endforeach
                                                               @endif
                                                               </table>
                                                         </div>

                                                          <div class="row">

                                                              <!-- Modal -->
                                                              <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                                                                <div class="modal-dialog  modal-lg" role="document">
                                                                  <div class="modal-content">
                                                                    <div class="modal-header">
                                                                      <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                                      <h4 class="modal-title" id="myModalLabel">Incluir Filho(a)</h4>
                                                                    </div>
                                                                    <div class="modal-body">

                                                                         <div class="row">

                                                                                <div class="col-xs-5">
                                                                                    <label for="nome_filho" class="control-label">Nome</label>
                                                                                    <input id="nome_filho" name = "nome_filho" type="text" class="form-control" value="">
                                                                                 </div>

                                                                                 <div class="col-xs-3">
                                                                                       <label for="opSexoFilho" class="control-label">Sexo</label>
                                                                                       <select id="opSexoFilho" placeholder="(Selecionar)" name="opSexoFilho" data-none-selected-text="Nenhum item selecionado" class="form-control selectpicker" style="width: 100%;">
                                                                                       <option  value=""></option>
                                                                                             <option  value="M">Masculino</option>
                                                                                             <option  value="F">Feminino</option>
                                                                                       </select>

                                                                                 </div>

                                                                                 <div class="col-xs-3">
                                                                                      <label for="datanascimento_filho" class="control-label">Data Nascimento</label>

                                                                                      <div class="input-group">
                                                                                             <div class="input-group-addon">
                                                                                              <i class="fa fa-calendar"></i>
                                                                                              </div>

                                                                                              <input id ="datanascimento_filho" onblur="validar_data(this)" name = "datanascimento_filho" type="text" class="form-control" data-inputmask='"mask": "99/99/9999"' data-mask  value="">
                                                                                      </div>

                                                                                 </div>

                                                                        </div>

                                                                        <div class="row">

                                                                            <div class="col-xs-4">
                                                                                      @include('carregar_combos', array('dados'=>$status, 'titulo' =>'Status', 'id_combo'=>'status_filho', 'complemento'=>'', 'comparar'=>'', 'id_pagina'=> '8'))
                                                                                      @include('modal_cadastro_basico', array('qual_campo'=>'status_filho', 'modal' => 'modal_status_filho', 'tabela' => 'status'))
                                                                            </div>

                                                                            <div class="col-xs-4">
                                                                                      @include('carregar_combos', array('dados'=>$estadoscivis, 'titulo' =>'Estado Civil', 'id_combo'=>'estado_civil_filho', 'complemento'=>'', 'comparar'=>'', 'id_pagina'=> '22'))
                                                                                      @include('modal_cadastro_basico', array('qual_campo'=>'estado_civil_filho', 'modal' => 'modal_estado_civil_filho', 'tabela' => 'estados_civis'))
                                                                            </div>


                                                                                 <div class="col-xs-3">
                                                                                      <label for="datafalecimento_filho" class="control-label">Data Falecimento</label>

                                                                                      <div class="input-group">
                                                                                             <div class="input-group-addon">
                                                                                              <i class="fa fa-calendar"></i>
                                                                                              </div>

                                                                                              <input id ="datafalecimento_filho" name = "datafalecimento_filho" onblur="validar_data(this)" type="text" class="form-control" data-inputmask='"mask": "99/99/9999"' data-mask  value="">
                                                                                      </div>

                                                                                 </div>

                                                                         </div><!-- end row-->

                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
                                                                        <button type="button" class="btn btn-primary" onclick="incluir_filho();" data-dismiss="modal">Salvar</button>
                                                                    </div>
                                                                  </div>
                                                                </div>
                                                              </div> <!-- fim modal -->

                                                          </div>

                                                    </div> <!-- fim box-body-->
                                              </div>
                                           </div>
                               </div><!-- end row-->

                               <div class="row">

                                       <div class="col-md-12">

                                              <div class="box box-default">

                                                    <div class="box-header">
                                                            <h3 class="box-title">Filiação</h3>
                                                    </div>

                                                    <div class="box-body"><!-- box-body-->

                                                          <div class="row"><!-- row pai-->
                                                                   <div class="col-xs-12">
                                                                      <label for="pai" class="control-label">Pai - Selecionar do cadastro</label>
                                                                      <div class="input-group">
                                                                               <div class="input-group-addon">
                                                                                  <button  id="buscarpessoa" type="button"  data-toggle="modal" data-target="#pai_myModal">
                                                                                         <i class="fa fa-search"></i> ...
                                                                                   </button>
                                                                                   &nbsp;<a href="#" onclick="remover_pessoa('pai');" title="Limpar Campo"><spam class="fa fa-close"></spam></a>
                                                                                </div>

                                                                                @include('modal_buscar_pessoas', array('qual_campo'=>'pai', 'modal' => 'pai_myModal'))

                                                                                @if (isset($membros_familiares))
                                                                                    <input id="pai"  name = "pai" type="text" class="form-control" placeholder="Clica na lupa ao lado para consultar uma pessoa" value="{!! ($membros_familiares[0]->pai_id!="" ? str_repeat('0', (9-strlen($membros_familiares[0]->pai_id))) . $membros_familiares[0]->pai_id . ' - ' . $membros_familiares[0]->razaosocial_pai  : '') !!}" readonly >
                                                                                @else
                                                                                    <input id="pai"  name = "pai" type="text" class="form-control" placeholder="Clica na lupa ao lado para consultar uma pessoa" value="" readonly >
                                                                                @endif


                                                                        </div>
                                                                  </div>
                                                         </div>
                                                         <div class="row"><!-- row-->

                                                                   <div class="col-xs-4">
                                                                      <label for="nome_pai" class="control-label">ou Informar Nome Pai</label>
                                                                      <input id="nome_pai" name = "nome_pai" type="text" class="form-control" value="{{ ($tipo_operacao=='inclusao' ? old('nome_pai') : (isset($membros_familiares) ? $membros_familiares[0]->nome_pai : '') ) }}">
                                                                   </div>

                                                                   <div class="col-xs-4">
                                                                        @include('carregar_combos', array('dados'=>$status, 'titulo' =>'Status', 'id_combo'=>'status_pai', 'complemento'=>'', 'comparar'=>(isset($membros_familiares) ? $membros_familiares[0]->status_pai_id : '') , 'id_pagina'=> '8'))
                                                                        @include('modal_cadastro_basico', array('qual_campo'=>'status_pai', 'modal' => 'modal_status_pai', 'tabela' => 'status'))
                                                                    </div>

                                                                    <div class="col-xs-4">
                                                                        <label for="datafalecimento_pai" class="control-label">Data Falecimento Pai</label>

                                                                        <div class="input-group">
                                                                               <div class="input-group-addon">
                                                                                <i class="fa fa-calendar"></i>
                                                                                </div>

                                                                                @if (isset($membros_familiares))
                                                                                        <input id ="datafalecimento_pai" name = "datafalecimento_pai" onblur="validar_data(this)" type="text" class="form-control" data-inputmask='"mask": "99/99/9999"' data-mask  value="{{ ($tipo_operacao=='inclusao' ? old('datafalecimento_pai') : $membros_familiares[0]->data_falecimento_pai) }}">
                                                                                @else
                                                                                        <input id ="datafalecimento_pai" name = "datafalecimento_pai" onblur="validar_data(this)" type="text" class="form-control" data-inputmask='"mask": "99/99/9999"' data-mask  value="">
                                                                                @endif

                                                                        </div>

                                                                   </div>

                                                          </div><!-- end row-->

                                                          <div class="row"><!-- row mãe-->
                                                                   <div class="col-xs-12">
                                                                          <label for="mae" class="control-label">Mãe - Selecionar do cadastro</label>
                                                                          <div class="input-group">
                                                                                 <div class="input-group-addon">
                                                                                    <button  id="buscarpessoa" type="button"  data-toggle="modal" data-target="#mae_myModal">
                                                                                           <i class="fa fa-search"></i> ...
                                                                                     </button>
                                                                                     &nbsp;<a href="#" onclick="remover_pessoa('mae');" title="Limpar Campo"><spam class="fa fa-close"></spam></a>
                                                                                  </div>

                                                                                  @include('modal_buscar_pessoas', array('qual_campo'=>'mae', 'modal' => 'mae_myModal'))

                                                                                  @if (isset($membros_familiares))
                                                                                        <input id="mae"  name = "mae" type="text" class="form-control" placeholder="Clica na lupa ao lado para consultar uma pessoa" value="{!! ($membros_familiares[0]->mae_id!="" ? str_repeat('0', (9-strlen($membros_familiares[0]->mae_id))) . $membros_familiares[0]->mae_id . ' - ' . $membros_familiares[0]->razaosocial_mae  : '') !!}" readonly >
                                                                                  @else
                                                                                        <input id="mae"  name = "mae" type="text" class="form-control" placeholder="Clica na lupa ao lado para consultar uma pessoa" value="" readonly >
                                                                                  @endif
                                                                          </div>
                                                                  </div>
                                                         </div>
                                                         <div class="row"><!-- row-->

                                                                   <div class="col-xs-4">
                                                                      <label for="nome_mae" class="control-label">ou Informar Nome Mãe</label>
                                                                      <input id="nome_mae" name = "nome_mae" type="text" class="form-control" value="{{ ($tipo_operacao=='inclusao' ? old('nome_mae') : (isset($membros_familiares) ? $membros_familiares[0]->nome_mae : '') ) }}">
                                                                   </div>


                                                                   <div class="col-xs-4">
                                                                        @include('carregar_combos', array('dados'=>$status, 'titulo' =>'Status', 'id_combo'=>'status_mae', 'complemento'=>'', 'comparar'=>(isset($membros_familiares) ? $membros_familiares[0]->status_mae_id : '') , 'id_pagina'=> '8'))
                                                                        @include('modal_cadastro_basico', array('qual_campo'=>'status_mae', 'modal' => 'modal_status_mae', 'tabela' => 'status'))
                                                                    </div>

                                                                    <div class="col-xs-4">
                                                                        <label for="datafalecimento_mae" class="control-label">Data Falecimento Mãe</label>

                                                                        <div class="input-group">
                                                                               <div class="input-group-addon">
                                                                                <i class="fa fa-calendar"></i>
                                                                                </div>

                                                                                @if (isset($membros_familiares))
                                                                                      <input id ="datafalecimento_mae" name = "datafalecimento_mae" onblur="validar_data(this)" type="text" class="form-control" data-inputmask='"mask": "99/99/9999"' data-mask  value="{{ ($tipo_operacao=='inclusao' ? old('datafalecimento_mae') : $membros_familiares[0]->data_falecimento_mae) }}">
                                                                                @else
                                                                                       <input id ="datafalecimento_mae" name = "datafalecimento_mae" onblur="validar_data(this)" type="text" class="form-control" data-inputmask='"mask": "99/99/9999"' data-mask  value="">
                                                                                @endif
                                                                        </div>

                                                                   </div>

                                                          </div><!-- end row-->

                                                    </div>

                                              </div>

                                        </div>

                               </div><!-- end row-->

                            </div>
                          </div>
                      </div><!-- FIM TAB FAMILIAR-->


                        <!-- TAB RELACIONAMENTOS-->
                      <div class="panel box box-primary">
                          <div class="box-header with-border">
                            <h5 class="box-title">
                              <a data-toggle="collapse" data-parent="#accordion" href="#tab_relacionamentos">
                                <span class="fa fa-sitemap"></span> Relacionamentos
                              </a>
                            </h5>
                          </div>
                          <div id="tab_relacionamentos" class="panel-collapse collapse">
                            <div class="box-body">

                             <div  class="row">

                                     <div class="col-md-12">

                                              <div class="box box-default">

                                                    <div class="box-body"><!-- box-body-->

                                                            <div class="row"><!-- row-->

                                                                   <input type="hidden" name="tiposrelacionamentos[]" class="minimal" value="">
                                                                   <div class="col-xs-5">
                                                                          @include('carregar_combos_multiple', array('dados'=>$tiposrelacionamentos, 'titulo' =>'Tipos de Relacionamentos', 'id_combo'=>'tiposrelacionamentos[]', 'complemento'=>'multiple="multiple"', 'comparar'=>(isset($membros_relacionamentos) ? $membros_relacionamentos : ''), 'id_pagina'=> '55'))
                                                                   </div><!-- col-xs-5-->

                                                                   <div class="col-xs-7">
                                                                      <label for="pessoa_relacionamento" class="control-label">Com Quem ?</label>
                                                                      <div class="input-group">
                                                                               <div class="input-group-addon">
                                                                                  <button  id="buscarpessoa" type="button"  data-toggle="modal" data-target="#relacionamento_myModal" >
                                                                                         <i class="fa fa-search"></i> ...
                                                                                   </button>
                                                                                </div>

                                                                                @include('modal_buscar_pessoas', array('qual_campo'=>'pessoa_relacionamento', 'modal' => 'relacionamento_myModal'))

                                                                                @if (isset($membros_relacionamentos))
                                                                                        <input id="pessoa_relacionamento"  name = "pessoa_relacionamento" type="text" class="form-control" placeholder="Clica na lupa ao lado para consultar uma pessoa" value="{!! ($membros_relacionamentos[0]->pessoas2_id!="" ? str_repeat('0', (9-strlen($membros_relacionamentos[0]->pessoas2_id))) . $membros_relacionamentos[0]->pessoas2_id . ' - ' . $membros_relacionamentos[0]->razaosocial  : '') !!}" readonly >
                                                                                @else
                                                                                        <input id="pessoa_relacionamento"  name = "pessoa_relacionamento" type="text" class="form-control" placeholder="Clica na lupa ao lado para consultar uma pessoa" value="" readonly >
                                                                                @endif

                                                                        </div>
                                                                  </div>

                                                            </div><!-- end row-->

                                                     </div><!-- end box-body-->

                                               </div><!-- end box-default-->

                                     </div>

                               </div><!-- end row-->

                            </div>

                          </div>
                      </div><!-- FIM TAB FORMAÇÃO-->



                      <!-- TAB HISTORICO ECLESIASTICO-->
                      <div class="panel box box-primary">
                          <div class="box-header with-border">
                            <h5 class="box-title">
                              <a data-toggle="collapse" data-parent="#accordion" href="#tab5">
                                    <span class="fa fa-clone"></span> Histórico Eclesiástico
                              </a>
                            </h5>
                          </div>

                          <div id="tab5" class="panel-collapse collapse">

                            <div class="box-body">

                                <div  class="row">

                                     <div class="col-md-12">

                                              <div class="box box-default">

                                                    <div class="box-header">
                                                            <h3 class="box-title">Igreja Anterior</h3>
                                                    </div>

                                                    <div class="box-body"><!-- box-body-->

                                                           <div class="row">
                                                                <div class="col-xs-5">
                                                                        <label for="igreja_anterior" class="control-label">Igreja</label>
                                                                        <input id="igreja_anterior" maxlength="150" name = "igreja_anterior" type="text" class="form-control" value="{{ ($tipo_operacao=='inclusao' ? old('igreja_anterior') : (isset($membros_historico) ? $membros_historico[0]->igreja_anterior : '') ) }}">
                                                                </div>


                                                                <div class="col-xs-3">
                                                                    <label for="fone_igreja_anterior" class="control-label">Telefone</label>

                                                                    <div class="input-group">
                                                                           <div class="input-group-addon">
                                                                            <i class="fa fa-phone"></i>
                                                                            </div>

                                                                            <input id="fone_igreja_anterior"  name = "fone_igreja_anterior" type="text" class="form-control" value="{{ ($tipo_operacao=='inclusao' ? old('fone_igreja_anterior') : (isset($membros_historico) ? $membros_historico[0]->fone_igreja_anterior : '') ) }}"  data-inputmask='"mask": "(99) 9999-9999"' data-mask >

                                                                    </div>
                                                                </div>

                                                                <div class="col-xs-3">
                                                                          @include('carregar_combos', array('dados'=>$religioes, 'titulo' =>'Religião Anterior', 'id_combo'=>'religioes', 'complemento'=>'', 'comparar'=>(isset($membros_historico) ? $membros_historico[0]->religioes_id : '') , 'id_pagina'=> '23'))
                                                                          @include('modal_cadastro_basico', array('qual_campo'=>'religioes', 'modal' => 'modal_religioes', 'tabela' => 'religioes'))
                                                                </div><!-- col-xs-5-->

                                                           </div><!-- end row-->


                                                           <div class="row">

                                                                  <div class="col-xs-3">
                                                                              <label for="cep_igreja_anterior" class="control-label">CEP</label>
                                                                              <div class="input-group">
                                                                                       <div class="input-group-addon">
                                                                                          <a href="#" data-toggle="tooltip" title="Digite o CEP para buscar automaticamente o endereço. Não informar pontos ou traços.">
                                                                                                <img src="{{ url('/images/help.png') }}" class="user-image" alt="Ajuda"  />
                                                                                           </a>
                                                                                        </div>

                                                                                        <input id="cep_igreja_anterior" maxlength="8" name = "cep_igreja_anterior" type="text" class="form-control" value="{{ ($tipo_operacao=='inclusao' ? old('cep_igreja_anterior') : (isset($membros_historico) ? $membros_historico[0]->cep_igreja_anterior : '') ) }}">
                                                                                </div>
                                                                  </div>

                                                                    <div class="col-xs-7">
                                                                            <label for="endereco_igreja_anterior" class="control-label">Endereço</label>
                                                                            <input id="endereco_igreja_anterior" maxlength="150" name = "endereco_igreja_anterior" type="text" class="form-control" value="{{ ($tipo_operacao=='inclusao' ? old('endereco_igreja_anterior') : (isset($membros_historico) ? $membros_historico[0]->endereco_igreja_anterior : '') ) }}">
                                                                    </div>

                                                                    <div class="col-xs-2">
                                                                            <label for="numero_igreja_anterior" class="control-label">Número</label>
                                                                            <input id="numero_igreja_anterior" maxlength="10" name = "numero_igreja_anterior" type="text" class="form-control" value="{{ ($tipo_operacao=='inclusao' ? old('numero_igreja_anterior') : (isset($membros_historico) ? $membros_historico[0]->numero_igreja_anterior : '') ) }}">
                                                                    </div>

                                                            </div><!-- end row  -->

                                                            <div class="row">
                                                                  <div class="col-xs-5">
                                                                        <label for="bairro_igreja_anterior" class="control-label">Bairro</label>
                                                                        <input id="bairro_igreja_anterior" maxlength="50" name = "bairro_igreja_anterior" type="text" class="form-control" value="{{ ($tipo_operacao=='inclusao' ? old('bairro_igreja_anterior') : (isset($membros_historico) ? $membros_historico[0]->bairro_igreja_anterior : '') ) }}">
                                                                   </div>

                                                                  <div class="col-xs-5">
                                                                      <label for="complemento_igreja_anterior" class="control-label">Complemento</label>
                                                                      <input id="complemento_igreja_anterior" name = "complemento_igreja_anterior" type="text" class="form-control" value="{{ ($tipo_operacao=='inclusao' ? old('complemento_igreja_anterior') : (isset($membros_historico) ? $membros_historico[0]->complemento_igreja_anterior : '') ) }}">
                                                                  </div>
                                                            </div><!-- end row  -->

                                                            <div class="row">
                                                                    <div class="col-xs-5">
                                                                            <label for="cidade_igreja_anterior" class="control-label">Cidade</label>
                                                                            <input id="cidade_igreja_anterior" maxlength="60" name = "cidade_igreja_anterior" type="text" class="form-control" value="{{ ($tipo_operacao=='inclusao' ? old('cidade_igreja_anterior') : (isset($membros_historico) ? $membros_historico[0]->cidade_igreja_anterior : '') ) }}">
                                                                    </div>

                                                                    <div class="col-xs-2">
                                                                        <label for="estado_igreja_anterior" class="control-label">Estado</label>
                                                                        <input id="estado_igreja_anterior" maxlength="2" name = "estado_igreja_anterior" type="text" class="form-control" value="{{ ($tipo_operacao=='inclusao' ? old('estado_igreja_anterior') : (isset($membros_historico) ? $membros_historico[0]->estado_igreja_anterior : '') ) }}">
                                                                    </div>

                                                            </div><!-- end row  -->

                                                     </div><!-- end box-body-->

                                               </div><!-- end box-default-->

                                        </div>

                               </div><!-- end row-->


                               <div  class="row">

                                     <div class="col-md-12">

                                              <div class="box box-default">

                                                    <div class="box-body"><!-- box-body-->

                                                            <div class="row">

                                                                <div class="col-xs-4">
                                                                        <label for="data_batismo" class="control-label">Data Batismo</label>

                                                                        <div class="input-group">
                                                                               <div class="input-group-addon">
                                                                                <i class="fa fa-calendar"></i>
                                                                                </div>

                                                                                <input id ="data_batismo" name = "data_batismo" onblur="validar_data(this)" type="text" class="form-control" data-inputmask='"mask": "99/99/9999"' data-mask  value="{{ ($tipo_operacao=='inclusao' ? old('data_batismo') : (isset($membros_historico) ? $membros_historico[0]->data_batismo : '') ) }}">
                                                                        </div>

                                                               </div>

                                                                <div class="col-xs-4">
                                                                        <label for="igreja_batismo" class="control-label">Igreja</label>
                                                                        <input id="igreja_batismo" maxlength="150" name = "igreja_batismo" type="text" class="form-control" value="{{ ($tipo_operacao=='inclusao' ? old('igreja_batismo') : (isset($membros_historico) ? $membros_historico[0]->igreja_batismo : '') ) }}">
                                                                </div>

                                                                <div class="col-xs-4">
                                                                        <label for="celebrador" class="control-label">Celebrador</label>
                                                                        <input id="celebrador"  name = "celebrador" type="text" class="form-control" value="{{ ($tipo_operacao=='inclusao' ? old('celebrador') : (isset($membros_historico) ? $membros_historico[0]->celebrador : '') ) }}">
                                                                </div>

                                                           </div><!-- end row -->

                                                    </div>
                                              </div>
                                     </div>
                               </div>

                               <div  class="row">

                                     <div class="col-md-12">

                                              <div class="box box-default">

                                                    <div class="box-header">
                                                            <h3 class="box-title">Movimento de Membro</h3>
                                                    </div>

                                                    <div class="box-body"><!-- box-body-->

                                                          <div class="row"><!-- row entrada-->

                                                                <div class="col-xs-4">
                                                                        <label  for="data_entrada" class="control-label">Data Entrada</label>

                                                                        <div class="input-group">
                                                                               <div class="input-group-addon">
                                                                                <i class="fa fa-calendar"></i>
                                                                                </div>

                                                                                <input id ="data_entrada" name = "data_entrada" onblur="validar_data(this)" type="text" class="form-control" data-inputmask='"mask": "99/99/9999"' data-mask  value="{{ ($tipo_operacao=='inclusao' ? old('data_entrada') : (isset($membros_historico) ? $membros_historico[0]->data_entrada : '') ) }}">
                                                                        </div>

                                                               </div>

                                                                <div class="col-xs-5">
                                                                        @include('carregar_combos', array('dados'=>$motivos, 'titulo' =>'Motivo Entrada', 'id_combo'=>'motivo_entrada', 'complemento'=>'', 'comparar'=>(isset($membros_historico) ? $membros_historico[0]->motivos_entrada_id : '') , 'id_pagina'=> '18'))
                                                                        @include('modal_cadastro_basico', array('qual_campo'=>'motivo_entrada', 'modal' => 'modal_motivo_entrada', 'tabela' => 'tipos_movimentacao'))
                                                                </div><!-- col-xs-5-->

                                                                <div class="col-xs-3">
                                                                        <label for="ata_entrada" class="control-label">Registrado em Ata n.:</label>
                                                                        <input id="ata_entrada" name = "ata_entrada" type="text" class="form-control" value="{{ ($tipo_operacao=='inclusao' ? old('ata_entrada') : (isset($membros_historico) ? $membros_historico[0]->ata_entrada : '') ) }}">
                                                                </div>

                                                           </div><!-- end row -->

                                                          <div class="row"><!-- row saida-->

                                                                <div class="col-xs-4">
                                                                        <label  for="data_saida" class="control-label">Data Saída</label>

                                                                        <div class="input-group">
                                                                               <div class="input-group-addon">
                                                                                <i class="fa fa-calendar"></i>
                                                                                </div>

                                                                                <input id ="data_saida" name = "data_saida" onblur="validar_data(this)" type="text" class="form-control" data-inputmask='"mask": "99/99/9999"' data-mask  value="{{ ($tipo_operacao=='inclusao' ? old('data_saida') : (isset($membros_historico) ? $membros_historico[0]->data_saida : '') ) }}">
                                                                        </div>

                                                               </div>

                                                                <div class="col-xs-5">
                                                                        @include('carregar_combos', array('dados'=>$motivos, 'titulo' =>'Motivo Saída', 'id_combo'=>'motivosaida', 'complemento'=>'', 'comparar'=>(isset($membros_historico) ? $membros_historico[0]->motivos_saida_id : '') , 'id_pagina'=> '18'))
                                                                        @include('modal_cadastro_basico', array('qual_campo'=>'motivosaida', 'modal' => 'modal_motivosaida', 'tabela' => 'tipos_movimentacao'))
                                                                </div><!-- col-xs-5-->

                                                                <div class="col-xs-3">
                                                                        <label for="ata_saida" class="control-label">Registrado em Ata n.:</label>
                                                                        <input id="ata_saida" name = "ata_saida" type="text" class="form-control" value="{{ ($tipo_operacao=='inclusao' ? old('ata_saida') : (isset($membros_historico) ? $membros_historico[0]->ata_saida : '') ) }}">
                                                                </div>

                                                           </div><!-- end row -->

                                                          <div class="row">
                                                                <div class="col-xs-10">
                                                                        <label for="observacoes_hist" class="control-label">Observação</label>
                                                                        <input id="observacoes_hist" name = "observacoes_hist" type="text" class="form-control" value="{{ ($tipo_operacao=='inclusao' ? old('observacoes_hist') : (isset($membros_historico) ? $membros_historico[0]->observacoes_hist : '') ) }}">
                                                                </div>
                                                          </div><!--end row-->
                                                     </div>
                                                 </div>
                                             </div>
                                         </div>

                               <!-- fim aqui-->

                            </div>
                          </div>
                      </div><!-- FIM TAB HISTORICO ECLESIASTICO-->


                      <!-- TAB Habilidades, Dons -->
                      <div class="panel box box-primary">
                          <div class="box-header with-border">
                            <h5 class="box-title">
                              <a data-toggle="collapse" data-parent="#accordion" href="#tab6">
                                <span class="fa fa-magic"></span> Dons e Habilidades
                              </a>
                            </h5>
                          </div>
                          <div id="tab6" class="panel-collapse collapse">
                            <div class="box-body">


                                   <div class="col-md-12">

                                              <div class="box box-default">

                                                    <div class="box-body"><!-- box-body-->

                                                            <div class="row"><!-- row-->

                                                                  <div class="col-xs-6">
                                                                        <label for="prefere_trabalhar_com" class="control-label">Prefere trabalhar com :</label>

                                                                         <select name="prefere_trabalhar_com" class="form-control select2" style="width: 100%;">
                                                                          <option  value="">(Selecionar)</option>
                                                                                @if (isset($membros_dados_pessoais))
                                                                                    <option  value="P" {{ ($tipo_operacao=='inclusao' ? '' : ($membros_dados_pessoais[0]->prefere_trabalhar_com=='P' ? 'selected=selected' : '') )  }}>Pessoas</option>
                                                                                    <option  value="T" {{ ($tipo_operacao=='inclusao' ? '' : ($membros_dados_pessoais[0]->prefere_trabalhar_com=='T' ? 'selected=selected' : '') )  }}>Tarefas</option>
                                                                                @else
                                                                                    <option  value="P">Pessoas</option>
                                                                                    <option  value="T">Tarefas</option>
                                                                                @endif
                                                                          </select>
                                                                  </div><!-- end col-xs-->

                                                                  <div class="col-xs-6">

                                                                        <label for="considera_se" class="control-label">Considera-se :</label>

                                                                          <select name="considera_se" class="form-control select2" style="width: 100%;">
                                                                          <option  value="">(Selecionar)</option>
                                                                                @if (isset($membros_dados_pessoais))
                                                                                    <option  value="M" {{ ($tipo_operacao=='inclusao' ? '' : ($membros_dados_pessoais[0]->considera_se=='M' ? 'selected=selected' : '') )  }}>Muito Estruturado</option>
                                                                                    <option  value="P" {{ ($tipo_operacao=='inclusao' ? '' : ($membros_dados_pessoais[0]->considera_se=='P' ? 'selected=selected' : '') )  }}>Pouco Estruturado</option>
                                                                                    <option  value="E" {{ ($tipo_operacao=='inclusao' ? '' : ($membros_dados_pessoais[0]->considera_se=='E' ? 'selected=selected' : '') )  }}>Estruturado</option>
                                                                                @else
                                                                                    <option  value="M">Muito Estruturado</option>
                                                                                    <option  value="P">Pouco Estruturado</option>
                                                                                    <option  value="E">Estruturado</option>
                                                                                @endif
                                                                          </select>

                                                                  </div><!-- end col-xs-->

                                                            </div><!-- end row-->

                                                            <input type="hidden" name="dons[]" class="minimal" value="">
                                                            <input type="hidden" name="habilidades[]" class="minimal" value="">


                                                            <div class="row"><!-- row-->

                                                                   <div class="col-xs-6">
                                                                          @include('carregar_combos', array('dados'=>$disponibilidades, 'titulo' =>'Disponibilidade de Tempo', 'id_combo'=>'disponibilidades', 'complemento'=>'', 'comparar'=> ($tipo_operacao=='inclusao' ? '' : (isset($membros_dados_pessoais) ? $membros_dados_pessoais[0]->disponibilidades_id : '') ), 'id_pagina'=> '25'))
                                                                          @include('modal_cadastro_basico', array('qual_campo'=>'disponibilidades', 'modal' => 'modal_disponibilidades', 'tabela' => 'disponibilidades'))
                                                                   </div><!-- col-xs-5-->

                                                                   <div class="col-xs-6">
                                                                          @include('carregar_combos_multiple', array('dados'=>$dons, 'titulo' =>'Dons Espirituais', 'id_combo'=>'dons[]', 'complemento'=>'multiple="multiple"', 'comparar'=>(isset($membros_dons) ? $membros_dons : '') , 'id_pagina'=> '16'))
                                                                   </div><!-- col-xs-5-->

                                                            </div>
                                                            <div class="row"><!-- row-->
                                                                   <div class="col-xs-6">
                                                                          @include('carregar_combos_multiple', array('dados'=>$habilidades, 'titulo' =>'Habilidades', 'id_combo'=>'habilidades[]', 'complemento'=>'multiple="multiple"', 'comparar'=>(isset($membros_habilidades) ? $membros_habilidades : ''), 'id_pagina'=> '24'))
                                                                   </div><!-- col-xs-5-->

                                                            </div><!-- end row-->

                                                     </div><!-- end box-body-->

                                               </div><!-- end box-default-->

                                     </div>

                            </div>
                          </div>
                      </div><!-- FIM TAB Habilidades, Dons -->

                      <!-- TAB Envolvimento Ministerial-->
                      <div class="panel box box-primary">
                          <div class="box-header with-border">
                            <h5 class="box-title">
                              <a data-toggle="collapse" data-parent="#accordion" href="#tab7">
                                <span class="fa fa-bullseye"></span> Envolvimento Ministerial
                              </a>
                            </h5>
                          </div>
                          <div id="tab7" class="panel-collapse collapse">
                            <div class="box-body">

                                     <div  class="row">

                                             <div class="col-md-12">

                                                      <div class="box box-default">

                                                            <div class="box-body"><!-- box-body-->

                                                                    <div class="row"><!-- row-->

                                                                          <input type="hidden" name="ministerios[]" class="minimal" value="">
                                                                          <input type="hidden" name="atividades[]" class="minimal" value="">

                                                                           <div class="col-xs-6">
                                                                                  @include('carregar_combos_multiple', array('dados'=>$ministerios, 'titulo' =>'Ministérios', 'id_combo'=>'ministerios[]', 'complemento'=>'multiple="multiple"', 'comparar'=>(isset($membros_ministerios) ? $membros_ministerios : '') , 'id_pagina'=> '13'))
                                                                           </div><!-- col-xs-5-->

                                                                           <div class="col-xs-6">
                                                                                  @include('carregar_combos_multiple', array('dados'=>$atividades, 'titulo' =>'Atividades', 'id_combo'=>'atividades[]', 'complemento'=>'multiple="multiple"', 'comparar'=>(isset($membros_atividades) ? $membros_atividades : ''), 'id_pagina'=> '15'))
                                                                           </div><!-- col-xs-5-->

                                                                    </div><!-- end row-->

                                                             </div><!-- end box-body-->

                                                       </div><!-- end box-default-->

                                             </div>

                                     </div><!-- end row-->


                            </div>
                          </div>
                      </div><!-- FIM TAB Envolvimento Ministerial -->

                      <!-- TAB Histórico de Movimentações -->
                      <div class="panel box box-primary">
                          <div class="box-header with-border">
                            <h5 class="box-title">
                              <a data-toggle="collapse" data-parent="#accordion" href="#tab8">
                                <span class="fa fa-exchange"></span> Histórico de Movimentações
                              </a>
                            </h5>
                          </div>
                          <div id="tab8" class="panel-collapse collapse">
                            <div class="box-body">

                                <div class="row">
                                          <div class="col-xs-12">

                                               @if (isset($view_pessoas_movimentacoes))
                                                         <table class="table table-bordered table-hover">
                                                           <tr>
                                                                <td>Data Movimentação</td>
                                                                <td>Motivo</td>
                                                                <td>{!! \Session::get('label_celulas_singular') !!} Anterior</td>
                                                                <td>Novo(a) {!! \Session::get('label_celulas_singular') !!}</td>
                                                                <td>Observação</td>
                                                            </tr>
                                                         @foreach ($view_pessoas_movimentacoes as $item)
                                                                  <tr>
                                                                      <td>{!! $item->data_movimentacao !!}</td>
                                                                      <td>{!! $item->nome !!}</td>
                                                                      <td>{!! $item->celula_atual !!}</td>
                                                                      <td>{!! $item->celula_nova !!}</td>
                                                                      <td>{!! $item->observacao !!}</td>
                                                                  </tr>
                                                         @endforeach
                                                         </table>
                                               @endif
                                          </div>
                                  </div>
                            </div>
                          </div>
                      </div><!-- FIM TAB Histórico de Movimentações -->

                      <!-- TAB Histórico de Movimentações -->
                      <div class="panel box box-primary">
                          <div class="box-header with-border">
                            <h5 class="box-title">
                              <a data-toggle="collapse" data-parent="#accordion" href="#tab_cursos">
                                <span class="fa fa-mortar-board"></span> Cursos / Eventos
                              </a>
                            </h5>
                          </div>
                          <div id="tab_cursos" class="panel-collapse collapse">
                            <div class="box-body">

                                      <div class="row">
                                          <div class="col-xs-5">
                                                <label for="curso" class="control-label">Curso / Evento :</label>
                                                 <select id="curso"  name="curso"  data-live-search="true" data-none-selected-text="(Selecionar)" class="form-control selectpicker" style="width: 100%;">
                                                 <option  value="">(Selecionar)</option>
                                                 @foreach ($cursos as $item)
                                                        <option  value="{{$item->id}}">{{$item->nome}}</option>
                                                 @endforeach
                                                 </select>
                                         </div>

                                        <div class="col-xs-5">
                                                <label for="ministrante" class="control-label">Ministrante</label>
                                                <div class="input-group">
                                                       <div class="input-group-addon">
                                                          <button  id="buscarpessoa" type="button"  data-toggle="modal" data-target="#ministrante_myModal" >
                                                                 <i class="fa fa-search"></i> ...
                                                           </button>
                                                           &nbsp;<a href="#" onclick="remover_pessoa('ministrante');" title="Limpar Campo"><spam class="fa fa-close"></spam></a>
                                                        </div>

                                                        @include('modal_buscar_pessoas', array('qual_campo'=>'ministrante', 'modal' => 'ministrante_myModal'))

                                                        <input id="ministrante"  name = "ministrante" type="text" class="form-control" placeholder="Clica na lupa ao lado para consultar uma pessoa" value="" readonly >

                                                </div>
                                          </div>
                                     </div>

                                     <div class="row">

                                          <div class="col-xs-3">
                                                <label for="data_inicio" class="control-label">Data Início</label>
                                                <div class="input-group">
                                                       <div class="input-group-addon">
                                                            <i class="fa fa-calendar"></i>
                                                        </div>

                                                        <input id ="data_inicio" name = "data_inicio" onblur="validar_data(this)" type="text" class="form-control" data-inputmask='"mask": "99/99/9999"' data-mask  value="">
                                                </div>
                                          </div>

                                          <div class="col-xs-3">
                                                <label for="data_fim" class="control-label">Data Fim</label>
                                                <div class="input-group">
                                                       <div class="input-group-addon">
                                                            <i class="fa fa-calendar"></i>
                                                        </div>

                                                        <input id ="data_fim" name = "data_fim" onblur="validar_data(this)" type="text" class="form-control" data-inputmask='"mask": "99/99/9999"' data-mask  value="">
                                                </div>
                                          </div>

                                          <div class="col-xs-6">
                                                  <label for="observacao" class="control-label">Observação</label>
                                                  <input id="observacao" name="observacao" type="text" class="form-control" value="">
                                          </div>

                                      </div>

                                      <div class="row">

                                          <div class="col-xs-4">
                                                 <p>&nbsp;</p>
                                                <button onclick="AddTableRow()" type="button" class="btn btn-info"><i class="fa fa-user-plus"></i> Adicionar Curso</button>
                                          </div>

                                      </div>

                                      <div class="row">

                                          <div class="col-xs-12">

                                                      <table id="tabela_cursos" class="table table-bordered table-hover">
                                                        <tbody>
                                                            <tr>
                                                                <th>Curso / Evento</th>
                                                                <th>Ministrante</th>
                                                                <th>Data Início</th>
                                                                <th>Data Fim</th>
                                                                <th>Observação</th>
                                                                <th>Remover</th>
                                                            </tr>

                                                          <tr>
                                                              <td class="col-xs-3"></td>
                                                              <td class="col-xs-4"></td>
                                                              <td class="col-xs-2"></td>
                                                              <td class="col-xs-2"></td>
                                                              <td class="col-xs-5"></td>
                                                              <td class="col-xs-1"></td>
                                                          </tr>

                                                          @if (isset($membros_cursos))
                                                              @foreach($membros_cursos as $item)
                                                                  <tr>
                                                                      <td class="col-xs-3">{!!$item->nome!!}</td>
                                                                      <td class="col-xs-4">{!!$item->razaosocial!!}</td>
                                                                      <td class="col-xs-2">{!! trim($item->data_inicio)!="" ? date('d/m/Y',strtotime($item->data_inicio)) : "" !!}</td>
                                                                      <td class="col-xs-2">{!! trim($item->data_fim)!="" ? date('d/m/Y',strtotime($item->data_fim)) : "" !!}</td>
                                                                      <td class="col-xs-5">{!!$item->observacao!!}</td>
                                                                      <td class="col-xs-1"><a href="#tabela_cursos" class="btn btn-danger btn-sm" onclick="RemoveTableRow(this)"><spam class="glyphicon glyphicon-trash"></spam></a>
                                                                            <input id="hidden_cursos[]"  name = "hidden_cursos[]" type="hidden" value="{!!$item->id!!}">
                                                                            <input id="inc_cursos[]"  name = "inc_cursos[]" type="hidden" value="{!!$item->nome!!}">
                                                                            <input id="inc_ministrante[]"  name = "inc_ministrante[]" type="hidden" value="{!!$item->razaosocial!!}">
                                                                            <input id="inc_ministrante_id[]"  name = "inc_ministrante_id[]" type="hidden" value="{!!$item->ministrante_id!!}">
                                                                            <input id="inc_datainicio[]"  name = "inc_datainicio[]" type="hidden" value="{!! trim($item->data_inicio)!="" ? date('d/m/Y',strtotime($item->data_inicio)) : "" !!}">
                                                                            <input id="inc_datafim[]"  name = "inc_datafim[]" type="hidden" value="{!! trim($item->data_fim)!="" ? date('d/m/Y',strtotime($item->data_fim)) : "" !!}">
                                                                            <input id="inc_obs[]"  name = "inc_obs[]" type="hidden" value="{!!$item->observacao!!}">
                                                                      </td>

                                                                  </tr>
                                                              @endforeach
                                                          @endif

                                                        </tbody>
                                                      </table>

                                         </div>

                                   </div><!-- end row-->


                            </div>
                          </div>
                      </div><!-- FIM TAB Histórico de Movimentações -->



                      <!-- TAB Células -->
                      <div class="panel box box-primary">
                          <div class="box-header with-border">
                            <h5 class="box-title">
                              <a data-toggle="collapse" data-parent="#accordion" href="#tab10">
                                <span class="fa fa-street-view"></span> {!! \Session::get('label_celulas') !!}
                              </a>
                            </h5>
                          </div>
                          <div id="tab10" class="panel-collapse collapse">
                            <div class="box-body">

                                  <div  class="row">
                                       <div class="col-md-12">
                                                <div class="box box-default">
                                                      <div class="box-body"><!-- box-body-->
                                                              <div class="row"><!-- row-->
                                                                  <div class="col-xs-11">

                                                                        <label for="celulas" class="control-label">Participa {!! \Session::get('label_celulas_singular') !!}</label>

                                                                        <select id="celulas" name="celulas" placeholder="(Selecionar)" data-live-search="true" data-none-selected-text="Nenhum item selecionado" class="form-control selectpicker" style="width: 100%;">
                                                                        <option  value=""></option>
                                                                        @foreach($celulas as $item)
                                                                              @if (isset($membros_celula))
                                                                                  <option  value="{!! $item->id  . '|' . $item->nome !!}" {{$membros_celula[0]->celulas_id==$item->id ? 'selected' : '' }}>{{$item->nome}}</option>
                                                                              @else
                                                                                  <option  value="{!! $item->id  . '|' . $item->nome !!}">{{$item->nome}}</option>
                                                                              @endif
                                                                        @endforeach
                                                                        </select>

                                                                  </div><!-- col-xs-5-->
                                                              </div>
                                                      </div>
                                                </div>
                                       </div>
                                  </div>

                            </div>
                          </div>
                      </div><!-- FIM TAB Células-->


                    </div><!-- end box-group -->


                  </div>
                  <!-- /.box-body -->
                </div>
                <!-- /.box -->
              </div>
         </div>


   </div><!-- FIM - DADOS ECLISIASTICOS-->

<script type="text/javascript">

  function remover_pessoa(var_objeto)
  {
        $('#' + var_objeto).val('');
  }

  /*Quando selecionar um conjuge do cadastro desabilitar os campos para informação manual*/
  function validar_conjuge()
  {

      var ind_conjuge = document.getElementById("conjuge").selectedIndex;
      var texto_conjuge = document.getElementById("conjuge").options;

       if (texto_conjuge[ind_conjuge].text != "")
       {
          document.getElementById("datanasc_conjuge").value = "";
          document.getElementById("datafalecimento").value = "";
          document.getElementById("nome_conjuge").value ="";
          document.getElementById("status_conjuge").selectedIndex = -1;
          document.getElementById("dados_conjuge").style.display = "none";
       }
       else
       {
          document.getElementById("dados_conjuge").style.display = "block";
       }


 }

function incluir_filho_cadastro()
{
        if (document.getElementById("filho_cadastro").value != "")
        {
              /*cria os inputs para exibicao ao usuario*/
              var sFilho = '<div class="col-xs-2"><input id="inc_filhos[]" readonly name = "inc_filhos[]" type="text" class="form-control" value="' + document.getElementById("filho_cadastro").value + '"></div>';
              var sSexoFilho = '<div class="col-xs-1"><input id="inc_sexo[]" readonly name = "inc_sexo[]" type="text" class="form-control" value=""></div>';
              var sStatusFilho = '<div class="col-xs-2"><input id="inc_status[]" readonly name = "inc_status[]" type="text" class="form-control" value=""></div>';
              var sEstadoCivilFilho = '<div class="col-xs-2"><input id="inc_estadocivl[]" readonly name = "inc_estadocivl[]" type="text" class="form-control" value=""></div>';
              var sDataNascFilho = '<div class="col-xs-2"><input id="inc_datanasc[]" readonly name = "inc_datanasc[]" type="text" class="form-control" value=""></div>';
              var sDataFalecimentoFilho = '<div class="col-xs-2"><input id="inc_datafalec[]" readonly name = "inc_datafalec[]" type="text" class="form-control" value=""></div>';
              var sFilhoHidden = '<input id="hidden_id_filhos[]" name = "hidden_id_filhos[]" type="hidden" class="form-control" value="' + document.getElementById("filho_cadastro").value.substring(0,9) + '">';

              /*Salva os ID's*/
              var sHiddenSexo = '<input id="hidden_sexo[]" name = "hidden_sexo[]" type="hidden" class="form-control" value="">';
              var sHiddenStatusFilho = '<input id="hidden_status[]" name = "hidden_status[]" type="hidden" class="form-control" value="">';
              var sHiddenEstadoCivilFilho = '<input id="hidden_estadocivl[]" name = "hidden_estadocivl[]" type="hidden" class="form-control" value="">';

              /*Gera codigo HTML*/
              document.getElementById("mais_filhos").innerHTML = document.getElementById("mais_filhos").innerHTML + sFilho + sSexoFilho + sStatusFilho + sEstadoCivilFilho + sDataNascFilho + sDataFalecimentoFilho + sHiddenSexo + sHiddenStatusFilho + sHiddenEstadoCivilFilho + sFilhoHidden;

              /*Limpar campos*/
              document.getElementById("filho_cadastro").value = "";
        }

}

function incluir_filho()
{

          if (document.getElementById("nome_filho").value == "")
          {
              alert("Informe o Nome");
              return false;
          }

          var ind_sexo = document.getElementById("opSexoFilho").selectedIndex;
          var texto_sexo = document.getElementById("opSexoFilho").options;
          var ind_estado_civil_filho = document.getElementById("estado_civil_filho").selectedIndex;
          var texto_estado_civil_filho = document.getElementById("estado_civil_filho").options;

          var ind_status_filho = document.getElementById("status_filho").selectedIndex;
          var texto_status_filho = document.getElementById("status_filho").options;

          var sFilhoHidden = '<input id="hidden_id_filhos[]" name = "hidden_id_filhos[]" type="hidden" class="form-control" value="">';

          /*cria os inputs para exibicao ao usuario*/
          var sFilho = '<div class="col-xs-2"><input id="inc_filhos[]" readonly name = "inc_filhos[]" type="text" class="form-control" value="' + document.getElementById("nome_filho").value + '"></div>';
          var sSexoFilho = '<div class="col-xs-1"><input id="inc_sexo[]" readonly name = "inc_sexo[]" type="text" class="form-control" value="' + texto_sexo[ind_sexo].text + '"></div>';
          var sStatusFilho = '<div class="col-xs-2"><input id="inc_status[]" readonly name = "inc_status[]" type="text" class="form-control" value="' + texto_status_filho[ind_status_filho].text + '"></div>';
          var sEstadoCivilFilho = '<div class="col-xs-2"><input id="inc_estadocivl[]" readonly name = "inc_estadocivl[]" type="text" class="form-control" value="' + texto_estado_civil_filho[ind_estado_civil_filho].text + '"></div>';
          var sDataNascFilho = '<div class="col-xs-2"><input id="inc_datanasc[]" readonly name = "inc_datanasc[]" type="text" class="form-control" value="' + document.getElementById("datanascimento_filho").value + '"></div>';
          var sDataFalecimentoFilho = '<div class="col-xs-2"><input id="inc_datafalec[]" readonly name = "inc_datafalec[]" type="text" class="form-control" value="' + document.getElementById("datafalecimento_filho").value + '"></div>';

          /*Salva os ID's*/
          var sHiddenSexo = '<input id="hidden_sexo[]" name = "hidden_sexo[]" type="hidden" class="form-control" value="' + texto_sexo[ind_sexo].value + '">';
          var sHiddenStatusFilho = '<input id="hidden_status[]" name = "hidden_status[]" type="hidden" class="form-control" value="' + texto_status_filho[ind_status_filho].value + '">';
          var sHiddenEstadoCivilFilho = '<input id="hidden_estadocivl[]" name = "hidden_estadocivl[]" type="hidden" class="form-control" value="' + texto_estado_civil_filho[ind_estado_civil_filho].value + '">';

          /*Gera codigo HTML*/
          document.getElementById("mais_filhos").innerHTML = document.getElementById("mais_filhos").innerHTML + sFilho + sSexoFilho + sStatusFilho + sEstadoCivilFilho + sDataNascFilho + sDataFalecimentoFilho + sHiddenSexo + sHiddenStatusFilho + sHiddenEstadoCivilFilho + sFilhoHidden;

          /*Limpar campos*/
          document.getElementById("nome_filho").value = "";
          document.getElementById("datanascimento_filho").value="";
          document.getElementById("datafalecimento_filho").value="";
}


</script>

<script type="text/javascript">

  $(document).ready(function()
  {
    $("#tab_filhos .deleteLink").on("click",function()
    {
        var tr = $(this).closest('tr');
        tr.css("background-color","#FF3700");

        tr.fadeOut(400, function()
        {
            tr.remove();
        });
      return false;
    });
});

</script>

<script type="text/javascript">

   (function($) {
      AddTableRow = function() {

        /*Não deixa adicionar sem curso*/
        if (document.getElementById("curso").value=="")
        {
            return false; //sai da funcao
        }

        var newRow = $("<tr>");
        var cols = "";
        var strCampos="";

        var ind_curso = document.getElementById("curso").selectedIndex;
        var texto_curso = document.getElementById("curso").options;
        var scurso = texto_curso[ind_curso].text ;

        //ID do curso
        strCampos =    '<input id="hidden_cursos[]"  name = "hidden_cursos[]" type="hidden" value="' + document.getElementById("curso").value + '">';
        strCampos += '<input id="inc_cursos[]"  name = "inc_cursos[]" type="hidden" value="' + scurso + '">';
        strCampos += '<input id="inc_ministrante[]"  name = "inc_ministrante[]" type="hidden" value="' + document.getElementById("ministrante").value + '">';
        strCampos += '<input id="inc_ministrante_id[]"  name = "inc_ministrante_id[]" type="hidden" value="' + document.getElementById("ministrante").value.substr(0,9) + '">';
        strCampos += '<input id="inc_datainicio[]"  name = "inc_datainicio[]" type="hidden" value="' + document.getElementById("data_inicio").value + '">';
        strCampos += '<input id="inc_datafim[]"  name = "inc_datafim[]" type="hidden" value="' + document.getElementById("data_fim").value + '">';
        strCampos += '<input id="inc_obs[]"  name = "inc_obs[]" type="hidden" value="' + document.getElementById("observacao").value + '">';

        //Cria linha na tabela
        cols += '<td>' + scurso + '</td>';
        cols += '<td>' + document.getElementById("ministrante").value + '</td>';
        cols += '<td>' + document.getElementById("data_inicio").value + '</td>';
        cols += '<td>' + document.getElementById("data_fim").value + '</td>';
        cols += '<td>' + document.getElementById("observacao").value + '</td>';
        cols += '<td>';
        cols += '<a href="#tabela_cursos" class="btn btn-danger btn-sm" onclick="RemoveTableRow(this)"><spam class="glyphicon glyphicon-trash"></spam></a>'  + strCampos;
        cols += '</td>';

        newRow.append(cols);
        $("#tabela_cursos").append(newRow);

        //limpa campos
        $("#curso")[0].selectedIndex = 0;
        $('#curso').trigger('change');
        document.getElementById("ministrante").value="";
        document.getElementById("data_inicio").value="";
        document.getElementById("data_fim").value="";
        document.getElementById("observacao").value="";
        return false;
      };
    })(jQuery);

    //remover linha tabela
    (function($) {

      RemoveTableRow = function(handler) {
        var tr = $(handler).closest('tr');

        tr.fadeOut(400, function(){
          tr.remove();
        });

        return false;
      };
    })(jQuery);

</script>