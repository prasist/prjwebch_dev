@extends('principal.master')

@section('content')

{{ \Session::put('titulo', 'Disponiblidades de Tempo') }}
{{ \Session::put('subtitulo', 'Inclusão') }}
{{ \Session::put('route', 'disponibilidades') }}
{{ \Session::put('id_pagina', '25') }}

@include('inclusao_padrao')

@endsection