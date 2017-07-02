@extends('principal.master')

@section('content')

{{ \Session::put('titulo', 'Configurações') }}
{{ \Session::put('subtitulo', 'Listagem') }}
{{ \Session::put('route', 'configuracoes') }}
{{ \Session::put('id_pagina', '41') }}

        <div>{{{ $errors->first('erros') }}}</div>

        <div class="row">
        <div class="col-md-12">
          <div class="box">
            <div class="box-header">

                <div class="box-body">

                    <div id="tour7"></div>
                    <table id="tab_simples" class="table table-bordered table-hover">
                    <thead>
                        <tr>
                        <th>Descrição</th>
                         <th>Alterar</th>
                        <th>Visualizar</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($dados as $value)

                        <tr>

                            <td>
                                  @can('verifica_permissao', [\Session::get('id_pagina') ,'alterar'])
                                  <a href = "{{ URL::to(\Session::get('route') .'/' . $value->id . '/edit') }}" >
                                        Configuração Padrão
                                  </a>
                                  @else
                                        @can('verifica_permissao', [\Session::get('id_pagina') ,'visualizar'])
                                                <a href = "{{ URL::to(\Session::get('route') .'/' . $value->id . '/preview') }}" >
                                                      Configuração Padrão
                                                </a>
                                        @else
                                                Configuração Padrão
                                        @endcan
                                  @endcan
                            </td>

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
        $("#menu_celulas").addClass("treeview active");
    });
</script>
@endsection