@extends('principal.master')

@section('content')

{{ \Session::put('titulo', 'Idiomas') }}
{{ \Session::put('subtitulo', 'Inclusão') }}
{{ \Session::put('route', 'idiomas') }}
{{ \Session::put('id_pagina', '9') }}

@include('inclusao_padrao')

@endsection