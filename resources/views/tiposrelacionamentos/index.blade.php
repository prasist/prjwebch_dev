@extends('principal.master')

@section('content')

{{ \Session::put('titulo', 'Tipos de Relacionamentos') }}
{{ \Session::put('subtitulo', 'Listagem') }}
{{ \Session::put('route', 'tiposrelacionamentos') }}
{{ \Session::put('id_pagina', '55') }}

@include('pagina_padrao')

@endsection