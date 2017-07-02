@extends('principal.master')

@section('content')

{{ \Session::put('titulo', 'Áreas de Formação') }}
{{ \Session::put('subtitulo', 'Inclusão') }}
{{ \Session::put('route', 'areas') }}
{{ \Session::put('id_pagina', '12') }}

@include('inclusao_padrao')

@endsection