@extends('principal.master')

@section('content')

{{ \Session::put('titulo', 'Habilidades') }}
{{ \Session::put('subtitulo', 'Inclusão') }}
{{ \Session::put('route', 'habilidades') }}
{{ \Session::put('id_pagina', '24') }}

@include('inclusao_padrao')

@endsection