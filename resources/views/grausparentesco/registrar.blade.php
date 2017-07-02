@extends('principal.master')

@section('content')

{{ \Session::put('titulo', 'Graus de Parentesco') }}
{{ \Session::put('subtitulo', 'Inclusão') }}
{{ \Session::put('route', 'grausparentesco') }}
{{ \Session::put('id_pagina', '19') }}

@include('inclusao_padrao')

@endsection