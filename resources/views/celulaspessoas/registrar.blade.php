@extends('principal.master')

@section('content')

{{ \Session::put('titulo', 'Células / Participantes') }}
{{ \Session::put('subtitulo', 'Inclusão') }}
{{ \Session::put('route', 'celulaspessoas') }}
{{ \Session::put('id_pagina', '45') }}

<div class = 'row'>

    <div class="col-md-12">

    <div>
            <a href="{{ url('/' . \Session::get('route')) }}" class="btn btn-default"><i class="fa fa-arrow-circle-left"></i> Voltar</a>
    </div>

    <form method = 'POST'  class="form-horizontal" action = "{{ url('/' . \Session::get('route') . '/gravar')}}">

    {!! csrf_field() !!}

    <div class="box box-default">

          <div class="box-body">

                  <div class="row">

                        <div class="col-xs-11 {{ $errors->has('celulas') ? ' has-error' : '' }}">
                                <label for="celulas" class="control-label">Célula</label>
                                <select id="celulas" placeholder="(Selecionar)" name="celulas" data-live-search="true" data-none-selected-text="Nenhum item selecionado" class="form-control selectpicker" style="width: 100%;" >
                                <option  value=""></option>
                                @foreach($celulas as $item)
                                         <option  value="{{$item->id}}" {{ ($id_celula==$item->id ? "selected" : "") }}>{{$item->nome}}</option>
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

                        <div class="col-xs-11 {{ $errors->has('pessoas') ? ' has-error' : '' }}">
                                <label for="pessoas" class="control-label">Localizar Participante :</label>
                                <div class="input-group">
                                         <div class="input-group-addon">
                                            <button  id="buscarpessoa2" type="button"  data-toggle="modal" data-target="#modal_pessoas" >
                                                   <i class="fa fa-search"></i> ...
                                             </button>
                                         </div>

                                          @include('modal_buscar_pessoas', array('qual_campo'=>'pessoas', 'modal' => 'modal_pessoas'))

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

                  <div class="row">
                     <div class="col-xs-11">
                     <br/>
                        <button onclick="AddTableRow()" type="button" class="btn btn-info"><i class="fa fa-user-plus"></i> Incluir Participante na Célula</button>
                        <br/>
                        <br/>
                        <table id="example" class="table table-bordered table-hover">
                            <tbody>
                             <tr>
                               <!--<th>Célula</th>-->
                               <th>Pessoa</th>
                               <th>Remover</th>
                             </tr>
                             <tr>
                               <!--<td>&nbsp;</td>-->
                               <td>&nbsp;</td>
                               <td>&nbsp;</td>
                             </tr>
                            </tbody>

                        </table>
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

@include('celulaspessoas.script_table')


<script type="text/javascript">
$(function ()
    {

        $("#menu_celulas").addClass("treeview active");


          //Verifica se cpf é único no banco de dados
          $("#celulas").change(function()
          {

              if ($(this).val()!="") //se foi preenchido o campo
              {

                      var strValor = $(this).val(); //Pega conteudo campo cpf
                      var urlGetUser = '{!! url("/funcoes/verificarcelulas/' +  strValor +  '") !!}'; //Route funcoes = FuncoesController@index passando cpf como parametro

                      $.ajax(
                      {
                          url: urlGetUser,
                           success: function (response) { //Encontrando a rota e a funcao retornando dados, exibe alerta

                               if (response!="") //Só exibe mensagem se encontrar CPF para outra pessoa
                               {

                                  /*Só exibir mensagem se realmente estiver sendo cadastrado uma nova pessoa*/
                                  if ($("#celulas").val()==response)
                                  {
                                      alert('Célula já cadastrada. Favor utilizar a função Alteração para incluir ou remover participantes.');
                                      $("#celulas").val("").change(); //Desmarca a opção selecionada
                                  }

                               }

                           }
                      });
              }

         });



     });
</script>

@endsection