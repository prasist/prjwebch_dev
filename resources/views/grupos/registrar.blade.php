@extends('principal.master')

@section('content')

{{ \Session::put('titulo', 'Grupos de Usuário') }}
{{ \Session::put('subtitulo', 'Inclusão') }}
{{ \Session::put('route', 'grupos') }}

@include('inclusao_padrao')

@endsection