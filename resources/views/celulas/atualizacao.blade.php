@extends('principal.master')

@section('content')

{{ \Session::put('titulo', 'Cadastro ' . \Session::get('label_celulas')) }}

@if ($tipo_operacao=="incluir")
    {{ \Session::put('subtitulo', 'Inclusão') }}
@else
    {{ \Session::put('subtitulo', 'Alteração / Visualização') }}
@endif

{{ \Session::put('route', 'celulas') }}
{{ \Session::put('id_pagina', '42') }}

<style type="text/css">

    @media print
    {
         body *
         {
           visibility: hidden;
         }

        #printable, #printable *
        {
            visibility: visible;
        }

        #nao_imprimir_1
        {
            display:none;
        }

        #nao_imprimir_2
        {
            display:none;
        }

        #nao_imprimir_3
        {
            display:none;
        }


        #printable
        {
          page-break-inside: auto;
          page-break-after: avoid;
          left: 0;
          top: 0;
          bottom: 0;
          margin: 0;
          padding: 0;
        }
    }

</style>

<div class = 'row'>

<div class="col-md-12">

<div class="row">
    <div class="col-xs-2">
            <a href="{{ url('/' . \Session::get('route')) }}" class="btn btn-default"><i class="fa fa-arrow-circle-left"></i> Voltar</a>
    </div>

    <div class="col-xs-3">
        <a href="{{ url('/tutoriais/4')}}" data-toggle="tooltip" title="Clique Aqui para ver o tutorial..." target="_blank">
            <i class="glyphicon glyphicon-question-sign text-success"></i>&nbsp;Como cadastrar {!! \Session::get('label_celulas') !!} ?
       </a>
    </div>
</div>

@if ($tipo_operacao=="incluir")
<form name="form_celulas" id="form_celulas" method = 'POST' class="form-horizontal" action = "{{ url('/' . \Session::get('route') . '/gravar')}}" novalidate>
@else
<form name="form_celulas" id="form_celulas" method = 'POST' class="form-horizontal"  action = "{{ url('/' . \Session::get('route') . '/' . $dados[0]->id . '/update')}}" novalidate>
@endif

<input type="hidden" id="quero_incluir_participante" name="quero_incluir_participante" value="">
{!! csrf_field() !!}

