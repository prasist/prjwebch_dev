@extends('principal.master')

@section('content')

{{ \Session::put('titulo', 'Ministérios') }}
{{ \Session::put('subtitulo', 'Inclusão') }}
{{ \Session::put('route', 'ministerios') }}
{{ \Session::put('id_pagina', '13') }}

@include('inclusao_padrao')

@endsection