@extends('principal.master')

@section('content')

{{ \Session::put('titulo', 'Faixas Etárias') }}
{{ \Session::put('subtitulo', 'Alteração / Visualização') }}
{{ \Session::put('route', 'faixas') }}
{{ \Session::put('id_pagina', '44') }}

@include('edicao_padrao')

@endsection