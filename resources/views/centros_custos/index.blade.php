@extends('principal.master')

@section('content')

{{ \Session::put('titulo', 'Centros de Custos') }}
{{ \Session::put('subtitulo', 'Listagem') }}
{{ \Session::put('route', 'centros_custos') }}
{{ \Session::put('id_pagina', '50') }}


@include('pagina_padrao')

@endsection