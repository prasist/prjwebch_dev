@extends('principal.master')

@section('content')

{{ \Session::put('titulo', 'Configurações') }}
{{ \Session::put('subtitulo', 'Atualização') }}
{{ \Session::put('route', 'configmsg') }}
{{ \Session::put('id_pagina', '64') }}

<div class = 'row'>

    <div class="col-md-12">

        <h4>Configuração Serviço de Envio SMS/Whatsapp</h4>

        @if ($tipo_operacao=="incluir")
              <form method = 'POST'  class="form-horizontal" action = "{{ url('/' . \Session::get('route') . '/gravar')}}">
        @else
              <form method = 'POST' class="form-horizontal" action = "{{ url('/configmsg/' . $dados[0]->id . '/update')}}">
        @endif

        {!! csrf_field() !!}

            <div class="box box-primary">

                 <div class="box-body"> <!--anterior box-body-->

                            <div class="row">
                                  <div class="col-xs-10">
                                        <h4 class="text-info">
                                           Esse serviço é fornecido pela <a href="http://www.speedmarket.com.br/" target="_blank"><img src="{{ url('/images/logo_speed.png') }}" alt="Speed Market"> </a> e deve ser adquirido e gerenciado pelo painel de controle do mesmo.
                                           <br/><br/>O SIGMA3 tem integração direta com a plataforma de envio, bastando apenas informar o usuário e senha obtido na contratação.
                                           <br/>
                                           A disponibilidade é de responsabilidade da SPEED Market, bem como a contratação de créditos.
                                        </h4>
                                  </div>
                            </div>

                             <div class="row">
                                    <div class="col-xs-3">
                                          <label for="tipo" class="control-label">Tipo de Serviço SMS Contratado :</label>
                                    </div>

                                    <div class="col-xs-3">
                                          <label for="sms_marketing" class="control-label">SMS Marketing</label>
                                          @if ($tipo_operacao=="editar")
                                                <input  id= "sms_marketing" name="sms_marketing" type="checkbox" class="ckExibir" data-group-cls="btn-group-sm"  {{ $dados[0]->sms_marketing=="S" ? "checked" : "" }}/>
                                          @else
                                                <input  id= "sms_marketing" name="sms_marketing" type="checkbox" class="ckExibir" data-group-cls="btn-group-sm"  />
                                          @endif
                                    </div>

                                    <div class="col-xs-3">
                                           <label for="sms_corporativo" class="control-label">SMS Corporativo</label>
                                           @if ($tipo_operacao=="editar")
                                                  <input  id= "sms_corporativo" name="sms_corporativo" type="checkbox" class="ckExibir" data-group-cls="btn-group-sm"  {{ $dados[0]->sms_corporativo=="S" ? "checked" : "" }} />
                                           @else
                                                   <input  id= "sms_corporativo" name="sms_corporativo" type="checkbox" class="ckExibir" data-group-cls="btn-group-sm"  />
                                           @endif
                                    </div>

                                    <div class="col-xs-3">
                                           <label for="whatsapp" class="control-label">Whatsapp</label>
                                           @if ($tipo_operacao=="editar")
                                           <input  id= "whatsapp" name="whatsapp" type="checkbox" class="ckExibir" data-group-cls="btn-group-sm" {{ $dados[0]->whatsapp=="S" ? "checked" : "" }} />
                                           @else
                                           <input  id= "whatsapp" name="whatsapp" type="checkbox" class="ckExibir" data-group-cls="btn-group-sm"  />
                                           @endif

                                    </div>

                            </div>


                            <div class="row{{ $errors->has('email') ? ' has-error' : '' }}">
                                    <div class="col-xs-6">
                                          <label for="email" class="control-label">Usuário de Acesso SPEED MARKET</label>

                                          @if ($tipo_operacao=="editar")
                                               <input id="email" maxlength="255"  name = "email" type="text" class="form-control" value="{{ $dados[0]->email }}">
                                          @else
                                                <input id="email" maxlength="255"  name = "email" type="text" class="form-control" value="">
                                          @endif

                                             <!-- se houver erros na validacao do form request -->
                                             @if ($errors->has('email'))
                                              <span class="help-block">
                                                  <strong>{{ $errors->first('email') }}</strong>
                                              </span>
                                             @endif

                                    </div>
                            </div>

                            <div class="row{{ $errors->has('password') ? ' has-error' : '' }}">
                                    <div class="col-xs-6">
                                          <label for="password" class="control-label">Senha SPEED MARKET</label>

                                          <input id="password" maxlength="60"  name = "password" type="password" class="form-control" value="">

                                             <!-- se houver erros na validacao do form request -->
                                             @if ($errors->has('password'))
                                              <span class="help-block">
                                                  <strong>{{ $errors->first('password') }}</strong>
                                              </span>
                                             @endif

                                    </div>

                            </div>

                            <div class="row{{ $errors->has('ddd') ? ' has-error' : '' }}">
                                    <div class="col-xs-6">
                                    <p>&nbsp;</p>
                                    <p>Se os telefones celulares estiverem sem o DDD, o sistema incluirá automaticamente conforme informado abaixo para que as mensagens sejam enviadas corretamente.</p>
                                          <label for="ddd" class="control-label">DDD de sua Localidade</label>

                                          @if ($tipo_operacao=="editar")
                                               <input id="ddd" maxlength="2"  name = "ddd" type="text" placeholder="Ex: 41" class="form-control" value="{{ $dados[0]->ddd }}">
                                          @else
                                                <input id="ddd" maxlength="2"  name = "ddd" type="text" placeholder="Ex: 41" class="form-control" value="">
                                          @endif

                                             <!-- se houver erros na validacao do form request -->
                                             @if ($errors->has('ddd'))
                                              <span class="help-block">
                                                  <strong>{{ $errors->first('ddd') }}</strong>
                                              </span>
                                             @endif

                                    </div>
                            </div>


            </div><!-- fim box-body"-->
        </div><!-- box box-primary -->

        <div class="box-footer">
            <button class = 'btn btn-primary' type ='submit' {{ ($preview=='true' ? 'disabled=disabled' : "" ) }}><i class="fa fa-save"></i> Salvar</button>
            <a href="{{ url('/home')}}" class="btn btn-default">Cancelar</a>
        </div>

       </form>

    </div><!-- <col-md-12 -->

</div><!-- row -->

<script type="text/javascript">

      $(function () {

            $('.ckExibir').checkboxpicker({
                offLabel : 'Não',
                onLabel : 'Sim',
            });

      });

</script>

@endsection