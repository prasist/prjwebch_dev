@extends('principal.master')

@section('content')

{{ \Session::put('titulo', 'Cargos / Funções') }}
{{ \Session::put('subtitulo', 'Alteração / Visualização') }}
{{ \Session::put('route', 'cargos') }}
{{ \Session::put('id_pagina', '20') }}

@include('edicao_padrao')

@endsection