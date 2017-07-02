@extends('principal.master')

@section('content')

{{ \Session::put('titulo', 'Grupos de Títulos') }}
{{ \Session::put('subtitulo', 'Alteração / Visualização') }}
{{ \Session::put('route', 'grupos_titulos') }}
{{ \Session::put('id_pagina', '51') }}

@include('edicao_padrao')

@endsection