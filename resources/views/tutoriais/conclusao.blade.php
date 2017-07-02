@extends('principal.master')

@section('content')

{{ \Session::put('titulo', 'Tutoriais') }}
{{ \Session::put('subtitulo', 'Conclusão') }}
{{ \Session::put('route', 'quicktour') }}

<div class = 'row'>

    <div class="col-md-12">

        <form method = 'POST'  class="form-horizontal" action = {{ url('/' . \Session::get('route') . '/done/' . $id)}}>
        {!! csrf_field() !!}

        <div class="row">
                <div class="col-md-12">
                  <div class="box">
                    <div class="box-header">

                        <div class="box-body">

                            @if ($id==1)
                            <p>
                                 <b>Tour Rápido - Cadastro de Usuários concluído!</b><br/>
                                Clique no botão abaixo para confirmar e não exibir mais o Tour quando logar novamente.
                            </p>
                            @endif

                            @if ($id==2)
                            <p>
                                 <b>Tour Rápido - Visão Geral do SIGMA3 concluído!</b><br/>
                                Clique no botão abaixo para confirmar e não exibir mais o Tour quando logar novamente.
                            </p>
                            @endif

                                <div class="box-footer">
                                    <button class = 'btn btn-primary' type ='submit'><span class="fa fa-trophy"></span> Confirmar Conclusão</button>
                                </div>
                                <div id="tour9"></div>
                                <div id="tour6_visaogeral"></div>

                        </div>

                     </div>
                   </div>
                </div>

         </div>
        </form>
      </div>
   </div>

@endsection