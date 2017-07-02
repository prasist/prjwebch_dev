@extends('principal.master')

@section('content')

{{ \Session::put('titulo', 'Controle Atividades') }}

@if ($tipo_operacao=="incluir")
    {{ \Session::put('subtitulo', 'Inclusão') }}
@else
    {{ \Session::put('subtitulo', 'Alteração / Visualização') }}
@endif

{{ \Session::put('route', 'controle_atividades') }}
{{ \Session::put('id_pagina', '58') }}

<div class = 'row'>

  <div class="col-md-12">

            <div class="row">
              <div class="col-xs-2">
                      <a href="{{ url('/' . \Session::get('route')) }}" class="btn btn-default"><i class="fa fa-arrow-circle-left"></i> Voltar</a>
              </div>

              <div class="col-xs-3">
                  <a href="{{ url('/tutoriais/5')}}" data-toggle="tooltip" title="Clique Aqui para ver o tutorial..." target="_blank">
                      <i class="glyphicon glyphicon-question-sign text-success"></i>&nbsp;Como Gerenciar {!! \Session::get('label_encontros') !!} ?
                 </a>
              </div>
          </div>

  </div>

@if ($tipo_operacao=="incluir")
      <form method = 'POST' class="form-horizontal" enctype="multipart/form-data" action ="{{ url('/' . \Session::get('route') . '/gravar')}}">
@else
      <form method = 'POST' class="form-horizontal" enctype="multipart/form-data" action ="{{ url('/' . \Session::get('route') . '/' . $dados[0]->id . '/update')}}">
@endif

