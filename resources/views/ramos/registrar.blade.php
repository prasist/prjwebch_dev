@extends('principal.master')

@section('content')

{{ \Session::put('titulo', 'Ramos de Atividades') }}
{{ \Session::put('subtitulo', 'Inclusão') }}
{{ \Session::put('route', 'ramos') }}
{{ \Session::put('id_pagina', '21') }}

@include('inclusao_padrao')

@endsection