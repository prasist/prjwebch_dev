@extends('principal.master')

@section('content')

{{ \Session::put('titulo', 'Igrejas') }}
{{ \Session::put('subtitulo', 'Alteração / Visualização') }}
{{ \Session::put('route', 'igrejas') }}
{{ \Session::put('id_pagina', '7') }}

@include('edicao_padrao')

@endsection