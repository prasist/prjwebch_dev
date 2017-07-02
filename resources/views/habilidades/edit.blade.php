@extends('principal.master')

@section('content')

{{ \Session::put('titulo', 'Habilidades') }}
{{ \Session::put('subtitulo', 'Alteração / Visualização') }}
{{ \Session::put('route', 'habilidades') }}
{{ \Session::put('id_pagina', '24') }}

@include('edicao_padrao')

@endsection