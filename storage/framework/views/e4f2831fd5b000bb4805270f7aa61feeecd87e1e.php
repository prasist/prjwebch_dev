<?php $__env->startSection('content'); ?>

<!-- retirdado composer.json "barryvdh/laravel-debugbar": "^2.1",-->
<div class="container">

 <div class="row">

         <br/>
        <center>
        <a  href="<?php echo e(url('http://sigma3sistemas.com.br')); ?>"><img src="<?php echo e(url('/images/clients/logo_sigma3.png')); ?>" class="user-image" alt="Usuário Logado" width="100" height="30" /></a>
        <p>Sistema de Gestão para Igrejas</p>
        </center>

    </div>

    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Bem-Vindo</div>

                <div class="panel-body">


                 <?php if(isset($erros)): ?>
                     <?php if($erros): ?>
                    <div class="alert alert-danger alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <h4><i class="icon fa fa-ban"></i> Atenção!</h4>
                    <?php echo e($erros); ?>

                    <br/>
                    Ao tentar logar novamente a outra conexão será finalizada.
                    </div>
                    <?php endif; ?>
                <?php endif; ?>

                <ul>

                        <li>
                                <?php if(Auth::user()): ?>
                                    Usuário <b><?php echo Auth::user()->name; ?></b> com sessão ativa.
                                <?php endif; ?>
                               <a  href="<?php echo e(url('/home')); ?>">Retonar ao SIGMA3</a>
                        </li>

                        <li>
                                <a  href="<?php echo e(url('http://sigma3sistemas.com.br')); ?>">Retonar ao site</a>
                        </li>

                        <li>
                                <a  href="<?php echo e(url('/login')); ?>">Logar Novamente</a>
                        </li>

                </ul>

                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>