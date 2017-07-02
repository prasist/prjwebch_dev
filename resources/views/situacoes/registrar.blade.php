@extends('principal.master')

@section('content')

{{ \Session::put('titulo', 'Situações') }}
{{ \Session::put('subtitulo', 'Inclusão') }}
{{ \Session::put('route', 'situacoes') }}
{{ \Session::put('id_pagina', '26') }}
@include('inclusao_padrao')

@endsection