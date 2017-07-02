@extends('principal.master')

@section('content')

{{ \Session::put('titulo', 'Cursos / Eventos') }}
{{ \Session::put('subtitulo', 'Listagem') }}
{{ \Session::put('route', 'cursos') }}
{{ \Session::put('id_pagina', '66') }}

@include('pagina_padrao')

@endsection