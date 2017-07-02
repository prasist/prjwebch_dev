<?php $__env->startSection('content'); ?>

<?php echo e(\Session::put('titulo', \Session::get('label_celulas'))); ?>

<?php echo e(\Session::put('subtitulo', 'Listagem')); ?>

<?php echo e(\Session::put('route', 'celulas')); ?>

<?php echo e(\Session::put('id_pagina', '42')); ?>



        <div><?php echo e($errors->first('erros')); ?></div>

        <div class="row">
                <div class="col-xs-2">
                <?php if (app('Illuminate\Contracts\Auth\Access\Gate')->check('verifica_permissao', [ \Session::get('id_pagina'),'incluir'])): ?>
                  <form method = 'get' class="form-horizontal" action = "<?php echo e(url('/' . \Session::get('route') . '/registrar')); ?>">
                        <button class = 'btn btn-success btn-flat' type ='submit'><i class="fa fa-file-text-o"></i> Criar <?php echo \Session::get('label_celulas_singular'); ?></button>
                  </form>
                <?php endif; ?>
                </div>

                <div class="col-xs-3">
                    <a href="<?php echo e(url('/tutoriais/4')); ?>" data-toggle="tooltip" title="Clique Aqui para ver o tutorial..." target="_blank">
                        <i class="glyphicon glyphicon-question-sign text-success"></i>&nbsp;Como cadastrar <?php echo \Session::get('label_celulas'); ?> ?
                   </a>
                </div>

               <div class="col-xs-5">
                        <p class="text"><i> Legendas</i></p>
                        <span class="badge bg-yellow">0</span>&nbsp;Quantidade <?php echo \Session::get('label_celulas_singular'); ?> Multiplicadas (Primeira Geração)
                        <br/>
                        <span class="badge bg-purple">0</span>&nbsp;Quantidade <?php echo \Session::get('label_celulas_singular'); ?> Multiplicadas (Segunda Geração)
                        <br/>
                        <span class="badge bg-blue">0</span>&nbsp;Quantidade de <?php echo \Session::get('label_participantes'); ?>

                        <br/>
              </div>

        </div>


        <div class="row">
        <div class="col-md-12">
          <div class="box">
            <div class="box-header">

                <div class="box-body table-responsive no-padding">

                    <table id="table_celulas" class="table table-responsive table-hover">
                    <thead>
                        <tr>
                        <th>Nome <?php echo \Session::get('label_celulas_singular'); ?></th>
                        <th><?php echo \Session::get('label_lider_singular'); ?></th>
                        <th>Dia Encontro</th>
                        <th>Região</th>
                        <th>Horário</th>
                        <th>Cor</th>
                        <th>Alterar</th>
                        <th>Visualizar</th>
                        <th>Excluir</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($dados as $value): ?>

                        <tr>

                            <td>
                                  <?php if (app('Illuminate\Contracts\Auth\Access\Gate')->check('verifica_permissao', [\Session::get('id_pagina') ,'alterar'])): ?>
                                  <a href = "<?php echo e(URL::to(\Session::get('route') .'/' . $value->id . '/edit')); ?>" data-toggle="tooltip" data-placement="top" title="Clique para Alterar">
                                       <?php echo $value->nome; ?>

                                  </a>
                                  <?php else: ?>
                                        <?php if (app('Illuminate\Contracts\Auth\Access\Gate')->check('verifica_permissao', [\Session::get('id_pagina') ,'visualizar'])): ?>
                                                <a href = "<?php echo e(URL::to(\Session::get('route') .'/' . $value->id . '/preview')); ?>" >
                                                      <?php echo $value->nome; ?>

                                                </a>
                                        <?php else: ?>
                                                <?php echo $value->nome; ?>

                                        <?php endif; ?>
                                  <?php endif; ?>
                            </td>

                            <td>
                                  <?php if (app('Illuminate\Contracts\Auth\Access\Gate')->check('verifica_permissao', [\Session::get('id_pagina') ,'alterar'])): ?>
                                  <a href = "<?php echo e(URL::to(\Session::get('route') .'/' . $value->id . '/edit')); ?>" data-toggle="tooltip" data-placement="top" title="Clique para Alterar">
                                       <?php echo $value->razaosocial; ?> <span class="badge bg-blue"><?php echo $value->tot; ?></span>
                                  </a>
                                  <?php else: ?>
                                        <?php if (app('Illuminate\Contracts\Auth\Access\Gate')->check('verifica_permissao', [\Session::get('id_pagina') ,'visualizar'])): ?>
                                                <a href = "<?php echo e(URL::to(\Session::get('route') .'/' . $value->id . '/preview')); ?>" >
                                                      <?php echo $value->razaosocial; ?> <span class="badge bg-blue"><?php echo $value->tot; ?></span>
                                                </a>
                                        <?php else: ?>
                                                <?php echo $value->razaosocial; ?> <span class="badge bg-blue"><?php echo $value->tot; ?></span>
                                        <?php endif; ?>
                                  <?php endif; ?>
                                  <?php if($value->tot_geracao>0): ?>
                                  <span class="badge bg-yellow"><?php echo ($value->tot_geracao); ?></span>
                                  <?php endif; ?>
                                  <?php if(isset($value->total_ant)): ?>
                                      <?php if($value->total_ant>0): ?>
                                      <span class="badge bg-purple"><?php echo ($value->total_ant); ?></span>
                                      <?php endif; ?>
                                  <?php endif; ?>
                            </td>

                            <td><?php echo $value->descricao_dia_encontro; ?></td>
                            <td><?php echo $value->regiao; ?></td>
                            <td><?php echo $value->horario; ?></td>
                            <td style="color: #<?php echo rtrim(ltrim($value->cor)); ?>;  background-color:#<?php echo rtrim(ltrim($value->cor)); ?>;">
                                  <?php echo rtrim(ltrim($value->cor)); ?>

                            </td>

                            <td class="col-xs-1">
                                      <?php if (app('Illuminate\Contracts\Auth\Access\Gate')->check('verifica_permissao', [\Session::get('id_pagina') ,'alterar'])): ?>
                                            <a href = "<?php echo e(URL::to(\Session::get('route') .'/' . $value->id . '/edit')); ?>" class = 'btn  btn-info btn-sm'><spam class="glyphicon glyphicon-pencil"></spam></a>
                                      <?php endif; ?>
                            </td>

                            <td class="col-xs-1">
                                      <?php if (app('Illuminate\Contracts\Auth\Access\Gate')->check('verifica_permissao', [\Session::get('id_pagina') ,'visualizar'])): ?>
                                               <a href = "<?php echo e(URL::to(\Session::get('route') .'/' . $value->id . '/preview')); ?>" class = 'btn btn-primary btn-sm'><span class="glyphicon glyphicon-zoom-in"></span></a>
                                      <?php endif; ?>
                            </td>

                            <td class="col-xs-1">
                                      <?php if (app('Illuminate\Contracts\Auth\Access\Gate')->check('verifica_permissao', [ \Session::get('id_pagina') ,'excluir'])): ?>
                                      <form id="excluir<?php echo e($value->id); ?>" action="<?php echo e(URL::to(\Session::get('route') . '/' . $value->id . '/delete')); ?>" method="DELETE">

                                            <button
                                                data-toggle="tooltip" data-placement="top" title="Excluir Registro" type="submit"
                                                class="btn btn-danger btn-sm"
                                                onclick="return confirm('Confirma exclusão do registro ?');">
                                                <spam class="glyphicon glyphicon-trash"></spam></button>

                                      </form>
                                      <?php endif; ?>
                            </td>


                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                    </table>
                </div>
            </div>
          </div>
         </div>
        </div>

<script type="text/javascript">
    $(document).ready(function() {
        $("#menu_celulas").addClass("treeview active");
    });
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('principal.master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>