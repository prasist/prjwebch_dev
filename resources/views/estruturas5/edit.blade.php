@extends('principal.master')

@section('content')

{{ \Session::put('titulo', Session::get('nivel5')) }}
{{ \Session::put('subtitulo', 'Alteração/Visualização') }}
{{ \Session::put('route', 'estruturas5') }}
{{ \Session::put('id_pagina', '40') }}

<div class = 'row'>

    <div class="col-md-12">

    <div>
            <a href={{ url('/' . \Session::get('route')) }} class="btn btn-default"><i class="fa fa-arrow-circle-left"></i> Voltar</a>
    </div>

    <form method = 'POST' class="form-horizontal"  action = {{ url('/' . \Session::get('route') . '/' . $dados[0]->id . '/update')}}>

       {!! csrf_field() !!}

        <div class="box box-primary">

                 <div class="box-body">


                        <div class="row">

                                <div class="col-xs-4{{ $errors->has('nivel4') ? ' has-error' : '' }}">
                                        <label for="nivel4" class="control-label">{!!Session::get('nivel4') !!}</label>
                                        <select id="nivel4" placeholder="(Selecionar)" name="nivel4" data-live-search="true" data-none-selected-text="Nenhum item selecionado" class="form-control selectpicker" style="width: 100%;">
                                        <option  value=""></option>
                                        @foreach($nivel4 as $item)
                                               <option  value="{{$item->id}}" {{ ($dados[0]->celulas_nivel4_id == $item->id ? 'selected' : '') }}>{{$item->nome}}</option>
                                        @endforeach
                                        </select>
                                </div><!-- col-xs-5-->

                                <div class="col-xs-4{{ $errors->has('nivel3') ? ' has-error' : '' }}">
                                      <label for="nivel3" class="control-label">{{Session::get('nivel3')}}</label>
                                      <select id="nivel3" placeholder="(Selecionar)" name="nivel3" data-live-search="true" data-none-selected-text="Nenhum item selecionado" class="form-control" style="width: 100%;">
                                      <option  value=""></option>
                                      </select>
                                </div><!-- col-xs-5-->

                                <!-- se houver erros na validacao do form request -->
                                 @if ($errors->has('nivel3'))
                                  <span class="help-block">
                                      <strong>{{ $errors->first('nivel3') }}</strong>
                                  </span>
                                 @endif

                                 <!-- se houver erros na validacao do form request -->
                                 @if ($errors->has('nivel4'))
                                  <span class="help-block">
                                      <strong>{{ $errors->first('nivel4') }}</strong>
                                  </span>
                                 @endif

                        </div>

                        <div class="row">

                                <div class="col-xs-4{{ $errors->has('nivel2') ? ' has-error' : '' }}">
                                       <label for="nivel2" class="control-label">{{Session::get('nivel2')}}</label>
                                      <select id="nivel2" placeholder="(Selecionar)" name="nivel2" data-live-search="true" data-none-selected-text="Nenhum item selecionado" class="form-control" style="width: 100%;">
                                      <option  value=""></option>
                                      </select>
                                </div><!-- col-xs-5-->

                                <div class="col-xs-4{{ $errors->has('nivel1') ? ' has-error' : '' }}">
                                      <label for="nivel1" class="control-label">{{Session::get('nivel1')}}</label>
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


                                     <!-- se houver erros na validacao do form request -->
                                     @if ($errors->has('nivel2'))
                                      <span class="help-block">
                                          <strong>{{ $errors->first('nivel2') }}</strong>
                                      </span>
                                     @endif

                            </div>

                            <div class="row">
                              <div class="box-header with-border">

                                <h5 class="box-title">
                                 {!!Session::get('nivel5')!!}

                               </h5>
                               <p class="text-info">Preencher pelo menos uma das opções (Descrição / Pessoa) ou ambas se preferir.</p>
                             </div>
                           </div>

                            <div class="row">

                                    <div class="col-xs-4 {{ $errors->has('nome') ? ' has-error' : '' }}">
                                          <label for="nome" class="control-label">Descrição</label>
                                          <input id="nome" maxlength="60"  placeholder="Descrição Alternativa" name = "nome" type="text" class="form-control" value="{!! $dados[0]->descricao !!}">

                                          <!-- se houver erros na validacao do form request -->
                                         @if ($errors->has('nome'))
                                          <span class="help-block">
                                              <strong>{{ $errors->first('nome') }}</strong>
                                          </span>
                                         @endif

                                    </div>

                                    <div class="col-xs-6 {{ $errors->has('pessoas') ? ' has-error' : '' }}">
                                                  <label for="nome" class="control-label">Pessoa</label>
                                                  <div class="input-group">
                                                           <div class="input-group-addon">
                                                              <button  id="buscarpessoa" type="button"  data-toggle="modal" data-target="#myModal" title="Pesquisar Pessoas..." >
                                                                     <i class="fa fa-search"></i> ...
                                                               </button>
                                                               &nbsp;<a href="#" onclick="remover_pessoa('pessoas');" title="Limpar Campo"><spam class="fa fa-close"></spam></a>
                                                            </div>

                                                            @include('modal_buscar_pessoas', array('qual_campo'=>'pessoas', 'modal' => 'myModal'))

                                                            <input id="pessoas"  name = "pessoas" type="text" class="form-control" placeholder="Clica na lupa ao lado para consultar uma pessoa" value="{!! ($dados[0]->pessoas_id!="" ? str_repeat('0', (9-strlen($dados[0]->pessoas_id))) . $dados[0]->pessoas_id . ' - ' . $dados[0]->razaosocial  : '') !!}" readonly >

                                                            <!-- se houver erros na validacao do form request -->
                                                             @if ($errors->has('pessoas'))
                                                              <span class="help-block">
                                                                  <strong>{{ $errors->first('pessoas') }}</strong>
                                                              </span>
                                                             @endif

                                                    </div>
                                   </div>

                            </div>




            </div><!-- fim box-body"-->
        </div><!-- box box-primary -->

        <div class="box-footer">
            <button class = 'btn btn-primary' type ='submit' {{ ($preview=='true' ? 'disabled=disabled' : "" ) }}><i class="fa fa-save"></i> Salvar</button>
            <a href="{{ url('/' . \Session::get('route') )}}" class="btn btn-default">Cancelar</a>
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
            if ($("#nivel4").val()!="")
            {
                  $("#nivel4").trigger("change");
            }

    });
</script>
@endsection