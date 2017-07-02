@extends('principal.master')

@section('content')

{{ \Session::put('titulo', 'Centros de Custos') }}
{{ \Session::put('subtitulo', 'Inclusão') }}
{{ \Session::put('route', 'centros_custos') }}
{{ \Session::put('id_pagina', '50') }}

@include('inclusao_padrao')

@endsection