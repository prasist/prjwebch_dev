@extends('principal.master')

@section('content')

{{ \Session::put('titulo', 'Ministérios') }}
{{ \Session::put('subtitulo', 'Listagem') }}
{{ \Session::put('route', 'ministerios') }}
{{ \Session::put('id_pagina', '13') }}

@include('pagina_padrao')

@endsection