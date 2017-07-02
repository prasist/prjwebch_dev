@extends('principal.master')

@section('content')

     <div class="error-page">
            <h2 class="headline text-yellow">404</h2>
            <div class="error-content">
              <h3><i class="fa fa-warning text-yellow"></i> Página não encontrada.</h3>
              <p>
                A página requisitada não foi encontrada, verifique se houve algum erro de digitação e tente novamente.
                <br/>
                <br/>
                <a href="{{ URL('/home')}}">Voltar para Página Inicial</a>
              </p>

            </div><!-- /.error-content -->
          </div><!-- /.error-page -->

@endsection