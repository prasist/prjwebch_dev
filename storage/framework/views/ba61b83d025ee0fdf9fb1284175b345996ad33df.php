<!-- Left side column. contains the logo and sidebar -->

<aside class="main-sidebar">
  <!-- sidebar: style can be found in sidebar.less -->
  <section class="sidebar">
    <!-- Sidebar user panel -->
    <div class="user-panel">

      <div id="tour1"></div>
      <div id="tour3_visaogeral"></div>

      <!--Foto usuário -->
      <div class="pull-left image">

        <?php if(Auth::user()->path_foto!=""): ?>
        <img src="<?php echo e(url('/images/users/' . Auth::user()->path_foto)); ?>" class="img-circle" alt="Usuário Logado" />
        <?php else: ?>
        <img src="<?php echo e(url('/images/users/user.png')); ?>" class="img-circle" alt="Usuário Logado" />
        <?php endif; ?>

      </div>
      <!-- ************* -->

      <!-- Usuário logado-->
      <div class="pull-left info">
        <p><?php echo e(Auth::user()->name); ?></p>
        <a href="<?php echo e(URL::to('profile/' . Auth::user()->id . '/perfil')); ?>"><i class="fa fa-user text-success"></i> Alterar Perfil</a>
      </div>
      <!-- ************** -->
    </div>

    <!-- search form -->
    <!--<form action="#" method="get" id="form_procurar_pessoa" class="sidebar-form">-->
    <?php if(Auth::user()->membro!="S"): ?>
    <form name ="form_principal" method = 'get' class="sidebar-form"  action = "<?php echo e(url('/pessoas/buscar_nome')); ?>">
      <div class="input-group">
        <input type="text" name="razaosocial" id="razaosocial" class="form-control" placeholder="Localizar Pessoas...">
        <span class="input-group-btn">
          <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
          </button>
        </span>
      </div>
    </form>
    <?php endif; ?>

    <!--Menu Principal -->
    <ul class="sidebar-menu">
      <li class="header">Menu Principal</li>

      <?php if (app('Illuminate\Contracts\Auth\Access\Gate')->check('verifica_permissao_modulo', ['Configurações'])): ?>
      <li class="treeview" id="menu_config">
        <a href="#" title="Alterar e Incluir Dados Cadastrais da Igreja Sede e Igrejas / Instituições e Configurações do serviço de mensagens">
          <i class="fa fa-wrench"></i> <span>Configurações</span>
          <i class="fa fa-angle-left pull-right"></i>
        </a>
        <ul class="treeview-menu">

          <?php if(Gate::check('verifica_permissao', [1 ,'acessar'])): ?>
          <li><a href="<?php echo e(url('/clientes')); ?>"><i class="fa fa-angle-double-right"></i> Igreja Sede</a></li>
          <?php endif; ?>

          <?php if(Gate::check('verifica_permissao', [27 ,'acessar'])): ?>
          <li><a href="<?php echo e(url('/empresas')); ?>"><i class="fa fa-angle-double-right"></i> Igrejas / Instituições </a></li>
          <?php endif; ?>

          <?php if(Gate::check('verifica_permissao', [64 ,'acessar'])): ?>
          <li><a href="<?php echo e(url('/configmsg')); ?>"><i class="fa fa-angle-double-right"></i> Config Serviço SMS/Whatsapp </a></li>
          <?php endif; ?>

          <?php if(Gate::check('verifica_permissao', [70 ,'acessar'])): ?>
          <li><a href="<?php echo e(url('/config_gerais')); ?>"><i class="fa fa-angle-double-right"></i> Configurações Gerais </a></li>
          <?php endif; ?>

        </ul>
      </li>
      <?php endif; ?>


      <?php if (app('Illuminate\Contracts\Auth\Access\Gate')->check('verifica_permissao_modulo', ['Segurança'])): ?>
      <li class="treeview" id="menu_seguranca">
        <a href="#" title="Cadastrar Usuários, Grupos e Permissões de Acesso ao sistema...">
          <i class="fa fa-lock"></i> <span>Segurança</span> <i class="fa fa-angle-left pull-right"></i>
        </a>
        <ul  class="treeview-menu">
          <?php if(Gate::check('verifica_permissao', [2 ,'acessar'])): ?>
          <li>
            <a href="<?php echo e(url('/grupos')); ?>" title="Cadastro dos Grupos de acesso..."><i class="fa fa-angle-double-right"></i>Grupos de Usuário</a>
          </li>
          <?php endif; ?>

          <?php if(Gate::check('verifica_permissao', [3 ,'acessar'])): ?>
          <li>
            <a href="<?php echo e(url('/permissoes')); ?>" title="Aqui você informará quais permissões de acesso cada grupo terá..."><i class="fa fa-angle-double-right"></i>Grupo / Permissões</a>
          </li>
          <?php endif; ?>

          <?php if(Gate::check('verifica_permissao', [5 ,'acessar'])): ?>
          <li>
            <a href="<?php echo e(url('/usuarios')); ?>" title="Aqui você cadastra os usuários e os associa aos grupos de acesso que pertencerão..."><i class="fa fa-angle-double-right"></i>Usuários</a>
          </li>
          <?php endif; ?>

          <?php if(Gate::check('verifica_permissao', [61 ,'acessar'])): ?>
          <li>
            <a href="<?php echo e(url('/login_membros')); ?>" title="Gerar Login e Senha automaticamente para os membros..."><i class="fa fa-angle-double-right"></i>Criar Login para Membros</a>
          </li>
          <?php endif; ?>
        </ul>
      </li>
      <?php endif; ?>

      <div id="tour2"></div>

      <?php if (app('Illuminate\Contracts\Auth\Access\Gate')->check('verifica_permissao_modulo', ['Cadastros Base'])): ?>
      <li class="treeview" id="menu_cadastros_base">
        <a href="#" title="Cadastro de diversas tabelas de dados auxiliares, tais como Profissões, Cargos, Atividades, Ministérios, Grupos de Pessoas, etc...">
          <i class="fa fa-edit"></i> <span>Cadastros Base</span>
          <i class="fa fa-angle-left pull-right"></i>
        </a>
        <ul class="treeview-menu">

          <li class="text">&nbsp;</li>
          <li><a href="<?php echo e(url('/bancos')); ?>"><i class="fa fa-angle-double-right"></i>Bancos</a></li>
          <li><a href="<?php echo e(url('/cargos')); ?>"><i class="fa fa-angle-double-right"></i>Cargos / Funções</a></li>
          <li><a href="<?php echo e(url('/ramos')); ?>"><i class="fa fa-angle-double-right"></i>Ramos de Atividades</a></li>
          <li><a href="<?php echo e(url('/civis')); ?>"><i class="fa fa-angle-double-right"></i>Estados Civis</a></li>
          <li><a href="<?php echo e(url('/idiomas')); ?>"><i class="fa fa-angle-double-right"></i>Idiomas</a></li>
          <li><a href="<?php echo e(url('/graus')); ?>"><i class="fa fa-angle-double-right"></i>Graus de Instrução</a></li>
          <li><a href="<?php echo e(url('/areas')); ?>"><i class="fa fa-angle-double-right"></i>Áreas de Formação</a></li>
          <li><a href="<?php echo e(url('/profissoes')); ?>"><i class="fa fa-angle-double-right"></i>Profissões</a></li>
          <li><a href="<?php echo e(url('/grausparentesco')); ?>"><i class="fa fa-angle-double-right"></i>Graus de Parentesco</a></li>
          <li><a href="<?php echo e(url('/disponibilidades')); ?>"><i class="fa fa-angle-double-right"></i>Disponibilidades de Tempo</a></li>
          <li><a href="<?php echo e(url('/publicos')); ?>"><i class="fa fa-angle-double-right"></i>Públicos Alvos</a></li>
          <li><a href="<?php echo e(url('/faixas')); ?>"><i class="fa fa-angle-double-right"></i>Faixas Etárias</a></li>

          <li class="text">&nbsp;</li>
          <li><a href="<?php echo e(url('/cursos')); ?>"><i class="fa fa-angle-double-right"></i>Cursos / Eventos</a></li>
          <li><a href="<?php echo e(url('/igrejas')); ?>"><i class="fa fa-angle-double-right"></i>Igrejas</a></li>
          <li><a href="<?php echo e(url('/religioes')); ?>"><i class="fa fa-angle-double-right"></i>Religiões</a></li>
          <li><a href="<?php echo e(url('/ministerios')); ?>"><i class="fa fa-angle-double-right"></i>Ministérios</a></li>
          <li><a href="<?php echo e(url('/atividades')); ?>"><i class="fa fa-angle-double-right"></i>Atividades</a></li>
          <li><a href="<?php echo e(url('/dons')); ?>"><i class="fa fa-angle-double-right"></i>Dons Espirituais</a></li>
          <li><a href="<?php echo e(url('/habilidades')); ?>"><i class="fa fa-angle-double-right"></i>Habilidades</a></li>

          <li class="text">&nbsp;</li>
          <li><a href="<?php echo e(url('/status')); ?>"><i class="fa fa-angle-double-right"></i>Status</a></li>
          <li><a href="<?php echo e(url('/situacoes')); ?>"><i class="fa fa-angle-double-right"></i>Situações</a></li>
          <li><a href="<?php echo e(url('/tipospessoas')); ?>"><i class="fa fa-angle-double-right"></i>Tipos de Pessoas</a></li>
          <li><a href="<?php echo e(url('/grupospessoas')); ?>"><i class="fa fa-angle-double-right"></i>Grupos de Pessoas</a></li>
          <li class="text">&nbsp;</li>
          <li><a href="<?php echo e(url('/tipospresenca')); ?>"><i class="fa fa-angle-double-right"></i>Tipos de Presença</a></li>
          <li><a href="<?php echo e(url('/tiposmovimentacao')); ?>"><i class="fa fa-angle-double-right"></i>Tipos de Mov. Membros</a></li>
          <li><a href="<?php echo e(url('/tiposrelacionamentos')); ?>"><i class="fa fa-angle-double-right"></i>Tipos de Relacionamentos</a></li>
          <li><a href="<?php echo e(url('/questionarios')); ?>"><i class="fa fa-angle-double-right"></i>Questionário Padrão Encontros</a></li>

        </ul>
      </li>
      <?php endif; ?>

      <?php if (app('Illuminate\Contracts\Auth\Access\Gate')->check('verifica_permissao_modulo', ['Gestão de Pessoas'])): ?>
      <li class="treeview" id="menu_pessoas">
        <a href="#" title="Cadastro, consulta e relatórios de Membros e Pessoas em Geral...">
          <i class="fa fa-user"></i><span>Pessoas</span>
          <i class="fa fa-angle-left pull-right"></i>
        </a>
        <ul class="treeview-menu">
          <?php if(Gate::check('verifica_permissao', [28 ,'acessar'])): ?>
          <li><a href="<?php echo e(url('/pessoas')); ?>"><i class="fa fa-file-text-o"></i> Listar / Cadastrar</a></li>
          <?php endif; ?>

          <?php if(Gate::check('verifica_permissao', [47 ,'acessar'])): ?>
          <li><a href="<?php echo e(url('/relpessoas')); ?>"><i class="fa fa-print"></i> Relatórios</a></li>
          <?php endif; ?>

          <?php if(Gate::check('verifica_permissao', [69 ,'acessar'])): ?>
          <li><a href="<?php echo e(url('/relcursos')); ?>"><i class="fa fa-print"></i> Relatórios Cursos / Eventos</a></li>
          <?php endif; ?>
        </ul>
      </li>
      <?php endif; ?>


      <?php if (app('Illuminate\Contracts\Auth\Access\Gate')->check('verifica_permissao_modulo', ['Gestão de Células'])): ?>
      <!-- Células -->
      <li class="treeview" id="menu_celulas">

        <a href="#" onclick="redirecionar_celulas();" title="Gerencie <?php echo \Session::get('label_celulas'); ?>, planejamento <?php echo \Session::get('label_encontros'); ?>, configurações, relatórios e estatísticas...">
          <i class="fa fa-users"></i> <span><?php echo \Session::get('label_celulas'); ?></span>
          <i class="fa fa-angle-left pull-right"></i>
        </a>

        <ul class="treeview-menu">

            <li>
                <a href="<?php echo e(url('/dashboard_celulas')); ?>">
                      <i class="fa fa-bar-chart"></i>Visão Geral
                </a>
            </li>

            <?php if(Gate::check('verifica_permissao', [41 ,'acessar'])): ?>
             <li>
                 <a href="<?php echo e(url('/configuracoes')); ?>"><i class="fa fa-wrench"></i>Configurações</a>
             </li>
            <?php endif; ?>


            <?php if(Gate::check('verifica_permissao', [36 ,'acessar']) || Gate::check('verifica_permissao', [37 ,'acessar']) || Gate::check('verifica_permissao', [38 ,'acessar']) || Gate::check('verifica_permissao', [39 ,'acessar']) || Gate::check('verifica_permissao', [40 ,'acessar'])): ?>
            <li>
              <a href="#"><i class="fa fa-sitemap"></i> Estruturas <i class="fa fa-angle-left pull-right"></i></a>
              <ul class="treeview-menu">
                <li><a href="<?php echo e(url('/estruturas1')); ?>"> 1 - <?php echo e(Session::get('nivel1')); ?></a></li>
                <li><a href="<?php echo e(url('/estruturas2')); ?>"> 2 - <?php echo e(Session::get('nivel2')); ?></a></li>
                <li><a href="<?php echo e(url('/estruturas3')); ?>"> 3 - <?php echo e(Session::get('nivel3')); ?></a></li>
                <li><a href="<?php echo e(url('/estruturas4')); ?>"> 4 - <?php echo e(Session::get('nivel4')); ?></a></li>
                <li><a href="<?php echo e(url('/estruturas5')); ?>"> 5 - <?php echo e(Session::get('nivel5')); ?></a></li>
              </ul>
            </li>
            <?php endif; ?>
       </ul>

          <?php if(Gate::check('verifica_permissao', [42 ,'acessar'])): ?>
          <ul class="treeview-menu">
            <li>
              <a href="<?php echo e(url('/celulas/registrar')); ?>"><i class="fa fa-plus"></i> Incluir <?php echo \Session::get('label_celulas_singular'); ?></a>
            </li>
          </ul>
          <?php endif; ?>

          <?php if(Gate::check('verifica_permissao', [42 ,'acessar'])): ?>
          <ul class="treeview-menu">
            <li>
              <a href="<?php echo e(url('/celulas')); ?>" title="Lista todas <?php echo \Session::get('label_celulas'); ?> cadastradas e a quantidade de <?php echo \Session::get('label_participantes'); ?>..."><i class="fa  fa-list-alt"></i> Listar</a>
            </li>
          </ul>
          <?php endif; ?>

          <?php if(Gate::check('verifica_permissao', [45 ,'acessar'])): ?>
          <ul class="treeview-menu">
            <li>
              <a href="<?php echo e(url('/celulaspessoas')); ?>" title="Incluir Pessoas para <?php echo \Session::get('label_celulas'); ?>..."> <i class="fa fa-user-plus"></i> <?php echo \Session::get('label_participantes'); ?> </i></a>
            </li>
          </ul>
          <?php endif; ?>


          <?php if(Gate::check('verifica_permissao', [67 ,'acessar']) || Gate::check('verifica_permissao', [68 ,'acessar'])): ?>
          <ul class="treeview-menu">
            <li>
              <a href="#" title="Movimentação de Membros entre <?php echo \Session::get('label_celulas'); ?>..."><i class="fa fa-exchange"></i> Movimentação Membros <i class="fa fa-angle-left pull-right"></i></a>
                  <ul class="treeview-menu">
                      <?php if(Gate::check('verifica_permissao', [67 ,'acessar'])): ?>
                      <li><a href="<?php echo e(url('/membersmove')); ?>"> Nova Movimentação</a></li>
                      <?php endif; ?>

                      <?php if(Gate::check('verifica_permissao', [68 ,'acessar'])): ?>
                      <li><a href="<?php echo e(url('/relmovimentacoes')); ?>"> Relatórios</a></li>
                      <?php endif; ?>
                  </ul>
            </li>
          </ul>
          <?php endif; ?>


          <!--<ul class="treeview-menu">
            <li>
              <a href="#"><i class="fa fa-sitemap"></i> Encontros <i class="fa fa-angle-left pull-right"></i></a>
              -->
              <ul class="treeview-menu">
               <?php if(Gate::check('verifica_permissao', [58 ,'acessar'])): ?>
               <li><a href="<?php echo e(url('/controle_atividades')); ?>" title="Controle a presença dos membros e visitantes, envie material <?php echo \Session::get('label_encontros'); ?>..."> <i class="fa fa-check"></i> Gerenciar <?php echo \Session::get('label_encontros'); ?></a></li>
               <?php endif; ?>

               <?php if(Gate::check('verifica_permissao', [65 ,'acessar'])): ?>
               <li><a href="<?php echo e(url('/relencontro')); ?>" title="Relatórios Estatístico dos <?php echo \Session::get('label_encontros'); ?>, <?php echo \Session::get('label_participantes'); ?> <?php echo \Session::get('label_celulas'); ?>..."> <i class="fa fa-print"></i> Relatório <?php echo \Session::get('label_encontros'); ?></a></li>
               <?php endif; ?>

             </ul>

            <!--
           </li>
         </ul>-->

         <?php if(Gate::check('verifica_permissao', [46 ,'acessar'])): ?>
         <ul class="treeview-menu">
          <li>
            <a href="<?php echo e(url('/relcelulas')); ?>"><i class="fa fa-print"></i> Relatório <?php echo \Session::get('label_celulas'); ?></a>
          </li>
        </ul>
        <?php endif; ?>




    </li>
    <?php endif; ?>

    <?php if (app('Illuminate\Contracts\Auth\Access\Gate')->check('verifica_permissao_modulo', ['Financeiro'])): ?>
    <li class="treeview" id="financ">

      <a href="#" onclick="redirecionar();">
        <i class="fa fa-usd"></i><span>Financeiro</span>
        <i class="fa fa-angle-left pull-right"></i>
      </a>

      <ul class="treeview-menu">

       <li><a href="<?php echo url('/financeiro'); ?>"><i class="fa fa-bar-chart"></i>Visão Geral</a></li>
       <li>
        <a href="#"><i class="fa fa-file-text-o"></i>Cadastros Base <i class="fa fa-angle-left pull-right"></i></a>
        <ul class="treeview-menu">
          <?php if(Gate::check('verifica_permissao', [35 ,'acessar'])): ?>
          <li><a href="<?php echo url('/bancos'); ?>">Bancos</a></li>
          <?php endif; ?>

          <?php if(Gate::check('verifica_permissao', [51 ,'acessar'])): ?>
          <li><a href="<?php echo url('/grupos_titulos'); ?>"> Grupos de Títulos</a></li>
          <?php endif; ?>

          <?php if(Gate::check('verifica_permissao', [49 ,'acessar'])): ?>
          <li><a href="<?php echo url('/planos_contas'); ?>"> Planos de Contas</a></li>
          <?php endif; ?>

          <?php if(Gate::check('verifica_permissao', [50 ,'acessar'])): ?>
          <li><a href="<?php echo url('/centros_custos'); ?>"> Centros de Custos</a></li>
          <?php endif; ?>

          <?php if(Gate::check('verifica_permissao', [48 ,'acessar'])): ?>
          <li><a href="<?php echo url('/contas'); ?>"> Contas Correntes</a></li>
          <?php endif; ?>
        </ul>
      </li>


      <?php if(Gate::check('verifica_permissao', [52 ,'acessar'])): ?>
      <li>
        <a href="#"><i class="fa fa-calendar-plus-o"></i>Contas a Pagar <i class="fa fa-angle-left pull-right"></i></a>
        <ul class="treeview-menu">
          <li><a href="<?php echo url('/titulos/P'); ?>">Lançamentos</a></li>
        </ul>
      </li>
      <?php endif; ?>

      <?php if(Gate::check('verifica_permissao', [52 ,'acessar'])): ?>
      <li>
        <a href="#"><i class="fa fa-money"></i>Contas a Receber <i class="fa fa-angle-left pull-right"></i></a>
        <ul class="treeview-menu">
          <li><a href="<?php echo url('/titulos/R'); ?>">Lançamentos</a></li>
        </ul>
      </li>
      <?php endif; ?>

      <!--
      <li>
        <a href="#"><i class="fa fa-angle-double-right"></i>Transferências</i></a>
      </li>
      -->

      <?php if(Gate::check('verifica_permissao', [53 ,'acessar'])): ?>
      <li>
        <a href="<?php echo url('/relfinanceiro'); ?>"><i class="fa fa-print"></i>Relatórios</a>
      </li>
      <?php endif; ?>

    </ul>

  </li>
  <?php endif; ?>

  <?php if(Gate::check('verifica_permissao', [59 ,'acessar'])): ?>
  <li class="treeview">
    <a href="<?php echo e(url('/mensagens')); ?>">
      <i class="fa fa-commenting-o"></i> <span>Enviar SMS/Whatsapp</span>
    </a>
  </li>
  <?php endif; ?>

  <?php if(Gate::check('verifica_permissao', [60 ,'acessar'])): ?>
  <li class="treeview">
    <a href="<?php echo e(url('/home')); ?>">
      <i class="fa fa-users"></i> <span><?php echo \Session::get('label_celulas'); ?></span>
    </a>
  </li>
  <?php endif; ?>

  <?php if(Auth::user()->membro!="S"): ?>
  <li class="header">Precisa de Ajuda ?</li>
  <li class="treeview">
    <a href="#">
      <i class="fa fa-book"></i> <span>Ajuda / Documentação</span>
      <i class="fa fa-angle-left pull-right"></i>
    </a>

    <ul class="treeview-menu">
      <li>
        <a href="#"><i class="fa fa-angle-double-right"></i>Tour Rápido </i></a>
        <ul class="treeview-menu">
          <li><a href="<?php echo e(url('/quicktour/reload/2')); ?>"><i class="fa fa-flag-checkered"></i> Visão Geral do SIGMA3</a></li>
          <?php if(\Session::get('admin')==1): ?>
          <li><a href="<?php echo e(url('/quicktour/reload/1')); ?>"><i class="fa fa-flag-checkered"></i> Cadastrar Novo Usuário</a></li>
          <?php endif; ?>
        </ul>
      </li>

      <li>
        <a href="#"><i class="fa fa-angle-double-right"></i>Tutoriais</i></a>
        <ul class="treeview-menu">
          <li><a href="<?php echo e(url('/tutoriais/1')); ?>">Cadastro de Usuários</a></li>
          <li><a href="<?php echo e(url('/tutoriais/2')); ?>">Novo Usuário Administrador</a></li>
          <li><a href="<?php echo e(url('/tutoriais/3')); ?>">Criando Login do Membro</a></li>
          <li><a href="<?php echo e(url('/tutoriais/3')); ?>">Criando Login do <?php echo \Session::get('label_lider_singular'); ?></a></li>
          <li><a href="<?php echo e(url('/tutoriais/4')); ?>">Criando (<?php echo \Session::get('label_celulas'); ?>)</a></li>
          <li><a href="<?php echo e(url('/tutoriais/5')); ?>">Gerenciando <?php echo \Session::get('label_encontros'); ?></a></li>
        </ul>
      </li>
    </ul>

    <div id="tour5_visaogeral"></div>

  </li>
  <?php endif; ?>

  <li class="treeview">
    <a href=<?php echo e(url('/suporte')); ?>>
      <i class="fa fa-question-circle"></i> <span>Suporte</span>
    </a>
  </li>

</section>
<!-- /.sidebar -->
</aside>
<script type="text/javascript">

  function redirecionar()
  {

    var_pagina = "<?php echo url('/financeiro'); ?>";
    window.location=var_pagina;

  }

  function redirecionar_celulas()
  {

    var_pagina = "<?php echo url('/dashboard_celulas'); ?>";
    window.location=var_pagina;

  }
</script>