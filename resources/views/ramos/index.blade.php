@extends('principal.master')

@section('content')

{{ \Session::put('titulo', 'Ramos de Atividades') }}
{{ \Session::put('subtitulo', 'Listagem') }}
{{ \Session::put('route', 'ramos') }}
{{ \Session::put('id_pagina', '21') }}

@include('pagina_padrao')

@endsection