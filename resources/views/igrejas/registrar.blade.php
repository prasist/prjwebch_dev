@extends('principal.master')

@section('content')

{{ \Session::put('titulo', 'Igrejas') }}
{{ \Session::put('subtitulo', 'Inclusão') }}
{{ \Session::put('route', 'igrejas') }}
{{ \Session::put('id_pagina', '7') }}

@include('inclusao_padrao')

@endsection