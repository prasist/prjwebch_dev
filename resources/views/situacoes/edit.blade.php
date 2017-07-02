@extends('principal.master')

@section('content')

{{ \Session::put('titulo', 'Situações') }}
{{ \Session::put('subtitulo', 'Alteração / Visualização') }}
{{ \Session::put('route', 'situacoes') }}
{{ \Session::put('id_pagina', '26') }}

@include('edicao_padrao')
@endsection