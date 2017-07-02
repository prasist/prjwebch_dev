@extends('principal.master')

@section('content')

{{ \Session::put('titulo', 'Ramos de Atividades') }}
{{ \Session::put('subtitulo', 'Alteração / Visualização') }}
{{ \Session::put('route', 'ramos') }}
{{ \Session::put('id_pagina', '21') }}
@include('edicao_padrao')
@endsection