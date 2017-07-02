@extends('principal.master')

@section('content')

{{ \Session::put('titulo', 'Grupos de Pessoas') }}
{{ \Session::put('subtitulo', 'Inclusão') }}
{{ \Session::put('route', 'grupospessoas') }}
{{ \Session::put('id_pagina', '31') }}

@include('inclusao_padrao')

@endsection