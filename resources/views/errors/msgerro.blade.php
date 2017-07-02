
@extends('principal.master')

@section('content')

     <div class="error-page">
            <h2 class="headline text-yellow">{{ $erro['codigo'] }}</h2>
            <div class="error-content">
              <h3><i class="fa fa-warning text-yellow"></i> {{ $erro['titulo']}}.</h3>
              <p>
                {{ $erro['mensagem'] }}
                <br/>
                <br/>
                <br/>
                <br/>
                {{ $erro['mensagem_original'] }}

                <a href="{{ URL('/home')}}">Voltar para Página Inicial</a>
              </p>

            </div><!-- /.error-content -->
          </div><!-- /.error-page -->

@endsection