@extends('principal.master')

@section('content')

{{ \Session::put('titulo', 'Validação de Dados') }}
{{ \Session::put('subtitulo', 'Listagem') }}
{{ \Session::put('route', 'pessoas') }}
{{ \Session::put('id_pagina', '28') }}


        <div class="row">
        <div class="col-md-12">
          <div class="box">
            <div class="box-header" data-original-title>
                <div class="box-body table-responsive no-padding">

                        <ul>
                        @foreach($dados as $value)

                            <li>{{$value->id}}

                                  @can('verifica_permissao', [\Session::get('id_pagina') ,'alterar'])
                                  <a href = "{{ URL::to(\Session::get('route') .'/' . $value->id . '/edit') }}" data-toggle="tooltip" data-placement="top" title="Clique para Alterar">
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


                            - {{$value->tipo}} -


                                      @can('verifica_permissao', [\Session::get('id_pagina') ,'alterar'])
                                            <a href = "{{ URL::to(\Session::get('route') .'/' . $value->id . '/edit') }}" class = 'btn  btn-info btn-sm' data-toggle="tooltip" data-placement="top" title="Alterar Registro">Alterar</a>
                                      @endcan


                                      @can('verifica_permissao', [\Session::get('id_pagina') ,'visualizar'])
                                               <a href = "{{ URL::to(\Session::get('route') .'/' . $value->id . '/preview') }}" class = 'btn btn-primary btn-sm' data-toggle="tooltip" data-placement="top" title="Visualizar Registro">Visualizar</a>
                                      @endcan

                                      @can('verifica_permissao', [ \Session::get('id_pagina') ,'excluir'])
                                        <form id="excluir{{ $value->id }}" action="{{ URL::to(\Session::get('route') . '/' . $value->id . '/delete') }}" method="DELETE">

                                              <button
                                                  data-toggle="tooltip" data-placement="top" title="Excluir Registro" type="submit"
                                                  class="btn btn-danger btn-sm"
                                                  onclick="return confirm('Confirma exclusão desse registro : {{ $value->razaosocial }} ?');">
                                                  Excluir</button>

                                        </form>
                                      @endcan
                                     </li>


                        @endforeach

                    </ul>

                </div>
            </div>
          </div>
         </div>
        </div>

@endsection