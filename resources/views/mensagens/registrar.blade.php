@extends('principal.master')

@section('content')

{{ \Session::put('titulo', 'Mensagens') }}
{{ \Session::put('subtitulo', 'Envio') }}
{{ \Session::put('route', 'mensagens') }}
{{ \Session::put('id_pagina', '59') }}

@include('envio_mensagem')

@endsection