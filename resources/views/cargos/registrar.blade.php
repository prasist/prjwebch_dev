@extends('principal.master')

@section('content')

{{ \Session::put('titulo', 'Cargos / Funções') }}
{{ \Session::put('subtitulo', 'Inclusão') }}
{{ \Session::put('route', 'cargos') }}
{{ \Session::put('id_pagina', '20') }}

@include('inclusao_padrao')

@endsection