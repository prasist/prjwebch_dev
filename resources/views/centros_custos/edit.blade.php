@extends('principal.master')

@section('content')

{{ \Session::put('titulo', 'Centros de Custos') }}
{{ \Session::put('subtitulo', 'Alteração / Visualização') }}
{{ \Session::put('route', 'centros_custos') }}
{{ \Session::put('id_pagina', '50') }}

@include('edicao_padrao')

@endsection