<div class="box box-default">
  <div class="box-body">
    <div class="row">
        <div class="col-md-12">

                      <div class="nav-tabs-custom">

                          <ul class="nav nav-tabs">
                            <li class="active"><a href="#tab_1" data-toggle="tab">Dados Cadastrais</a></li>

                            @if ($tipo_operacao=="editar")
                                <li><a href="#tab_participantes" data-toggle="tab">Participantes <span class="badge bg-blue">{!!$dados[0]->tot!!}</span></a></li>
                                <input type="hidden" name="hidden_existe" id="hidden_existe" value="{!!$dados[0]->tot!!}">
                            @else
                                <input type="hidden" name="hidden_existe" id="hidden_existe" value="">
                            @endif

                            <li>
                            @if ($dados[0]->tot_geracao!=0)
                                  <a href="#tab_2" data-toggle="tab">Vinculo de {!! \Session::get('label_celulas') !!}&nbsp;<span class="pull-right badge bg-yellow">{!! ($dados[0]->tot_geracao==0 ? "" : $dados[0]->tot_geracao) !!}</span></a>
                            @else
                                  @if (isset($dados[0]->total_ant))
                                  <a href="#tab_2" data-toggle="tab">Vinculo de {!! \Session::get('label_celulas') !!}&nbsp;<span class="pull-right badge bg-purple">{!! ($dados[0]->total_ant==0 ? "" : $dados[0]->total_ant) !!}</span></a>
                                  @endif
                            @endif


                            </li>

                          </ul>

                          <div class="tab-content">
                                    <!-- TABS-->
                                    <div class="tab-pane active" id="tab_1">

                                        <div class="row">

                                              <div class="form-group">
                                              <label for="nivel5" class="col-sm-2 control-label">{!!Session::get('nivel5') !!}</label>
                                              <div class="col-sm-10{{ $errors->has('nivel5') ? ' has-error' : '' }}">
                                                      <select id="nivel5" placeholder="(Selecionar)" name="nivel5" data-live-search="true" data-none-selected-text="Nenhum item selecionado" class="form-control" style="width: 100%;">
                                                      <option  value=""></option>
                                                      @foreach($nivel5 as $item)
                                                             @if ($tipo_operacao=="editar")
                                                                  <option  value="{{$item->id}}" {{ ($dados[0]->celulas_nivel5_id == $item->id ? 'selected' : '') }} >{{$item->nome}}</option>
                                                             @else
                                                                  <option  value="{{$item->id}}" >{{$item->nome}}</option>
                                                             @endif
                                                      @endforeach
                                                      </select>
                                                      <!-- se houver erros na validacao do form request -->
                                                     @if ($errors->has('nivel5'))
                                                      <span class="help-block">
                                                          <strong>{{ $errors->first('nivel5') }}</strong>
                                                      </span>
                                                     @endif
                                              </div>
                                            </div>


                                            <div class="form-group">
                                            <label for="nivel4" class="col-sm-2 control-label">{{Session::get('nivel4')}}</label>

                                            <div class="col-sm-10{{ $errors->has('nivel4') ? ' has-error' : '' }}">
                                                  <select id="nivel4" placeholder="(Selecionar)" name="nivel4" data-live-search="true" data-none-selected-text="Nenhum item selecionado" class="form-control" style="width: 100%;">
                                                  <option  value=""></option>
                                                  </select>
                                            </div>

                                                  <!-- se houver erros na validacao do form request -->
                                                   @if ($errors->has('nivel4'))
                                                    <span class="help-block">
                                                        <strong>{{ $errors->first('nivel4') }}</strong>
                                                    </span>
                                                   @endif
                                          </div>

                                          <div class="form-group">
                                            <label for="nivel3" class="col-sm-2 control-label">{{Session::get('nivel3')}}</label>

                                            <div class="col-sm-10{{ $errors->has('nivel3') ? ' has-error' : '' }}">
                                                  <select id="nivel3" placeholder="(Selecionar)" name="nivel3" data-live-search="true" data-none-selected-text="Nenhum item selecionado" class="form-control" style="width: 100%;">
                                                  <option  value=""></option>
                                                  </select>
                                            </div>

                                                  <!-- se houver erros na validacao do form request -->
                                                   @if ($errors->has('nivel3'))
                                                    <span class="help-block">
                                                        <strong>{{ $errors->first('nivel3') }}</strong>
                                                    </span>
                                                   @endif
                                          </div>

                                          <div class="form-group">
                                            <label for="nivel2" class="col-sm-2 control-label">{{Session::get('nivel2')}}</label>

                                            <div class="col-sm-10{{ $errors->has('nivel2') ? ' has-error' : '' }}">
                                                    <select id="nivel2" placeholder="(Selecionar)" name="nivel2" data-live-search="true" data-none-selected-text="Nenhum item selecionado" class="form-control" style="width: 100%;">
                                                    <option  value=""></option>
                                                    </select>
                                            </div>

                                                 <!-- se houver erros na validacao do form request -->
                                                 @if ($errors->has('nivel2'))
                                                  <span class="help-block">
                                                      <strong>{{ $errors->first('nivel2') }}</strong>
                                                  </span>
                                                 @endif
                                          </div>

                                          <div class="form-group">
                                            <label for="nivel1" class="col-sm-2 control-label">{{Session::get('nivel1')}}</label>

                                            <div class="col-sm-10{{ $errors->has('nivel1') ? ' has-error' : '' }}">
                                                  <select id="nivel1" placeholder="(Selecionar)" name="nivel1" data-live-search="true" data-none-selected-text="Nenhum item selecionado" class="form-control" style="width: 100%;">
                                                  <option  value=""></option>
                                                  </select>
                                            </div>

                                                    <!-- se houver erros na validacao do form request -->
                                                   @if ($errors->has('nivel1'))
                                                    <span class="help-block">
                                                        <strong>{{ $errors->first('nivel1') }}</strong>
                                                    </span>
                                                   @endif
                                          </div>

                                        </div>


                                         <div class="row">

                                              <div class="col-xs-5">
                                                      <label for="nome" class="control-label">Nome {!! \Session::get('label_celulas_singular') !!}</label>
                                                      @if ($tipo_operacao=="editar")
                                                            <input id="nome"  placeholder="(Opcional)" name = "nome" type="text" class="form-control" value="{!! $dados[0]->nome !!}">
                                                      @else
                                                            <input id="nome"  placeholder="(Opcional)" name = "nome" type="text" class="form-control" value="">
                                                      @endif
                                              </div>

                                              <div class="col-xs-1">
                                                    <label for="cor" class="control-label">Cor</label>
                                                    @if ($tipo_operacao=="editar")
                                                        <input id="cor"  placeholder="(Opcional)" name = "cor" type="text" class="pick-a-color form-control" value="{{($dados[0]->cor=='' ? 'fff' : $dados[0]->cor)}}">
                                                    @else
                                                        <input id="cor"  placeholder="(Opcional)" name = "cor" type="text" class="pick-a-color form-control" value="fff">
                                                    @endif
                                              </div>

                                              <div class="col-xs-6 {{ $errors->has('regiao') ? ' has-error' : '' }}">
                                                      <label for="regiao" class="control-label">Região</label>
                                                      @if ($tipo_operacao=="editar")
                                                        <input id="regiao"  placeholder="(Opcional)" name = "regiao" type="text" class="form-control" value="{{$dados[0]->regiao}}">
                                                      @else
                                                        <input id="regiao"  placeholder="(Opcional)" name = "regiao" type="text" class="form-control" value="">
                                                      @endif

                                                      <!-- se houver erros na validacao do form request -->
                                                     @if ($errors->has('regiao'))
                                                      <span class="help-block">
                                                          <strong>{{ $errors->first('regiao') }}</strong>
                                                      </span>
                                                     @endif

                                              </div>
                                        </div>

                                        <div class="row">

                                              <div class="col-xs-6 {{ $errors->has('pessoas') ? ' has-error' : '' }}">
                                                      <label for="pessoas" class="control-label"><span class="text-danger">*</span> {!! \Session::get('label_lider_singular') !!}</label>
                                                      <div class="input-group">
                                                               <div class="input-group-addon">
                                                                  <button  id="buscarpessoa" type="button"  data-toggle="modal" data-target="#modal_lider" >
                                                                         <i class="fa fa-search"></i> ...
                                                                   </button>
                                                                   &nbsp;<a href="#" onclick="remover_pessoa('pessoas');" title="Limpar Campo"><spam class="fa fa-close"></spam></a>

                                                                </div>

                                                                @include('modal_buscar_pessoas', array('qual_campo'=>'pessoas', 'modal' => 'modal_lider'))

                                                                @if ($tipo_operacao=="editar")
                                                                    <input id="pessoas"  name = "pessoas" type="text" class="form-control" placeholder="Clica na lupa ao lado para consultar uma pessoa" value="{!! ($dados[0]->lider_pessoas_id!="" ? str_repeat('0', (9-strlen($dados[0]->lider_pessoas_id))) . $dados[0]->lider_pessoas_id . ' - ' . $dados[0]->razaosocial  : '') !!}" readonly >
                                                                @else
                                                                    <input id="pessoas"  name = "pessoas" type="text" class="form-control" placeholder="Clica na lupa ao lado para consultar uma pessoa" value="" readonly >
                                                                @endif


                                                                <!-- se houver erros na validacao do form request -->
                                                                @if ($errors->has('pessoas'))
                                                                <span class="help-block">
                                                                    <strong>{{ $errors->first('pessoas') }}</strong>
                                                                </span>
                                                                @endif

                                                        </div>
                                               </div>

                                               <div class="col-xs-6 {{ $errors->has('vicelider_pessoas_id') ? ' has-error' : '' }}">
                                                      <label for="vicelider_pessoas_id" class="control-label">{!! \Session::get('label_lider_treinamento') !!}</label>
                                                      <div class="input-group">
                                                               <div class="input-group-addon">
                                                                  <button  id="buscarpessoa2" type="button"  data-toggle="modal" data-target="#modal_vice" >
                                                                         <i class="fa fa-search"></i> ...
                                                                   </button>
                                                                   &nbsp;<a href="#" onclick="remover_pessoa('vicelider_pessoas_id');" title="Limpar Campo"><spam class="fa fa-close"></spam></a>

                                                                </div>

                                                                @include('modal_buscar_pessoas', array('qual_campo'=>'vicelider_pessoas_id', 'modal' => 'modal_vice'))

                                                                @if ($tipo_operacao=="editar")
                                                                       <input id="vicelider_pessoas_id"  name = "vicelider_pessoas_id" type="text" class="form-control" placeholder="Clica na lupa ao lado para consultar uma pessoa" value="{!! ($dados[0]->vicelider_pessoas_id!="" ? str_repeat('0', (9-strlen($dados[0]->vicelider_pessoas_id))) . $dados[0]->vicelider_pessoas_id . ' - ' . $dados[0]->nome_vicelider  : '') !!}" readonly >
                                                                @else
                                                                       <input id="vicelider_pessoas_id"  name = "vicelider_pessoas_id" type="text" class="form-control" placeholder="Clica na lupa ao lado para consultar uma pessoa" value="" readonly >
                                                                @endif

                                                                <!-- se houver erros na validacao do form request -->
                                                                @if ($errors->has('vicelider_pessoas_id'))
                                                                <span class="help-block">
                                                                     <strong>{{ $errors->first('vicelider_pessoas_id') }}</strong>
                                                                 </span>
                                                                @endif
                                                        </div>
                                               </div>


                                        </div>

                                        <div class="row">
                                                   <div class="col-xs-12 {{ $errors->has('suplente1_pessoas_id') ? ' has-error' : '' }}">
                                                        <label for="suplente1_pessoas_id" class="control-label">{!! \Session::get('label_anfitriao') !!}</label>
                                                        <div class="input-group">
                                                                 <div class="input-group-addon">
                                                                    <button  id="buscarpessoa3" type="button"  data-toggle="modal" data-target="#modal_suplente1" >
                                                                           <i class="fa fa-search"></i> ...
                                                                     </button>
                                                                     &nbsp;<a href="#" onclick="remover_pessoa('suplente1_pessoas_id');" title="Limpar Campo"><spam class="fa fa-close"></spam></a>
                                                                  </div>

                                                                  @include('modal_buscar_pessoas', array('qual_campo'=>'suplente1_pessoas_id', 'modal' => 'modal_suplente1'))

                                                                  @if ($tipo_operacao=="editar")
                                                                      <input id="suplente1_pessoas_id"  name = "suplente1_pessoas_id" type="text" class="form-control" placeholder="Clica na lupa ao lado para consultar uma pessoa" value="{!! ($dados[0]->suplente1_pessoas_id!="" ? str_repeat('0', (9-strlen($dados[0]->suplente1_pessoas_id))) . $dados[0]->suplente1_pessoas_id . ' - ' . $dados[0]->nome_suplente1  : '') !!}" readonly >
                                                                  @else
                                                                      <input id="suplente1_pessoas_id"  name = "suplente1_pessoas_id" type="text" class="form-control" placeholder="Clica na lupa ao lado para consultar uma pessoa" value="" readonly >
                                                                  @endif

                                                                  <!-- se houver erros na validacao do form request -->
                                                                   @if ($errors->has('suplente1_pessoas_id'))
                                                                    <span class="help-block">
                                                                        <strong>{{ $errors->first('suplente1_pessoas_id') }}</strong>
                                                                    </span>
                                                                   @endif

                                                          </div>
                                               </div>
                                        </div>


                                        <div class="row">

                                                <div class="col-xs-3 {{ $errors->has('dia_encontro') ? ' has-error' : '' }}">
                                                      <label for="dia_encontro" class="control-label"><span class="text-danger">*</span> Dia Encontro</label>

                                                      <select id="dia_encontro"  placeholder="(Selecionar)" name="dia_encontro" data-live-search="true" data-none-selected-text="Nenhum item selecionado" class="form-control" style="width: 100%;" required>
                                                      <option  value=""></option>
                                                      <!--[0 Domingo] - [1 Segunda] - [2 Terca] - [3 Quarta] - [4 Quinta] - [5 Sexta] - [6 Sabado]-->
                                                      @if ($tipo_operacao=="editar")
                                                             <option  value="1" {{ ($dados[0]->dia_encontro=="1" ? "selected" : "") }}>Segunda-Feira</option>
                                                             <option  value="2" {{ ($dados[0]->dia_encontro=="2" ? "selected" : "") }}>Terça-Feira</option>
                                                             <option  value="3" {{ ($dados[0]->dia_encontro=="3" ? "selected" : "") }}>Quarta-Feira</option>
                                                             <option  value="4" {{ ($dados[0]->dia_encontro=="4" ? "selected" : "") }}>Quinta-Feira</option>
                                                             <option  value="5" {{ ($dados[0]->dia_encontro=="5" ? "selected" : "") }}>Sexta-Feira</option>
                                                             <option  value="6" {{ ($dados[0]->dia_encontro=="6" ? "selected" : "") }}>Sábado</option>
                                                             <option  value="0" {{ ($dados[0]->dia_encontro=="0" ? "selected" : "") }}>Domingo</option>
                                                      @else
                                                             <option  value="1" >Segunda-Feira</option>
                                                             <option  value="2" >Terça-Feira</option>
                                                             <option  value="3" >Quarta-Feira</option>
                                                             <option  value="4">Quinta-Feira</option>
                                                             <option  value="5">Sexta-Feira</option>
                                                             <option  value="6">Sábado</option>
                                                             <option  value="0">Domingo</option>
                                                      @endif
                                                      </select>


                                                      <!-- se houver erros na validacao do form request -->
                                                     @if ($errors->has('dia_encontro'))
                                                      <span class="help-block">
                                                          <strong>{{ $errors->first('dia_encontro') }}</strong>
                                                      </span>
                                                     @endif

                                                </div>

                                                <div class="col-xs-2 {{ $errors->has('horario') ? ' has-error' : '' }}">

                                                        <div class="bootstrap-timepicker">
                                                              <div class="form-group">
                                                                <label for="horario" class="control-label"><span class="text-danger">*</span>  Horário</label>

                                                                <div class="input-group">
                                                                  @if ($tipo_operacao=="editar")
                                                                        <input type="text" data-inputmask='"mask": "99:99"' data-mask  name="horario" id="horario"  class="form-control input-small" value="{{ $dados[0]->horario}}" required>
                                                                  @else
                                                                        <input type="text" data-inputmask='"mask": "99:99"' data-mask  name="horario" id="horario" class="form-control input-small" required>
                                                                  @endif
                                                                  <div class="input-group-addon">
                                                                    <i class="fa fa-clock-o"></i>
                                                                  </div>
                                                                </div>
                                                                <!-- /.input group -->
                                                              </div>
                                                              <!-- /.form group -->
                                                            </div>

                                                            @if ($errors->has('horario'))
                                                              <span class="help-block">
                                                                  <strong>{{ $errors->first('horario') }}</strong>
                                                              </span>
                                                             @endif

                                                </div>

                                                <div class="col-xs-4">
                                                      <label for="local" class="control-label">Local Encontro</label>

                                                      <!-- ng-options="local.Name for local in Locais track by local.Id"-->
                                                      <!--
                                                      <select ng-model="selectedCarregar" ng-options="local.Name for local in Locais track by local.Id">
                                                            <option value="">Selecionar</option>

                                                      </select>
                                                      -->

                                                      <!--<option ng-repeat="option in data.Locais" value="@{{option.id}}">@{{option.name}}</option>-->

                                                      <select id="local" placeholder="(Selecionar)" name="local" data-live-search="true" data-none-selected-text="Nenhum item selecionado" class="form-control" style="width: 100%;">
                                                      <option  value=""></option>
                                                      @if ($tipo_operacao=="editar")
                                                          <option  value="1" {{ ($dados[0]->qual_endereco=="1" ? "selected" : "") }}>Endereço do {!! \Session::get('label_lider_singular') !!}</option>
                                                          <option  value="2" {{ ($dados[0]->qual_endereco=="2" ? "selected" : "") }}>Endereço do {!! \Session::get('label_lider_treinamento') !!}</option>
                                                          <option  value="3" {{ ($dados[0]->qual_endereco=="3" ? "selected" : "") }}>Endereço do {!! \Session::get('label_anfitriao') !!}</option>
                                                          <option  value="4" {{ ($dados[0]->qual_endereco=="4" ? "selected" : "") }}>Endereço do {!! \Session::get('label_lider_suplente') !!}</option>
                                                          <option  value="5" {{ ($dados[0]->qual_endereco=="5" ? "selected" : "") }}>Endereço da Igreja Sede</option>
                                                          <option  value="6" {{ ($dados[0]->qual_endereco=="6" ? "selected" : "") }}>Outro</option>
                                                      @else
                                                          <option  value="1">Endereço do {!! \Session::get('label_lider_singular') !!}</option>
                                                          <option  value="2">Endereço do {!! \Session::get('label_lider_treinamento') !!}</option>
                                                          <option  value="3">Endereço do {!! \Session::get('label_anfitriao') !!}</option>
                                                          <option  value="4">Endereço do {!! \Session::get('label_lider_suplente') !!}</option>
                                                          <option  value="5">Endereço da Igreja Sede</option>
                                                          <option  value="6">Outro</option>
                                                      @endif
                                                      </select>
                                             </div>

                                                <!--
                                                <div class="col-xs-3 {{ $errors->has('turno') ? ' has-error' : '' }}">
                                                      <label for="turno" class="control-label">Turno</label>

                                                      <select id="turno" placeholder="(Selecionar)" name="turno" data-live-search="true" data-none-selected-text="Nenhum item selecionado" class="form-control" style="width: 100%;">
                                                      <option  value=""></option>
                                                      <option  value="M">Manhã</option>
                                                      <option  value="T">Tarde</option>
                                                      <option  value="N">Noite</option>
                                                      </select>

                                                     @if ($errors->has('turno'))
                                                      <span class="help-block">
                                                          <strong>{{ $errors->first('turno') }}</strong>
                                                      </span>
                                                     @endif

                                                </div>
                                                -->

                                        </div><!-- end row -->

                                        <div id="div_endereco" class="row" style="display: none">
                                            <div class="col-xs-12">
                                                  <label for="endereco_encontro" class="control-label">Outro Local Encontro</label>
                                                  @if ($tipo_operacao=="editar")
                                                       <input type="text" id="endereco_encontro" name="endereco_encontro" class="form-control" value="{{$dados[0]->endereco_encontro}}" placeholder="Preencha o endereço completo...">
                                                  @else
                                                       <input type="text" id="endereco_encontro" name="endereco_encontro" class="form-control" value="" placeholder="Preencha o endereço completo...">
                                                  @endif
                                            </div>
                                        </div>

                                           <div class="row">

                                              <div class="col-xs-6">
                                                    @if ($tipo_operacao=="editar")
                                                          @include('carregar_combos', array('dados'=>$publicos, 'titulo' =>'Público Alvo', 'id_combo'=>'publico_alvo', 'complemento'=>'', 'comparar'=>$dados[0]->publico_alvo_id, 'id_pagina'=> '43'))
                                                    @else
                                                          @include('carregar_combos', array('dados'=>$publicos, 'titulo' =>'Público Alvo', 'id_combo'=>'publico_alvo', 'complemento'=>'', 'comparar'=>'', 'id_pagina'=> '43'))
                                                    @endif

                                                    @include('modal_cadastro_basico', array('qual_campo'=>'publico_alvo', 'modal' => 'modal_publico_alvo', 'tabela' => 'publicos_alvos'))
                                              </div>

                                              <div class="col-xs-6">
                                                    @if ($tipo_operacao=="editar")
                                                          @include('carregar_combos', array('dados'=>$faixas, 'titulo' =>'Faixas Etárias', 'id_combo'=>'faixa_etaria', 'complemento'=>'', 'comparar'=>$dados[0]->faixa_etaria_id, 'id_pagina'=> '44'))
                                                    @else
                                                          @include('carregar_combos', array('dados'=>$faixas, 'titulo' =>'Faixas Etárias', 'id_combo'=>'faixa_etaria', 'complemento'=>'', 'comparar'=>'', 'id_pagina'=> '44'))
                                                    @endif

                                                    @include('modal_cadastro_basico', array('qual_campo'=>'faixa_etaria', 'modal' => 'modal_faixa_etaria', 'tabela' => 'faixas_etarias'))
                                              </div>

                                        </div>


                                        <br/>
                                        <div class="row">
                                            <div class="col-md-12">
                                              <div class="box box-solid">

                                                <!-- /.box-header -->
                                                <div class="box-body">
                                                  <div class="box-group" id="accordion">
                                                    <!-- we are adding the .panel class so bootstrap.js collapse plugin detects it -->
                                                    <div class="panel box box-default">
                                                      <div class="box-header with-border">
                                                        <h5 class="box-title">
                                                          <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne">
                                                            ( + ) Informações Complementares
                                                          </a>
                                                        </h5>
                                                      </div>
                                                      <div id="collapseOne" class="panel-collapse collapse">
                                                        <div class="box-body">

                                                                   <div class="row">
                                                                        <div class="col-xs-10">
                                                                              <label for="email_grupo" class="control-label">E-mail do grupo</label>
                                                                              @if ($tipo_operacao=="editar")
                                                                                    <input id="email_grupo"  placeholder="(Opcional)" name = "email_grupo" type="text" class="form-control" value="{!! $dados[0]->email_grupo!!}">
                                                                              @else
                                                                                    <input id="email_grupo"  placeholder="(Opcional)" name = "email_grupo" type="text" class="form-control" value="">
                                                                              @endif
                                                                        </div>
                                                                   </div>

                                                                   <div class="row">
                                                                        <div class="col-xs-10">
                                                                              <label for="obs" class="control-label">Observações</label>
                                                                              @if ($tipo_operacao=="editar")
                                                                                    <input id="obs"  placeholder="(Opcional)" name = "obs" type="text" class="form-control" value="{!! $dados[0]->obs!!}">
                                                                              @else
                                                                                    <input id="obs"  placeholder="(Opcional)" name = "obs" type="text" class="form-control" value="">
                                                                              @endif
                                                                        </div>
                                                                   </div>


                                                                  <div class="row">
                                                                    <div class="col-xs-12">
                                                                          <label for="suplente2_pessoas_id" class="control-label">{!! \Session::get('label_lider_suplente') !!}</label>
                                                                          <div class="input-group">
                                                                                   <div class="input-group-addon">
                                                                                      <button  id="buscarpessoa4" type="button"  data-toggle="modal" data-target="#modal_suplente2" >
                                                                                             <i class="fa fa-search"></i> ...
                                                                                       </button>
                                                                                       &nbsp;<a href="#" onclick="remover_pessoa('suplente2_pessoas_id');" title="Limpar Campo"><spam class="fa fa-close"></spam></a>
                                                                                    </div>

                                                                                    @include('modal_buscar_pessoas', array('qual_campo'=>'suplente2_pessoas_id', 'modal' => 'modal_suplente2'))

                                                                                    @if ($tipo_operacao=="editar")
                                                                                          <input id="suplente2_pessoas_id"  name = "suplente2_pessoas_id" type="text" class="form-control" placeholder="Clica na lupa ao lado para consultar uma pessoa" value="{!! ($dados[0]->suplente2_pessoas_id!="" ? str_repeat('0', (9-strlen($dados[0]->suplente2_pessoas_id))) . $dados[0]->suplente2_pessoas_id . ' - ' . $dados[0]->nome_suplente2  : '') !!}" readonly >
                                                                                    @else
                                                                                          <input id="suplente2_pessoas_id"  name = "suplente2_pessoas_id" type="text" class="form-control" placeholder="Clica na lupa ao lado para consultar uma pessoa" value="" readonly >
                                                                                    @endif


                                                                            </div>
                                                                   </div>
                                                               </div>

                                                               <div class="row">

                                                                    <div class="col-xs-3">
                                                                        <label for="segundo_dia_encontro" class="control-label">2º Dia Encontro</label>

                                                                        <select id="segundo_dia_encontro" placeholder="(Selecionar)" name="segundo_dia_encontro" data-live-search="true" data-none-selected-text="Nenhum item selecionado" class="form-control" style="width: 100%;">
                                                                        <option  value=""></option>
                                                                        @if ($tipo_operacao=="editar")
                                                                              <option  value="1" {{ ($dados[0]->segundo_dia_encontro=="1" ? "selected" : "") }}>Segunda-Feira</option>
                                                                              <option  value="2" {{ ($dados[0]->segundo_dia_encontro=="2" ? "selected" : "") }}>Terça-Feira</option>
                                                                              <option  value="3" {{ ($dados[0]->segundo_dia_encontro=="3" ? "selected" : "") }}>Quarta-Feira</option>
                                                                              <option  value="4" {{ ($dados[0]->segundo_dia_encontro=="4" ? "selected" : "") }}>Quinta-Feira</option>
                                                                              <option  value="5" {{ ($dados[0]->segundo_dia_encontro=="5" ? "selected" : "") }}>Sexta-Feira</option>
                                                                              <option  value="6" {{ ($dados[0]->segundo_dia_encontro=="6" ? "selected" : "") }}>Sábado</option>
                                                                              <option  value="0" {{ ($dados[0]->segundo_dia_encontro=="0" ? "selected" : "") }}>Domingo</option>
                                                                        @else
                                                                              <option  value="1">Segunda-Feira</option>
                                                                              <option  value="2">Terça-Feira</option>
                                                                              <option  value="3">Quarta-Feira</option>
                                                                              <option  value="4">Quinta-Feira</option>
                                                                              <option  value="5">Sexta-Feira</option>
                                                                              <option  value="6">Sábado</option>
                                                                              <option  value="0">Domingo</option>
                                                                        @endif
                                                                        </select>

                                                                  </div>

                                                                  <div class="col-xs-3">

                                                                          <div class="bootstrap-timepicker">
                                                                                <div class="form-group">
                                                                                  <label for="horario2" class="control-label">Horário 2º Dia Encontro</label>

                                                                                  <div class="input-group">

                                                                                     @if ($tipo_operacao=="editar")
                                                                                          <input type="text" name="horario2" id="horario2"  data-inputmask='"mask": "99:99"' data-mask  class="form-control input-small" value="{{ $dados[0]->horario2}}">
                                                                                     @else
                                                                                          <input type="text" name="horario2" id="horario2"  data-inputmask='"mask": "99:99"' data-mask  class="form-control input-small">
                                                                                     @endif

                                                                                    <div class="input-group-addon">
                                                                                      <i class="fa fa-clock-o"></i>
                                                                                    </div>
                                                                                  </div>
                                                                                  <!-- /.input group -->
                                                                                </div>
                                                                                <!-- /.form group -->
                                                                              </div>

                                                                  </div>
                                                                </div>

                                                                <div class="row">
                                                                       <div class="col-xs-3">
                                                                                <label  for="data_inicio" class="control-label">Data de Início da {!! \Session::get('label_celulas') !!}</label>
                                                                                <div class="input-group">
                                                                                       <div class="input-group-addon">
                                                                                        <i class="fa fa-calendar"></i>
                                                                                        </div>
                                                                                        @if ($tipo_operacao=="editar")
                                                                                              <input id ="data_inicio" name = "data_inicio" onblur="validar_data(this);" type="text" class="form-control" data-inputmask='"mask": "99/99/9999"' data-mask  value="{{ $dados[0]->data_inicio_format}}">
                                                                                        @else
                                                                                              <input id ="data_inicio" name = "data_inicio" onblur="validar_data(this);" type="text" class="form-control" data-inputmask='"mask": "99/99/9999"' data-mask  value="">
                                                                                        @endif
                                                                                </div>
                                                                       </div>

                                                                       <div class="col-xs-3">
                                                                                <label  for="data_previsao_multiplicacao" class="control-label">Data Previsão Multiplicação</label>
                                                                                <div class="input-group">
                                                                                       <div class="input-group-addon">
                                                                                        <i class="fa fa-calendar"></i>
                                                                                        </div>
                                                                                        @if ($tipo_operacao=="editar")
                                                                                              <input id ="data_previsao_multiplicacao" name = "data_previsao_multiplicacao" onblur="validar_data(this);" type="text" class="form-control" data-inputmask='"mask": "99/99/9999"' data-mask  value="{{ $dados[0]->data_previsao_multiplicacao_format}}">
                                                                                        @else
                                                                                              <input id ="data_previsao_multiplicacao" name = "data_previsao_multiplicacao" onblur="validar_data(this);" type="text" class="form-control" data-inputmask='"mask": "99/99/9999"' data-mask  value="">
                                                                                        @endif
                                                                                </div>
                                                                       </div>

                                                                </div>

                                                        </div>
                                                      </div>
                                                    </div>

                                                  </div>
                                                </div>
                                                <!-- /.box-body -->
                                              </div>
                                              <!-- /.box -->
                                            </div>

                                        </div><!-- fim box-body"-->

                                    </div><!-- /.tab-pane -->

                                      <div class="tab-pane" id="tab_participantes">

                                          <div class="row">
                                                <div class="col-xs-11">

                                                    @if ($tipo_operacao=="editar")

                                                    @if ($dados[0]->tot>0)
                                                        <a href="{{ URL::to('celulaspessoas/' . $dados[0]->id . '/edit') }}" class = 'btn btn-success btn-flat'><i class="fa fa-file-text-o"></i>  Editar Participante(s)</a>
                                                    @else
                                                        <a href="{{ URL::to('celulaspessoas/registrar/' .$dados[0]->id) }}" class = 'btn btn-success btn-flat'><i class="fa fa-file-text-o"></i>  Incluir Participante(s)</a>
                                                    @endif

                                                    <table id="example" class="table table-bordered table-hover">
                                                        <tbody>
                                                         <tr>
                                                           <!--<th>Célula</th>-->
                                                           <th>Pessoa</th>
                                                         </tr>

                                                        @foreach($participantes as $item)
                                                         <tr>
                                                           <!--<td>{!! $item->descricao_concatenada !!}</td>-->
                                                           <td>{!! $item->descricao_pessoa !!}</td>

                                                         </tr>
                                                        @endforeach
                                                        </tbody>

                                                    </table>
                                                    @endif

                                                </div>
                                          </div>


                                    </div>

                                    <div class="tab-pane" id="tab_2">

                                          <div id="nao_imprimir_1" class="row">
                                                <div class="col-xs-11">
                                                      <p class="text-info">- Informe o campo abaixo caso essa célula teve origem em outra.</p>
                                                      <p class="text-info"> - Células Vinculadas são aquelas que ocorrem dentro da própria célula, por exemplo : Célula para Crianças</p>
                                                      <p class="text-info"> - Células Multiplicadas são novas células geradas a partir de outra.</p>

                                                      <label for="origem" class="control-label">Qual a origem {!! \Session::get('label_celulas') !!} ?</label>
                                                      <select id="origem" placeholder="(Selecionar)" name="origem" data-live-search="true" data-none-selected-text="Nenhum item selecionado" class="form-control selectpicker" style="width: 100%;" >
                                                      <option  value=""></option>
                                                      @if ($tipo_operacao=="editar")
                                                          <option  value="1" {{ $dados[0]->origem == 1 ? "selected" : ""}}>Multiplicação</option>
                                                          <option  value="2" {{ $dados[0]->origem == 2 ? "selected" : ""}}>Vínculo (ou {!! \Session::get('label_celulas') !!} Filho(a))</option>
                                                      @else
                                                          <option  value="1">Multiplicação</option>
                                                          <option  value="2">Vínculo (ou {!! \Session::get('label_celulas') !!} Filho(a))</option>
                                                      @endif
                                                      </select>

                                                </div>
                                          </div>

                                          <div id="nao_imprimir_2" class="row">
                                              <div class="col-xs-11">
                                                      <label for="celulas_pai_id" class="control-label">Quem é a {!! \Session::get('label_celulas') !!} Pai ?</label>
                                                      <select id="celulas_pai_id" placeholder="(Selecionar)" name="celulas_pai_id" data-live-search="true" data-none-selected-text="Nenhum item selecionado" class="form-control selectpicker" style="width: 100%;" >
                                                      <option  value="0"></option>
                                                      @foreach($celulas as $item)
                                                              @if ($tipo_operacao=="editar")
                                                                    <option  value="{{$item->id}}" {{$dados[0]->celulas_pai_id == $item->id ? "selected" : ""}}>{{$item->nome}}</option>
                                                               @else
                                                                    <option  value="{{$item->id}}">{{$item->nome}}</option>
                                                               @endif
                                                      @endforeach
                                                      </select>
                                              </div>
                                        </div>

                                        <br/>
                                        <div class="row">
                                            <div class="col-md-12">
                                              <!-- Widget: user widget style 1 -->
                                              <div id="arvore" class="box box-widget">

                                                <div class="box-footer no-padding">

                                                  <div id="nao_imprimir_3" class="row">
                                                      <div class="col-md-12">
                                                           <a href="#" onclick="window.print();"><i class="fa fa-print"></i>&nbsp;Clique Aqui para Imprimir (<i>Será necessário expandir a Árvore Hierárquica antes da impressão</i>)</a>
                                                     </div>
                                                  </div>

                                                  @if (isset($nome_lider_anterior))
                                                      @if ($nome_lider_anterior!="")
                                                      <div class="row">
                                                          <div class="col-md-12">
                                                                <br/>
                                                                @if (isset($dados[0]->total_ant))
                                                                <b>{!!$nome_lider_anterior!!} era o líder anterior e a quantidade atual de sua geração é : {!! $dados[0]->total_ant !!}</b>
                                                                @endif
                                                          </div>
                                                      </div>
                                                      @endif
                                                  @endif

                                                  <div class="row">
                                                    <div class="col-md-12">
                                                     <div id="printable" class="box-header with-border">
                                                      @if (isset($gerar_estrutura_origem))
                                                            {!! $gerar_estrutura_origem !!}
                                                      @endif
                                                     </div>
                                                  </div>
                                                </div>

                                              </div>
                                            </div>
                                          </div>
                                       </div>

                                    </div><!--  END TABS-->

                         </div> <!-- TAB CONTENTS -->

                      </div> <!-- nav-tabs-custom -->

        </div>
    </div>
  </div>
