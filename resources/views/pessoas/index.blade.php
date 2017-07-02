@extends('principal.master')

@section('content')

{{ \Session::put('titulo', 'Pessoas') }}
{{ \Session::put('subtitulo', 'Listagem') }}
{{ \Session::put('route', 'pessoas') }}
{{ \Session::put('id_pagina', '28') }}

        <div>{{{ $errors->first('erros') }}}</div>

        <div class="row">
                <div class="col-xs-2">
                @can('verifica_permissao', [ \Session::get('id_pagina'),'incluir'])

              <div class="input-group margin">
                  <div class="input-group-btn">
                    <button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown"><span class="fa fa-user-plus"></span>  Novo Registro
                        <span class="fa fa-caret-down"></span></button>
                        <ul class="dropdown-menu">

                          <!-- Carrega todos os tipos de pessoas, cria uma rota passando o ID do tipo de pessoa. Com esse ID a interface habilitara ou nao campos -->
                          @foreach($tipos as $item)
                              <li><a href="{{ url('/' . \Session::get('route') . '/registrar/' . $item->id )}}">{{ $item->nome }}</a></li>
                          @endforeach

                        </ul>
                  </div>
                  <br/>
              </div>

                @endcan
                </div>
        </div>


          <!--
         <div class="alert2 callout callout-info">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <h4><i class="icon fa fa-info"></i> Dica!</h4>
                Antes de iniciar o cadastro de Pessoas, verifique quais tabelas auxiliares serão necessárias e as cadastre previamente (Menu : Cadastro Base).
                <br/>Exemplos : Grupos, Status, Estados Civis, Graus de Instrução, Idiomas, etc...
         </div>
         -->


@include('pessoas.filtros_pesquisa')

        <div class="row">
        <div class="col-md-12">
          <div class="box">
            <div class="box-header" data-original-title>
                <div class="box-body table-responsive no-padding">

                    <table id="tab_pessoas" class="table table-responsive table-hover">
                    <thead>
                        <tr>
                        <th>Código</th>
                        <th>Nome</th>
                        <th>Nome Abrev.</th>
                        <th>Telefone</th>
                        <!--<th>CNPJ/CPF</th>-->
                        <th>Celular</th>
                        <th>ID Tipo</th>
                        <th>Alterar</th>
                        <th>Ver</th>
                        <th>Excluir</th>
                        </tr>
                    </thead>
                    <tbody>
                      <tr>
                          <td></td>
                          <td></td>
                          <td></td>
                          <td></td>
                          <td></td>
                      </tr>

                    </tbody>
                    </table>
                </div>
            </div>
          </div>
         </div>
        </div>

<script type="text/javascript">

        $(document).ready(function(){

              $("#pessoas").addClass("treeview active");
        });

              $(function ()
              {

                //console.log('{{$where}}');
                var sDados = '{{$where}}';  //Pega dados consulta
                var urlRoute = "{!! url('/pessoas/json/" + sDados + "') !!}"; //Rota para consulta
                var rota = "{{$rota}}"; //Somente rota da pagina

                /*Permissoes para saber se cria botao ou nao*/
                var alterar = '{{$alterar}}';
                var visualizar = '{{$visualizar}}';
                var excluir = '{{$excluir}}';

                    $('#tab_pessoas').dataTable({
                          "bDeferRender": true,
                          "deferRender": true,
                          "pagingType": "full_numbers",
                          'iDisplayLength': 25,
                          "bProcessing": true,
                          "processing": true,
                          "aaSorting": [[ 1, "asc" ]],
                          language:
                          {
                              searchPlaceholder: "Nome, Telefone...",
                              processing:     "Aguarde...Carregando",
                              paginate: {
                                                first:      "Primeira",
                                                previous:   "Anterior",
                                                next:       "Próxima",
                                                last:       "Última"}
                          },

                          "serverSide": true,
                          "ajax": urlRoute,
                          "columnDefs":
                          [
                                  {"targets": [5], "sortable": false},
                                  {"targets": [6], "sortable": false},
                                  {"targets": [7], "sortable": false},
                                  {"targets": [8], "sortable": false},
                                  {"targets": [5], "visible": false,"searchable": false}
                            ],
                          "columns": [
                                  { data: "id" },
                                  //{ data: "razaosocial" },
                                  {"mRender": function(data, type, full) {
                                        if (visualizar)
                                        {
                                            var urlGetUserPerfil = '{!! url("/' + rota + '/ver/' + full['id'] + '") !!}';
                                            //var urlGetUserPerfil = '{!! url("/' + rota + '/' +  full['id'] +  '/edit") !!}'; //Route
                                            return '<a href="' + urlGetUserPerfil + '/' + full['id_tipo_pessoa'] + '" data-toggle="tooltip" data-placement="top" title="Clique para ver Perfil">' + full['razaosocial'] + '</a>';
                                        }
                                        else
                                        {
                                              return full['razaosocial'];
                                        }
                                    }},
                                  { data: "nomefantasia" },
                                  { data: "fone_principal" },
                                  //{ data: "cnpj_cpf" },
                                  { data: "fone_celular" },
                                  { data: "id_tipo_pessoa" },
                                  {"mRender": function(data, type, full) {
                                        if (alterar)
                                        {
                                            var urlGetUser = '{!! url("/' + rota + '/' +  full['id'] +  '/edit") !!}'; //Route
                                            return '<a class="btn  btn-info btn-sm" href="' + urlGetUser + '/' + full['id_tipo_pessoa'] + '"><spam class="glyphicon glyphicon-pencil"></spam></a>';
                                        }
                                        else
                                        {
                                              return '<p></p>';
                                        }
                                    }},
                                    {"mRender": function(data, type, full) {
                                        if (visualizar)
                                        {
                                              var urlGetUser = '{!! url("/' + rota + '/' +  full['id'] +  '/preview") !!}'; //Route
                                              return '<a class="btn  btn-primary btn-sm" href="' + urlGetUser + '/' + full['id_tipo_pessoa'] + '"><spam class="glyphicon glyphicon-zoom-in"></spam></a>';
                                        }
                                        else
                                        {
                                              return '<p></p>';
                                        }

                                    }},
                                    {"mRender": function(data, type, full) {
                                         if (excluir)
                                         {
                                                var urlGetUser = '{!! url("/' + rota + '/' +  full['id'] +  '/delete") !!}'; //Route
                                                return "<form id='excluir" + full['id'] + "' action='" + urlGetUser + "' method='DELETE'><button data-toggle='tooltip' data-placement='top' title='Excluir Ítem' type='submit' class='btn btn-danger btn-sm' onclick='return confirm(\"Confirma a exclusão do registro ?\");'><spam class='glyphicon glyphicon-trash'></spam></button></form>";
                                         }
                                         else
                                          {
                                                return '<p></p>';
                                          }
                                    }}
                              ],
                     });
              });
</script>
@endsection