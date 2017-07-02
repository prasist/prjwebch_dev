@extends('principal.master')

@section('content')

{{ \Session::put('titulo', 'Tipos de Presença') }}
{{ \Session::put('subtitulo', 'Inclusão') }}
{{ \Session::put('route', 'tipospresenca') }}
{{ \Session::put('id_pagina', '17') }}
@include('inclusao_padrao')

@endsection