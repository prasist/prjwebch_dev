@extends('principal.master')

@section('content')

{{ \Session::put('titulo', 'Status') }}
{{ \Session::put('subtitulo', 'Inclusão') }}
{{ \Session::put('route', 'status') }}
{{ \Session::put('id_pagina', '8') }}
@include('inclusao_padrao')

@endsection