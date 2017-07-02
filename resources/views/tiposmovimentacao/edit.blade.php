@extends('principal.master')

@section('content')

{{ \Session::put('titulo', 'Tipos de Movimentação Membros') }}
{{ \Session::put('subtitulo', 'Alteração / Visualização') }}
{{ \Session::put('route', 'tiposmovimentacao') }}
{{ \Session::put('id_pagina', '18') }}

@include('edicao_padrao')
@endsection