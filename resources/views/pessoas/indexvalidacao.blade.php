@extends('principal.master')

@section('content')

{{ \Session::put('titulo', 'Pessoas') }}
{{ \Session::put('subtitulo', 'Listagem') }}
{{ \Session::put('route', 'pessoas') }}
{{ \Session::put('id_pagina', '28') }}


        <div class="row">
        <div class="col-md-12">
          <div class="box">
            <div class="box-header" data-original-title>
                <div class="box-body table-responsive no-padding">

                        <ul>
                           <li>
                        <a href="{{ url('/pessoas/validar/repetidos')}}">Clique Aqui para verificar Registros Repetidos</a>
                        </li>
                        <li>
                        <a href="{{ url('/pessoas/validar/semdata')}}">Clique Aqui para verificar Pessoas Sem Data de Nascimento</a>
                        </li>
                        <li>
                        <a href="{{ url('/pessoas/validar/sememail')}}">Clique Aqui para verificar Pessoas Sem Email</a>
                        </li>
                        <li>
                        <a href="{{ url('/pessoas/validar/semfone')}}">Clique Aqui para verificar Pessoas Sem Telefones Cadastrados</a>
                        </li>

                        </ul>
                </div>
            </div>
          </div>
         </div>
        </div>

@endsection