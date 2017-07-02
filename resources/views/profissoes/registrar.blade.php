@extends('principal.master')

@section('content')

{{ \Session::put('titulo', 'Profissões') }}
{{ \Session::put('subtitulo', 'Inclusão') }}
{{ \Session::put('route', 'profissoes') }}
{{ \Session::put('id_pagina', '11') }}

@include('inclusao_padrao')

@endsection