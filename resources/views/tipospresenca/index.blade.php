@extends('principal.master')

@section('content')

{{ \Session::put('titulo', 'Tipos de Presença') }}
{{ \Session::put('subtitulo', 'Listagem') }}
{{ \Session::put('route', 'tipospresenca') }}
{{ \Session::put('id_pagina', '17') }}

@include('pagina_padrao')

@endsection