@extends('principal.master')

@section('content')

{{ \Session::put('titulo', 'Áreas de Formação') }}
{{ \Session::put('subtitulo', 'Listagem') }}
{{ \Session::put('route', 'areas') }}
{{ \Session::put('id_pagina', '12') }}

@include('pagina_padrao')

@endsection