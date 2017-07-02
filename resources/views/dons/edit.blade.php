@extends('principal.master')

@section('content')

{{ \Session::put('titulo', 'Dons Espirituais') }}
{{ \Session::put('subtitulo', 'Alteração / Visualização') }}
{{ \Session::put('route', 'dons') }}
{{ \Session::put('id_pagina', '16') }}

@include('edicao_padrao')

@endsection