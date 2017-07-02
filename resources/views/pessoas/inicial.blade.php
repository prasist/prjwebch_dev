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
                              <li><a href={{ url('/' . \Session::get('route') . '/registrar/' . $item->id )}}>{{ $item->nome }}</a></li>
                          @endforeach

                        </ul>
                  </div>
                  <br/>
              </div>

                @endcan
                </div>
        </div>


@include('pessoas.filtros_pesquisa')


@endsection