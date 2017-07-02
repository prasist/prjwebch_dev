@extends('principal.master')

@section('content')

{{ \Session::put('titulo', 'Habilidades') }}
{{ \Session::put('subtitulo', 'Listagem') }}
{{ \Session::put('route', 'habilidades') }}
{{ \Session::put('id_pagina', '24') }}

@include('pagina_padrao')

@endsection