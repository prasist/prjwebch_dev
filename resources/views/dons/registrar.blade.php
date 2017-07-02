@extends('principal.master')

@section('content')

{{ \Session::put('titulo', 'Dons Espirituais') }}
{{ \Session::put('subtitulo', 'Inclusão') }}
{{ \Session::put('route', 'dons') }}
{{ \Session::put('id_pagina', '16') }}

@include('inclusao_padrao')

@endsection