@extends('principal.master')

@section('content')

{{ \Session::put('titulo', 'Religiões') }}
{{ \Session::put('subtitulo', 'Listagem') }}
{{ \Session::put('route', 'religioes') }}
{{ \Session::put('id_pagina', '23') }}

@include('pagina_padrao')

@endsection