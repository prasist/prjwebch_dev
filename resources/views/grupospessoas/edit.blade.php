@extends('principal.master')

@section('content')

{{ \Session::put('titulo', 'Grupos de Pessoas') }}
{{ \Session::put('subtitulo', 'Alteração / Visualização') }}
{{ \Session::put('route', 'grupospessoas') }}
{{ \Session::put('id_pagina', '31') }}

@include('edicao_padrao')

@endsection