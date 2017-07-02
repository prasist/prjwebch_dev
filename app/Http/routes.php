<?php


    Route::get('minhaigreja', 'MinhaIgreja@index');
    Route::post('minhaigreja/enviar', 'MinhaIgreja@enviar_email');

    Route::get('/', function ()
    {
        return view('home');
    });

    Route::group(['middleware' => ['web']], function ()
    {
        //
    });

    Route::group(['middleware' => 'web'], function ()
    {

        Route::auth();

        /*Logout do sistema*/
        Route::get('logout', function() {

            Auth::logout();
            \Session::flush();
            //return view('home', ['erros'=>'']);
            return Redirect::away('http://www.sigma3sistemas.com.br');

        });

        /*Validacao de login em outra maquina*/
        Route::get('userlogged', 'HomeController@jalogado');

        /*Rota inicial*/
        Route::get('/home', 'HomeController@index');


        Route::get('errors.404', function() {

            return view('errors.404');

       });

    /*Canais de suporte*/
    Route::get('suporte', function ()
    {
          return view('suporte.suporte');

    });


Route::get('relpessoas/relatorio_pessoas_tipo/{tipo}/{opcao}', 'RelatorioPessoasController@relatorio_pessoas_tipo');

Route::get('relcursos', 'RelatorioCursosController@index'); /*PAGINA INICIAL DOS RELATORIOS (FILTROS)*/
Route::post('relcursos/pesquisar/{tipo}', 'RelatorioCursosController@pesquisar');  /*RELATORIO DE CELULAS, PASSANDO PARAMETRO "CELULAS" GERARÁ O RELATÓRIO DE CELULAS, OU "ENCONTRO" PARA RELATORIOS DOS ENCONTROS*/

/*--------------------------RELATÓRIOS ENVOLVENDO CÉLULAS / PESSOAS-------------------------*/
Route::get('/relmovimentacoes','RelatorioCelulasController@index_movimentacoes'); /*RELATORIO DE MOVIMENTACOES*/
Route::post('/relmovimentacoes/{tipo}','RelatorioCelulasController@pesquisar'); /*RELATORIO DE CELULAS, PASSANDO PARAMETRO "MOVIMENTACOES" GERARÁ O RELATÓRIO DE MOVIMENTACOES DE MEMBROS*/
Route::post('relcelulas/pesquisar/{tipo}', 'RelatorioCelulasController@pesquisar');  /*RELATORIO DE CELULAS, PASSANDO PARAMETRO "CELULAS" GERARÁ O RELATÓRIO DE CELULAS, OU "ENCONTRO" PARA RELATORIOS DOS ENCONTROS*/
Route::get('estatisticas/{id}', 'RelatorioCelulasController@estatisticas'); /*RELATORIOS ESTATISTICOS CELULAS (MULTIPLICACOES, BATISMOS, QUANTIDADE GERAL)*/
Route::get('estatisticas_nivel/{id}/{nivel}/{valor}/{nome}/{saida}', 'RelatorioCelulasController@estatisticas_nivel');  /*RELATORIO ESTATISTICOS CONFORME NIVEL HIERARQUICO SELECIONADO*/
Route::get('relcelulas', 'RelatorioCelulasController@index'); /*PAGINA INICIAL DOS RELATORIOS (FILTROS)*/


/*VALIDACAO DADOS CADASTRAIS*/
Route::get('pessoas/validar', 'PessoasController@validacao_dados');
Route::get('pessoas/validar/{tipo}', 'PessoasController@listar_validacao');

 /*Movimentacao Membros*/
Route::get('membersmove', 'MembersMoveController@index');
Route::post('/membersmove/gravar','MembersMoveController@store');

//Avisos dos sistema
Route::get('/avisos/ler/{id}','AvisosController@show');
Route::get('/avisos/listar','AvisosController@listar');

Route::get('/celulas/buscar_estruturas','CelulasController@getEstruturas');

//Alteracao dados membro  - area do membro
Route::post('/membro_dados/gravar','MembroDadosController@store');
Route::get('membro_dados/{id}/edit','MembroDadosController@edit');
Route::post('membro_dados/{id}/update','MembroDadosController@update');

Route::post('checkin/{controle_atividades}/{pessoas}/{user}','ControleAtividadesController@checkin');

Route::get('config_gerais/json','ConfigGeraisController@index_json');
Route::get('config_gerais','ConfigGeraisController@index');
Route::post('config_gerais/{id}/update','ConfigGeraisController@update');

/*configuracao*/
Route::get('configmsg','ConfigMsgController@index');
Route::post('configmsg/{id}/update','ConfigMsgController@update');
Route::post('/configmsg/gravar','ConfigMsgController@store');


/*Login membros*/
    Route::get('login_membros', 'LoginMembroController@index');
    Route::post('/login_membros/gravar','LoginMembroController@store');
    Route::get('/login_membros/registrar','LoginMembroController@create');
    Route::get('/login_membros/{id}/preview','LoginMembroController@show');
    Route::get('login_membros/{id}/edit','LoginMembroController@edit');
    Route::get('login_membros/{id}/delete','LoginMembroController@destroy');

    //Envio SMS e Whatsapp
    Route::get('mensagens', 'MensagensController@create');
    Route::post('mensagens/enviar', 'MensagensController@enviar');

    /*Controle Atividades*/
    Route::get('controle_atividades/imprimir/{id}/data/{tipo}/{data}', 'ControleAtividadesController@relatorio_encontro');    //Imprimir relatorio encontro semanal
    Route::get('controle_atividades', 'ControleAtividadesController@index');
    Route::get('controle_atividades/buscar/{cell_id}/{day}/{month}/{year}', 'ControleAtividadesController@buscar');
    Route::post('/controle_atividades/gravar','ControleAtividadesController@store');
    Route::get('/controle_atividades/registrar/{data}','ControleAtividadesController@create');
    Route::get('/controle_atividades/{id}/preview','ControleAtividadesController@show');
    Route::post('controle_atividades/{id}/update','ControleAtividadesController@update');
    Route::get('controle_atividades/{id}/edit','ControleAtividadesController@edit');
    Route::get('controle_atividades/{id}/delete','ControleAtividadesController@destroy');
    Route::get('controle_atividades/{id}/remover','ControleAtividadesController@remove_image');

    /*Tipos de Relacionamentos */
    Route::get('questionarios', 'QuestionariosController@index');
    Route::post('/questionarios/gravar','QuestionariosController@store');
    Route::get('/questionarios/registrar','QuestionariosController@create');
    Route::get('/questionarios/{id}/preview','QuestionariosController@show');
    Route::post('questionarios/{id}/update','QuestionariosController@update');
    Route::get('questionarios/{id}/edit','QuestionariosController@edit');
    Route::get('questionarios/{id}/delete','QuestionariosController@destroy');

    /*Tipos de Relacionamentos */
    Route::get('tiposrelacionamentos', 'TiposRelacionamentosController@index');
    Route::post('/tiposrelacionamentos/gravar','TiposRelacionamentosController@store');
    Route::get('/tiposrelacionamentos/registrar','TiposRelacionamentosController@create');
    Route::get('/tiposrelacionamentos/{id}/preview','TiposRelacionamentosController@show');
    Route::post('tiposrelacionamentos/{id}/update','TiposRelacionamentosController@update');
    Route::get('tiposrelacionamentos/{id}/edit','TiposRelacionamentosController@edit');
    Route::get('tiposrelacionamentos/{id}/delete','TiposRelacionamentosController@destroy');

    /*Tipos de Relacionamentos Discipulado*/
    Route::get('tiposrd', 'TiposRDController@index');
    Route::post('/tiposrd/gravar','TiposRDController@store');
    Route::get('/tiposrd/registrar','TiposRDController@create');
    Route::get('/tiposrd/{id}/preview','TiposRDController@show');
    Route::post('tiposrd/{id}/update','TiposRDController@update');
    Route::get('tiposrd/{id}/edit','TiposRDController@edit');
    Route::get('tiposrd/{id}/delete','TiposRDController@destroy');

    /*Financeiro*/
    Route::get('financeiro', 'FinanceiroController@index');

    Route::get('dashboard_celulas', 'CelulasController@dashboard');
    Route::get('dashboard_celulas/{mes}/{ano}', 'CelulasController@dashboard_filtros');
    Route::get('grafico_celulas/{opcao}/{mes}/{ano}', 'CelulasController@grafico_mensal');


    /*Relatorio Financeiro*/
    Route::get('relfinanceiro', 'RelatorioFinanceiroController@index');
    Route::post('relfinanceiro/pesquisar', 'RelatorioFinanceiroController@pesquisar');

    //Contas a Pagar ou receber
    Route::post('titulos/{id}/update_inline/{campo}/{tipo}','TitulosController@update_inline');
    Route::get('titulos/{tipo}', 'TitulosController@index');
    Route::post('titulos/filtrar/{tipo}', 'TitulosController@pesquisar'); //Filtrar pesquisa
    Route::post('titulos/acao_lote/{tipo}', 'TitulosController@acao_lote'); //Botao para acao em lote
    Route::post('/titulos/gravar/{tipo}','TitulosController@store'); //Gravar titulo
    Route::get('/titulos/registrar/{tipo}','TitulosController@create');
    Route::get('/titulos/{id}/preview/{tipo}','TitulosController@show');
    Route::post('titulos/{id}/update/{tipo}','TitulosController@update');
    Route::get('titulos/{id}/edit/{tipo}','TitulosController@edit');
    Route::get('titulos/{id}/delete/{tipo}','TitulosController@destroy');

    /*Contas Correntes*/
    Route::get('contas', 'ContasController@index');
    Route::post('/contas/gravar','ContasController@store');
    Route::get('/contas/registrar','ContasController@create');
    Route::get('/contas/{id}/preview','ContasController@show');
    Route::post('contas/{id}/update','ContasController@update');
    Route::get('contas/{id}/edit','ContasController@edit');
    Route::get('contas/{id}/delete','ContasController@destroy');

    /*Plano de Contas*/
    Route::get('planos_contas', 'PlanosContasController@index');
    Route::post('/planos_contas/gravar','PlanosContasController@store');
    Route::get('/planos_contas/registrar','PlanosContasController@create');
    Route::get('/planos_contas/{id}/preview','PlanosContasController@show');
    Route::post('planos_contas/{id}/update','PlanosContasController@update');
    Route::get('planos_contas/{id}/edit','PlanosContasController@edit');
    Route::get('planos_contas/{id}/delete','PlanosContasController@destroy');

    /*Centros de Custo*/
    Route::get('centros_custos', 'CentrosCustosController@index');
    Route::post('/centros_custos/gravar','CentrosCustosController@store');
    Route::get('/centros_custos/registrar','CentrosCustosController@create');
    Route::get('/centros_custos/{id}/preview','CentrosCustosController@show');
    Route::post('centros_custos/{id}/update','CentrosCustosController@update');
    Route::get('centros_custos/{id}/edit','CentrosCustosController@edit');
    Route::get('centros_custos/{id}/delete','CentrosCustosController@destroy');

     /*Grupos titulos*/
    Route::get('grupos_titulos', 'GruposTitulosController@index');
    Route::post('/grupos_titulos/gravar','GruposTitulosController@store');
    Route::get('/grupos_titulos/registrar','GruposTitulosController@create');
    Route::get('/grupos_titulos/{id}/preview','GruposTitulosController@show');
    Route::post('grupos_titulos/{id}/update','GruposTitulosController@update');
    Route::get('grupos_titulos/{id}/edit','GruposTitulosController@edit');
    Route::get('grupos_titulos/{id}/delete','GruposTitulosController@destroy');

    /*curos eventos*/
    Route::get('cursos', 'CursosController@index');
    Route::post('/cursos/gravar','CursosController@store');
    Route::get('/cursos/registrar','CursosController@create');
    Route::get('/cursos/{id}/preview','CursosController@show');
    Route::post('cursos/{id}/update','CursosController@update');
    Route::get('cursos/{id}/edit','CursosController@edit');
    Route::get('cursos/{id}/delete','CursosController@destroy');

    Route::get('carregar_tabela/{tabela}', 'CadastrarController@carregar_tabela');

    //Criar novo registro através da combobox
    Route::get('cadastrar/json/{conteudo}', 'CadastrarController@cadastrar');

    /*Validação do cadastro de novos usuarios*/
    Route::get('validacao/{codigo}', 'HomeController@confirm');

    /*Validacao do CPF / CNPJ - disparado pelo jquery*/
    Route::get('funcoes/{id}', 'FuncoesController@validar');

    /*Verificar se a célula que está sendo incluida  já existe*/
    Route::get('funcoes/verificarcelulas/{id}', 'FuncoesController@validar_celulas');

    /*Verificar se a PESSOA ja participa de alguma celula*/
    Route::get('funcoes/verificar_participante/{id}', 'FuncoesController@validar_participante');

    /*Pesquisa de pessoas*/
    Route::get('buscapessoa/{id}', 'FuncoesController@buscarpessoa');

    /*Hierarquia de celulas inverso, comecando pela ultima estrutura*/
    Route::get('nivel5/{id}', 'CarregaEstruturasController@carregar_nivel5');
    Route::get('nivel4/{id}', 'CarregaEstruturasController@carregar_nivel4');
    Route::get('nivel3/{id}', 'CarregaEstruturasController@carregar_nivel3');
    Route::get('nivel2/{id}', 'CarregaEstruturasController@carregar_nivel2');
    Route::get('nivel1/{id}', 'CarregaEstruturasController@carregar_nivel1');


    /*hierarquia de celulas a partir do nivel 1*/
    Route::get('nivel1_up/{id}', 'CarregaEstruturasController@carregar_nivel1_up');
    Route::get('nivel2_up/{id}', 'CarregaEstruturasController@carregar_nivel2_up');
    Route::get('nivel3_up/{id}', 'CarregaEstruturasController@carregar_nivel3_up');
    Route::get('nivel4_up/{id}', 'CarregaEstruturasController@carregar_nivel4_up');
    Route::get('nivel5_up/{id}', 'CarregaEstruturasController@carregar_nivel5_up');

    /*Relatorio de pessoas*/
    Route::get('relpessoas', 'RelatorioPessoasController@index');
    Route::post('relpessoas/pesquisar', 'RelatorioPessoasController@pesquisar');


   //Relatorio de encontros
    Route::get('relencontro', 'RelEncontroController@index');

    Route::post('filhos', 'FilhosController@destroy');

    Route::get('tutoriais/{id}', 'TutoriaisController@tutorial');

    Route::get('quicktour/{id}', 'TutoriaisController@index');
    Route::post('quicktour/done/{id}', 'TutoriaisController@concluir');
    Route::get('quicktour/reload/{id}', 'TutoriaisController@iniciar');

    /*Clientes Cloud*/
    Route::get('clientes', 'ClientesCloudController@index');
    Route::post('/clientes/gravar','ClientesCloudController@store');
    Route::get('/clientes/registrar','ClientesCloudController@create');
    Route::get('/clientes/{id}/preview','ClientesCloudController@show');
    Route::post('clientes/{id}/update','ClientesCloudController@update');
    Route::get('clientes/{id}/edit','ClientesCloudController@edit');
    Route::get('clientes/{id}/remover','ClientesCloudController@remove_image');

    /*Empresas do cliente*/
    Route::get('empresas', 'EmpresasController@index');
    Route::post('/empresas/gravar','EmpresasController@store');
    Route::get('/empresas/registrar','EmpresasController@create');
    Route::get('/empresas/{id}/preview','EmpresasController@show');
    Route::post('empresas/{id}/update','EmpresasController@update');
    Route::get('empresas/{id}/edit','EmpresasController@edit');
    Route::get('empresas/{id}/remover','EmpresasController@remove_image');
    Route::get('empresas/{id}/delete','EmpresasController@destroy');
    Route::get('empresas/{id}/deleteMsg','EmpresasController@DeleteMsg');

     /*Grupos de Usuários*/
    Route::get('grupos', 'GruposController@index');
    Route::post('/grupos/gravar','GruposController@store');
    Route::get('/grupos/registrar','GruposController@create');
    Route::get('/grupos/{id}/preview','GruposController@show');
    Route::post('grupos/{id}/update','GruposController@update');
    Route::get('grupos/{id}/edit','GruposController@edit');
    Route::get('grupos/{id}/delete','GruposController@destroy');

  /*Permissoes do Grupo*/
    Route::get('permissoes', 'PermissoesGrupoController@index');
    Route::post('/permissoes/gravar','PermissoesGrupoController@store');
    Route::get('/permissoes/registrar','PermissoesGrupoController@create');
    Route::get('/permissoes/{id}/preview','PermissoesGrupoController@show');
    Route::post('permissoes/update','PermissoesGrupoController@update');
    Route::get('permissoes/{id}/edit','PermissoesGrupoController@edit');
    Route::get('permissoes/{id}/delete','PermissoesGrupoController@destroy');
    Route::get('permissoes/{id}/deleteMsg','PermissoesGrupoController@DeleteMsg');

 /*Usuários*/
    Route::get('usuarios', 'UsersController@index');
    Route::post('/usuarios/gravar','UsersController@store');
    Route::get('/usuarios/registrar','UsersController@create');
    Route::get('/usuarios/{id}/preview','UsersController@show');
    Route::post('usuarios/{id}/update','UsersController@update');
    Route::get('usuarios/{id}/edit','UsersController@edit');
    Route::get('usuarios/{id}/delete','UsersController@destroy');
    Route::get('usuarios/{id}/remover','UsersController@remove_image');
    Route::get('usuarios/{id}/perfil','UsersController@perfil');

    /*Perfil*/
    Route::get('profile/{id}/perfil','PerfilController@perfil');
    Route::post('profile/{id}/update','PerfilController@update');
    Route::get('profile/{id}/remover','PerfilController@remove_image');


   /*Igrejas*/
    Route::get('igrejas', 'IgrejasController@index');
    Route::post('/igrejas/gravar','IgrejasController@store');
    Route::get('/igrejas/registrar','IgrejasController@create');
    Route::get('/igrejas/{id}/preview','IgrejasController@show');
    Route::post('igrejas/{id}/update','IgrejasController@update');
    Route::get('igrejas/{id}/edit','IgrejasController@edit');
    Route::get('igrejas/{id}/delete','IgrejasController@destroy');

    /*Status*/
    Route::get('status', 'StatusController@index');
    Route::post('/status/gravar','StatusController@store');
    Route::get('/status/registrar','StatusController@create');
    Route::get('/status/{id}/preview','StatusController@show');
    Route::post('status/{id}/update','StatusController@update');
    Route::get('status/{id}/edit','StatusController@edit');
    Route::get('status/{id}/delete','StatusController@destroy');

    /*Idiomas*/
    Route::get('idiomas', 'IdiomasController@index');
    Route::post('/idiomas/gravar','IdiomasController@store');
    Route::get('/idiomas/registrar','IdiomasController@create');
    Route::get('/idiomas/{id}/preview','IdiomasController@show');
    Route::post('idiomas/{id}/update','IdiomasController@update');
    Route::get('idiomas/{id}/edit','IdiomasController@edit');
    Route::get('idiomas/{id}/delete','IdiomasController@destroy');

     /*Graus de Instrução*/
    Route::get('graus', 'GrausController@index');
    Route::post('/graus/gravar','GrausController@store');
    Route::get('/graus/registrar','GrausController@create');
    Route::get('/graus/{id}/preview','GrausController@show');
    Route::post('graus/{id}/update','GrausController@update');
    Route::get('graus/{id}/edit','GrausController@edit');
    Route::get('graus/{id}/delete','GrausController@destroy');

    /*Profissoes */
    Route::get('profissoes', 'ProfissoesController@index');
    Route::post('/profissoes/gravar','ProfissoesController@store');
    Route::get('/profissoes/registrar','ProfissoesController@create');
    Route::get('/profissoes/{id}/preview','ProfissoesController@show');
    Route::post('profissoes/{id}/update','ProfissoesController@update');
    Route::get('profissoes/{id}/edit','ProfissoesController@edit');
    Route::get('profissoes/{id}/delete','ProfissoesController@destroy');

    /*Àreas de Formação */
    Route::get('areas', 'AreasController@index');
    Route::post('/areas/gravar','AreasController@store');
    Route::get('/areas/registrar','AreasController@create');
    Route::get('/areas/{id}/preview','AreasController@show');
    Route::post('areas/{id}/update','AreasController@update');
    Route::get('areas/{id}/edit','AreasController@edit');
    Route::get('areas/{id}/delete','AreasController@destroy');

    /*Ministério */
    Route::get('ministerios', 'MinisteriosController@index');
    Route::post('/ministerios/gravar','MinisteriosController@store');
    Route::get('/ministerios/registrar','MinisteriosController@create');
    Route::get('/ministerios/{id}/preview','MinisteriosController@show');
    Route::post('ministerios/{id}/update','MinisteriosController@update');
    Route::get('ministerios/{id}/edit','MinisteriosController@edit');
    Route::get('ministerios/{id}/delete','MinisteriosController@destroy');

     /*Atividades  */
    Route::get('atividades', 'AtividadesController@index');
    Route::post('/atividades/gravar','AtividadesController@store');
    Route::get('/atividades/registrar','AtividadesController@create');
    Route::get('/atividades/{id}/preview','AtividadesController@show');
    Route::post('atividades/{id}/update','AtividadesController@update');
    Route::get('atividades/{id}/edit','AtividadesController@edit');
    Route::get('atividades/{id}/delete','AtividadesController@destroy');

    /*Dons */
    Route::get('dons', 'DonsController@index');
    Route::post('/dons/gravar','DonsController@store');
    Route::get('/dons/registrar','DonsController@create');
    Route::get('/dons/{id}/preview','DonsController@show');
    Route::post('dons/{id}/update','DonsController@update');
    Route::get('dons/{id}/edit','DonsController@edit');
    Route::get('dons/{id}/delete','DonsController@destroy');

    /*Tipos Presenca */
    Route::get('tipospresenca', 'TiposPresencaController@index');
    Route::post('/tipospresenca/gravar','TiposPresencaController@store');
    Route::get('/tipospresenca/registrar','TiposPresencaController@create');
    Route::get('/tipospresenca/{id}/preview','TiposPresencaController@show');
    Route::post('tipospresenca/{id}/update','TiposPresencaController@update');
    Route::get('tipospresenca/{id}/edit','TiposPresencaController@edit');
    Route::get('tipospresenca/{id}/delete','TiposPresencaController@destroy');

    /*Tipos Movimentação */
    Route::get('tiposmovimentacao', 'TiposMovimentacaoController@index');
    Route::post('/tiposmovimentacao/gravar','TiposMovimentacaoController@store');
    Route::get('/tiposmovimentacao/registrar','TiposMovimentacaoController@create');
    Route::get('/tiposmovimentacao/{id}/preview','TiposMovimentacaoController@show');
    Route::post('tiposmovimentacao/{id}/update','TiposMovimentacaoController@update');
    Route::get('tiposmovimentacao/{id}/edit','TiposMovimentacaoController@edit');
    Route::get('tiposmovimentacao/{id}/delete','TiposMovimentacaoController@destroy');

    /*Graus parentesco */
    Route::get('grausparentesco', 'GrausParentescoController@index');
    Route::post('/grausparentesco/gravar','GrausParentescoController@store');
    Route::get('/grausparentesco/registrar','GrausParentescoController@create');
    Route::get('/grausparentesco/{id}/preview','GrausParentescoController@show');
    Route::post('grausparentesco/{id}/update','GrausParentescoController@update');
    Route::get('grausparentesco/{id}/edit','GrausParentescoController@edit');
    Route::get('grausparentesco/{id}/delete','GrausParentescoController@destroy');

    /*Cargos e Funções*/
    Route::get('cargos', 'CargosController@index');
    Route::post('/cargos/gravar','CargosController@store');
    Route::get('/cargos/registrar','CargosController@create');
    Route::get('/cargos/{id}/preview','CargosController@show');
    Route::post('cargos/{id}/update','CargosController@update');
    Route::get('cargos/{id}/edit','CargosController@edit');
    Route::get('cargos/{id}/delete','CargosController@destroy');

    /*Ramos Atividades*/
    Route::get('ramos', 'RamosAtividadesController@index');
    Route::post('/ramos/gravar','RamosAtividadesController@store');
    Route::get('/ramos/registrar','RamosAtividadesController@create');
    Route::get('/ramos/{id}/preview','RamosAtividadesController@show');
    Route::post('ramos/{id}/update','RamosAtividadesController@update');
    Route::get('ramos/{id}/edit','RamosAtividadesController@edit');
    Route::get('ramos/{id}/delete','RamosAtividadesController@destroy');

    /*Estados Civis*/
    Route::get('civis', 'EstadosCivisController@index');
    Route::post('/civis/gravar','EstadosCivisController@store');
    Route::get('/civis/registrar','EstadosCivisController@create');
    Route::get('/civis/{id}/preview','EstadosCivisController@show');
    Route::post('civis/{id}/update','EstadosCivisController@update');
    Route::get('civis/{id}/edit','EstadosCivisController@edit');
    Route::get('civis/{id}/delete','EstadosCivisController@destroy');

    /*Religioẽs*/
    Route::get('religioes', 'ReligioesController@index');
    Route::post('/religioes/gravar','ReligioesController@store');
    Route::get('/religioes/registrar','ReligioesController@create');
    Route::get('/religioes/{id}/preview','ReligioesController@show');
    Route::post('religioes/{id}/update','ReligioesController@update');
    Route::get('religioes/{id}/edit','ReligioesController@edit');
    Route::get('religioes/{id}/delete','ReligioesController@destroy');

    /*Habilidades*/
    Route::get('habilidades', 'HabilidadesController@index');
    Route::post('/habilidades/gravar','HabilidadesController@store');
    Route::get('/habilidades/registrar','HabilidadesController@create');
    Route::get('/habilidades/{id}/preview','HabilidadesController@show');
    Route::post('habilidades/{id}/update','HabilidadesController@update');
    Route::get('habilidades/{id}/edit','HabilidadesController@edit');
    Route::get('habilidades/{id}/delete','HabilidadesController@destroy');

    /*Disponibilidades*/
    Route::get('disponibilidades', 'DisponibilidadesController@index');
    Route::post('/disponibilidades/gravar','DisponibilidadesController@store');
    Route::get('/disponibilidades/registrar','DisponibilidadesController@create');
    Route::get('/disponibilidades/{id}/preview','DisponibilidadesController@show');
    Route::post('disponibilidades/{id}/update','DisponibilidadesController@update');
    Route::get('disponibilidades/{id}/edit','DisponibilidadesController@edit');
    Route::get('disponibilidades/{id}/delete','DisponibilidadesController@destroy');

    /*Situações*/
    Route::get('situacoes', 'SituacoesController@index');
    Route::post('/situacoes/gravar','SituacoesController@store');
    Route::get('/situacoes/registrar','SituacoesController@create');
    Route::get('/situacoes/{id}/preview','SituacoesController@show');
    Route::post('situacoes/{id}/update','SituacoesController@update');
    Route::get('situacoes/{id}/edit','SituacoesController@edit');
    Route::get('situacoes/{id}/delete','SituacoesController@destroy');

    Route::get('relpessoas/aniversariantes/{querystring}', 'RelatorioPessoasController@pesquisar_aniversariantes');

    /*Pessoas*/
    Route::get('pessoas/buscar_nome', 'PessoasController@pesquisar_nome');
    Route::get('/pessoas/ver/{id}/{id_tipo_pessoa}','PessoasController@perfil');
    Route::post('pessoas/pesquisar', 'PessoasController@pesquisar');
    Route::get('pessoas', 'PessoasController@index');
    Route::get('pessoas/{buscar_nome}/buscar_nome', 'PessoasController@listar_por_nome');
    Route::get('pessoas/{buscar_nome}/json', 'PessoasController@listar_por_nome_json');
    Route::get('pessoas/json/{querystring}', 'PessoasController@listar_json');
    Route::post('/pessoas/gravar','PessoasController@store');
    //Route::get('/pessoas/registrar','PessoasController@create');
    Route::get('/pessoas/registrar/{id}','PessoasController@create');
    //Route::get('/pessoas/{id}/preview','PessoasController@show');
    Route::get('/pessoas/{id}/preview/{id_tipo_pessoa}','PessoasController@show');
    Route::post('pessoas/{id}/update','PessoasController@update');
    //Route::get('pessoas/{id}/edit','PessoasController@edit');
    Route::get('pessoas/{id}/edit/{id_tipo_pessoa}','PessoasController@edit');
    Route::get('pessoas/{id}/delete','PessoasController@destroy');
    Route::get('pessoas/{id}/remover','PessoasController@remove_image');

    /*Grupos Pessoas*/
    Route::get('grupospessoas', 'GruposPessoasController@index');
    Route::post('/grupospessoas/gravar','GruposPessoasController@store');
    Route::get('/grupospessoas/registrar','GruposPessoasController@create');
    Route::get('/grupospessoas/{id}/preview','GruposPessoasController@show');
    Route::post('grupospessoas/{id}/update','GruposPessoasController@update');
    Route::get('grupospessoas/{id}/edit','GruposPessoasController@edit');
    Route::get('grupospessoas/{id}/delete','GruposPessoasController@destroy');

    /*Tipos de Pessoas*/
    Route::get('tipospessoas', 'TiposPessoasController@index');
    Route::post('/tipospessoas/gravar','TiposPessoasController@store');
    Route::get('/tipospessoas/registrar','TiposPessoasController@create');
    Route::get('/tipospessoas/{id}/preview','TiposPessoasController@show');
    Route::post('tipospessoas/{id}/update','TiposPessoasController@update');
    Route::get('tipospessoas/{id}/edit','TiposPessoasController@edit');
    Route::get('tipospessoas/{id}/delete','TiposPessoasController@destroy');

    /*Tipos de Telefones*/
    Route::get('tipostelefones', 'TiposTelefonesController@index');
    Route::post('/tipostelefones/gravar','TiposTelefonesController@store');
    Route::get('/tipostelefones/registrar','TiposTelefonesController@create');
    Route::get('/tipostelefones/{id}/preview','TiposTelefonesController@show');
    Route::post('tipostelefones/{id}/update','TiposTelefonesController@update');
    Route::get('tipostelefones/{id}/edit','TiposTelefonesController@edit');
    Route::get('tipostelefones/{id}/delete','TiposTelefonesController@destroy');

    /* Usado para verificar a existencia de um usuário para as igrejas/instituições.*/
    Route::get('/validar/{id}/user', 'UsersController@validar');

    /*Bancos*/
    Route::get('bancos', 'BancosController@index');
    Route::post('/bancos/gravar','BancosController@store');
    Route::get('/bancos/registrar','BancosController@create');
    Route::get('/bancos/{id}/preview','BancosController@show');
    Route::post('bancos/{id}/update','BancosController@update');
    Route::get('bancos/{id}/edit','BancosController@edit');
    Route::get('bancos/{id}/delete','BancosController@destroy');

    /*Estrutura Celula - Nivel 1*/
    Route::get('estruturas1', 'Estruturas1Controller@index');
    Route::post('/estruturas1/gravar','Estruturas1Controller@store');
    Route::get('/estruturas1/registrar','Estruturas1Controller@create');
    Route::get('/estruturas1/{id}/preview','Estruturas1Controller@show');
    Route::post('estruturas1/{id}/update','Estruturas1Controller@update');
    Route::get('estruturas1/{id}/edit','Estruturas1Controller@edit');
    Route::get('estruturas1/{id}/delete','Estruturas1Controller@destroy');

    /*Estrutura Celula - Nivel 2*/
    Route::get('estruturas2', 'Estruturas2Controller@index');
    Route::post('/estruturas2/gravar','Estruturas2Controller@store');
    Route::get('/estruturas2/registrar','Estruturas2Controller@create');
    Route::get('/estruturas2/{id}/preview','Estruturas2Controller@show');
    Route::post('estruturas2/{id}/update','Estruturas2Controller@update');
    Route::get('estruturas2/{id}/edit','Estruturas2Controller@edit');
    Route::get('estruturas2/{id}/delete','Estruturas2Controller@destroy');

    /*Estrutura Celula - Nivel 3*/
    Route::get('estruturas3', 'Estruturas3Controller@index');
    Route::post('/estruturas3/gravar','Estruturas3Controller@store');
    Route::get('/estruturas3/registrar','Estruturas3Controller@create');
    Route::get('/estruturas3/{id}/preview','Estruturas3Controller@show');
    Route::post('estruturas3/{id}/update','Estruturas3Controller@update');
    Route::get('estruturas3/{id}/edit','Estruturas3Controller@edit');
    Route::get('estruturas3/{id}/delete','Estruturas3Controller@destroy');

    /*Estrutura Celula - Nivel 4*/
    Route::get('estruturas4', 'Estruturas4Controller@index');
    Route::post('/estruturas4/gravar','Estruturas4Controller@store');
    Route::get('/estruturas4/registrar','Estruturas4Controller@create');
    Route::get('/estruturas4/{id}/preview','Estruturas4Controller@show');
    Route::post('estruturas4/{id}/update','Estruturas4Controller@update');
    Route::get('estruturas4/{id}/edit','Estruturas4Controller@edit');
    Route::get('estruturas4/{id}/delete','Estruturas4Controller@destroy');

  /*Estrutura Celula - Nivel 5*/
    Route::get('estruturas5', 'Estruturas5Controller@index');
    Route::post('/estruturas5/gravar','Estruturas5Controller@store');
    Route::get('/estruturas5/registrar','Estruturas5Controller@create');
    Route::get('/estruturas5/{id}/preview','Estruturas5Controller@show');
    Route::post('estruturas5/{id}/update','Estruturas5Controller@update');
    Route::get('estruturas5/{id}/edit','Estruturas5Controller@edit');
    Route::get('estruturas5/{id}/delete','Estruturas5Controller@destroy');


    /*configuracoes celulas*/
    Route::get('configuracoes', 'ConfiguracoesController@index');
    Route::post('/configuracoes/gravar','ConfiguracoesController@store');
    Route::get('/configuracoes/{id}/preview','ConfiguracoesController@show');
    Route::post('configuracoes/{id}/update','ConfiguracoesController@update');
    Route::get('configuracoes/{id}/edit','ConfiguracoesController@edit');

    /*Células*/
    Route::get('celulas/select1', 'CelulasController@loadSelect');
    Route::get('celulas/buscar/{id}', 'CelulasController@buscar_dados');
    Route::get('celulas/buscar_datas/{dia}/{mes}/{ano}', 'CelulasController@return_dates');
    //Route::get('celulas/buscar_data_avulsa/{dia}/{mes}/{ano}', 'CelulasController@return_dates_avulsa');
    Route::get('celulas', 'CelulasController@index');
    Route::post('/celulas/gravar','CelulasController@store');
    Route::get('/celulas/registrar','CelulasController@create');
    Route::get('/celulas/registrar2','CelulasController@create2'); //somente para fins de testes
    Route::get('/celulas/{id}/preview','CelulasController@show');
    Route::post('celulas/{id}/update','CelulasController@update');
    Route::get('celulas/{id}/edit','CelulasController@edit');
    Route::get('celulas/{id}/delete','CelulasController@destroy');

    /*Públicos Alvos*/
    Route::get('publicos', 'PublicosController@index');
    Route::post('/publicos/gravar','PublicosController@store');
    Route::get('/publicos/registrar','PublicosController@create');
    Route::get('/publicos/{id}/preview','PublicosController@show');
    Route::post('publicos/{id}/update','PublicosController@update');
    Route::get('publicos/{id}/edit','PublicosController@edit');
    Route::get('publicos/{id}/delete','PublicosController@destroy');

    /*Faixas Etárias*/
    Route::get('faixas', 'FaixasController@index');
    Route::post('/faixas/gravar','FaixasController@store');
    Route::get('/faixas/registrar','FaixasController@create');
    Route::get('/faixas/{id}/preview','FaixasController@show');
    Route::post('faixas/{id}/update','FaixasController@update');
    Route::get('faixas/{id}/edit','FaixasController@edit');
    Route::get('faixas/{id}/delete','FaixasController@destroy');

    /*Células / Pessoas*/
    Route::get('celulaspessoas', 'CelulasPessoasController@index');
    Route::post('/celulaspessoas/gravar','CelulasPessoasController@store');
    Route::get('/celulaspessoas/registrar','CelulasPessoasController@create');
    Route::get('/celulaspessoas/registrar/{id}','CelulasPessoasController@create_membro');
    Route::get('/celulaspessoas/{id}/preview','CelulasPessoasController@show');
    Route::get('/celulaspessoas/{id}/imprimir','CelulasPessoasController@imprimir');
    Route::post('celulaspessoas/{id}/update','CelulasPessoasController@update');
    Route::get('celulaspessoas/{id}/edit','CelulasPessoasController@edit');
    Route::get('celulaspessoas/{id}/delete','CelulasPessoasController@destroy');
    Route::get('celulaspessoas/{id}/remover_membro/{pessoas_id}','CelulasPessoasController@remover_membro');
    Route::get('celulaspessoas/participantes/{id}', 'CelulasPessoasController@exibir_participantes_json'); /*A partir da celula informada, retorna um json com os participantes*/
    Route::get('celulaspessoas/listar_participantes/{id}', 'CelulasPessoasController@listar_participantes_json'); /*A partir da celula informada, retorna um json com os participantes*/


});