</div>

   <div class="box-footer">
       <button class = 'btn btn-primary' type ='submit' {{ ($preview=='true' ? 'disabled=disabled' : "" ) }} ><i class="fa fa-save"></i> Salvar</button>
       <a href="#" class="btn btn-warning" onclick="salvar_e_incluir();" {{ ($preview=='true' ? 'disabled=disabled' : "" ) }} ><i class="fa fa-users"></i> Salvar e Incluir Participantes</a>
       <a href="{{ url('/' . \Session::get('route') )}}" class="btn btn-default">Cancelar</a>
       <br/><span class="text-danger">*</span><i>Campos Obrigatórios</i>
   </div>

   </form>

 </div>

</div>

@include('configuracoes.script_estruturas')

<script type="text/javascript">

    function remover_pessoa(var_objeto)
    {
        $('#' + var_objeto).val('');
    }

    $(document).ready(function()
    {

           $("#menu_celulas").addClass("treeview active");

            /*quando carregar a pagina e estiver preenchido o nivel4, dispara o evento que carrega as outras dropdows.*/
            if ($("#nivel5").val()!="")
            {
                  $("#nivel5").trigger("change");
            }

          if ($('#local').val()==6)
          {
               $("#div_endereco").show();
          }

          //Quando selecionar outro tipo de endereco para encontro
          $("#local").change(function()
          {

               if ($(this).val()==6)
               {
                    $("#div_endereco").show();
               } else {
                    $("#div_endereco").hide();
               }

          });

    });

    function salvar_e_incluir()
    {

          if ($('#hidden_existe').val()!="0")
          {
              $('#quero_incluir_participante').val('sim');
          }
          else
          {
               $('#quero_incluir_participante').val('simnovo');
          }

          $('#form_celulas')[0].submit();
    }

</script>


@endsection