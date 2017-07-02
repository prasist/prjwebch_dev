@extends('principal.master')

@section('content')

{{ \Session::put('titulo', 'Igrejas') }}
{{ \Session::put('subtitulo', 'Listagem') }}
{{ \Session::put('route', 'igrejas') }}
{{ \Session::put('id_pagina', '7') }}

@include('pagina_padrao')

@endsection