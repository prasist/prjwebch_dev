@extends('principal.master')

@section('content')

{{ \Session::put('titulo', 'Grupos de Títulos') }}
{{ \Session::put('subtitulo', 'Inclusão') }}
{{ \Session::put('route', 'grupos_titulos') }}
{{ \Session::put('id_pagina', '51') }}

@include('inclusao_padrao')

@endsection