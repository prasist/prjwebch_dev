@extends('principal.master')

@section('content')

{{ \Session::put('titulo', 'Avisos do Sistema') }}
{{ \Session::put('subtitulo', 'Listagem') }}
{{ \Session::put('route', 'home') }}
{{ \Session::put('id_pagina', '34') }}

        <ul>
        @foreach($dados as $item)

                        <li><a href="{{url('/avisos/ler/' . $item->id . '')}}">{{$item->titulo}}  - {!! date('d/m/Y',strtotime($item->data_publicacao)) !!}</a></li>


        @endforeach
        </ul>

@endsection