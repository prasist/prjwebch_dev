@extends('principal.master')

@section('content')

{{ \Session::put('titulo', 'Avisos do Sistema') }}
{{ \Session::put('subtitulo', 'Avisos') }}
{{ \Session::put('route', 'home') }}
{{ \Session::put('id_pagina', '34') }}

<div class="row">
        <div class="col-md-12">
          <div class="box">
            <div class="box-header">


                <div class="content body">

                      <section id="introduction">
                        <h2 class="page-header"><a href="#introduction">{!!$dados[0]->titulo!!}</a></h2>
                        <p class="lead">
                        {!!$dados[0]->texto!!}
                        </p>
                      </section><!-- /#introduction -->

                      <br/>
                      <ul>
                      @foreach($outras as $item)

                                      <li><a href="{{url('/avisos/ler/' . $item->id . '')}}">{{$item->titulo}}  - {!! date('d/m/Y',strtotime($item->data_publicacao)) !!}</a></li>


                      @endforeach
                      </ul>

                </div>

            </div>
</div>
</div>
</div>


@endsection