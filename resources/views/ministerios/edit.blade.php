@extends('principal.master')

@section('content')

{{ \Session::put('titulo', 'Ministérios') }}
{{ \Session::put('subtitulo', 'Alteração / Visualização') }}
{{ \Session::put('route', 'ministerios') }}
{{ \Session::put('id_pagina', '13') }}

@include('edicao_padrao')

@endsection