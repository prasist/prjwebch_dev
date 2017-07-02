@extends('principal.master')

@section('content')

{{ \Session::put('titulo', 'Grupos de Títulos') }}
{{ \Session::put('subtitulo', 'Listagem') }}
{{ \Session::put('route', 'grupos_titulos') }}
{{ \Session::put('id_pagina', '51') }}
@include('pagina_padrao')

@endsection