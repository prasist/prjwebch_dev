@extends('principal.master')

@section('content')

{{ \Session::put('titulo', 'Tipos de Movimentação Membros') }}
{{ \Session::put('subtitulo', 'Incluir') }}
{{ \Session::put('route', 'tiposmovimentacao') }}
{{ \Session::put('id_pagina', '18') }}

@include('inclusao_padrao')

@endsection