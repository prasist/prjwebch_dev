@extends('principal.master')

@section('content')

{{ \Session::put('titulo', Session::get('nivel2')) }}
{{ \Session::put('subtitulo', 'Inclusão') }}
{{ \Session::put('route', 'estruturas2') }}
{{ \Session::put('id_pagina', '37') }}

<div class = 'row'>

    <div class="col-md-12">

    <div>
            <a href={{ url('/' . \Session::get('route')) }} class="btn btn-default"><i class="fa fa-arrow-circle-left"></i> Voltar</a>
    </div>

    <form method = 'POST'  class="form-horizontal" action = {{ url('/' . \Session::get('route') . '/gravar')}}>

       {!! csrf_field() !!}

        <div class="box box-primary">

                 <div class="box-body">

                            <div class="row">
                                    <div class="col-xs-5{{ $errors->has('nivel1') ? ' has-error' : '' }}">
                                          <label for="nivel1" class="control-label">{!!Session::get('nivel1') !!}</label>
                                          <select id="nivel1" placeholder="(Selecionar)" name="nivel1" data-live-search="true" data-none-selected-text="Nenhum item selecionado" class="form-control selectpicker" style="width: 100%;">
                                          <option  value=""></option>
                                          @foreach($nivel1 as $item)
                                                 <option  value="{{$item->id}}" >{{$item->nome}}</option>
                                          @endforeach
                                          </select>
                                    </div>

                                    <!-- se houver erros na validacao do form request -->
                                         @if ($errors->has('nivel1'))
                                          <span class="help-block">
                                              <strong>{{ $errors->first('nivel1') }}</strong>
                                          </span>
                                         @endif
                            </div>

                            <div class="row">
                              <div class="box-header with-border">

                                <h5 class="box-title">
                                 {!!Session::get('nivel2')!!}

                               </h5>
                               <p class="text-info">Preencher pelo menos uma das opções (Descrição / Pessoa) ou ambas se preferir.</p>
                             </div>
                           </div>

                            <div class="row">

                                    <div class="col-xs-4 {{ $errors->has('nome') ? ' has-error' : '' }}">
                                          <label for="nome" class="control-label">Descrição</label>
                                          <input id="nome" maxlength="60"  placeholder="Descrição Alternativa" name = "nome" type="text" class="form-control" value="">

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
                                                              <button  id="buscarpessoa" type="button"  data-toggle="modal" data-target="#myModal" >
                                                                     <i class="fa fa-search"></i> ...
                                                               </button>
                                                               &nbsp;<a href="#" onclick="remover_pessoa('pessoas');" title="Limpar Campo"><spam class="fa fa-close"></spam></a>

                                                            </div>

                                                            @include('modal_buscar_pessoas', array('qual_campo'=>'pessoas', 'modal' => 'myModal'))

                                                            <input id="pessoas"  name = "pessoas" type="text" class="form-control" placeholder="Clica na lupa ao lado para consultar uma pessoa" value="" readonly >

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
            <button class = 'btn btn-primary' type ='submit'><i class="fa fa-save"></i> Salvar</button>
            <a href="{{ url('/' . \Session::get('route') )}}" class="btn btn-default">Cancelar</a>
        </div>

        </form>

    </div>

</div>
<script type="text/javascript">

   function remover_pessoa(var_objeto)
   {
       $('#' + var_objeto).val('');
   }

   $(document).ready(function() {
       $("#menu_celulas").addClass("treeview active");
   });

</script>
@endsection