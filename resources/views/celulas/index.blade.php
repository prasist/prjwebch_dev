@extends('principal.master')

@section('content')

{{ \Session::put('titulo', \Session::get('label_celulas')) }}
{{ \Session::put('subtitulo', 'Listagem') }}
{{ \Session::put('route', 'celulas') }}
{{ \Session::put('id_pagina', '42') }}


        <div>{{{ $errors->first('erros') }}}</div>

        <div class="row">
                <div class="col-xs-2">
                @can('verifica_permissao', [ \Session::get('id_pagina'),'incluir'])
                  <form method = 'get' class="form-horizontal" action = "{{ url('/' . \Session::get('route') . '/registrar')}}">
                        <button class = 'btn btn-success btn-flat' type ='submit'><i class="fa fa-file-text-o"></i> Criar {!! \Session::get('label_celulas_singular') !!}</button>
                  </form>
                @endcan
                </div>

                <div class="col-xs-3">
                    <a href="{{ url('/tutoriais/4')}}" data-toggle="tooltip" title="Clique Aqui para ver o tutorial..." target="_blank">
                        <i class="glyphicon glyphicon-question-sign text-success"></i>&nbsp;Como cadastrar {!! \Session::get('label_celulas') !!} ?
                   </a>
                </div>

               <div class="col-xs-5">
                        <p class="text"><i> Legendas</i></p>
                        <span class="badge bg-yellow">0</span>&nbsp;Quantidade {!! \Session::get('label_celulas_singular') !!} Multiplicadas (Primeira Geração)
                        <br/>
                        <span class="badge bg-purple">0</span>&nbsp;Quantidade {!! \Session::get('label_celulas_singular') !!} Multiplicadas (Segunda Geração)
                        <br/>
                        <span class="badge bg-blue">0</span>&nbsp;Quantidade de {!! \Session::get('label_participantes') !!}
                        <br/>
              </div>

        </div>


        <div class="row">
        <div class="col-md-12">
          <div class="box">
            <div class="box-header">

                <div class="box-body table-responsive no-padding">

                    <table id="table_celulas" class="table table-responsive table-hover">
                    <thead>
                        <tr>
                        <th>Nome {!! \Session::get('label_celulas_singular') !!}</th>
                        <th>{!! \Session::get('label_lider_singular') !!}</th>
                        <th>Dia Encontro</th>
                        <th>Região</th>
                        <th>Horário</th>
                        <th>Cor</th>
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
                                  <a href = "{{ URL::to(\Session::get('route') .'/' . $value->id . '/edit') }}" data-toggle="tooltip" data-placement="top" title="Clique para Alterar">
                                       {!! $value->nome !!}
                                  </a>
                                  @else
                                        @can('verifica_permissao', [\Session::get('id_pagina') ,'visualizar'])
                                                <a href = "{{ URL::to(\Session::get('route') .'/' . $value->id . '/preview') }}" >
                                                      {!! $value->nome !!}
                                                </a>
                                        @else
                                                {!! $value->nome !!}
                                        @endcan
                                  @endcan
                            </td>

                            <td>
                                  @can('verifica_permissao', [\Session::get('id_pagina') ,'alterar'])
                                  <a href = "{{ URL::to(\Session::get('route') .'/' . $value->id . '/edit') }}" data-toggle="tooltip" data-placement="top" title="Clique para Alterar">
                                       {!! $value->razaosocial !!} <span class="badge bg-blue">{!!$value->tot!!}</span>
                                  </a>
                                  @else
                                        @can('verifica_permissao', [\Session::get('id_pagina') ,'visualizar'])
                                                <a href = "{{ URL::to(\Session::get('route') .'/' . $value->id . '/preview') }}" >
                                                      {!! $value->razaosocial !!} <span class="badge bg-blue">{!!$value->tot!!}</span>
                                                </a>
                                        @else
                                                {!! $value->razaosocial !!} <span class="badge bg-blue">{!!$value->tot!!}</span>
                                        @endcan
                                  @endcan
                                  @if ($value->tot_geracao>0)
                                  <span class="badge bg-yellow">{!! ($value->tot_geracao) !!}</span>
                                  @endif
                                  @if (isset($value->total_ant))
                                      @if ($value->total_ant>0)
                                      <span class="badge bg-purple">{!! ($value->total_ant) !!}</span>
                                      @endif
                                  @endif
                            </td>

                            <td>{!! $value->descricao_dia_encontro !!}</td>
                            <td>{!! $value->regiao !!}</td>
                            <td>{!! $value->horario !!}</td>
                            <td style="color: #{!! rtrim(ltrim($value->cor)) !!};  background-color:#{!! rtrim(ltrim($value->cor)) !!};">
                                  {!! rtrim(ltrim($value->cor)) !!}
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
        $("#menu_celulas").addClass("treeview active");
    });
</script>
@endsection