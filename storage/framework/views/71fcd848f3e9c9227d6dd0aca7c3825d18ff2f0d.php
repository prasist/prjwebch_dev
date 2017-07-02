<?php $__env->startSection('content'); ?>

<?php echo e(\Session::put('titulo', 'Cadastro ' . \Session::get('label_celulas'))); ?>


<?php if($tipo_operacao=="incluir"): ?>
    <?php echo e(\Session::put('subtitulo', 'Inclusão')); ?>

<?php else: ?>
    <?php echo e(\Session::put('subtitulo', 'Alteração / Visualização')); ?>

<?php endif; ?>

<?php echo e(\Session::put('route', 'celulas')); ?>

<?php echo e(\Session::put('id_pagina', '42')); ?>


<style type="text/css">

    @media  print
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

<div class = 'row'>

<div class="col-md-12">

<div class="row">
    <div class="col-xs-2">
            <a href="<?php echo e(url('/' . \Session::get('route'))); ?>" class="btn btn-default"><i class="fa fa-arrow-circle-left"></i> Voltar</a>
    </div>

    <div class="col-xs-3">
        <a href="<?php echo e(url('/tutoriais/4')); ?>" data-toggle="tooltip" title="Clique Aqui para ver o tutorial..." target="_blank">
            <i class="glyphicon glyphicon-question-sign text-success"></i>&nbsp;Como cadastrar <?php echo \Session::get('label_celulas'); ?> ?
       </a>
    </div>
</div>

<?php if($tipo_operacao=="incluir"): ?>
<form name="form_celulas" id="form_celulas" method = 'POST' class="form-horizontal" action = "<?php echo e(url('/' . \Session::get('route') . '/gravar')); ?>" novalidate>
<?php else: ?>
<form name="form_celulas" id="form_celulas" method = 'POST' class="form-horizontal"  action = "<?php echo e(url('/' . \Session::get('route') . '/' . $dados[0]->id . '/update')); ?>" novalidate>
<?php endif; ?>

<input type="hidden" id="quero_incluir_participante" name="quero_incluir_participante" value="">
<?php echo csrf_field(); ?>


