@extends('principal.master')

@section('content')

{{ \Session::put('titulo', 'Status') }}
{{ \Session::put('subtitulo', 'Alteração / Visualização') }}
{{ \Session::put('route', 'status') }}
{{ \Session::put('id_pagina', '8') }}

@include('edicao_padrao')
@endsection