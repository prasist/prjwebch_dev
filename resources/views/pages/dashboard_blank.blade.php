@extends('principal.master')

@section('content')

	<div>
                  @if (Auth::user()->confirmed==1)
                      <h2>Usuário Administrador ativado com sucesso. Para ter acesso a todos os recursos será necessário o preenchimento dos dados cadastrais da igreja sede.
                      Clique no botão "Cadastrar Agora" e complete o cadastro.</h2>

                      <form method = 'get' class="form-horizontal" action = "{{URL::to('clientes/registrar')}}">
                            <button class = 'btn btn-success btn-flat' type ='submit'>Cadastrar Agora</button>
                      </form>

                  @else
                        <h2>Sua conta não foi ativada. Verifique se já recebeu o email com o link de ativação. Em alguns casos o email vai para caixa Spam ou Lixeira.</h2>
                  @endif

	</div>

@endsection