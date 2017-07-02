@extends('principal.master')

@section('content')

{{ \Session::put('titulo', 'Tipos de Presença') }}
{{ \Session::put('subtitulo', 'Alteração / Visualização') }}
{{ \Session::put('route', 'tipospresenca') }}
{{ \Session::put('id_pagina', '17') }}
@include('edicao_padrao')
@endsection