{!! csrf_field() !!}

  <!-- Main content -->
    <section class="content">
      <div class="row">
        <!-- left column -->

        <div class="col-md-6">

              <!-- INICIO CONTEUDO -->

                <!-- Horizontal Form -->
                <div class="box box-info">
                  <div class="box-header with-border">
                       <h3 class="box-title">Selecionar {!! \Session::get('label_celulas_singular') !!} e Data de {!! \Session::get('label_encontros') !!}</h3>
                  </div>
                  <!-- /.box-header -->
                  <!-- form start -->
                  <div class="form-horizontal">
                    <div class="box-body">

                      <div class="row">
                            <div class="col-xs-12 {{ $errors->has('celulas') ? ' has-error' : '' }}">

                                    @if ($tipo_operacao=="editar")
                                          <input type="hidden" name="hidden_id" id="hidden_id" value="{{$dados[0]->id}}">
                                    @else
                                          <input type="hidden" name="hidden_id" id="hidden_id" value="">
                                    @endif

                                    <label for="celulas" class="control-label">{!! \Session::get('label_celulas_singular') !!}</label>
                                    <select id="celulas" placeholder="(Selecionar)" name="celulas" data-live-search="true" data-none-selected-text="Nenhum item selecionado" class="form-control" style="width: 100%;">
                                    <option  value="0"></option>
                                    @foreach($celulas as $item)
                                           @if ($tipo_operacao=="incluir")
                                                  <option  value="{{$item->id . '|' . $item->nome}}" {{ (old('celulas')== $item->id ? 'selected' : '') }}>{{$item->nome}}</option>
                                           @else
                                                   @if ($dados[0]->celulas_id== $item->id)
                                                  <option  value="{{$item->id . '|' . $item->nome}}" {{ ($dados[0]->celulas_id== $item->id ? 'selected' : '') }}>{{$item->nome}}</option>
                                                  @endif
                                           @endif
                                    @endforeach
                                    </select>
                            </div>

                            <!-- se houver erros na validacao do form request -->
                            @if ($errors->has('celulas'))
                            <span class="help-block">
                                <strong>{{ $errors->first('celulas') }}</strong>
                            </span>
                            @endif

                      </div>
                      <div class="row">
                          <div class="col-xs-12">
                                <input id="dia_encontro"  name = "dia_encontro" type="hidden" class="form-control" value="{{old('dia_encontro')}}">
                          </div>
                      </div>
                      <div class="row">

                            <div class="col-xs-4  {{ $errors->has('mes') ? ' has-error' : '' }}">
                                    <label for="mes" class="control-label">Mês</label>
                                    <select id="mes" name="mes" data-live-search="true" data-none-selected-text="Nenhum item selecionado" class="form-control selectpicker" style="width: 100%;">
                                        <option  value=""></option>

                                        @if ($tipo_operacao=="incluir")
                                             <option  value="01" {{ (date('m')==1 ? 'selected' : '') }} >Janeiro</option>
                                             <option  value="02" {{ (date('m')==2 ? 'selected' : '') }} >Fevereiro</option>
                                             <option  value="03" {{ (date('m')==3 ? 'selected' : '') }} >Março</option>
                                             <option  value="04" {{ (date('m')==4 ? 'selected' : '') }} >Abril</option>
                                             <option  value="05" {{ (date('m')==5 ? 'selected' : '') }} >Maio</option>
                                             <option  value="06" {{ (date('m')==6 ? 'selected' : '') }} >Junho</option>
                                             <option  value="07" {{ (date('m')==7 ? 'selected' : '') }} >Julho</option>
                                             <option  value="08" {{ (date('m')==8 ? 'selected' : '') }} >Agosto</option>
                                             <option  value="09" {{ (date('m')==9 ? 'selected' : '') }} >Setembro</option>
                                             <option  value="10" {{ (date('m')==10 ? 'selected' : '') }} >Outubro</option>
                                             <option  value="11" {{ (date('m')==11 ? 'selected' : '') }} >Novembro</option>
                                             <option  value="12" {{ (date('m')==12 ? 'selected' : '') }} >Dezembro</option>
                                        @else
                                             <option  value="01" {{ ($dados[0]->mes==1 ? 'selected' : '') }} >Janeiro</option>
                                             <option  value="02" {{ ($dados[0]->mes==2 ? 'selected' : '') }} >Fevereiro</option>
                                             <option  value="03" {{ ($dados[0]->mes==3 ? 'selected' : '') }} >Março</option>
                                             <option  value="04" {{ ($dados[0]->mes==4 ? 'selected' : '') }} >Abril</option>
                                             <option  value="05" {{ ($dados[0]->mes==5 ? 'selected' : '') }} >Maio</option>
                                             <option  value="06" {{ ($dados[0]->mes==6 ? 'selected' : '') }} >Junho</option>
                                             <option  value="07" {{ ($dados[0]->mes==7 ? 'selected' : '') }} >Julho</option>
                                             <option  value="08" {{ ($dados[0]->mes==8 ? 'selected' : '') }} >Agosto</option>
                                             <option  value="09" {{ ($dados[0]->mes==9 ? 'selected' : '') }} >Setembro</option>
                                             <option  value="10" {{ ($dados[0]->mes==10 ? 'selected' : '') }} >Outubro</option>
                                             <option  value="11" {{ ($dados[0]->mes==11 ? 'selected' : '') }} >Novembro</option>
                                             <option  value="12" {{ ($dados[0]->mes==12 ? 'selected' : '') }} >Dezembro</option>
                                        @endif

                                    </select>

                                    <!-- se houver erros na validacao do form request -->
                                    @if ($errors->has('mes'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('mes') }}</strong>
                                    </span>
                                    @endif
                            </div>


                            <div class="col-xs-4 {{ $errors->has('ano') ? ' has-error' : '' }}">
                                  <label for="ano" class="control-label">Ano</label>
                                  @if ($tipo_operacao=="incluir")
                                        <input id="ano"  name = "ano" type="text" class="form-control" value="{{date('Y')}}">
                                  @else
                                        <input id="ano"  name = "ano" type="text" class="form-control" value="{{$dados[0]->ano}}">
                                  @endif

                                    <!-- se houver erros na validacao do form request -->
                                    @if ($errors->has('ano'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('ano') }}</strong>
                                    </span>
                                    @endif

                            </div>

                            <div class="col-xs-4 {{ $errors->has('data_encontro') ? ' has-error' : '' }}">
                                <label for="data_encontro" class="control-label">Data {!! \Session::get('label_encontros_singular') !!}</label>
                                <!--<select id="data_encontro" name="data_encontro" data-live-search="true" data-none-selected-text="Nenhum item selecionado" class="form-control selectpicker" style="width: 100%;">-->
                                <select id="data_encontro" name="data_encontro" class="form-control">
                                      @if ($tipo_operacao=="incluir")
                                          <option value=""></option>
                                      @else
                                          @foreach($dates_of_meeting as $item)
                                                  @if ($dados[0]->dia==substr($item,0,2))
                                                  <option value='{{$dados[0]->dia==substr($item,0,2) ? $dados[0]->dia : "" }}' {{$dados[0]->dia==substr($item,0,2) ? "selected" : "" }}>{{$item}}</option>
                                                  @endif
                                          @endforeach
                                      @endif
                                </select>

                                <!-- se houver erros na validacao do form request -->
                                @if ($errors->has('data_encontro'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('data_encontro') }}</strong>
                                </span>
                                @endif
                          </div>


                      </div>
                      <div class="row">
                            <div class="col-xs-4">
                                      <label for="ckEstruturas" class="control-label">{!! \Session::get('label_encontros_singular') !!} Encerrado ?</label>
                                      <div class="input-group">
                                             <div class="input-group-addon">
                                                  <input  id= "ckFinalizar" name="ckFinalizar" data-group-cls="btn-group-sm" type="checkbox" class="ckFinalizar" {{ ($tipo_operacao=="incluir" ? "" : ($dados[0]->encontro_encerrado=="S" ? "checked" : "") )  }}/>
                                             </div>
                                      </div>
                            </div>

                            <div class="col-xs-4">
                                <p>&nbsp;</p>

                                <!--<button class = 'btn btn-info' type ='button' onclick="abrir_relatorio();" {{ ($preview=='true' ? 'disabled=disabled' : "" ) }}><i class="fa fa-print"></i> Imprimir</button>-->

                                <div class="input-group margin">
                                  <div class="input-group-btn">
                                    <button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown"><span class="fa fa-print"></span>  Imprimir
                                        <span class="fa fa-caret-down"></span></button>
                                        <ul class="dropdown-menu">

                                              <li><a href="#" onclick="abrir_relatorio('C');">Relatório Completo</a></li>
                                              <li><a href="#" onclick="abrir_relatorio('R');">Resumo</a></li>

                                        </ul>
                                  </div>
                                  <br/>
                              </div>

                            </div>

                            <div id="div_data" class="col-xs-3" style="display: none">
                                  <label for="data_avulsa" class="control-label">Data Encontro Avulso</label>
                                  <input id ="data_avulsa" name = "data_avulsa" onblur="validar_data(this);" type="text" class="form-control" data-inputmask='"mask": "99/99/9999"' data-mask  value="">
                            </div>

                      </div>


                 </div>
                    <!-- /.box-body -->
                    <!-- /.box-footer -->
                  </div>
                </div>
                <!-- /.box -->
              <!-- FIM CONTEUDO -->


            <!-- INICIO CONTEUDO -->
            <!-- Horizontal Form -->
            <div class="box box-info" id="box_mais" >
                  <div class="box-header with-border">
                    <h3 class="box-title">Encerramento {!! \Session::get('label_encontros_singular') !!}</h3>
                  </div>
                  <!-- /.box-header -->
                  <!-- form start -->
                  <div class="form-horizontal">
                    <div class="box-body">
                      <div class="row">

                                <div class="col-xs-4">
                                    <label for="hora_inicio" class="control-label">Horário Inicio</label>
                                    <input type="text" name="hora_inicio" id="hora_inicio"  data-inputmask='"mask": "99:99"' data-mask  class="form-control input-small" value='{{ ($tipo_operacao=="incluir" ? "" : $dados[0]->hora_inicio) }}'>
                                </div>

                                <div class="col-xs-4">
                                    <label for="hora_fim" class="control-label">Horário Término</label>
                                    <input type="text" name="hora_fim" id="hora_fim"  data-inputmask='"mask": "99:99"' data-mask  class="form-control input-small" value='{{ ($tipo_operacao=="incluir" ? "" : $dados[0]->hora_fim) }}'>
                                </div>

                                <!--
                                <div class="col-xs-4">
                                   <label for="valor_oferta" class="control-label">Valor Oferta</label>
                                   <input type="text" name="valor_oferta" id="valor_oferta"  class="formata_valor form-control" value='{{ ($tipo_operacao=="incluir" ? "" : $dados[0]->valor_oferta) }}'>
                                </div>
                                -->

                      </div>

                      <div class="row">
                            <div class="col-xs-12">
                                  <label for="observacao" class="control-label">Observações</label>
                                  <textarea name="observacao" class="form-control" rows="2" placeholder="Digite o texto..." >{!! ($tipo_operacao=="incluir" ? "" : rtrim(ltrim($dados[0]->obs))) !!}</textarea>
                            </div>
                      </div>

                 </div>
                <!-- /.box-body -->
                <!-- /.box-footer -->
              </div>
            </div>
            <!-- /.box -->
            <!-- FIM CONTEUDO -->

        </div>

        <!--/.col (left) -->
        <!-- right column -->
        <div class="col-md-6">

          <!-- INICIO CONTEUDO -->
          <!-- Horizontal Form -->
            <div class="box box-info" id="box_material">
                  <div class="box-header with-border">
                    <h3 class="box-title">Material {!! \Session::get('label_encontros_singular') !!}</h3>
                  </div>
                  <!-- /.box-header -->
                  <!-- form start -->
                  <div class="form-horizontal">
                    <div class="box-body">
                      <div class="row">

                           <div class="col-xs-12">
                                  <p class="text"><i>Para arquivos maiores, sugerimos utilizar algum repositório remoto e informar o link no campo "Link Externo"</i></p>
                                  <label for="upload_arquivo" class="control-label">Tamanho Máximo cada Arquivo : 200Kb.</label>
                                  <input type="file" id="upload_arquivo[]" name = "upload_arquivo[]" multiple="true" onchange="checkPhoto(this)">
                                  <label id="msg" class="text-danger"></label>

                                  @if ($tipo_operacao=="editar")
                                      <table id="tab_arquivos" class="table table-responsive table-hover">
                                      @foreach($controle_materiais as $item)
                                           @if ($item->arquivo!="")
                                              <tr id="{{$item->id}}">
                                                  <td><a href="{{ url('/arquivos/encontros/' . $item->arquivo) }}" target="_blank">{{$item->arquivo}}</a></td>
                                                  <td><a href="#" class="btn btn-danger remover_arquivo" id="{{$item->id}}"><i class="fa fa-trash"></i></a></td>
                                              </tr>
                                           @endif

                                      @endforeach
                                      </table>
                                  @endif
                           </div>

                      </div>

                      <div class="row">
                              <div class="col-xs-12">
                                   <label for="link_externo" class="control-label">Link Externo (Material {!! \Session::get('label_encontros_singular') !!}, Artigo, Documento, Site, Video, Imagem, etc)</label>
                                   <input type="text" name="link_externo" id="link_externo"  class="form-control" value='{{ ($tipo_operacao=="editar" ? $dados[0]->link_externo : "") }}'>
                              </div>
                      </div>

                      <div class="row">
                              <div class="col-xs-12">
                                   <label for="texto_encontro" class="control-label">Texto</label>
                                   <textarea name="texto_encontro" class="form-control" rows="4" placeholder="Digite o texto..." >@if ($tipo_operacao=="editar"){{rtrim(ltrim($dados[0]->texto))}}@endif</textarea>
                              </div>
                      </div>


                 </div>
                <!-- /.box-body -->
                <!-- /.box-footer -->
              </div>

              <div class="box-footer">
                  <button class = 'btn btn-primary' type ='submit' {{ ($preview=='true' ? 'disabled=disabled' : "" ) }}><i class="fa fa-save"></i> Salvar</button>
                  <a href="{{ url('/' . \Session::get('route') )}}" class="btn btn-default">Cancelar</a>
              </div>

            </div>
            <!-- /.box -->
            <!-- FIM CONTEUDO -->


        </div>

       <div class="col-md-12" id="box_participantes" >

          <div class="box box-default">

                <div class="box-body">

                        <div class="row">
                              <p id="reune_sempre"></p>
                        </div>

                        <div class="row">
                           <div class="col-xs-12">
                           <br/>

                                 <table id="tab_participantes" class="table table-responsive table-hover">
                                  <thead>
                                      <tr>
                                          <th >ID</th>
                                          <th >Participantes</th>
                                          <th >Presença</th>
                                          <th >Observação</th>
                                      </tr>
                                  </thead>
                                  <tbody>

                                    <tr>
                                        <td ></td>
                                        <td ></td>
                                        <td ></td>
                                        <td ></td>
                                    </tr>

                                    @if ($tipo_operacao=="editar")
                                        @foreach ($participantes as $item)
                                        <tr>
                                                  <td>{{$item->id}}</td>
                                                  <td>{{ltrim(rtrim($item->razaosocial))}}</td>
                                                  <td>
                                                      <input name="presenca[]" id="presenca[]" type="checkbox" class="obs" data-group-cls="btn-group-sm" value="{{$item->id}}"  data-off-text="Não" data-on-text="Sim" {{ ($item->presenca_simples=="S" ? "checked" : "") }} />
                                                  </td>
                                                  <td>
                                                            <input  name="id_obs_membro[]" id="id_obs_membro[]" type="hidden"  value="{{$item->id}}" />
                                                            <input  name="obs_membro[]" id="obs_membro[]" type="text" class="form-control" value="{{ltrim(rtrim($item->observacao))}}" />
                                                  </td>
                                         </tr>
                                         @endforeach
                                    @endif

                                  </tbody>
                                 </table>

                             </div>
                        </div>

                  </div><!-- fim box-body"-->
              </div><!-- box box-primary -->


       </div>


       <!-- ini-->
       <div class="col-md-12"  id="box_visitantes" >

            <!-- Horizontal Form -->
                <div class="box box-info">
                  <div class="box-header with-border">
                    <h3 class="box-title">Visitantes</h3>
                  </div>
                  <!-- /.box-header -->
                  <!-- form start -->
                  <div class="form-horizontal">
                    <div class="box-body">

                        <div class="row">
                                <div class="col-xs-12">
                                        <a href="#" class="btn btn-default" id="addRow" name="addRow"><b> + Incluir Visitante </b></a>
                                        <p>&nbsp;</p>

                                            <table id="tab_visitantes" class="table table-responsive">
                                              <thead>
                                                  <tr>
                                                      <th>Nome</th>
                                                      <th>Fone</th>
                                                      <th>Email</th>
                                                      <th>Remover</th>
                                                  </tr>
                                              </thead>
                                              <tbody>
                                                <tr>
                                                    <td class="col-xs-5"><input name="nome_visitante[]" type="text" class="form-control" value=""  /></td>
                                                    <td class="col-xs-3"><input name="fone_visitante[]" type="text" class="form-control" value=""  /></td>
                                                    <td class="col-xs-3"><input name="email_visitante[]" type="text" class="form-control" value=""  /></td>
                                                    <td class="col-xs-1"><button data-toggle="tooltip" data-placement="top" title="Excluir Ítem"  class="btn btn-danger btn-sm remover"><spam class="glyphicon glyphicon-trash"></spam></button></td>
                                                </tr>

                                                @if ($tipo_operacao=='editar')

                                                      @foreach($visitantes as $item)
                                                            @if ($item->nome!="")
                                                            <tr>
                                                                <td class="col-xs-5"><input name="nome_visitante[]" type="text" class="form-control" value="{{$item->nome}}"  /></td>
                                                                <td class="col-xs-3"><input name="fone_visitante[]" type="text" class="form-control" value="{{$item->fone}}"  /></td>
                                                                <td class="col-xs-3"><input name="email_visitante[]" type="text" class="form-control" value="{{$item->email}}"  /></td>
                                                                <td class="col-xs-1"><button data-toggle="tooltip" data-placement="top" title="Excluir Ítem"  class="btn btn-danger btn-sm remover"><spam class="glyphicon glyphicon-trash"></spam></button></td>
                                                            </tr>
                                                            @endif
                                                      @endforeach

                                                @endif

                                              </tbody>
                                            </table>

                               </div>

                         </div><!-- end row-->


                   </div>

                 </div>

               </div>

                <!-- /.box -->
                <!-- FIM CONTEUDO -->

        </div>

       <div class="col-md-12"  id="box_questions" >
             <!-- Horizontal Form -->
                <div class="box box-info">
                  <div class="box-header with-border">
                    <h3 class="box-title">Questionários</h3>
                  </div>
                  <!-- /.box-header -->
                  <!-- form start -->
                  <div class="form-horizontal">
                    <div class="box-body">
                    <input id="ck_resposta[]" name="ck_resposta[]" type="hidden" value=""/>

                              @foreach ($questions as $item)
                                    <div class="form-group">
                                            <label  class="col-sm-6 control-label">{{$item->pergunta}}</label>
                                             <input id="id_hidden_pergunta[]" name="id_hidden_pergunta[]" type="hidden"  value="{{$item->id}}"  />

                                            <div class="col-xs-4">
                                                    <!-- 1 = yes or no -->
                                                    <!-- 2 = number field -->
                                                    <!-- 3 = text field -->

                                                    @if ($item->tipo_resposta==1)
                                                            @if ($tipo_operacao=='editar')
                                                                    @if (rtrim(ltrim($item->resposta))=="S")
                                                                          @if ($item->questionarios_id==$item->id)
                                                                               <input id="ck_resposta[]" name="ck_resposta[]" type="checkbox" class="perguntas" data-group-cls="btn-group-sm" data-off-text="Não" data-on-text="Sim" checked  value="{{$item->id}}"/>
                                                                          @else
                                                                               <input id="ck_resposta[]" name="ck_resposta[]" type="checkbox"  value="{{$item->id}}" class="perguntas" data-group-cls="btn-group-sm" data-off-text="Não" data-on-text="Sim" />
                                                                          @endif
                                                                    @else
                                                                          <input id="ck_resposta[]" name="ck_resposta[]" type="checkbox"  value="{{$item->id}}" class="perguntas" data-group-cls="btn-group-sm" data-off-text="Não" data-on-text="Sim"  />
                                                                    @endif
                                                            @else
                                                                  <input id="ck_resposta[]" name="ck_resposta[]" type="checkbox"  value="{{$item->id}}" class="perguntas" data-group-cls="btn-group-sm" data-off-text="Não" data-on-text="Sim" />
                                                            @endif
                                                    @endif



                                                    @if ($item->tipo_resposta==2 || $item->tipo_resposta==3)

                                                            @if ($tipo_operacao=='editar')
                                                                    @if (rtrim(ltrim($item->resposta))!="")
                                                                         @if ($item->questionarios_id==$item->id)

                                                                                @if ($item->tipo_resposta==2)
                                                                                      <input id="text_resposta[]" name="text_resposta[]" type="number" name="input"  min="0" max="99" class="form-control"  value="{{ ($tipo_operacao=='editar' ? $item->resposta : '') }}" >
                                                                                @else
                                                                                      <input id="text_resposta[]" name="text_resposta[]" type="text" class="form-control"  value="{{ ($tipo_operacao=='editar' ? $item->resposta : '') }}" />
                                                                                @endif
                                                                         @else
                                                                                @if ($item->tipo_resposta==2)
                                                                                      <input id="text_resposta[]" name="text_resposta[]" type="number" name="input"  min="0" max="99" class="form-control"  value="" >
                                                                                @else
                                                                                      <input id="text_resposta[]" name="text_resposta[]" type="text" class="form-control"  value="" />
                                                                                @endif
                                                                         @endif
                                                                    @else
                                                                         @if ($item->tipo_resposta==2)
                                                                                <input id="text_resposta[]" name="text_resposta[]" type="number" name="input"  min="0" max="99" class="form-control"  value="" >
                                                                          @else
                                                                                <input id="text_resposta[]" name="text_resposta[]" type="text" class="form-control"  value="" />
                                                                          @endif
                                                                    @endif
                                                            @else
                                                                    @if ($item->tipo_resposta==2)
                                                                                <input id="text_resposta[]" name="text_resposta[]" type="number" name="input"  min="0" max="99" class="form-control"  value="" >
                                                                          @else
                                                                                <input id="text_resposta[]" name="text_resposta[]" type="text" class="form-control"  value="" />
                                                                          @endif
                                                            @endif

                                                    @else
                                                           <input id="text_resposta[]" name="text_resposta[]" type="hidden" value="" />
                                                    @endif

                                           </div>
                                    </div>
                              @endforeach

                    </div>

                      <!--
                      <div id="ampulheta" class="overlay modal" style="display: none">
                          <i class="fa fa-refresh fa-spin"></i>
                      </div>-->

                 </div>



              </div>

                <!-- /.box -->
                <!-- FIM CONTEUDO -->
       </div>

      </div>
      <!-- /.row -->

            <div class="box-footer">
                  <button class = 'btn btn-primary' type ='submit' {{ ($preview=='true' ? 'disabled=disabled' : "" ) }}><i class="fa fa-save"></i> Salvar</button>
                  <a href="{{ url('/' . \Session::get('route') )}}" class="btn btn-default">Cancelar</a>
            </div>



    </section>
    <!-- /.content -->
 </form>

