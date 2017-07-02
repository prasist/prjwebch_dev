@extends('principal.master')

@section('content')

{{ \Session::put('titulo', 'Igreja Sede') }}
{{ \Session::put('subtitulo', 'Listagem') }}
{{ \Session::put('route', 'clientes') }}
{{ \Session::put('id_pagina', '1') }}

        <div>{{{ $errors->first('erros') }}}</div>
        <div class="row">
        <div class="col-md-12">
          <div class="box">
            <div class="box-header">

                <div class="box-body">

                    <table id="example1" class="table table-bordered table-hover">
                    <thead>
                        <tr>
                        <th>Razão Social</th>
                        <th>Nome Fantasia</th>
                        <th>CNPJ</th>
                        <th>Insc. Est.</th>
                        <th>Alterar</th>
                        <th>Visualizar</th>

                        </tr>
                    </thead>
                    <tbody>

                        @foreach($clientes_cloud as $value)

                        <tr>

                            <td>
                                  @can('verifica_permissao', [\Session::get('id_pagina') ,'alterar'])
                                  <a href = "{{ URL::to(\Session::get('route') .'/' . $value->id . '/edit') }}" >
                                        {{$value->razaosocial}}
                                  </a>
                                  @else
                                        @can('verifica_permissao', [\Session::get('id_pagina') ,'visualizar'])
                                                <a href = "{{ URL::to(\Session::get('route') .'/' . $value->id . '/preview') }}" >
                                                      {{$value->razaosocial}}
                                                </a>
                                        @else
                                                {{$value->razaosocial}}
                                        @endcan
                                  @endcan


                            </td>
                            <td>{{$value->nomefantasia}}</td>
                            <td>{{$value->cnpj}}</td>
                            <td>{{$value->inscricaoestadual}}</td>

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
        $("#menu_config").addClass("treeview active");
    });
</script>
@endsection