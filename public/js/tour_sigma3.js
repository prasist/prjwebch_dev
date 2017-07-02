  // Define the tour!

    var tour = {
      id: "tour_novousuario",
      steps: [
        {
          title: "Bem-Vindo ao Sigma3",
          content: "Criando um novo usuário. <br/><br/>Antes é necessário entender que o sistema separa os usuários por grupos, para assim facilitar as permissões de acesso que serão feitas posteriormente. Dito isso, vamos começar!",
          target: document.querySelector("#tour1"),
          placement: "right"
        },
        {
          title: "Passo 1",
          content: "Para criar um novo usuário, é preciso criar o grupo em que ele será colocado. Clique em 'Segurança' na barra lateral e, logo após, em 'Grupos de Usuário'.",
          target: document.querySelector("#tour2"),
          placement: "bottom",
          multipage: true,
              onNext: function() {

                var pathArray = window.location.pathname.split( '/' );
                var secondLevelLocation = pathArray[0];
                window.location =  "/grupos";
              }
        },
        {
          title: "Passo 2",
          content: "Note que já existe um grupo cadastrado chamado 'Administrador'. Ele é criado automaticamente pelo sistema. Clique em 'Novo'.",
          target: document.querySelector("#tour3"),
          placement: "bottom",
          multipage: true,
              onNext: function() {

                var pathArray = window.location.pathname.split( '/' );
                var secondLevelLocation = pathArray[0];
                window.location =  "/grupos/registrar";
              }
        },
        {
          title: "Passo 3",
          content: "Após informar um nome e gravar, clique em 'Grupos/Permissões' no menu 'Segurança'.",
          target: document.querySelector("#tour4"),
          placement: "bottom",
          multipage: true,
              onNext: function() {

                var pathArray = window.location.pathname.split( '/' );
                var secondLevelLocation = pathArray[0];
                window.location =  "/permissoes";

              }
        },
        {
          title: "Passo 4",
          content: "Após clicar em 'Novo Registro', aparecerão as permissões ACESSAR, INCLUIR, ALTERAR, EXCLUIR, VISUALIZAR, EXPORTAR ou IMPRIMIR.",
          target: document.querySelector("#tour5"),
          placement: "bottom",
          multipage: true,
              onNext: function() {
                var pathArray = window.location.pathname.split( '/' );
                var secondLevelLocation = pathArray[0];
                window.location =  "/permissoes/registrar";
              }
        },

       {
          title: "Passo 5",
          content: "Defina as permissões do grupo e grave.",
          target: document.querySelector("#tour4_1"),
          placement: "bottom",
          multipage: true,
              onNext: function() {
                var pathArray = window.location.pathname.split( '/' );
                var secondLevelLocation = pathArray[0];
                window.location =  "/permissoes";
              }
        },



        {
          title: "Passo 6",
          content: "Concluído o cadastro das permissões, clique em 'Usuários',  no menu 'Segurança' e comece a cadastrar os novos usuários clicando no botão 'Novo Registro'.",
          target: document.querySelector("#tour6"),
          placement: "bottom",
          multipage: true,
              onNext: function() {
                var pathArray = window.location.pathname.split( '/' );
                var secondLevelLocation = pathArray[0];
                window.location =  "/usuarios";
              }
        },

        {
          title: "Passo 7",
          content: "Clique no botão 'Novo Registro' para criar um novo usuário",
          target: document.querySelector("#tour7"),
          placement: "bottom",
          multipage: true,
              onNext: function() {
                var pathArray = window.location.pathname.split( '/' );
                var secondLevelLocation = pathArray[0];
                window.location =  "/usuarios/registrar";
              }
        },

        {
          title: "Passo 8",
          content: "Não esqueça de fazer a escolha do Grupo do usuário de acordo com as permissões que você deseja dar a ele. Preencha as informações cadastrais do usuário, clique em 'Gravar' e pronto! O novo usuário está cadastrado. Ele poderá ter acesso ao sistema fazendo login com o e-mail e a senha cadastrados pelo administrador.",
          target: document.querySelector("#tour8"),
          placement: "bottom",
          multipage: true,
              onNext: function()
              {
                  var pathArray = window.location.pathname.split( '/' );
                  var secondLevelLocation = pathArray[0];
                  window.location =  "/quicktour/1";
              }
        },

        {
          title: "Parabéns",
          content: "Você concluiu o guia rápido!!! <br/> O Tour pode ser acessado a qualquer momento na opção 'Ajuda/Documentação', opção 'Tour - Cadastro de Usuários'.",
          target: document.querySelector("#tour9"),
          placement: "bottom"
        }
      ]
    };

    var tour_visao_geral = {
      id: "tour_visaogeral",
      steps: [
        {
          title: "Bem-Vindo ao Sigma3 - Gestão para Igrejas",
          content: "Nesse Guia Rápido você terá uma visão geral do SIGMA3.",
          target: document.querySelector("#tour1_visaogeral"),
          placement: "right"
        },
        {
          title: "Iniciando",
          content: "Por aqui você pode acessar seu perfil ou encerrar a sessão.",
          target: document.querySelector("#tour2_visaogeral"),
          placement: "left"
        },
        {
          title: "Menu",
          content: "Use o menu de navegação para começar a usar o sistema.",
          target: document.querySelector("#tour3_visaogeral"),
          placement: "right"
        },
        {
          title: "Ocultar Menu",
          content: "Aqui você escolhe mostrar ou ocultar o menu de navegação.",
          target: document.querySelector("#tour4_visaogeral"),
          placement: "bottom"
        },
        {
          title: "Menu - Ajuda",
          content: "Para outras informações e tutoriais mais detalhados, clique na opção 'Ajuda / Documentação'.",
          target: document.querySelector("#tour5_visaogeral"),
          placement: "bottom",
          multipage: true,
              onNext: function()
              {
                  var pathArray = window.location.pathname.split( '/' );
                  var secondLevelLocation = pathArray[0];
                  window.location =  "/quicktour/2";
              }
        },
        {
          title: "Parabéns! Você concluiu o Guia Rápido.",
          content: "O Tour poderá ser acessado a qualquer momento no menu 'Ajuda / Documentação', opção 'Visão Geral do Sigma3'." ,
          target: document.querySelector("#tour6_visaogeral"),
          placement: "bottom"
        }
      ]
    };

      var avisos_sigma3 = {
      id: "avisos_sigma3",
      steps: [
        {
          title: "Olá...",
          content: "Agora você receberá notificações sobre dicas e novidades do Sigma3 por aqui...",
          target: document.querySelector("#aviso_mensagens"),
          placement: "left"
        }
      ]
    };