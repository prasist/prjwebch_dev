@extends('principal.master')

@section('content')

{{ \Session::put('titulo', 'Relatório de Pessoas') }}
{{ \Session::put('subtitulo', 'Listagem') }}
{{ \Session::put('route', 'relpessoas') }}
{{ \Session::put('id_pagina', '47') }}

<div class = 'row'>

 <div class="col-md-12">

    <button class = 'btn btn-primary' type ='button' onclick="javascript: history.back();">Voltar</button>

    <div class="box box-default">

          <div class="box-body">

            <div class="row">
                <div class="col-md-12">
                     @if ($emails)
                      <div class="row">
                            <div class="col-xs-12">
                            <p>
                            Filtros Utilizados : {!! $filtros !!}
                            <br/>
                            Encontrado : <b>{{count($emails)}}</b> registro(s).
                            <br/>
                            Verifique se há saldo disponível para envio de mensagens (SMS / Whatsapp)

                            <br/>
                            @if ($emails)
                            <br/>
                            @if ($resultado=="email")
                                <b>Atenção, o resultado retornará somente pessoas que tenham o email cadastrado.</b>
                                <b>No campo abaixo, tecle CTRL + A para selecionar os emails e CTRL + C para copiar.</b>
                            @else
                                <b>Atenção, o resultado retornará somente pessoas que tenham o telefone celular cadastrado.</b>
                            @endif
                            <br/>
                            @endif
                            </p>
                            <br/>
                            @if ($emails)
                                @if ($resultado=="email")
                                    <textarea class="form-control" rows="30">
                                    @foreach($emails as $item)
                                          {!! $item->razaosocial . ' <' . $item->emailprincipal . '>'!!},
                                    @endforeach
                                    </textarea>
                                @endif
                           @else
                              <b>Nenhum Registro Encontrado ou Email/Celular não preenchido no cadastro da Pessoa.</b>
                           @endif

                            </div>
                      </div>
                      @else
                          <b>Nenhum Registro Encontrado ou Email/Celular não preenchido no cadastro da Pessoa.</b>
                      @endif

                </div><!-- /.col -->

            </div><!-- /.row -->

            @if ($resultado=="celular")
                  @include('envio_mensagem', ['listagem'=>$emails])
            @endif

         </div><!-- fim box-body"-->
     </div><!-- box box-primary -->

      <div class="box-footer">
          <button class = 'btn btn-primary' type ='button' onclick="javascript: history.back();">Voltar</button>
      </div>

    </div>

</div>

@endsection