        <div>{{{ $errors->first('erros') }}}</div>

        <div class="row">
                <div class="col-xs-2">
                @can('verifica_permissao', [ \Session::get('id_pagina'),'incluir'])
                  <form method = 'get' class="form-horizontal" action = {{ url('/' . \Session::get('route') . '/registrar')}}>
                        <button class = 'btn btn-success btn-flat' type ='submit'><span class="glyphicon glyphicon-new-window"></span> Novo </button>
                  </form>
                @endcan
                </div>
        </div>

        <div class="row">
        <div class="col-md-12">
          <div class="box">
            <div class="box-header">

                <div class="box-body">


                    <table id="example1" class="table table-bordered table-hover">
                    <thead>
                        <tr>
                        <!--<th>ID</th>-->
                        <th>Descrição</th>
                        <th>Alterar</th>
                        <th>Visualizar</th>
                        <th>Excluir</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($dados as $value)

                        <tr>

                            <!--<td>{{$value->id}}</td>-->
                            <td>
                                  @can('verifica_permissao', [\Session::get('id_pagina') ,'alterar'])
                                  <a href = "{{ URL::to(\Session::get('route') .'/' . $value->id . '/edit') }}" data-toggle="tooltip" data-placement="top" title="Clique para Alterar">
                                        {{$value->nome}}
                                  </a>
                                  @else
                                        @can('verifica_permissao', [\Session::get('id_pagina') ,'visualizar'])
                                                <a href = "{{ URL::to(\Session::get('route') .'/' . $value->id . '/preview') }}" >
                                                      {{$value->nome}}
                                                </a>
                                        @else
                                                {{$value->nome}}
                                        @endcan
                                  @endcan
                            </td>

                            <td class="col-xs-1">
                                      @can('verifica_permissao', [\Session::get('id_pagina') ,'alterar'])
                                            <a href = "{{ URL::to(\Session::get('route') .'/' . $value->id . '/edit') }}" class = 'btn  btn-info btn-sm' data-toggle="tooltip" data-placement="top" title="Alterar Registro"><spam class="glyphicon glyphicon-pencil"></spam></a>
                                      @endcan
                            </td>

                            <td class="col-xs-1">
                                      @can('verifica_permissao', [\Session::get('id_pagina') ,'visualizar'])
                                               <a href = "{{ URL::to(\Session::get('route') .'/' . $value->id . '/preview') }}" class = 'btn btn-primary btn-sm' data-toggle="tooltip" data-placement="top" title="Visualizar Registro"><span class="glyphicon glyphicon-zoom-in"></span></a>
                                      @endcan
                            </td>
                            <td class="col-xs-1">
                                        @if ($value->default != 1)

                                                @can('verifica_permissao', [ \Session::get('id_pagina') ,'excluir'])
                                                <form id="excluir{{ $value->id }}" action="{{ URL::to(\Session::get('route') . '/' . $value->id . '/delete') }}" method="DELETE">

                                                      <button
                                                          data-toggle="tooltip" data-placement="top" title="Excluir Registro" type="submit"
                                                          class="btn btn-danger btn-sm"
                                                          onclick="return confirm('Confirma exclusão desse registro : {{ $value->nome }} ?');">
                                                          <spam class="glyphicon glyphicon-trash"></spam></button>

                                                </form>
                                                @endcan

                                        @endif
                            </td>

                        </tr>
                        @endforeach
                    </tbody>
                    </table>
                    <div id="tour3"></div>
                </div>
            </div>
          </div>
         </div>
        </div>

<script type="text/javascript">
    $(document).ready(function() {
        $("#menu_cadastros_base").addClass("treeview active");
    });
</script>