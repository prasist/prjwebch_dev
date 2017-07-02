@extends('principal.master')

@section('content')

{{ \Session::put('titulo', 'Atividades') }}
{{ \Session::put('subtitulo', 'Alteração / Visualização') }}
{{ \Session::put('route', 'atividades') }}
{{ \Session::put('id_pagina', '15') }}

@include('edicao_padrao')

@endsection