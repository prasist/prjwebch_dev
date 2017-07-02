@extends('principal.master')

@section('content')

{{ \Session::put('titulo', 'Questionários') }}
{{ \Session::put('subtitulo', 'Listagem') }}
{{ \Session::put('route', 'questionarios') }}
{{ \Session::put('id_pagina', '57') }}


        <div>{{{ $errors->first('erros') }}}</div>

        <div class="row">
                <div class="col-xs-2">
                @can('verifica_permissao', [ \Session::get('id_pagina'),'incluir'])
                  <form method = 'get' class="form-horizontal" action = {{ url('/' . \Session::get('route') . '/registrar')}}>
                        <button class = 'btn btn-success btn-flat' type ='submit'><i class="fa fa-file-text-o"></i> Novo Registro</button>
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
                        <th>Pergunta</th>
                        <th>Tipo Resposta</th>
                         <th>Alterar</th>
                        <th>Visualizar</th>
                        <th>Excluir</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($dados as $value)
                        <tr>

                            <td>
                                  @can('verifica_permissao', [\Session::get('id_pagina') ,'alterar'])
                                  <a href = "{{ URL::to(\Session::get('route') .'/' . $value->id . '/edit') }}" >
                                        {{$value->pergunta}}
                                  </a>
                                  @else
                                        @can('verifica_permissao', [\Session::get('id_pagina') ,'visualizar'])
                                                <a href = "{{ URL::to(\Session::get('route') .'/' . $value->id . '/preview') }}" >
                                                      {{$value->pergunta}}
                                                </a>
                                        @else
                                                {{$value->pergunta}}
                                        @endcan
                                  @endcan

                            </td>
                            <td>{{ ($value->tipo_resposta==1 ? 'Sim/Não' : ($value->tipo_resposta==2 ? "Campo Numérico" : "Campo Texto")) }}</td>

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
                                                          data-toggle="tooltip" data-placement="top" title="Excluir Ítem" type="submit"
                                                          class="btn btn-danger btn-sm"
                                                          onclick="return confirm('Confirma exclusão desse registro ?');">
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
        $("#menu_cadastros_base").addClass("treeview active");
    });
</script>
@endsection