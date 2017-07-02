</span>@extends('principal.master')

@section('content')

{{ \Session::put('titulo', 'Células / Participantes') }}
{{ \Session::put('subtitulo', 'Listagem') }}
{{ \Session::put('route', 'celulaspessoas') }}
{{ \Session::put('id_pagina', '45') }}

        <div>{{{ $errors->first('erros') }}}</div>

        <div class="row">
                <div class="col-xs-2">
                @can('verifica_permissao', [ \Session::get('id_pagina'),'incluir'])
                  <form method = 'get' class="form-horizontal" action = "{{ url('/' . \Session::get('route') . '/registrar')}}">
                        <button class = 'btn btn-success btn-flat' type ='submit'><span class="glyphicon glyphicon-new-window"></span> Incluir Participante(s) em uma Célula</button>
                  </form>
                @endcan
                </div>
        </div>

        <div class="row">
        <div class="col-md-12">
          <div class="box">
            <div class="box-header">

                <div class="box-body table-responsive no-padding">

                    <table id="tab_celulas_pessoas" class="table table-responsive table-hover">
                    <thead>
                        <tr>
                        <!--<th>ID</th>-->
                        <th>Nome Célula</th>
                        <th>Líder / Qtd. Participantes</th>
                        <th>Cor</th>
                        <th>Alterar</th>
                        <th>Visualizar</th>
                        <th>Imprimir</th>
                        <th>Excluir</th>
                        </tr>
                    </thead>
                    <tbody>

                        @foreach($dados as $value)

                        <tr>

                            <td>
                                  @can('verifica_permissao', [\Session::get('id_pagina') ,'alterar'])
                                  <a href = "{{ URL::to(\Session::get('route') .'/' . $value->celulas_id . '/edit') }}" data-toggle="tooltip" data-placement="top" title="Clique para Alterar">
                                        {!! $value->nome_celula !!}
                                  </a>
                                  @else
                                        @can('verifica_permissao', [\Session::get('id_pagina') ,'visualizar'])
                                                <a href = "{{ URL::to(\Session::get('route') .'/' . $value->celulas_id . '/preview') }}" >
                                                      {!! $value->nome_celula !!}
                                                </a>
                                        @else
                                                {!! $value->nome_celula !!}
                                        @endcan
                                  @endcan
                            </td>

                            <td>
                                  @can('verifica_permissao', [\Session::get('id_pagina') ,'alterar'])
                                  <a href = "{{ URL::to(\Session::get('route') .'/' . $value->celulas_id . '/edit') }}" data-toggle="tooltip" data-placement="top" title="Clique para Alterar">
                                        {!! $value->nome !!} <span class="badge bg-blue">{!!$value->tot!!}</span>
                                  </a>
                                  @else
                                        @can('verifica_permissao', [\Session::get('id_pagina') ,'visualizar'])
                                                <a href = "{{ URL::to(\Session::get('route') .'/' . $value->celulas_id . '/preview') }}" >
                                                      {!! $value->nome !!} <span class="badge bg-blue">{!!$value->tot!!}</span>
                                                </a>
                                        @else
                                                {!! $value->nome !!} <span class="badge bg-blue">{!!$value->tot!!}</span>
                                        @endcan
                                  @endcan
                            </td>

                            <td style="color: #{!! rtrim(ltrim($value->cor)) !!};  background-color:#{!! rtrim(ltrim($value->cor)) !!};">
                                  {!! rtrim(ltrim($value->cor)) !!}
                            </td>

                            <td class="col-xs-1">
                                      @can('verifica_permissao', [\Session::get('id_pagina') ,'alterar'])
                                            <a href = "{{ URL::to(\Session::get('route') .'/' . $value->celulas_id . '/edit') }}" class = 'btn  btn-info btn-sm'><spam class="glyphicon glyphicon-pencil"></spam></a>
                                      @endcan
                            </td>

                            <td class="col-xs-1">
                                      @can('verifica_permissao', [\Session::get('id_pagina') ,'visualizar'])
                                               <a href = "{{ URL::to(\Session::get('route') .'/' . $value->celulas_id . '/preview') }}" class = 'btn btn-primary btn-sm'><span class="glyphicon glyphicon-zoom-in"></span></a>
                                      @endcan
                            </td>

                            <td class="col-xs-1">
                                      @can('verifica_permissao', [\Session::get('id_pagina') ,'imprimir'])
                                               <a href = "{{ URL::to(\Session::get('route') .'/' . $value->celulas_id . '/imprimir') }}" class = 'btn btn-warning btn-sm'><span class="glyphicon glyphicon-print"></span></a>
                                      @endcan
                            </td>

                            <td class="col-xs-1">

                                    @can('verifica_permissao', [ \Session::get('id_pagina') ,'excluir'])
                                    <form id="excluir{{ $value->celulas_id }}" action="{{ URL::to(\Session::get('route') . '/' . $value->celulas_id . '/delete') }}" method="DELETE">

                                          <button
                                              data-toggle="tooltip" data-placement="top" title="Excluir Ítem" type="submit"
                                              class="btn btn-danger btn-sm"
                                              onclick="return confirm('Confirma exclusão desse registro : {{ $value->nome }} ?');">
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
        $("#menu_celulas").addClass("treeview active");
    });
</script>

@endsection