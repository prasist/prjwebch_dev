@extends('principal.master')

@section('content')

{{ \Session::put('titulo', 'Áreas de Formação') }}
{{ \Session::put('subtitulo', 'Alteração / Visualização') }}
{{ \Session::put('route', 'areas') }}
{{ \Session::put('id_pagina', '12') }}

@include('edicao_padrao')

@endsection