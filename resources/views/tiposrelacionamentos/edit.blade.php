@extends('principal.master')

@section('content')

{{ \Session::put('titulo', 'Tipos de Relacionamentos') }}
{{ \Session::put('subtitulo', 'Alteração / Visualização') }}
{{ \Session::put('route', 'tiposrelacionamentos') }}
{{ \Session::put('id_pagina', '55') }}

@include('edicao_padrao')
@endsection