</div>


<script type="text/javascript">


        /*Validação da imagem que será enviada*/
        function checkPhoto(target)
        {

            /*Tamanho maximo */
            if(target.files[0].size > 200000) {
                document.getElementById("msg").innerHTML = "arquivo muito grande (max 200Kb)";
                document.getElementById("upload_arquivo").value = "";
                alert("Imagem muito grande (max 200Kb), favor selecionar outro arquivo.");
                return false;
            }

            /*Chegou ate aqui beleza...*/
            document.getElementById("msg").innerHTML = "";
            return true;
        }

      function abrir_relatorio(tipo)
      {

          if ($('#hidden_id').val()!="")
          {
              var var_day = $("#data_encontro").val();
              var var_year = $("#ano").val();
              var var_month = $("#mes").val();
              var urlGetUser = '{!! url("/controle_atividades/imprimir/' +  $('#hidden_id').val() +  '/data/' + tipo + '/' + var_year + '-' + var_month + '-' + var_day + '") !!}';
              window.location.href =urlGetUser;
          }
          else
          {
              alert('Não há dados para imprimir para a Data informada.');
          }
      }


    $(document).ready(function(){

      $("#ampulheta").bind("ajaxStart", function(){
          $(this).show();
      }).bind("ajaxStop", function(){
          $(this).hide();
      });


     $("#menu_celulas").addClass("treeview active");

      //Remove linha visitantes
      $("#tab_visitantes").on("click", ".remover", function(e){
          $(this).closest('tr').remove();
      });


      //remove file
      $("#tab_arquivos").on("click", ".remover_arquivo", function(e){

          //get ID of the file
          var var_id = $(this).closest('tr').attr('id');
          $(this).closest('tr').remove();

          //url of route to delete file
          var urlGetUser = '{!! url("/controle_atividades/' +  var_id +  '/remover' + '") !!}';

          //call ajax
          $.ajax(
          {
               url: urlGetUser,
               success: function (response) {

                   if (response=="false")
                   {
                       alert("Erro ao remover o arquivo");
                   }

               }
          });

      });



          //Adicionar linha visitante
          $('#addRow').on( 'click', function () {

              $('#tab_visitantes').append('<tr><td class="col-xs-5"><input name="nome_visitante[]" type="text" class="form-control" value=""  /></td><td class="col-xs-3"><input name="fone_visitante[]" type="text" class="form-control" value=""  /></td><td class="col-xs-3"><input name="email_visitante[]" type="text" class="form-control" value=""  /></td><td class="col-xs-1"><button data-toggle="tooltip" data-placement="top" title="Excluir Ítem"  class="btn btn-danger btn-sm remover"><spam class="glyphicon glyphicon-trash"></spam></button></td></tr>')

         });


          //editing data
          if  ($('#hidden_id').val()!="") {

              $("[class='obs']").bootstrapSwitch();
              exibir_divs(true);

              //initialize datatable

               $('#tab_participantes').dataTable({
                          "bDeferRender": true,
                          "deferRender": true,
                          "pagingType": "full_numbers",
                          'iDisplayLength': 25,
                          "bProcessing": true,
                          "processing": true,
                          "ordering": false,
                          "search": false,
                          "paging": false,
                          "aaSorting": [[ 1, "asc" ]],
                          language:
                          {
                              searchPlaceholder: "Pesquisar...",
                              processing:     "Aguarde...Carregando",
                              paginate: {
                                                first:      "Primeira",
                                                previous:   "Anterior",
                                                next:       "Próxima",
                                                last:       "Última"}
                          },

                          "columnDefs":
                          [
                             {"targets": [0], "visible": false},
                             {"targets": [1], "sortable": true},
                             {"targets": [2], "sortable": false},
                             {"targets": [3], "sortable": false}
                          ]
                   });


          } else { //create, nothing to do...
                exibir_divs(false);
          }


          function exibir_divs(bool_opcao)
          {

                  if (bool_opcao==true)
                  {
                        $('#box_mais').show();
                        $('#box_participantes').show();
                        $('#box_visitantes').show();
                        $('#box_questions').show();
                        $('#box_resumo').show();
                  }
                  else
                  {
                        //hide divs
                      //$('#box_mais').hide();
                      //$('#box_participantes').hide();
                      //$('#box_visitantes').hide();
                      //$('#box_questions').hide();
                      //$('#box_resumo').hide();
                 }
          }


          function vai()
          {
               $("[name='presenca']").bootstrapSwitch();
          }

          function apos()
          {
                //alert('Selecione agora a Data do Encontro para marcar as presenças');
                //Buscar informações da Célula
                if ($('#celulas').val()!="") //se foi preenchido o campo
                {

                        var conteudo_celulas = $('#celulas').val().split('|');
                        var strValor = conteudo_celulas[0];
                        var urlGetUser = '{!! url("/celulas/buscar/' +  strValor +  '/' + $('#mes').val()+ '/' + $('#ano').val() + '") !!}';

                        $.ajax(
                        {
                             url: urlGetUser,
                             success: function (response) {

                                 if (response!="")
                                 {
                                     $("#dia_encontro").val(response); //Limpa campo

                                          var var_day = $("#data_encontro").val();
                                          var var_year = $("#ano").val();
                                          var var_month = $("#mes").val();
                                          var var_cell_input = $('#celulas').val().split('|');
                                          var var_cell_id = var_cell_input[0];
                                          var urlGetUser = '{!! url("/celulas/buscar_datas/' +  var_cell_id + '/' + var_month + '/' + var_year + '") !!}';

                                          $.getJSON(urlGetUser, function( data, status )
                                          {

                                              if (status==="success") //if found
                                              {
                                                   html ='<option value=""></option>';

                                                   $.each(data, function(index, element)
                                                   {

                                                      if (element.trim() =="Segundo Dia Encontro") {
                                                         html +='<option value="' + element.substr(0,2) + '" disabled>' + element + '</option>';
                                                      } else {
                                                         html +='<option value="' + element.substr(0,2) + '">' + element + '</option>';
                                                      }

                                                   });

                                                  var $stations = $("#data_encontro"); //Instancia o objeto combo nivel2
                                                  $stations.empty();
                                                  $stations.append(html);
                                                  $("#data_encontro").trigger("change"); //trigger the change event for load fields from database

                                              }

                                          });

                                 }

                                  //$("#data_encontro").trigger("change");
                                  exibir_divs(true);
                                  $("[class='obs']").bootstrapSwitch();

                             }
                        });

                }

          }


        $('.ckFinalizar').checkboxpicker({
                offLabel : 'Não',
                onLabel : 'Sim',
        });


        $('#ckFinalizar').change(function()
        {
              if ($(this).prop('checked'))
              {
                  //$("#data_encontro").trigger("change");
                  exibir_divs(true);
                  $("[class='obs']").bootstrapSwitch();
              }
              else
              {
                  exibir_divs(false);
              }

        });



        $("[class='perguntas']").bootstrapSwitch(); //Habilita check box com SIM E NAO

        //ao celecionar a celula, preenche com os participantes
        $("#celulas").change(function()
        {

             var conteudo_celulas = $(this).val().split('|');
             var id_celula = conteudo_celulas[0];
             var urlRoute = "{!! url('/celulaspessoas/participantes/" + id_celula + "') !!}"; //Rota para consulta

                    $('#tab_participantes').dataTable({
                          "destroy": true,
                          "bDeferRender": true,
                          "deferRender": true,
                          "pagingType": "full_numbers",
                          'iDisplayLength': 25,
                          "bProcessing": true,
                          "processing": true,
                          "ordering": false,
                          "search": false,
                          "paging": false,
                          "aaSorting": [[ 1, "asc" ]],
                          language:
                          {
                              searchPlaceholder: "Pesquisar...",
                              processing:     "Aguarde...Carregando",
                              paginate: {
                                                first:      "Primeira",
                                                previous:   "Anterior",
                                                next:       "Próxima",
                                                last:       "Última"}
                          },
                          "serverSide": true,
                          "ajax": urlRoute,
                          "columnDefs":
                          [
                             {"targets": [0], "visible": false},
                             {"targets": [1], "sortable": true},
                             {"targets": [2], "sortable": false},
                             {"targets": [3], "sortable": false}
                          ],
                          "columns": [
                                  { data: "id" },
                                  { data: "razaosocial" },
                                  {"mRender": function(data, type, full) {

                                            return '<input name="presenca[]" id="presenca[]" type="checkbox" class="obs" data-group-cls="btn-group-sm" value="' + full['id'] + '"  data-off-text="Não" data-on-text="Sim" />';

                                    }},
                                    {"mRender": function(data, type, full) {

                                          var sHtml = '<input  name="id_obs_membro[]" id="id_obs_membro[]" type="hidden" class="form-control obs"  value="' + full['id'] + '" /><input  name="obs_membro[]" id="obs_membro[]" type="text" class="form-control obs"  value="" />';
                                          return sHtml;

                                    }}

                              ],
                   }).after(apos()); //Apos carregar participantes, dispara function


            }); //fim change celulas


    //month change event...reload dates of meeting
    $("#mes").change(function()
    {
         apos();
    });


          //------------- DATA ENCONTRO CHANGE EVENT-----------------------
          //Quando clicar em uma data no combo
          $("#data_encontro").change(function()
          {

               if ($('#ckFinalizar').prop('checked')) //Exibe divs se foi selecionado encerramento
               {
                    $("[class='obs']").bootstrapSwitch();
                    exibir_divs(true);
               }
               else //Esconde divs
               {
                    exibir_divs(false);
               }

                //Search for existent data in database
                var var_day = $("#data_encontro").val();
                var var_data = $("#data_encontro").text();
                var var_cell_input = $('#celulas').val().split('|');
                var var_cell_id = var_cell_input[0];
                var var_year = $("#ano").val();
                var var_month = $("#mes").val();

                //Se for encontro avulso
                if (var_day==" E") {
                   $('#div_data').show();
                } else {

                    var urlGetUser = '{!! url("/controle_atividades/buscar/' +  var_cell_id +  '/' + var_day + '/' + var_month + '/' + var_year + '") !!}';

                    //if selected a date
                    if (var_day!="")
                    {
                        $.getJSON(urlGetUser, function( data, status ) //search by : id, dia encontro, mes, ano
                        {

                            if (data!="") //found
                            {
                                //reopen page with ID found
                                var urlGetUser = '{!! url("/controle_atividades/' +  data[0].id +  '/edit") !!}';
                                window.location=urlGetUser; //redirect to route
                            }

                        });
                    }
                }

          });
          //-------------FIM DATA ENCONTRO CHANGE EVENT-----------------------


    });

</script>



@endsection