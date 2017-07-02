@extends('principal.master')

@section('content')

{{ \Session::put('titulo', 'Religiões') }}
{{ \Session::put('subtitulo', 'Alteração / Visualização') }}
{{ \Session::put('route', 'religioes') }}
{{ \Session::put('id_pagina', '23') }}

@include('edicao_padrao')
@endsection