@extends('principal.master')

@section('content')


{{ \Session::put('titulo', 'Graus de Parentesco') }}
{{ \Session::put('subtitulo', 'Listagem') }}
{{ \Session::put('route', 'grausparentesco') }}
{{ \Session::put('id_pagina', '19') }}

@include('pagina_padrao')

@endsection