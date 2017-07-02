@extends('principal.master')

@section('content')

{{ \Session::put('titulo', 'Usuários') }}
{{ \Session::put('subtitulo', 'Listagem') }}
{{ \Session::put('route', 'usuarios') }}
{{ \Session::put('id_pagina', '5') }}


        <div>{{{ $errors->first('erros') }}}</div>

        <div class="row">
                <div class="col-xs-2">
                @can('verifica_permissao', [ \Session::get('id_pagina'),'incluir'])
                  <form method = 'get' class="form-horizontal" action = {{ url('/' . \Session::get('route') . '/registrar')}}>
                        <button class = 'btn btn-success btn-flat' type ='submit'><i class="fa fa-file-text-o"></i> Novo Registro</button>
                  </form>
                @endcan
                </div>

              <div class="col-xs-6">
                  <a href="{{ url('/tutoriais/1')}}" data-toggle="tooltip" title="Clique Aqui para ver o tutorial..." target="_blank">
                      <i class="glyphicon glyphicon-question-sign text-success"></i>&nbsp;Como Cadastrar um usuário ?
                 </a>
                 &nbsp;
                 <a href="{{ url('/tutoriais/2')}}" data-toggle="tooltip" title="Clique Aqui para ver o tutorial..." target="_blank">
                      <i class="glyphicon glyphicon-question-sign text-success"></i>&nbsp;Como Cadastrar um novo Administrador ?
                 </a>
              </div>

        </div>

        <div class="row">
        <div class="col-md-12">
          <div class="box">
            <div class="box-header">

                <div class="box-body">

                    <div id="tour7"></div>
                    <table id="example1" class="table table-bordered table-hover">
                    <thead>
                        <tr>
                        <th>Nome Usuário</th>
                        <th>Email</th>
                        <th>Igreja/Instituição</th>
                         <th>Alterar</th>
                        <th>Visualizar</th>
                        <th>Excluir</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($usuarios as $value)

                        <tr>

                            <td>

                                  @can('verifica_permissao', [\Session::get('id_pagina') ,'alterar'])
                                  <a href = "{{ URL::to(\Session::get('route') .'/' . $value->id . '/edit') }}" >
                                        {{$value->name}}
                                  </a>
                                  @else
                                        @can('verifica_permissao', [\Session::get('id_pagina') ,'visualizar'])
                                                <a href = "{{ URL::to(\Session::get('route') .'/' . $value->id . '/preview') }}" >
                                                      {{$value->name}}
                                                </a>
                                        @else
                                                {{$value->name}}
                                        @endcan
                                  @endcan
                            </td>
                            <td>{{$value->email}}</td>
                            <td>{{$value->razaosocial}}</td>

                            <td class="col-xs-1">
                                      @can('verifica_permissao', [\Session::get('id_pagina') ,'alterar'])
                                            <a href = "{{ URL::to(\Session::get('route') .'/' . $value->id . '/edit') }}" class = 'btn  btn-info btn-sm'><spam class="glyphicon glyphicon-pencil"></spam></a>
                                      @endcan
                            </td>

                            <td class="col-xs-1">
                                      @can('verifica_permissao', [\Session::get('id_pagina') ,'visualizar'])
                                               <a href = "{{ URL::to(\Session::get('route') .'/' . $value->id . '/preview') }}" class = 'btn btn-primary btn-sm'><span class="glyphicon glyphicon-zoom-in"></span></a>
                                      @endcan
                            </td>
                            <td class="col-xs-1">
                                        @if ($value->master != 1)

                                                @can('verifica_permissao', [ \Session::get('id_pagina') ,'excluir'])
                                                <form id="excluir{{ $value->id }}" action="{{ URL::to(\Session::get('route') . '/' . $value->id . '/delete') }}" method="DELETE">

                                                      <button
                                                          data-toggle="tooltip" data-placement="top" title="Excluir Registro" type="submit"
                                                          class="btn btn-danger btn-sm"
                                                          onclick="return confirm('Confirma exclusão do registro ?');">
                                                          <spam class="glyphicon glyphicon-trash"></spam></button>

                                                </form>
                                                @endcan

                                        @endif
                            </td>


                        </tr>
                        @endforeach
                    </tbody>
                    </table>
                </div>
            </div>
          </div>
         </div>
        </div>
<script type="text/javascript">
    $(document).ready(function() {
        $("#menu_seguranca").addClass("treeview active");
    });
</script>
@endsection