@extends('principal.master')

@section('content')

{{ \Session::put('titulo', 'Graus de Instrução') }}
{{ \Session::put('subtitulo', 'Inclusão') }}
{{ \Session::put('route', 'graus') }}
{{ \Session::put('id_pagina', '10') }}

@include('inclusao_padrao')

@endsection