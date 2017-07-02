@extends('principal.master')

@section('content')

{{ \Session::put('titulo', 'Bancos') }}
{{ \Session::put('subtitulo', 'Listagem') }}
{{ \Session::put('route', 'bancos') }}
{{ \Session::put('id_pagina', '35') }}

@include('pagina_padrao')

@endsection