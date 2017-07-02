@extends('principal.master')

@section('content')

{{ \Session::put('titulo', 'Atividades') }}
{{ \Session::put('subtitulo', 'Inclusão') }}
{{ \Session::put('route', 'atividades') }}
{{ \Session::put('id_pagina', '15') }}

@include('inclusao_padrao')

@endsection