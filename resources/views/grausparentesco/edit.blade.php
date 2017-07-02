@extends('principal.master')

@section('content')

{{ \Session::put('titulo', 'Graus de Parentesco') }}
{{ \Session::put('subtitulo', 'Alteração / Visualização') }}
{{ \Session::put('route', 'grausparentesco') }}
{{ \Session::put('id_pagina', '19') }}

@include('edicao_padrao')

@endsection