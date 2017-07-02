@extends('principal.master')

@section('content')

{{ \Session::put('titulo', 'Tipos de Relacionamentos') }}
{{ \Session::put('subtitulo', 'Incluir') }}
{{ \Session::put('route', 'tiposrelacionamentos') }}
{{ \Session::put('id_pagina', '55') }}

@include('inclusao_padrao')

@endsection