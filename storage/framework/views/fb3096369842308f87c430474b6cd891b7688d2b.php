<header class="main-header">
    <!-- Logo -->
    <a href="<?php echo e(url('/home')); ?>" class="logo">
        <img src="<?php echo e(url('/images/clients/logo_sigma3.png')); ?>" class="user-image" alt="Usuário Logado" width="100" height="30" />
    </a>

    <nav class="navbar navbar-static-top" role="navigation">

        <div id="tour4_visaogeral"></div>
        <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
        <span class="sr-only">Navegação</span>
        </a>

        <div class="navbar-custom-menu">

            <ul class="nav navbar-nav">

               <li class="dropdown messages-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                    <spam><b><?php echo \Session::get('nome_igreja'); ?></b></spam>
                    <span class="label label-success"></span>
                    </a>
                </li>

                <li class="dropdown messages-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                    <i class="fa fa-envelope-o"></i>
                    <span class="label label-success"></span>
                    </a>
                    <ul class="dropdown-menu">
                        <li class="header">Você não tem novas mensagens</li>
                        <li>
                            <!-- inner menu: contains the actual data -->
                            <ul class="menu">
                                <li><!-- start message -->

                                        <!--
                                        <a href="#">
                                        <div class="pull-left">
                                            <!--<img src="<?php echo e(asset('dist/img/user2-160x160.jpg')); ?>" class="img-circle" alt="User Image"/>
                                        </div>
                                        <h4>
                                        Support Team
                                        <small><i class="fa fa-clock-o"></i> 5 mins</small>
                                        </h4>
                                        <p>Why not buy a new awesome theme?</p>
                                        </a>
                                        -->
                                </li><!-- end message -->


                            </ul>
                        </li>
                        <li class="footer"><a href="#">Ver todas mensagens</a></li>
                    </ul>
                </li>


                <li class="dropdown notifications-menu">

                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                    <div id="aviso_mensagens"></div>
                    <i class="fa fa-bell-o"></i>
                    <?php if(isset($avisos)): ?>
                            <?php if(count($avisos)>0): ?>
                                    <span class="label label-danger"><?php echo count($avisos); ?></span>
                           <?php endif; ?>
                    <?php endif; ?>
                    </a>

                    <ul class="dropdown-menu">
                        <li class="header">Notificações</li>
                        <li>

                            <ul class="menu">
                                <?php if(isset($avisos)): ?>
                                        <?php foreach($avisos as $item): ?>
                                        <li>
                                                <a href="<?php echo e(url('/avisos/ler/' . $item->id . '')); ?>">
                                                        <i class="fa fa-bullhorn text-aqua"></i>&nbsp;<?php echo e($item->titulo); ?>

                                                </a>
                                        </li>
                                        <?php endforeach; ?>
                                <?php endif; ?>

                            </ul>
                        </li>
                        <li class="footer"><a href="<?php echo e(url('/avisos/listar')); ?>">Ver Todas</a></li>
                    </ul>
                </li>


                <li class="dropdown user user-menu">
                    <div id="tour2_visaogeral"></div>
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <!--<img src="<?php echo e(asset('dist/img/user2-160x160.jpg')); ?>" class="user-image" alt="User Image"/>-->
                        <?php if(Auth::user()->path_foto!=""): ?>
                                <img src="<?php echo e(url('/images/users/' . Auth::user()->path_foto)); ?>" class="user-image" alt="Usuário Logado" />
                        <?php else: ?>
                                <img src="<?php echo e(url('/images/users/user.png')); ?>" class="user-image" alt="Usuário Logado" />
                        <?php endif; ?>
                            <?php echo Auth::user()->name; ?>

                    </a>
                    <ul class="dropdown-menu">
                        <!-- User image -->
                        <li class="user-header">
                            <!--<img src="<?php echo e(asset('dist/img/user2-160x160.jpg')); ?>" class="img-circle" alt="User Image" />-->
                            <?php if(Auth::user()->path_foto!=""): ?>
                                    <img src="<?php echo e(url('/images/users/' . Auth::user()->path_foto)); ?>" class="user-image" alt="Usuário Logado" />
                            <?php else: ?>
                                    <img src="<?php echo e(url('/images/users/user.png')); ?>" class="user-image" alt="Usuário Logado" />
                            <?php endif; ?>

                            <p>
                            <?php echo e(Auth::user()->name); ?>

                            <small>
                                Último Acesso : <?php echo \Session::get('ultimo_acesso'); ?>

                                <br/>
                                I.P. : <?php echo \Session::get('ip'); ?>

                            </small>
                            </p>
                        </li>


                        <!-- Menu Footer-->
                        <li class="user-footer">
                            <div class="pull-left">
                                <a href="<?php echo e(URL::to('profile/' . Auth::user()->id . '/perfil')); ?>" class="btn btn-default btn-flat"><i class="fa fa-user"></i> Perfil</a>
                            </div>
                            <div class="pull-right">
                                <a href="<?php echo e(url('/logout')); ?>" class="btn btn-default"><i class="fa fa-power-off"></i> Encerrar Sessão</a>
                            </div>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </nav>
</header>