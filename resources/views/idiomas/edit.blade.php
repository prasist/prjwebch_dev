@extends('principal.master')

@section('content')

{{ \Session::put('titulo', 'Idiomas') }}
{{ \Session::put('subtitulo', 'Alteração / Visualização') }}
{{ \Session::put('route', 'idiomas') }}
{{ \Session::put('id_pagina', '9') }}

@include('edicao_padrao')

@endsection