<div class="box box-default">
  <div class="box-body">
    <div class="row">
        <div class="col-md-12">

                      <div class="nav-tabs-custom">

                          <ul class="nav nav-tabs">
                            <li class="active"><a href="#tab_1" data-toggle="tab">Dados Cadastrais</a></li>

                            <?php if($tipo_operacao=="editar"): ?>
                                <li><a href="#tab_participantes" data-toggle="tab">Participantes <span class="badge bg-blue"><?php echo $dados[0]->tot; ?></span></a></li>
                                <input type="hidden" name="hidden_existe" id="hidden_existe" value="<?php echo $dados[0]->tot; ?>">
                            <?php else: ?>
                                <input type="hidden" name="hidden_existe" id="hidden_existe" value="">
                            <?php endif; ?>

                            <li>
                            <?php if($dados[0]->tot_geracao!=0): ?>
                                  <a href="#tab_2" data-toggle="tab">Vinculo de <?php echo \Session::get('label_celulas'); ?>&nbsp;<span class="pull-right badge bg-yellow"><?php echo ($dados[0]->tot_geracao==0 ? "" : $dados[0]->tot_geracao); ?></span></a>
                            <?php else: ?>
                                  <?php if(isset($dados[0]->total_ant)): ?>
                                  <a href="#tab_2" data-toggle="tab">Vinculo de <?php echo \Session::get('label_celulas'); ?>&nbsp;<span class="pull-right badge bg-purple"><?php echo ($dados[0]->total_ant==0 ? "" : $dados[0]->total_ant); ?></span></a>
                                  <?php else: ?>
                                  <a href="#tab_2" data-toggle="tab">Vinculo de <?php echo \Session::get('label_celulas'); ?></a>
                                  <?php endif; ?>
                            <?php endif; ?>


                            </li>

                          </ul>

                          <div class="tab-content">
                                    <!-- TABS-->
                                    <div class="tab-pane active" id="tab_1">

                                        <div class="row">

                                              <div class="form-group">
                                              <label for="nivel5" class="col-sm-2 control-label"><?php echo Session::get('nivel5'); ?></label>
                                              <div class="col-sm-10<?php echo e($errors->has('nivel5') ? ' has-error' : ''); ?>">
                                                      <select id="nivel5" placeholder="(Selecionar)" name="nivel5" data-live-search="true" data-none-selected-text="Nenhum item selecionado" class="form-control" style="width: 100%;">
                                                      <option  value=""></option>
                                                      <?php foreach($nivel5 as $item): ?>
                                                             <?php if($tipo_operacao=="editar"): ?>
                                                                  <option  value="<?php echo e($item->id); ?>" <?php echo e(($dados[0]->celulas_nivel5_id == $item->id ? 'selected' : '')); ?> ><?php echo e($item->nome); ?></option>
                                                             <?php else: ?>
                                                                  <option  value="<?php echo e($item->id); ?>" ><?php echo e($item->nome); ?></option>
                                                             <?php endif; ?>
                                                      <?php endforeach; ?>
                                                      </select>
                                                      <!-- se houver erros na validacao do form request -->
                                                     <?php if($errors->has('nivel5')): ?>
                                                      <span class="help-block">
                                                          <strong><?php echo e($errors->first('nivel5')); ?></strong>
                                                      </span>
                                                     <?php endif; ?>
                                              </div>
                                            </div>


                                            <div class="form-group">
                                            <label for="nivel4" class="col-sm-2 control-label"><?php echo e(Session::get('nivel4')); ?></label>

                                            <div class="col-sm-10<?php echo e($errors->has('nivel4') ? ' has-error' : ''); ?>">
                                                  <select id="nivel4" placeholder="(Selecionar)" name="nivel4" data-live-search="true" data-none-selected-text="Nenhum item selecionado" class="form-control" style="width: 100%;">
                                                  <option  value=""></option>
                                                  </select>
                                            </div>

                                                  <!-- se houver erros na validacao do form request -->
                                                   <?php if($errors->has('nivel4')): ?>
                                                    <span class="help-block">
                                                        <strong><?php echo e($errors->first('nivel4')); ?></strong>
                                                    </span>
                                                   <?php endif; ?>
                                          </div>

                                          <div class="form-group">
                                            <label for="nivel3" class="col-sm-2 control-label"><?php echo e(Session::get('nivel3')); ?></label>

                                            <div class="col-sm-10<?php echo e($errors->has('nivel3') ? ' has-error' : ''); ?>">
                                                  <select id="nivel3" placeholder="(Selecionar)" name="nivel3" data-live-search="true" data-none-selected-text="Nenhum item selecionado" class="form-control" style="width: 100%;">
                                                  <option  value=""></option>
                                                  </select>
                                            </div>

                                                  <!-- se houver erros na validacao do form request -->
                                                   <?php if($errors->has('nivel3')): ?>
                                                    <span class="help-block">
                                                        <strong><?php echo e($errors->first('nivel3')); ?></strong>
                                                    </span>
                                                   <?php endif; ?>
                                          </div>

                                          <div class="form-group">
                                            <label for="nivel2" class="col-sm-2 control-label"><?php echo e(Session::get('nivel2')); ?></label>

                                            <div class="col-sm-10<?php echo e($errors->has('nivel2') ? ' has-error' : ''); ?>">
                                                    <select id="nivel2" placeholder="(Selecionar)" name="nivel2" data-live-search="true" data-none-selected-text="Nenhum item selecionado" class="form-control" style="width: 100%;">
                                                    <option  value=""></option>
                                                    </select>
                                            </div>

                                                 <!-- se houver erros na validacao do form request -->
                                                 <?php if($errors->has('nivel2')): ?>
                                                  <span class="help-block">
                                                      <strong><?php echo e($errors->first('nivel2')); ?></strong>
                                                  </span>
                                                 <?php endif; ?>
                                          </div>

                                          <div class="form-group">
                                            <label for="nivel1" class="col-sm-2 control-label"><?php echo e(Session::get('nivel1')); ?></label>

                                            <div class="col-sm-10<?php echo e($errors->has('nivel1') ? ' has-error' : ''); ?>">
                                                  <select id="nivel1" placeholder="(Selecionar)" name="nivel1" data-live-search="true" data-none-selected-text="Nenhum item selecionado" class="form-control" style="width: 100%;">
                                                  <option  value=""></option>
                                                  </select>
                                            </div>

                                                    <!-- se houver erros na validacao do form request -->
                                                   <?php if($errors->has('nivel1')): ?>
                                                    <span class="help-block">
                                                        <strong><?php echo e($errors->first('nivel1')); ?></strong>
                                                    </span>
                                                   <?php endif; ?>
                                          </div>

                                        </div>


                                         <div class="row">

                                              <div class="col-xs-5">
                                                      <label for="nome" class="control-label">Nome <?php echo \Session::get('label_celulas_singular'); ?></label>
                                                      <?php if($tipo_operacao=="editar"): ?>
                                                            <input id="nome"  placeholder="(Opcional)" name = "nome" type="text" class="form-control" value="<?php echo $dados[0]->nome; ?>">
                                                      <?php else: ?>
                                                            <input id="nome"  placeholder="(Opcional)" name = "nome" type="text" class="form-control" value="">
                                                      <?php endif; ?>
                                              </div>

                                              <div class="col-xs-1">
                                                    <label for="cor" class="control-label">Cor</label>
                                                    <?php if($tipo_operacao=="editar"): ?>
                                                        <input id="cor"  placeholder="(Opcional)" name = "cor" type="text" class="pick-a-color form-control" value="<?php echo e(($dados[0]->cor=='' ? 'fff' : $dados[0]->cor)); ?>">
                                                    <?php else: ?>
                                                        <input id="cor"  placeholder="(Opcional)" name = "cor" type="text" class="pick-a-color form-control" value="fff">
                                                    <?php endif; ?>
                                              </div>

                                              <div class="col-xs-6 <?php echo e($errors->has('regiao') ? ' has-error' : ''); ?>">
                                                      <label for="regiao" class="control-label">Região</label>
                                                      <?php if($tipo_operacao=="editar"): ?>
                                                        <input id="regiao"  placeholder="(Opcional)" name = "regiao" type="text" class="form-control" value="<?php echo e($dados[0]->regiao); ?>">
                                                      <?php else: ?>
                                                        <input id="regiao"  placeholder="(Opcional)" name = "regiao" type="text" class="form-control" value="">
                                                      <?php endif; ?>

                                                      <!-- se houver erros na validacao do form request -->
                                                     <?php if($errors->has('regiao')): ?>
                                                      <span class="help-block">
                                                          <strong><?php echo e($errors->first('regiao')); ?></strong>
                                                      </span>
                                                     <?php endif; ?>

                                              </div>
                                        </div>

                                        <div class="row">

                                              <div class="col-xs-6 <?php echo e($errors->has('pessoas') ? ' has-error' : ''); ?>">
                                                      <label for="pessoas" class="control-label"><span class="text-danger">*</span> <?php echo \Session::get('label_lider_singular'); ?></label>
                                                      <div class="input-group">
                                                               <div class="input-group-addon">
                                                                  <button  id="buscarpessoa" type="button"  data-toggle="modal" data-target="#modal_lider" >
                                                                         <i class="fa fa-search"></i> ...
                                                                   </button>
                                                                   &nbsp;<a href="#" onclick="remover_pessoa('pessoas');" title="Limpar Campo"><spam class="fa fa-close"></spam></a>

                                                                </div>

                                                                <?php echo $__env->make('modal_buscar_pessoas', array('qual_campo'=>'pessoas', 'modal' => 'modal_lider'), array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

                                                                <?php if($tipo_operacao=="editar"): ?>
                                                                    <input id="pessoas"  name = "pessoas" type="text" class="form-control" placeholder="Clica na lupa ao lado para consultar uma pessoa" value="<?php echo ($dados[0]->lider_pessoas_id!="" ? str_repeat('0', (9-strlen($dados[0]->lider_pessoas_id))) . $dados[0]->lider_pessoas_id . ' - ' . $dados[0]->razaosocial  : ''); ?>" readonly >
                                                                <?php else: ?>
                                                                    <input id="pessoas"  name = "pessoas" type="text" class="form-control" placeholder="Clica na lupa ao lado para consultar uma pessoa" value="" readonly >
                                                                <?php endif; ?>


                                                                <!-- se houver erros na validacao do form request -->
                                                                <?php if($errors->has('pessoas')): ?>
                                                                <span class="help-block">
                                                                    <strong><?php echo e($errors->first('pessoas')); ?></strong>
                                                                </span>
                                                                <?php endif; ?>

                                                        </div>
                                               </div>

                                               <div class="col-xs-6 <?php echo e($errors->has('vicelider_pessoas_id') ? ' has-error' : ''); ?>">
                                                      <label for="vicelider_pessoas_id" class="control-label"><?php echo \Session::get('label_lider_treinamento'); ?></label>
                                                      <div class="input-group">
                                                               <div class="input-group-addon">
                                                                  <button  id="buscarpessoa2" type="button"  data-toggle="modal" data-target="#modal_vice" >
                                                                         <i class="fa fa-search"></i> ...
                                                                   </button>
                                                                   &nbsp;<a href="#" onclick="remover_pessoa('vicelider_pessoas_id');" title="Limpar Campo"><spam class="fa fa-close"></spam></a>

                                                                </div>

                                                                <?php echo $__env->make('modal_buscar_pessoas', array('qual_campo'=>'vicelider_pessoas_id', 'modal' => 'modal_vice'), array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

                                                                <?php if($tipo_operacao=="editar"): ?>
                                                                       <input id="vicelider_pessoas_id"  name = "vicelider_pessoas_id" type="text" class="form-control" placeholder="Clica na lupa ao lado para consultar uma pessoa" value="<?php echo ($dados[0]->vicelider_pessoas_id!="" ? str_repeat('0', (9-strlen($dados[0]->vicelider_pessoas_id))) . $dados[0]->vicelider_pessoas_id . ' - ' . $dados[0]->nome_vicelider  : ''); ?>" readonly >
                                                                <?php else: ?>
                                                                       <input id="vicelider_pessoas_id"  name = "vicelider_pessoas_id" type="text" class="form-control" placeholder="Clica na lupa ao lado para consultar uma pessoa" value="" readonly >
                                                                <?php endif; ?>

                                                                <!-- se houver erros na validacao do form request -->
                                                                <?php if($errors->has('vicelider_pessoas_id')): ?>
                                                                <span class="help-block">
                                                                     <strong><?php echo e($errors->first('vicelider_pessoas_id')); ?></strong>
                                                                 </span>
                                                                <?php endif; ?>
                                                        </div>
                                               </div>


                                        </div>

                                        <div class="row">
                                                   <div class="col-xs-12 <?php echo e($errors->has('suplente1_pessoas_id') ? ' has-error' : ''); ?>">
                                                        <label for="suplente1_pessoas_id" class="control-label"><?php echo \Session::get('label_anfitriao'); ?></label>
                                                        <div class="input-group">
                                                                 <div class="input-group-addon">
                                                                    <button  id="buscarpessoa3" type="button"  data-toggle="modal" data-target="#modal_suplente1" >
                                                                           <i class="fa fa-search"></i> ...
                                                                     </button>
                                                                     &nbsp;<a href="#" onclick="remover_pessoa('suplente1_pessoas_id');" title="Limpar Campo"><spam class="fa fa-close"></spam></a>
                                                                  </div>

                                                                  <?php echo $__env->make('modal_buscar_pessoas', array('qual_campo'=>'suplente1_pessoas_id', 'modal' => 'modal_suplente1'), array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

                                                                  <?php if($tipo_operacao=="editar"): ?>
                                                                      <input id="suplente1_pessoas_id"  name = "suplente1_pessoas_id" type="text" class="form-control" placeholder="Clica na lupa ao lado para consultar uma pessoa" value="<?php echo ($dados[0]->suplente1_pessoas_id!="" ? str_repeat('0', (9-strlen($dados[0]->suplente1_pessoas_id))) . $dados[0]->suplente1_pessoas_id . ' - ' . $dados[0]->nome_suplente1  : ''); ?>" readonly >
                                                                  <?php else: ?>
                                                                      <input id="suplente1_pessoas_id"  name = "suplente1_pessoas_id" type="text" class="form-control" placeholder="Clica na lupa ao lado para consultar uma pessoa" value="" readonly >
                                                                  <?php endif; ?>

                                                                  <!-- se houver erros na validacao do form request -->
                                                                   <?php if($errors->has('suplente1_pessoas_id')): ?>
                                                                    <span class="help-block">
                                                                        <strong><?php echo e($errors->first('suplente1_pessoas_id')); ?></strong>
                                                                    </span>
                                                                   <?php endif; ?>

                                                          </div>
                                               </div>
                                        </div>


                                        <div class="row">

                                                <div class="col-xs-3 <?php echo e($errors->has('dia_encontro') ? ' has-error' : ''); ?>">
                                                      <label for="dia_encontro" class="control-label"><span class="text-danger">*</span> Dia Encontro</label>

                                                      <select id="dia_encontro"  placeholder="(Selecionar)" name="dia_encontro" data-live-search="true" data-none-selected-text="Nenhum item selecionado" class="form-control" style="width: 100%;" required>
                                                      <option  value=""></option>
                                                      <!--[0 Domingo] - [1 Segunda] - [2 Terca] - [3 Quarta] - [4 Quinta] - [5 Sexta] - [6 Sabado]-->
                                                      <?php if($tipo_operacao=="editar"): ?>
                                                             <option  value="1" <?php echo e(($dados[0]->dia_encontro=="1" ? "selected" : "")); ?>>Segunda-Feira</option>
                                                             <option  value="2" <?php echo e(($dados[0]->dia_encontro=="2" ? "selected" : "")); ?>>Terça-Feira</option>
                                                             <option  value="3" <?php echo e(($dados[0]->dia_encontro=="3" ? "selected" : "")); ?>>Quarta-Feira</option>
                                                             <option  value="4" <?php echo e(($dados[0]->dia_encontro=="4" ? "selected" : "")); ?>>Quinta-Feira</option>
                                                             <option  value="5" <?php echo e(($dados[0]->dia_encontro=="5" ? "selected" : "")); ?>>Sexta-Feira</option>
                                                             <option  value="6" <?php echo e(($dados[0]->dia_encontro=="6" ? "selected" : "")); ?>>Sábado</option>
                                                             <option  value="0" <?php echo e(($dados[0]->dia_encontro=="0" ? "selected" : "")); ?>>Domingo</option>
                                                      <?php else: ?>
                                                             <option  value="1" >Segunda-Feira</option>
                                                             <option  value="2" >Terça-Feira</option>
                                                             <option  value="3" >Quarta-Feira</option>
                                                             <option  value="4">Quinta-Feira</option>
                                                             <option  value="5">Sexta-Feira</option>
                                                             <option  value="6">Sábado</option>
                                                             <option  value="0">Domingo</option>
                                                      <?php endif; ?>
                                                      </select>


                                                      <!-- se houver erros na validacao do form request -->
                                                     <?php if($errors->has('dia_encontro')): ?>
                                                      <span class="help-block">
                                                          <strong><?php echo e($errors->first('dia_encontro')); ?></strong>
                                                      </span>
                                                     <?php endif; ?>

                                                </div>

                                                <div class="col-xs-2 <?php echo e($errors->has('horario') ? ' has-error' : ''); ?>">

                                                        <div class="bootstrap-timepicker">
                                                              <div class="form-group">
                                                                <label for="horario" class="control-label"><span class="text-danger">*</span>  Horário</label>

                                                                <div class="input-group">
                                                                  <?php if($tipo_operacao=="editar"): ?>
                                                                        <input type="text" data-inputmask='"mask": "99:99"' data-mask  name="horario" id="horario"  class="form-control input-small" value="<?php echo e($dados[0]->horario); ?>" required>
                                                                  <?php else: ?>
                                                                        <input type="text" data-inputmask='"mask": "99:99"' data-mask  name="horario" id="horario" class="form-control input-small" required>
                                                                  <?php endif; ?>
                                                                  <div class="input-group-addon">
                                                                    <i class="fa fa-clock-o"></i>
                                                                  </div>
                                                                </div>
                                                                <!-- /.input group -->
                                                              </div>
                                                              <!-- /.form group -->
                                                            </div>

                                                            <?php if($errors->has('horario')): ?>
                                                              <span class="help-block">
                                                                  <strong><?php echo e($errors->first('horario')); ?></strong>
                                                              </span>
                                                             <?php endif; ?>

                                                </div>

                                                <div class="col-xs-4">
                                                      <label for="local" class="control-label">Local Encontro</label>

                                                      <!-- ng-options="local.Name for local in Locais track by local.Id"-->
                                                      <!--
                                                      <select ng-model="selectedCarregar" ng-options="local.Name for local in Locais track by local.Id">
                                                            <option value="">Selecionar</option>

                                                      </select>
                                                      -->

                                                      <!--<option ng-repeat="option in data.Locais" value="{{option.id}}">{{option.name}}</option>-->

                                                      <select id="local" placeholder="(Selecionar)" name="local" data-live-search="true" data-none-selected-text="Nenhum item selecionado" class="form-control" style="width: 100%;">
                                                      <option  value=""></option>
                                                      <?php if($tipo_operacao=="editar"): ?>
                                                          <option  value="1" <?php echo e(($dados[0]->qual_endereco=="1" ? "selected" : "")); ?>>Endereço do <?php echo \Session::get('label_lider_singular'); ?></option>
                                                          <option  value="2" <?php echo e(($dados[0]->qual_endereco=="2" ? "selected" : "")); ?>>Endereço do <?php echo \Session::get('label_lider_treinamento'); ?></option>
                                                          <option  value="3" <?php echo e(($dados[0]->qual_endereco=="3" ? "selected" : "")); ?>>Endereço do <?php echo \Session::get('label_anfitriao'); ?></option>
                                                          <option  value="4" <?php echo e(($dados[0]->qual_endereco=="4" ? "selected" : "")); ?>>Endereço do <?php echo \Session::get('label_lider_suplente'); ?></option>
                                                          <option  value="5" <?php echo e(($dados[0]->qual_endereco=="5" ? "selected" : "")); ?>>Endereço da Igreja Sede</option>
                                                          <option  value="6" <?php echo e(($dados[0]->qual_endereco=="6" ? "selected" : "")); ?>>Outro</option>
                                                      <?php else: ?>
                                                          <option  value="1">Endereço do <?php echo \Session::get('label_lider_singular'); ?></option>
                                                          <option  value="2">Endereço do <?php echo \Session::get('label_lider_treinamento'); ?></option>
                                                          <option  value="3">Endereço do <?php echo \Session::get('label_anfitriao'); ?></option>
                                                          <option  value="4">Endereço do <?php echo \Session::get('label_lider_suplente'); ?></option>
                                                          <option  value="5">Endereço da Igreja Sede</option>
                                                          <option  value="6">Outro</option>
                                                      <?php endif; ?>
                                                      </select>
                                             </div>

                                                <!--
                                                <div class="col-xs-3 <?php echo e($errors->has('turno') ? ' has-error' : ''); ?>">
                                                      <label for="turno" class="control-label">Turno</label>

                                                      <select id="turno" placeholder="(Selecionar)" name="turno" data-live-search="true" data-none-selected-text="Nenhum item selecionado" class="form-control" style="width: 100%;">
                                                      <option  value=""></option>
                                                      <option  value="M">Manhã</option>
                                                      <option  value="T">Tarde</option>
                                                      <option  value="N">Noite</option>
                                                      </select>

                                                     <?php if($errors->has('turno')): ?>
                                                      <span class="help-block">
                                                          <strong><?php echo e($errors->first('turno')); ?></strong>
                                                      </span>
                                                     <?php endif; ?>

                                                </div>
                                                -->

                                        </div><!-- end row -->

                                        <div id="div_endereco" class="row" style="display: none">
                                            <div class="col-xs-12">
                                                  <label for="endereco_encontro" class="control-label">Outro Local Encontro</label>
                                                  <?php if($tipo_operacao=="editar"): ?>
                                                       <input type="text" id="endereco_encontro" name="endereco_encontro" class="form-control" value="<?php echo e($dados[0]->endereco_encontro); ?>" placeholder="Preencha o endereço completo...">
                                                  <?php else: ?>
                                                       <input type="text" id="endereco_encontro" name="endereco_encontro" class="form-control" value="" placeholder="Preencha o endereço completo...">
                                                  <?php endif; ?>
                                            </div>
                                        </div>

                                           <div class="row">

                                              <div class="col-xs-6">
                                                    <?php if($tipo_operacao=="editar"): ?>
                                                          <?php echo $__env->make('carregar_combos', array('dados'=>$publicos, 'titulo' =>'Público Alvo', 'id_combo'=>'publico_alvo', 'complemento'=>'', 'comparar'=>$dados[0]->publico_alvo_id, 'id_pagina'=> '43'), array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                                                    <?php else: ?>
                                                          <?php echo $__env->make('carregar_combos', array('dados'=>$publicos, 'titulo' =>'Público Alvo', 'id_combo'=>'publico_alvo', 'complemento'=>'', 'comparar'=>'', 'id_pagina'=> '43'), array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                                                    <?php endif; ?>

                                                    <?php echo $__env->make('modal_cadastro_basico', array('qual_campo'=>'publico_alvo', 'modal' => 'modal_publico_alvo', 'tabela' => 'publicos_alvos'), array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                                              </div>

                                              <div class="col-xs-6">
                                                    <?php if($tipo_operacao=="editar"): ?>
                                                          <?php echo $__env->make('carregar_combos', array('dados'=>$faixas, 'titulo' =>'Faixas Etárias', 'id_combo'=>'faixa_etaria', 'complemento'=>'', 'comparar'=>$dados[0]->faixa_etaria_id, 'id_pagina'=> '44'), array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                                                    <?php else: ?>
                                                          <?php echo $__env->make('carregar_combos', array('dados'=>$faixas, 'titulo' =>'Faixas Etárias', 'id_combo'=>'faixa_etaria', 'complemento'=>'', 'comparar'=>'', 'id_pagina'=> '44'), array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                                                    <?php endif; ?>

                                                    <?php echo $__env->make('modal_cadastro_basico', array('qual_campo'=>'faixa_etaria', 'modal' => 'modal_faixa_etaria', 'tabela' => 'faixas_etarias'), array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                                              </div>

                                        </div>


                                        <br/>
                                        <div class="row">
                                            <div class="col-md-12">
                                              <div class="box box-solid">

                                                <!-- /.box-header -->
                                                <div class="box-body">
                                                  <div class="box-group" id="accordion">
                                                    <!-- we are adding the .panel class so bootstrap.js collapse plugin detects it -->
                                                    <div class="panel box box-default">
                                                      <div class="box-header with-border">
                                                        <h5 class="box-title">
                                                          <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne">
                                                            ( + ) Informações Complementares
                                                          </a>
                                                        </h5>
                                                      </div>
                                                      <div id="collapseOne" class="panel-collapse collapse">
                                                        <div class="box-body">

                                                                   <div class="row">
                                                                        <div class="col-xs-10">
                                                                              <label for="email_grupo" class="control-label">E-mail do grupo</label>
                                                                              <?php if($tipo_operacao=="editar"): ?>
                                                                                    <input id="email_grupo"  placeholder="(Opcional)" name = "email_grupo" type="text" class="form-control" value="<?php echo $dados[0]->email_grupo; ?>">
                                                                              <?php else: ?>
                                                                                    <input id="email_grupo"  placeholder="(Opcional)" name = "email_grupo" type="text" class="form-control" value="">
                                                                              <?php endif; ?>
                                                                        </div>
                                                                   </div>

                                                                   <div class="row">
                                                                        <div class="col-xs-10">
                                                                              <label for="obs" class="control-label">Observações</label>
                                                                              <?php if($tipo_operacao=="editar"): ?>
                                                                                    <input id="obs"  placeholder="(Opcional)" name = "obs" type="text" class="form-control" value="<?php echo $dados[0]->obs; ?>">
                                                                              <?php else: ?>
                                                                                    <input id="obs"  placeholder="(Opcional)" name = "obs" type="text" class="form-control" value="">
                                                                              <?php endif; ?>
                                                                        </div>
                                                                   </div>


                                                                  <div class="row">
                                                                    <div class="col-xs-12">
                                                                          <label for="suplente2_pessoas_id" class="control-label"><?php echo \Session::get('label_lider_suplente'); ?></label>
                                                                          <div class="input-group">
                                                                                   <div class="input-group-addon">
                                                                                      <button  id="buscarpessoa4" type="button"  data-toggle="modal" data-target="#modal_suplente2" >
                                                                                             <i class="fa fa-search"></i> ...
                                                                                       </button>
                                                                                       &nbsp;<a href="#" onclick="remover_pessoa('suplente2_pessoas_id');" title="Limpar Campo"><spam class="fa fa-close"></spam></a>
                                                                                    </div>

                                                                                    <?php echo $__env->make('modal_buscar_pessoas', array('qual_campo'=>'suplente2_pessoas_id', 'modal' => 'modal_suplente2'), array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

                                                                                    <?php if($tipo_operacao=="editar"): ?>
                                                                                          <input id="suplente2_pessoas_id"  name = "suplente2_pessoas_id" type="text" class="form-control" placeholder="Clica na lupa ao lado para consultar uma pessoa" value="<?php echo ($dados[0]->suplente2_pessoas_id!="" ? str_repeat('0', (9-strlen($dados[0]->suplente2_pessoas_id))) . $dados[0]->suplente2_pessoas_id . ' - ' . $dados[0]->nome_suplente2  : ''); ?>" readonly >
                                                                                    <?php else: ?>
                                                                                          <input id="suplente2_pessoas_id"  name = "suplente2_pessoas_id" type="text" class="form-control" placeholder="Clica na lupa ao lado para consultar uma pessoa" value="" readonly >
                                                                                    <?php endif; ?>


                                                                            </div>
                                                                   </div>
                                                               </div>

                                                               <div class="row">

                                                                    <div class="col-xs-3">
                                                                        <label for="segundo_dia_encontro" class="control-label">2º Dia Encontro</label>

                                                                        <select id="segundo_dia_encontro" placeholder="(Selecionar)" name="segundo_dia_encontro" data-live-search="true" data-none-selected-text="Nenhum item selecionado" class="form-control" style="width: 100%;">
                                                                        <option  value=""></option>
                                                                        <?php if($tipo_operacao=="editar"): ?>
                                                                              <option  value="1" <?php echo e(($dados[0]->segundo_dia_encontro=="1" ? "selected" : "")); ?>>Segunda-Feira</option>
                                                                              <option  value="2" <?php echo e(($dados[0]->segundo_dia_encontro=="2" ? "selected" : "")); ?>>Terça-Feira</option>
                                                                              <option  value="3" <?php echo e(($dados[0]->segundo_dia_encontro=="3" ? "selected" : "")); ?>>Quarta-Feira</option>
                                                                              <option  value="4" <?php echo e(($dados[0]->segundo_dia_encontro=="4" ? "selected" : "")); ?>>Quinta-Feira</option>
                                                                              <option  value="5" <?php echo e(($dados[0]->segundo_dia_encontro=="5" ? "selected" : "")); ?>>Sexta-Feira</option>
                                                                              <option  value="6" <?php echo e(($dados[0]->segundo_dia_encontro=="6" ? "selected" : "")); ?>>Sábado</option>
                                                                              <option  value="0" <?php echo e(($dados[0]->segundo_dia_encontro=="0" ? "selected" : "")); ?>>Domingo</option>
                                                                        <?php else: ?>
                                                                              <option  value="1">Segunda-Feira</option>
                                                                              <option  value="2">Terça-Feira</option>
                                                                              <option  value="3">Quarta-Feira</option>
                                                                              <option  value="4">Quinta-Feira</option>
                                                                              <option  value="5">Sexta-Feira</option>
                                                                              <option  value="6">Sábado</option>
                                                                              <option  value="0">Domingo</option>
                                                                        <?php endif; ?>
                                                                        </select>

                                                                  </div>

                                                                  <div class="col-xs-3">

                                                                          <div class="bootstrap-timepicker">
                                                                                <div class="form-group">
                                                                                  <label for="horario2" class="control-label">Horário 2º Dia Encontro</label>

                                                                                  <div class="input-group">

                                                                                     <?php if($tipo_operacao=="editar"): ?>
                                                                                          <input type="text" name="horario2" id="horario2"  data-inputmask='"mask": "99:99"' data-mask  class="form-control input-small" value="<?php echo e($dados[0]->horario2); ?>">
                                                                                     <?php else: ?>
                                                                                          <input type="text" name="horario2" id="horario2"  data-inputmask='"mask": "99:99"' data-mask  class="form-control input-small">
                                                                                     <?php endif; ?>

                                                                                    <div class="input-group-addon">
                                                                                      <i class="fa fa-clock-o"></i>
                                                                                    </div>
                                                                                  </div>
                                                                                  <!-- /.input group -->
                                                                                </div>
                                                                                <!-- /.form group -->
                                                                              </div>

                                                                  </div>
                                                                </div>

                                                                <div class="row">
                                                                       <div class="col-xs-3">
                                                                                <label  for="data_inicio" class="control-label">Data de Início da <?php echo \Session::get('label_celulas'); ?></label>
                                                                                <div class="input-group">
                                                                                       <div class="input-group-addon">
                                                                                        <i class="fa fa-calendar"></i>
                                                                                        </div>
                                                                                        <?php if($tipo_operacao=="editar"): ?>
                                                                                              <input id ="data_inicio" name = "data_inicio" onblur="validar_data(this);" type="text" class="form-control" data-inputmask='"mask": "99/99/9999"' data-mask  value="<?php echo e($dados[0]->data_inicio_format); ?>">
                                                                                        <?php else: ?>
                                                                                              <input id ="data_inicio" name = "data_inicio" onblur="validar_data(this);" type="text" class="form-control" data-inputmask='"mask": "99/99/9999"' data-mask  value="">
                                                                                        <?php endif; ?>
                                                                                </div>
                                                                       </div>

                                                                       <div class="col-xs-3">
                                                                                <label  for="data_previsao_multiplicacao" class="control-label">Data Previsão Multiplicação</label>
                                                                                <div class="input-group">
                                                                                       <div class="input-group-addon">
                                                                                        <i class="fa fa-calendar"></i>
                                                                                        </div>
                                                                                        <?php if($tipo_operacao=="editar"): ?>
                                                                                              <input id ="data_previsao_multiplicacao" name = "data_previsao_multiplicacao" onblur="validar_data(this);" type="text" class="form-control" data-inputmask='"mask": "99/99/9999"' data-mask  value="<?php echo e($dados[0]->data_previsao_multiplicacao_format); ?>">
                                                                                        <?php else: ?>
                                                                                              <input id ="data_previsao_multiplicacao" name = "data_previsao_multiplicacao" onblur="validar_data(this);" type="text" class="form-control" data-inputmask='"mask": "99/99/9999"' data-mask  value="">
                                                                                        <?php endif; ?>
                                                                                </div>
                                                                       </div>

                                                                </div>

                                                        </div>
                                                      </div>
                                                    </div>

                                                  </div>
                                                </div>
                                                <!-- /.box-body -->
                                              </div>
                                              <!-- /.box -->
                                            </div>

                                        </div><!-- fim box-body"-->

                                    </div><!-- /.tab-pane -->

                                      <div class="tab-pane" id="tab_participantes">

                                          <div class="row">
                                                <div class="col-xs-11">

                                                    <?php if($tipo_operacao=="editar"): ?>

                                                    <?php if($dados[0]->tot>0): ?>
                                                        <a href="<?php echo e(URL::to('celulaspessoas/' . $dados[0]->id . '/edit')); ?>" class = 'btn btn-success btn-flat'><i class="fa fa-file-text-o"></i>  Editar Participante(s)</a>
                                                    <?php else: ?>
                                                        <a href="<?php echo e(URL::to('celulaspessoas/registrar/' .$dados[0]->id)); ?>" class = 'btn btn-success btn-flat'><i class="fa fa-file-text-o"></i>  Incluir Participante(s)</a>
                                                    <?php endif; ?>

                                                    <table id="example" class="table table-bordered table-hover">
                                                        <tbody>
                                                         <tr>
                                                           <!--<th>Célula</th>-->
                                                           <th>Pessoa</th>
                                                         </tr>

                                                        <?php foreach($participantes as $item): ?>
                                                         <tr>
                                                           <!--<td><?php echo $item->descricao_concatenada; ?></td>-->
                                                           <td><?php echo $item->descricao_pessoa; ?></td>

                                                         </tr>
                                                        <?php endforeach; ?>
                                                        </tbody>

                                                    </table>
                                                    <?php endif; ?>

                                                </div>
                                          </div>


                                    </div>

                                    <div class="tab-pane" id="tab_2">

                                          <div id="nao_imprimir_1" class="row">
                                                <div class="col-xs-11">
                                                      <p class="text-info">- Informe o campo abaixo caso essa célula teve origem em outra.</p>
                                                      <p class="text-info"> - Células Vinculadas são aquelas que ocorrem dentro da própria célula, por exemplo : Célula para Crianças</p>
                                                      <p class="text-info"> - Células Multiplicadas são novas células geradas a partir de outra.</p>

                                                      <label for="origem" class="control-label">Qual a origem <?php echo \Session::get('label_celulas'); ?> ?</label>
                                                      <select id="origem" placeholder="(Selecionar)" name="origem" data-live-search="true" data-none-selected-text="Nenhum item selecionado" class="form-control selectpicker" style="width: 100%;" >
                                                      <option  value=""></option>
                                                      <?php if($tipo_operacao=="editar"): ?>
                                                          <option  value="1" <?php echo e($dados[0]->origem == 1 ? "selected" : ""); ?>>Multiplicação</option>
                                                          <option  value="2" <?php echo e($dados[0]->origem == 2 ? "selected" : ""); ?>>Vínculo (ou <?php echo \Session::get('label_celulas'); ?> Filho(a))</option>
                                                      <?php else: ?>
                                                          <option  value="1">Multiplicação</option>
                                                          <option  value="2">Vínculo (ou <?php echo \Session::get('label_celulas'); ?> Filho(a))</option>
                                                      <?php endif; ?>
                                                      </select>

                                                </div>
                                          </div>

                                          <div id="nao_imprimir_2" class="row">
                                              <div class="col-xs-11">
                                                      <label for="celulas_pai_id" class="control-label">Quem é a <?php echo \Session::get('label_celulas'); ?> Pai ?</label>
                                                      <select id="celulas_pai_id" placeholder="(Selecionar)" name="celulas_pai_id" data-live-search="true" data-none-selected-text="Nenhum item selecionado" class="form-control selectpicker" style="width: 100%;" >
                                                      <option  value="0"></option>
                                                      <?php foreach($celulas as $item): ?>
                                                              <?php if($tipo_operacao=="editar"): ?>
                                                                    <option  value="<?php echo e($item->id); ?>" <?php echo e($dados[0]->celulas_pai_id == $item->id ? "selected" : ""); ?>><?php echo e($item->nome); ?></option>
                                                               <?php else: ?>
                                                                    <option  value="<?php echo e($item->id); ?>"><?php echo e($item->nome); ?></option>
                                                               <?php endif; ?>
                                                      <?php endforeach; ?>
                                                      </select>
                                              </div>
                                        </div>

                                        <br/>
                                        <div class="row">
                                            <div class="col-md-12">
                                              <!-- Widget: user widget style 1 -->
                                              <div id="arvore" class="box box-widget">

                                                <div class="box-footer no-padding">

                                                  <div id="nao_imprimir_3" class="row">
                                                      <div class="col-md-12">
                                                           <a href="#" onclick="window.print();"><i class="fa fa-print"></i>&nbsp;Clique Aqui para Imprimir (<i>Será necessário expandir a Árvore Hierárquica antes da impressão</i>)</a>
                                                     </div>
                                                  </div>

                                                  <?php if(isset($nome_lider_anterior)): ?>
                                                      <?php if($nome_lider_anterior!=""): ?>
                                                      <div class="row">
                                                          <div class="col-md-12">
                                                                <br/>
                                                                <?php if(isset($dados[0]->total_ant)): ?>
                                                                <b><?php echo $nome_lider_anterior; ?> era o líder anterior e a quantidade atual de sua geração é : <?php echo $dados[0]->total_ant; ?></b>
                                                                <?php endif; ?>
                                                          </div>
                                                      </div>
                                                      <?php endif; ?>
                                                  <?php endif; ?>

                                                  <div class="row">
                                                    <div class="col-md-12">
                                                     <div id="printable" class="box-header with-border">
                                                      <?php if(isset($gerar_estrutura_origem)): ?>
                                                            <?php echo $gerar_estrutura_origem; ?>

                                                      <?php endif; ?>
                                                     </div>
                                                  </div>
                                                </div>

                                              </div>
                                            </div>
                                          </div>
                                       </div>

                                    </div><!--  END TABS-->

                         </div> <!-- TAB CONTENTS -->

                      </div> <!-- nav-tabs-custom -->

        </div>
    </div>
  </div>
</div>

   <div class="box-footer">
       <button class = 'btn btn-primary' type ='submit' <?php echo e(($preview=='true' ? 'disabled=disabled' : "" )); ?> ><i class="fa fa-save"></i> Salvar</button>
       <a href="#" class="btn btn-warning" onclick="salvar_e_incluir();" <?php echo e(($preview=='true' ? 'disabled=disabled' : "" )); ?> ><i class="fa fa-users"></i> Salvar e Incluir Participantes</a>
       <a href="<?php echo e(url('/' . \Session::get('route') )); ?>" class="btn btn-default">Cancelar</a>
       <br/><span class="text-danger">*</span><i>Campos Obrigatórios</i>
   </div>

   </form>

 </div>

</div>

<?php echo $__env->make('configuracoes.script_estruturas', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

<script type="text/javascript">

    function remover_pessoa(var_objeto)
    {
        $('#' + var_objeto).val('');
    }

    $(document).ready(function()
    {

           $("#menu_celulas").addClass("treeview active");

            /*quando carregar a pagina e estiver preenchido o nivel4, dispara o evento que carrega as outras dropdows.*/
            if ($("#nivel5").val()!="")
            {
                  $("#nivel5").trigger("change");
            }

          if ($('#local').val()==6)
          {
               $("#div_endereco").show();
          }

          //Quando selecionar outro tipo de endereco para encontro
          $("#local").change(function()
          {

               if ($(this).val()==6)
               {
                    $("#div_endereco").show();
               } else {
                    $("#div_endereco").hide();
               }

          });

    });

    function salvar_e_incluir()
    {

          if ($('#hidden_existe').val()!="0")
          {
              $('#quero_incluir_participante').val('sim');
          }
          else
          {
               $('#quero_incluir_participante').val('simnovo');
          }

          $('#form_celulas')[0].submit();
    }

</script>


<?php $__env->stopSection(); ?>

<?php echo $__env->make('principal.master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>