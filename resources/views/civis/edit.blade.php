@extends('principal.master')

@section('content')

{{ \Session::put('titulo', 'Estados Civis') }}
{{ \Session::put('subtitulo', 'Alteração / Visualização') }}
{{ \Session::put('route', 'civis') }}
{{ \Session::put('id_pagina', '22') }}

@include('edicao_padrao')

@endsection