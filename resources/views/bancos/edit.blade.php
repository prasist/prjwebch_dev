@extends('principal.master')

@section('content')

{{ \Session::put('titulo', 'Bancos') }}
{{ \Session::put('subtitulo', 'Alteração / Visualização') }}
{{ \Session::put('route', 'bancos') }}
{{ \Session::put('id_pagina', '35') }}

@include('edicao_padrao')

@endsection