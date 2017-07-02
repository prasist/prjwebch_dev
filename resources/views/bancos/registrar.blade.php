@extends('principal.master')

@section('content')

{{ \Session::put('titulo', 'Bancos') }}
{{ \Session::put('subtitulo', 'Inclusão') }}
{{ \Session::put('route', 'bancos') }}
{{ \Session::put('id_pagina', '35') }}

@include('inclusao_padrao')

@endsection