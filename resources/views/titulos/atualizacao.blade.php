@extends('principal.master')

@section('content')

@if ($tipo=="P")
    {{ \Session::put('titulo', 'Contas à Pagar') }}
@else
    {{ \Session::put('titulo', 'Contas à Receber') }}
@endif

@if ($tipo_operacao=="incluir")
    {{ \Session::put('subtitulo', 'Inclusão') }}
@else
    {{ \Session::put('subtitulo', 'Alteração / Visualização') }}
@endif

{{ \Session::put('route', 'titulos') }}
{{ \Session::put('id_pagina', '52') }}

<div class = 'row'>

    <div class="col-md-12">

    <div>
            <a href="{{ url('/' . \Session::get('route')) . '/' . $tipo }}" class="btn btn-default"><i class="fa fa-arrow-circle-left"></i> Voltar</a>
    </div>

     @if (isset($dados))
          <form method = 'POST' class="form-horizontal"  action = "{{ url('/' . \Session::get('route') . '/' . $dados[0]->id . '/update/' . $tipo)}}">
     @else
          <form method = 'POST'  class="form-horizontal" action = "{{ url('/' . \Session::get('route') . '/gravar/' . $tipo)}}">
     @endif

        {!! csrf_field() !!}
        <div class="box box-default">

             <div class="box-body">

                            <!-- Custom Tabs -->
                      <div class="nav-tabs-custom">

                        <ul class="nav nav-tabs">
                          <li class="active"><a href="#tab_1" data-toggle="tab">Dados</a></li>
                          @if ($tipo_operacao=="editar")
                          <li><a href="#tab_2" data-toggle="tab">Histórico</a></li>
                          @endif
                        </ul>

                        <div class="tab-content">
                          <div class="tab-pane active" id="tab_1">

                                        <div class="row">
                                              <div class="col-xs-4 {{ $errors->has('fornecedor') ? ' has-error' : '' }}">
                                                  <label for="fornecedor" class="control-label"><span class="text-danger">*</span>  Fornecedor / Cliente</label>
                                                  @if (isset($dados))
                                                      <input type="text" id="fornecedor" name="fornecedor" class="typeahead form-control"  autocomplete="off" spellcheck="false" placeholder="Digite o nome ou parte dele..." value="{!! ($dados[0]->pessoas_id!='' ? str_repeat('0', (9-strlen($dados[0]->pessoas_id))) . $dados[0]->pessoas_id . ' - ' . $dados[0]->razaosocial  : '') !!}">
                                                  @else
                                                      <input type="text" id="fornecedor" name="fornecedor" class="typeahead form-control"  autocomplete="off" spellcheck="false" placeholder="Digite o nome ou parte dele..." value="">
                                                  @endif
                                                  @if ($errors->has('fornecedor'))
                                                    <span class="help-block">
                                                        <strong>{{ $errors->first('fornecedor') }}</strong>
                                                    </span>
                                                  @endif
                                                  <!--<label for="fornecedor" class="control-label">Fornecedor / Cliente</label>
                                                  <div class="input-group">
                                                      <div class="input-group-addon">
                                                          <button  id="buscarpessoa" type="button"  data-toggle="modal" data-target="#modal_fornecedor" >
                                                          <i class="fa fa-search"></i> ...
                                                          </button>
                                                      </div>
                                                  @include('modal_buscar_pessoas', array('qual_campo'=>'fornecedor', 'modal' => 'modal_fornecedor'))
                                                  @if (isset($dados))
                                                      <input id="fornecedor" name = "fornecedor" type="text" class="form-control" placeholder="Clica na lupa ao lado para consultar uma pessoa" value="{!! ($dados[0]->pessoas_id!='' ? str_repeat('0', (9-strlen($dados[0]->pessoas_id))) . $dados[0]->pessoas_id . ' - ' . $dados[0]->razaosocial  : '') !!}" readonly >
                                                  @else
                                                      <input id="fornecedor" name = "fornecedor" type="text" class="form-control" placeholder="Clica na lupa ao lado para consultar uma pessoa" value="" readonly >
                                                  @endif
                                                  </div>-->
                                              </div>
                                        </div>
                                        <div class="row">

                                              <div class="col-xs-4 {{ $errors->has('descricao') ? ' has-error' : '' }}">
                                                    <label for="descricao" class="control-label"><span class="text-danger">*</span>  Descrição</label>
                                                    @if (isset($dados))
                                                        <input id="descricao"  placeholder="Campo Obrigatório" name = "descricao" type="text" class="form-control" value="{{ $dados[0]->descricao }}">
                                                    @else
                                                        <input id="descricao"  placeholder="Campo Obrigatório" name = "descricao" type="text" class="form-control" value="{{ old('descricao') }}">
                                                    @endif
                                                       <!-- se houver erros na validacao do form request -->
                                                       @if ($errors->has('descricao'))
                                                        <span class="help-block">
                                                            <strong>{{ $errors->first('descricao') }}</strong>
                                                        </span>
                                                       @endif
                                              </div>

                                              <div class="col-xs-2 {{ $errors->has('valor') ? ' has-error' : '' }}">
                                                    <label for="valor" class="control-label"><span class="text-danger">*</span>  Valor</label>
                                                    <div class="input-group">
                                                       <span class="input-group-addon">R$</span>
                                                         @if (isset($dados))
                                                              <input id="valor" maxlength="60"   name = "valor" type="text" class="formata_valor form-control" value="{{ $dados[0]->valor }}">
                                                         @else
                                                              <input id="valor" maxlength="60"   name = "valor" type="text" class="formata_valor form-control" onblur="onblur_valor();" value="{{ old('valor')}}">
                                                         @endif

                                                         @if ($errors->has('valor'))
                                                          <span class="help-block">
                                                              <strong>{{ $errors->first('valor') }}</strong>
                                                          </span>
                                                         @endif
                                                   </div>
                                              </div>

                                             <div class="col-xs-2">
                                                  <label for="data_emissao" class="control-label"><span class="text-danger">*</span>  Data Emissão</label>
                                                  <div class="input-group">
                                                         <div class="input-group-addon">
                                                          <i class="fa fa-calendar"></i>
                                                          </div>
                                                          @if (isset($dados))
                                                                <input id ="data_emissao" name = "data_emissao" onblur="validar_data(this);" type="text" class="form-control" data-inputmask='"mask": "99/99/9999"' data-mask  value="{{ $dados[0]->data_emissao }}">
                                                          @else
                                                                <input id ="data_emissao" name = "data_emissao" onblur="validar_data(this);" type="text" class="form-control" data-inputmask='"mask": "99/99/9999"' data-mask  value="{{ old('data_emissao') }}">
                                                          @endif
                                                  </div>
                                             </div>

                                             <div class="col-xs-2 {{ $errors->has('data_vencimento') ? ' has-error' : '' }}">
                                                  <label for="data_vencimento" class="control-label"><span class="text-danger">*</span>  Data Vencimento</label>
                                                  <div class="input-group">
                                                         <div class="input-group-addon">
                                                          <i class="fa fa-calendar"></i>
                                                          </div>
                                                          @if (isset($dados))
                                                                <input id ="data_vencimento" name = "data_vencimento" onblur="validar_data(this);" type="text" class="form-control" data-inputmask='"mask": "99/99/9999"' data-mask  value="{{ $dados[0]->data_vencimento }}">
                                                          @else
                                                                <input id ="data_vencimento" name = "data_vencimento" onblur="validar_data(this);" type="text" class="form-control" data-inputmask='"mask": "99/99/9999"' data-mask  value="{{ old('data_vencimento') }}">
                                                          @endif
                                                          <!-- se houver erros na validacao do form request -->
                                                           @if ($errors->has('data_vencimento'))
                                                            <span class="help-block">
                                                                <strong>{{ $errors->first('data_vencimento') }}</strong>
                                                            </span>
                                                           @endif
                                                  </div>
                                             </div>

                                        </div> <!-- row -->

                                        <div class="row">
                                              <div class="col-xs-4  {{ $errors->has('conta') ? ' has-error' : '' }}">
                                                    <span class="text-danger">*</span>
                                                   @if (isset($dados))
                                                            @include('carregar_combos', array('dados'=>$contas, 'titulo' =>'Conta', 'id_combo'=>'conta', 'complemento'=>'', 'comparar'=>$dados[0]->contas_id, 'id_pagina'=> '48'))
                                                   @else
                                                            @include('carregar_combos', array('dados'=>$contas, 'titulo' =>'Conta', 'id_combo'=>'conta', 'complemento'=>'', 'comparar'=>'', 'id_pagina'=> '48'))
                                                   @endif

                                                    @include('modal_cadastro_basico', array('qual_campo'=>'conta', 'modal' => 'modal_conta', 'tabela' => 'contas'))
                                                     <!-- se houver erros na validacao do form request -->
                                                     @if ($errors->has('conta'))
                                                     <span class="help-block">
                                                          <strong>{{ $errors->first('conta') }}</strong>
                                                     </span>
                                                     @endif
                                              </div><!-- col-xs-->

                                              <div class="col-xs-4">
                                                    @if (isset($dados))
                                                          @include('carregar_combos', array('dados'=>$plano_contas, 'titulo' =>'Plano de Contas', 'id_combo'=>'plano', 'complemento'=>'', 'comparar'=>$dados[0]->planos_contas_id, 'id_pagina'=> '49'))
                                                    @else
                                                          @include('carregar_combos', array('dados'=>$plano_contas, 'titulo' =>'Plano de Contas', 'id_combo'=>'plano', 'complemento'=>'', 'comparar'=>'', 'id_pagina'=> '49'))
                                                    @endif

                                                    @include('modal_cadastro_basico', array('qual_campo'=>'plano', 'modal' => 'modal_plano', 'tabela' => 'planos_contas'))
                                              </div><!-- col-xs-->

                                              <div class="col-xs-3">

                                                    <input type="hidden" name="centros_custos" id="centros_custos" value="">

                                                    @if (isset($rateio_titulos))
                                                        @if ($rateio_titulos->count()>0)
                                                              @if ($tipo_operacao=="editar")
                                                                    <label for="centros_custos" class="control-label text-info">Centro de Custo <i>(Existem Valores de Rateio)</i></label>
                                                              @else
                                                                    <label for="centros_custos" class="control-label">Centro de Custo</label>
                                                              @endif
                                                        @else
                                                              <label for="centros_custos" class="control-label">Centro de Custo</label>
                                                        @endif
                                                    @else
                                                          <label for="centros_custos" class="control-label">Centro de Custo</label>
                                                    @endif


                                                      <div class="input-group">
                                                             <div class="input-group-addon">
                                                                <a href="#" data-toggle="tooltip" title="Clique em 'Incluir Novo Registro' para cadastrar sem sair da página.">
                                                                      <img src="{{ url('/images/help.png') }}" class="user-image" alt="Ajuda"  />
                                                                 </a>
                                                              </div>

                                                             @if (isset($rateio_titulos) && $rateio_titulos->count()>0)
                                                                    <select id="centros_custos" onchange="incluir_registro_combo('centros_custos');" placeholder="(Selecionar)"
                                                                    name="centros_custos" data-live-search="true" data-none-selected-text="Nenhum item selecionado"
                                                                    class="form-control selectpicker" style="width: 100%;" {{$rateio_titulos->count()>0 ? "disabled" : "" }}>
                                                             @else
                                                                    <select id="centros_custos" onchange="incluir_registro_combo('centros_custos');" placeholder="(Selecionar)"
                                                                    name="centros_custos" data-live-search="true" data-none-selected-text="Nenhum item selecionado"
                                                                    class="form-control selectpicker" style="width: 100%;">
                                                             @endif


                                                              <option  value=""></option>

                                                              <!-- Verifica permissão de inclusao da pagina/tabela-->
                                                              @can('verifica_permissao', [52 ,'incluir'])
                                                                  <optgroup label="Ação">
                                                              @else
                                                                  <optgroup label="Ação" disabled>
                                                              @endcan

                                                              <option  value=""  data-icon="fa fa-eraser">(Nenhum)</option>
                                                              <option  value=""  data-icon="fa fa-plus-circle">(Incluir Novo Registro)</option>
                                                              <option data-divider="true"></option>
                                                              </optgroup>

                                                              <optgroup label="Registros">
                                                              @foreach($centros_custos as $item)
                                                                     @if (isset($dados))
                                                                          <option  value="{{$item->id}}" {{$dados[0]->centros_custos_id==$item->id ? "selected" : ""}} >{{$item->nome}}</option>
                                                                     @else
                                                                          <option  value="{{$item->id}}">{{$item->nome}}</option>
                                                                     @endif
                                                              @endforeach
                                                              </select>
                                                              </optgroup>

                                                              <span class="input-group-addon">
                                                                    <button  id="novorateio" type="button" data-toggle="modal" data-target="#myModal" onclick="calcular_rateio();">
                                                                        Rateio...
                                                                    </button>
                                                              </span>

                                                     </div>
                                                      @include('modal_cadastro_basico', array('qual_campo'=>'centros_custos', 'modal' => 'modal_centros_custos', 'tabela' => 'centros_custos'))
                                                </div>

                                        </div>

                                          <!-- vai ratear ? -->
                                          <!-- Modal -->
                                              <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                                                    <div class="modal-dialog  modal-lg" role="document">
                                                      <div class="modal-content">
                                                        <div class="modal-header">
                                                          <!--<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>-->
                                                          <h4 class="modal-title" id="myModalLabel">Rateio</h4>
                                                        </div>
                                                        <div class="modal-body">

                                                             <div class="row">
                                                                      <div class="col-xs-2">
                                                                       <b><i class="text-info"> Valor Total Título :</i> <input type="text" id="valor_original" readonly="true" name="valor_original" value="" class="form-control"></b>
                                                                      </div>
                                                                      <div class="col-xs-2">
                                                                       <b><i class="text-info"> Soma do Rateio :</i> <input type="text" id="soma_rateio" readonly="true" name="soma_rateio" value="" class="form-control"></b>
                                                                      </div>
                                                                      <div class="col-xs-2">
                                                                       <b><i class="text-info"> Valor Restante : </i><input type="text" id="valor_restante" readonly="true" name="valor_restante" value="" class="form-control"></b>
                                                                      </div>
                                                             </div>

                                                             <div class="row">

                                                                    <div class="col-xs-4">
                                                                          <label for="rateio_pc" class="control-label">Plano de Contas</label>

                                                                          <select id="rateio_pc" name="rateio_pc" placeholder="(Selecionar)" data-live-search="true" data-none-selected-text="Nenhum item selecionado" class="form-control selectpicker" style="width: 100%;" onchange="">
                                                                          <option  value=""></option>
                                                                          @foreach($plano_contas as $item)
                                                                                 <option  value="{{$item->id}}">{{$item->nome}}</option>
                                                                          @endforeach
                                                                          </select>
                                                                    </div>

                                                                    <div class="col-xs-4">
                                                                          <label for="rateio_cc" class="control-label">Centro de Custo</label>

                                                                          <select id="rateio_cc" name="rateio_cc" placeholder="(Selecionar)" data-live-search="true" data-none-selected-text="Nenhum item selecionado" class="form-control selectpicker" style="width: 100%;" onchange="document.getElementById('perc_rateio').focus(); validar_cc(this.value);">
                                                                          <option  value=""></option>
                                                                          @foreach($centros_custos as $item)
                                                                                 <option  value="{{$item->id}}">{{$item->nome}}</option>
                                                                          @endforeach
                                                                          </select>
                                                                    </div>

                                                                    <div class="col-xs-3">
                                                                          <label for="perc_rateio" class="control-label">% Rateio</label>
                                                                          <div class="input-group">
                                                                           <span class="input-group-addon">%</span>
                                                                           <input id="perc_rateio" onfocus="document.getElementById('valor_rateio').value=''; " name = "perc_rateio" type="text" class="form-control" value="" onblur="calcular_rateio();">
                                                                          </div>
                                                                    </div>

                                                                    <div class="col-xs-3">
                                                                          <label for="valor_rateio" class="control-label">Valor</label>
                                                                          <div class="input-group">
                                                                           <span class="input-group-addon">R$</span>
                                                                           <input id="valor_rateio" onfocus="document.getElementById('perc_rateio').value=''; "  name = "valor_rateio" type="text" class="form-control" value="" onblur="calcular_rateio();">
                                                                          </div>
                                                                    </div>

                                                                    <div class="col-xs-2">
                                                                          <label for="botao" class="control-label">&nbsp;</label>
                                                                          <button id="botao" type="button" class="btn btn-success form-control" onclick="incluir_rateio();"><i class="fa fa-plus"></i> Incluir</button>
                                                                    </div>

                                                            </div>

                                                        <div class="row">

                                                              @if ($tipo_operacao=="editar")
                                                                  <div class="col-xs-10">
                                                                       <input type="hidden" name="hidden_id_rateio_cc[]" id="hidden_id_rateio_cc[]" value="">
                                                                        <table id="mais_rateios" class="table table-bordered table-hover">
                                                                        @if (isset($rateio_titulos))
                                                                            <tr>
                                                                                  <td>Plano de Contas</td>
                                                                                  <td>Centro de Custo</td>
                                                                                  <td>%</td>
                                                                                  <td>Valor</td>
                                                                                  <td>Excluir</td>
                                                                            </tr>
                                                                            @foreach($rateio_titulos as $item)
                                                                            <tr>
                                                                                  <input id="hidden_id_rateio_pc[]" name = "hidden_id_rateio_pc[]" type="hidden" class="form-control ccusto" value="{{$item->planos_contas_id}}">
                                                                                  <input id="hidden_id_rateio_cc[]" name = "hidden_id_rateio_cc[]" type="hidden" class="form-control ccusto" value="{{$item->centros_custos_id}}">
                                                                                  <td><input id="inc_pc[]" readonly name = "inc_pc[]" type="text" class="form-control" value="{{$item->nome_pc}}"></td>
                                                                                  <td><input id="inc_cc[]" readonly name = "inc_cc[]" type="text" class="form-control" value="{{$item->nome}}"></td>
                                                                                  <td><input id="inc_perc[]" readonly name = "inc_perc[]" type="text" class="form-control valores" value='{{ str_replace(".", ",", $item->percentual) }}'></td>
                                                                                  <td><input id="inc_valor[]" readonly name = "inc_valor[]" type="text" class="form-control valores" value='{{ str_replace(".", ",", $item->valor) }}'></td>
                                                                                  <td><button data-toggle="tooltip" data-placement="top" title="Excluir Ítem"  class="btn btn-danger btn-sm remover"><spam class="glyphicon glyphicon-trash"></spam></button></td>
                                                                            </tr>
                                                                            @endforeach
                                                                        @endif
                                                                        </table>
                                                                  </div>
                                                              @else
                                                                    <div class="row">
                                                                        <div class="col-xs-10">
                                                                        <input type="hidden" name="hidden_id_rateio_cc[]" id="hidden_id_rateio_cc[]" value="">
                                                                              <table id="mais_rateios" class="table table-bordered table-hover">
                                                                                  <tr>
                                                                                        <td>Plano de Contas</td>
                                                                                        <td>Centro de Custo</td>
                                                                                        <td>%</td>
                                                                                        <td>Valor</td>
                                                                                        <td>Excluir</td>
                                                                                  </tr>
                                                                              </table>
                                                                        </div>
                                                                  </div>
                                                              @endif

                                                        </div>

                                                        </div>
                                                        <div class="modal-footer">
                                                            <button id="tchau" type="button" class="btn btn-danger" data-dismiss="modal" onclick="remover_todos();"><i class="fa fa-trash"></i> Excluir</button>
                                                            <button id="salvar" type="button" class="btn btn-primary" data-dismiss="modal" disabled="true"><i class="fa fa-save"></i> Salvar</button>
                                                            <button id="fechar" type="button" class="btn btn-default" data-dismiss="modal" ><i class="fa fa-close"></i> Fechar</button>
                                                        </div>
                                                      </div>
                                                    </div>
                                               </div>
                                           <!-- fim modal -->


                                        <input  id= "ckpago" name="ckpago" type="hidden" value=""/>
                                        <input type="hidden" name="total_pago" id='total_pago' value="0">

                                        <div class="row">
                                                <div class="col-xs-4">
                                                      <label for="ckpago" class="control-label">Marcar como Pago (Parcial ou Integral) ?</label>
                                                      <div class="input-group">
                                                             <div class="input-group-addon">
                                                                  @if (isset($dados))
                                                                        <input  id= "ckpago" name="ckpago" type="checkbox" class="ckpago" data-group-cls="btn-group-sm" value="{{ ($dados[0]->status=='B' ? true : '') }}"  {{ ($dados[0]->status=='B' ? 'checked' : '') }} />
                                                                  @else
                                                                        <input  id= "ckpago" name="ckpago" type="checkbox" class="ckpago" data-group-cls="btn-group-sm" value=""  />
                                                                  @endif
                                                             </div>
                                                      </div>
                                                </div>
                                        </div>

                                        @if (isset($dados))
                                              <!-- Somente para titulos parciais-->
                                              @if ($dados[0]->saldo_a_pagar>0 && $dados[0]->saldo_a_pagar <> $dados[0]->valor)
                                              <div class="row">
                                                    <div class="col-xs-10">
                                                      <label for="" class="control-label text-warning"><i class="fa fa-exclamation-triangle"></i> Esse Título está parcialmente baixado. Você pode efetuar novas baixas informando o valor no campo abaixo</label>
                                                      <p class="text-warning">- Em caso de pagamentos parciais, o título aparecerá como NÃO PAGO, pois existirá saldo à pagar.</p>
                                                    </div>
                                              </div>
                                              @endif
                                        @endif
                                        <!-- FIM - Somente para titulos parciais-->

                                        <div class="row">

                                              @if ($tipo_operacao=="editar")
                                              <div class="col-xs-2">
                                                      <label for="total_pago" class="control-label">Total Pago</label>
                                                      <div class="input-group">
                                                           <span class="input-group-addon">R$</span>
                                                           <b>

                                                           @if (isset($dados))
                                                                <input id="total_pago" readonly="true"  name = "total_pago" type="text" class="formata_valor form-control" value="{{$dados[0]->valor - $dados[0]->saldo_a_pagar}}">
                                                           @else
                                                                <input id="total_pago" readonly="true"  name = "total_pago" type="text" class="formata_valor form-control" value="">
                                                           @endif

                                                           </b>
                                                      </div>
                                              </div>

                                              <div class="col-xs-2">
                                                      <label for="saldo" class="control-label">Saldo à Pagar</label>
                                                      <div class="input-group">
                                                           <span class="input-group-addon">R$</span>
                                                           <b>

                                                           @if (isset($dados))
                                                                <input id="saldo" readonly="true"  name = "saldo" type="text" class="formata_valor form-control" value="{{$dados[0]->saldo_a_pagar}}">
                                                           @else
                                                                <input id="saldo" readonly="true"  name = "saldo" type="text" class="formata_valor form-control" value="">
                                                           @endif

                                                           </b>
                                                      </div>
                                              </div>
                                              @endif

                                              <div id="esconder" style="display: none" >
                                                    <div class="col-xs-2">
                                                          <label for="data_pagamento" class="control-label">Data Pagamento</label>

                                                          <div class="input-group">
                                                                 <div class="input-group-addon">
                                                                  <i class="fa fa-calendar"></i>
                                                                  </div>
                                                                  @if (isset($dados))
                                                                        <input id ="data_pagamento" name = "data_pagamento" onblur="validar_data(this);" type="text" class="form-control" data-inputmask='"mask": "99/99/9999"' data-mask  value="{{$dados[0]->data_pagamento}}">
                                                                  @else
                                                                        <input id ="data_pagamento" name = "data_pagamento" onblur="validar_data(this);" type="text" class="form-control" data-inputmask='"mask": "99/99/9999"' data-mask  value="">
                                                                  @endif
                                                          </div>
                                                      </div>


                                                      <div class="col-xs-2">
                                                            <label for="acrescimo" class="control-label">Acréscimo</label>
                                                            <div class="input-group">
                                                               <span class="input-group-addon">R$</span>
                                                                 @if (isset($dados))
                                                                      <input id="acrescimo" maxlength="10"   name = "acrescimo" type="text" class="formata_valor form-control" onblur="recalcula();" value="{{$dados[0]->acrescimo}}">
                                                                 @else
                                                                      <input id="acrescimo" maxlength="10"   name = "acrescimo" type="text" class="formata_valor form-control" onblur="recalcula();" value="">
                                                                 @endif
                                                            </div>
                                                       </div>

                                                        <div class="col-xs-2">
                                                            <label for="desconto" class="control-label">Desconto</label>
                                                            <div class="input-group">
                                                               <span class="input-group-addon">R$</span>
                                                                 @if (isset($dados))
                                                                      <input id="desconto" maxlength="10"   name = "desconto" type="text" class="formata_valor form-control" onblur="recalcula();" value="{{$dados[0]->desconto}}">
                                                                 @else
                                                                      <input id="desconto" maxlength="10"   name = "desconto" type="text" class="formata_valor form-control" onblur="recalcula();" value="">
                                                                 @endif
                                                            </div>
                                                       </div>

                                                       <div class="col-xs-2">
                                                            <label for="valor_pago" class="control-label">Valor Pagamento</label>
                                                            <div class="input-group">
                                                                 <span class="input-group-addon">R$</span>
                                                                 <input id="valor_pago" maxlength="10"   name = "valor_pago" type="text" class="formata_valor form-control" onblur="recalcula();" value="">
                                                            </div>
                                                       </div>
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
                                                              ( + ) Mais Informações
                                                            </a>
                                                          </h5>
                                                        </div>
                                                        <div id="collapseOne" class="panel-collapse collapse">
                                                          <div class="box-body">

                                                                     <div class="row">
                                                                           <div class="col-xs-5">
                                                                                <label for="obs" class="control-label">Observação</label>
                                                                                @if (isset($dados))
                                                                                      <input id="obs"  placeholder="(Opcional)" name = "obs" type="text" class="form-control" value="{{$dados[0]->obs}}">
                                                                                @else
                                                                                      <input id="obs"  placeholder="(Opcional)" name = "obs" type="text" class="form-control" value="">
                                                                                @endif
                                                                          </div>

                                                                    </div>

                                                                     <div class="row">
                                                                          <div class="col-xs-2">
                                                                                <label for="parcelas" class="control-label">Qtd. Parcelas</label>
                                                                                @if (isset($dados))
                                                                                      <input id="parcelas"  placeholder="(Opcional)" name = "parcelas" type="number" class="form-control" value="{{$dados[0]->numpar}}">
                                                                                @else
                                                                                      <input id="parcelas"  placeholder="(Opcional)" name = "parcelas" type="number" class="form-control" value="">
                                                                                @endif
                                                                          </div>

                                                                          <div class="col-xs-2">
                                                                                <label for="dias" class="control-label">N. Dias</label>
                                                                                @if (isset($dados))
                                                                                      <input id="dias"  placeholder="(Opcional)" name = "dias" type="number" class="form-control" value="{{$dados[0]->numdia}}">
                                                                                @else
                                                                                      <input id="dias"  placeholder="(Opcional)" name = "dias" type="number" class="form-control" value="">
                                                                                @endif
                                                                          </div>

                                                                          <div class="col-xs-2">
                                                                                <label for="numdoc" class="control-label">N. Documento</label>
                                                                                @if (isset($dados))
                                                                                      <input id="numdoc"  placeholder="(Opcional)" name = "numdoc" type="text" class="form-control" value="{{$dados[0]->numdoc}}">
                                                                                @else
                                                                                      <input id="numdoc"  placeholder="(Opcional)" name = "numdoc" type="text" class="form-control" value="">
                                                                                @endif
                                                                          </div>

                                                                          <div class="col-xs-2">
                                                                                <label for="serie" class="control-label">Série</label>
                                                                                @if (isset($dados))
                                                                                      <input id="serie"  placeholder="(Opcional)" name = "serie" type="text" class="form-control" value="{{$dados[0]->serie}}">
                                                                                @else
                                                                                      <input id="serie"  placeholder="(Opcional)" name = "serie" type="text" class="form-control" value="">
                                                                                @endif
                                                                          </div>



                                                                          <div class="col-xs-6">
                                                                                @if (isset($dados))
                                                                                      @include('carregar_combos', array('dados'=>$grupos_titulos, 'titulo' =>'Grupo Título', 'id_combo'=>'grupos_titulos', 'complemento'=>'', 'comparar'=>$dados[0]->grupos_titulos_id, 'id_pagina'=> '51'))
                                                                                @else
                                                                                      @include('carregar_combos', array('dados'=>$grupos_titulos, 'titulo' =>'Grupo Título', 'id_combo'=>'grupos_titulos', 'complemento'=>'', 'comparar'=>'', 'id_pagina'=> '51'))
                                                                                @endif

                                                                                @include('modal_cadastro_basico', array('qual_campo'=>'grupos_titulos', 'modal' => 'modal_grupos_titulos', 'tabela' => 'grupos_titulos'))
                                                                          </div><!-- col-xs-->

                                                                     </div>
                                                          </div>

                                                        </div>

                                                      </div>

                                                    </div>

                                                  </div>

                                                </div>

                                              </div>

                                            </div>

                          </div>
                          <!-- /.tab-pane -->

                          <div class="tab-pane" id="tab_2">
                                    <table class="table">
                                    <tr>
                                        <td>Data Ocorrência</td>
                                        <td>Usuário</td>
                                        <td>Descrição Título</td>
                                        <td>Conta</td>
                                        <td>Valor Título</td>
                                        <td>Acréscimo</td>
                                        <td>Desconto</td>
                                        <td>Valor Pago</td>
                                        <td>Saldo</td>
                                        <td>Status</td>
                                        <td>Ação</td>
                                    </tr>
                                    @if (isset($log))
                                        @foreach($log as $item)
                                              <tr>
                                                  <td>{{$item->data_ocorrencia}}</td>
                                                  <td>{{$item->name}}</td>
                                                  <td>{{$item->descricao}}</td>
                                                  <td>{{$item->nome}}</td>
                                                  <td>{{$item->valor}}</td>
                                                  <td>{{$item->acrescimo}}</td>
                                                  <td>{{$item->desconto}}</td>
                                                  <td>{{$item->valor_pago}}</td>
                                                  <td>{{$item->saldo_a_pagar}}</td>
                                                  <td>{{$item->status}}</td>
                                                  <td>
                                                  <!-- Se houve alteracao de status, poderá ser baixa, estorno ou baixa parcial-->
                                                  <!-- Se houver alteracao de status-->
                                                  @if (trim($item->alteracao_status)!="")
                                                      @if ($item->saldo_a_pagar==0)
                                                            <p>Baixa Integral</p>
                                                      @elseif ($item->saldo_a_pagar==$item->valor)
                                                            <p>Estorno</p>
                                                      @else
                                                            <p>Baixa Parcial</p>
                                                      @endif
                                                  @else
                                                      {{$item->acao}}
                                                  @endif

                                                  </td>
                                              </tr>
                                        @endforeach
                                    @endif
                                    </table>
                          </div>
                          <!-- /.tab-pane -->

                        </div>
                        <!-- /.tab-content -->
                      </div>
                      <!-- nav-tabs-custom -->


             </div><!-- fim box-body"-->

        </div><!-- box box-primary -->

        <div class="box-footer">
            <button class = 'btn btn-primary' type ='submit' {{ ($preview=='true' ? 'disabled=disabled' : "" ) }}><i class="fa fa-save"></i> Salvar</button>
            <a href="{{ url('/' . \Session::get('route') . '/' . $tipo)}}" class="btn btn-default">Cancelar</a>
        </div>

        </form>


    </div>

</div>


@include('titulos.script_titulos')

@endsection