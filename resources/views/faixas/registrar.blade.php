@extends('principal.master')

@section('content')

{{ \Session::put('titulo', 'Faixas Etárias') }}
{{ \Session::put('subtitulo', 'Inclusão') }}
{{ \Session::put('route', 'faixas') }}
{{ \Session::put('id_pagina', '44') }}

@include('inclusao_padrao')

@endsection