@extends('principal.master')

@section('content')

{{ \Session::put('titulo', 'Situações') }}
{{ \Session::put('subtitulo', 'Listagem') }}
{{ \Session::put('route', 'situacoes') }}
{{ \Session::put('id_pagina', '26') }}

@include('pagina_padrao')

@endsection