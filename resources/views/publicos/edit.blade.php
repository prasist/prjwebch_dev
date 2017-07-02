@extends('principal.master')

@section('content')

{{ \Session::put('titulo', 'Públicos Alvos') }}
{{ \Session::put('subtitulo', 'Alteração / Visualização') }}
{{ \Session::put('route', 'publicos') }}
{{ \Session::put('id_pagina', '43') }}

@include('edicao_padrao')

@endsection