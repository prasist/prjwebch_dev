@extends('principal.master')

@section('content')

{{ \Session::put('titulo', 'Públicos Alvos') }}
{{ \Session::put('subtitulo', 'Inclusão') }}
{{ \Session::put('route', 'publicos') }}
{{ \Session::put('id_pagina', '43') }}

@include('inclusao_padrao')

@endsection