@extends('principal.master')

@section('content')

{{ \Session::put('titulo', 'Estados Civis') }}
{{ \Session::put('subtitulo', 'Inclusão') }}
{{ \Session::put('route', 'civis') }}
{{ \Session::put('id_pagina', '22') }}

@include('inclusao_padrao')

@endsection