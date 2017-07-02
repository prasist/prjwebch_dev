@extends('principal.master')

@section('content')

{{ \Session::put('titulo', 'Relatório Resumo Encontros') }}
{{ \Session::put('subtitulo', 'Listagem') }}
{{ \Session::put('route', 'relencontro') }}
{{ \Session::put('id_pagina', '46') }}

@include('filtro_rel_encontro')

@include('configuracoes.script_estruturas')
@endsection