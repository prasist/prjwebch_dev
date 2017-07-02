<?php $__env->startSection('content'); ?>

     <div class="error-page">
            <h2 class="headline text-yellow">404</h2>
            <div class="error-content">
              <h3><i class="fa fa-warning text-yellow"></i> Página não encontrada.</h3>
              <p>
                A página requisitada não foi encontrada, verifique se houve algum erro de digitação e tente novamente.
                <br/>
                <br/>
                <a href="<?php echo e(URL('/home')); ?>">Voltar para Página Inicial</a>
              </p>

            </div><!-- /.error-content -->
          </div><!-- /.error-page -->

<?php $__env->stopSection(); ?>
<?php echo $__env->make('principal.master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>