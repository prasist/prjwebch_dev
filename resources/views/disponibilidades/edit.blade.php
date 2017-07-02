@extends('principal.master')

@section('content')

{{ \Session::put('titulo', 'Disponiblidades de Tempo') }}
{{ \Session::put('subtitulo', 'Alteração / Visualização') }}
{{ \Session::put('route', 'disponibilidades') }}
{{ \Session::put('id_pagina', '25') }}

@include('edicao_padrao')

@endsection