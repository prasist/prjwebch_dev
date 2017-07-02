@extends('principal.master')

@section('content')

{{ \Session::put('titulo', 'Profissões') }}
{{ \Session::put('subtitulo', 'Alteração / Visualização') }}
{{ \Session::put('route', 'profissoes') }}
{{ \Session::put('id_pagina', '11') }}

@include('edicao_padrao')

@endsection