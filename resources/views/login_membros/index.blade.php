@extends('principal.master')

@section('content')

{{ \Session::put('titulo', 'Login Membros') }}
{{ \Session::put('subtitulo', 'Listagem') }}
{{ \Session::put('route', 'login_membros') }}
{{ \Session::put('id_pagina', '61') }}


        <div>{{{ $errors->first('erros') }}}</div>

        <div class="row">
                <div class="col-xs-2">
                @can('verifica_permissao', [ \Session::get('id_pagina'),'incluir'])
                  <form method = 'get' class="form-horizontal" action = "{{ url('/' . \Session::get('route') . '/registrar')}}">
                        <button class = 'btn btn-success btn-flat' type ='submit'><i class="fa fa-file-text-o"></i> Gerar Login Membros</button>
                  </form>
                @endcan
                </div>

                <div class="col-xs-3">
                        <a href="{{ url('/tutoriais/3')}}" data-toggle="tooltip" title="Clique Aqui para ver o tutorial..." target="_blank">
                              <i class="glyphicon glyphicon-question-sign text-success"></i>&nbsp;Como criar um login para o Membro ?
                        </a>
                </div>


        </div>

        <div class="row">
        <div class="col-md-12">
          <div class="box">
            <div class="box-header">

                <div class="box-body">

                    <table id="tab_login" class="table table-bordered table-hover">
                    <thead>
                        <tr>
                        <th>Nome</th>
                        <th>Email</th>
                        <th>Último Acesso</th>
                        <th>IP</th>
                        <th>Excluir</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($usuarios as $value)

                        <tr>

                            <td>
                                    {{$value->name}}
                            </td>

                            <td>{{$value->email}}</td>

                            <td>{{$value->data_acesso}}</td>

                            <td>{{$value->ip}}</td>

                            <td class="col-xs-1">

                                      @can('verifica_permissao', [ \Session::get('id_pagina') ,'excluir'])
                                      <form id="excluir{{ $value->id }}" action="{{ URL::to(\Session::get('route') . '/' . $value->id . '/delete') }}" method="DELETE">

                                            <button
                                                data-toggle="tooltip" data-placement="top" title="Excluir Registro" type="submit"
                                                class="btn btn-danger btn-sm"
                                                onclick="return confirm('Confirma exclusão do registro ?');">
                                                <spam class="glyphicon glyphicon-trash"></spam></button>

                                      </form>
                                      @endcan

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