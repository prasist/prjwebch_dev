@extends('layouts.app')

@section('content')

<!-- retirdado composer.json "barryvdh/laravel-debugbar": "^2.1",-->
<div class="container">

 <div class="row">

         <br/>
        <center>
        <a  href="{{ url('http://sigma3sistemas.com.br') }}"><img src="{{ url('/images/clients/logo_sigma3.png') }}" class="user-image" alt="Usuário Logado" width="100" height="30" /></a>
        <p>Sistema de Gestão para Igrejas</p>
        </center>

    </div>

    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Bem-Vindo</div>

                <div class="panel-body">


                 @if (isset($erros))
                     @if ($erros)
                    <div class="alert alert-danger alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <h4><i class="icon fa fa-ban"></i> Atenção!</h4>
                    {{$erros}}
                    <br/>
                    Ao tentar logar novamente a outra conexão será finalizada.
                    </div>
                    @endif
                @endif

                <ul>

                        <li>
                                @if (Auth::user())
                                    Usuário <b>{!!Auth::user()->name!!}</b> com sessão ativa.
                                @endif
                               <a  href="{{ url('/home') }}">Retonar ao SIGMA3</a>
                        </li>

                        <li>
                                <a  href="{{ url('http://sigma3sistemas.com.br') }}">Retonar ao site</a>
                        </li>

                        <li>
                                <a  href="{{ url('/login') }}">Logar Novamente</a>
                        </li>

                </ul>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection