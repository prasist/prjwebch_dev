@extends('principal.master')

@section('content')

{{ \Session::put('titulo', 'Graus de Instrução') }}
{{ \Session::put('subtitulo', 'Alteração / Visualização') }}
{{ \Session::put('route', 'graus') }}
{{ \Session::put('id_pagina', '10') }}

@include('edicao_padrao')

@endsection