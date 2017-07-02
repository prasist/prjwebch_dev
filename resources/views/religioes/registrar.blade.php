@extends('principal.master')

@section('content')

{{ \Session::put('titulo', 'Religiões') }}
{{ \Session::put('subtitulo', 'Inclusão') }}
{{ \Session::put('route', 'religioes') }}
{{ \Session::put('id_pagina', '23') }}
@include('inclusao_padrao')

@endsection