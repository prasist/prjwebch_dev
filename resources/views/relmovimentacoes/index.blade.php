@extends('principal.master')

@section('content')

{{ \Session::put('titulo', 'Relatório de Movimentações Membros') }}
{{ \Session::put('subtitulo', 'Listagem') }}
{{ \Session::put('route', 'relmovimentacoes') }}
{{ \Session::put('id_pagina', '68') }}

<div class = 'row'>

 <div class="col-md-12">

 <form method = 'POST'  class="form-horizontal" action = "{{ url('/' . \Session::get('route') . '/movimentacoes')}}">

  {!! csrf_field() !!}

    <div class="box box-default">

          <div class="box-body">

            <div class="row">
                <div class="col-md-12">


                          <div class="row">

                                     <div class="col-xs-3">
                                              <label  for="data_movimentacao" class="control-label">Data Movimentação</label>
                                              <div class="input-group">
                                                     <div class="input-group-addon">
                                                      <i class="fa fa-calendar"></i>
                                                      </div>
                                                      <input id ="data_movimentacao" name = "data_movimentacao" onblur="validar_data(this);" type="text" class="form-control" data-inputmask='"mask": "99/99/9999"' data-mask  value="">
                                              </div>

                                     </div>

                                     <div class="col-xs-3">
                                              <label  for="data_movimentacao_ate" class="control-label">Até</label>
                                              <div class="input-group">
                                                     <div class="input-group-addon">
                                                      <i class="fa fa-calendar"></i>
                                                      </div>
                                                      <input id ="data_movimentacao_ate" name = "data_movimentacao_ate" onblur="validar_data(this)" type="text" class="form-control" data-inputmask='"mask": "99/99/9999"' data-mask  value="">
                                              </div>
                                     </div>

                                    <div class="col-xs-4">
                                             <label for="motivos" class="control-label">Motivo </label>
                                              <select id="motivos" placeholder="(Selecionar)" name="motivos" data-live-search="true" data-none-selected-text="(Selecionar)" class="form-control selectpicker" style="width: 100%;">
                                              <option  value=""></option>
                                              @foreach($motivos as $item)
                                                     <option  value="{{$item->id . '|' . $item->nome}}">{{$item->nome}}</option>
                                              @endforeach
                                              </select>
                                    </div><!-- col-xs-5-->

                          </div>

                          <div class="row">

                                <div class="col-xs-6">
                                        <label for="lideres" class="control-label">Célula Anterior</label>
                                        <select id="lideres" placeholder="(Selecionar)" name="lideres" data-live-search="true" data-none-selected-text="Nenhum item selecionado" class="form-control selectpicker" style="width: 100%;">
                                              <option  value="0"></option>
                                                @foreach($lideres as $item)
                                                       <option  value="{{$item->id . '|' . $item->nome}}" >{{$item->nome}}</option>
                                                @endforeach
                                        </select>
                                </div>

                                <div class="col-xs-6">
                                        <label for="vice_lider" class="control-label">Nova Célula</label>
                                        <select id="vice_lider" placeholder="(Selecionar)" name="vice_lider" data-live-search="true" data-none-selected-text="Nenhum item selecionado" class="form-control selectpicker" style="width: 100%;">
                                              <option  value="0"></option>
                                                @foreach($lideres as $item)
                                                       <option  value="{{$item->id . '|' . $item->nome}}" >{{$item->nome}}</option>
                                                @endforeach
                                        </select>
                                </div>


                          </div>


                          <div class="row">

                              <div class="col-xs-6">

                                    <label for="resultado" class="control-label">Formato de Saída : </label>
                                    <select id="resultado" name="resultado" class="form-control selectpicker">
                                    <option  value="pdf" data-icon="fa fa-file-pdf-o" selected>PDF (.pdf)</option>
                                    <option  value="xlsx" data-icon="fa fa-file-excel-o">Planilha Excel (.xls)</option>
                                    <option  value="csv" data-icon="fa fa-file-excel-o">CSV (.csv)</option>
                                    <option  value="docx" data-icon="fa fa-file-word-o">Microsoft Word (.docx)</option>
                                    <option  value="html" data-icon="fa fa-file-word-o">HTML (.html)</option>
                                    <option  value="email" data-icon="fa fa-envelope-o">Listagem de E-mails</option>
                                    </select>


                                     @if ($var_download=="")

                                           @if ($var_mensagem=="Nenhum Registro Encontrado")
                                                  <br/>
                                                  <br/>
                                                   <div class="alert2 alert-info">
                                                      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                                      <h4>
                                                      <i class="icon fa fa-check"></i> {{$var_mensagem}}</h4>
                                                  </div>
                                                  {{$var_mensagem}}
                                            @endif

                                     @else
                                        <br/>
                                        <br/>
                                        <div class="alert2 alert-info">
                                          <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                          <h4><i class="icon fa fa-check"></i> Relatório gerado com Sucesso!</h4>
                                          Clique no link abaixo para baixar o arquivo.
                                        </div>
                                        <a href="{!! url($var_download) !!}" class="text" target="_blank">
                                          CLIQUE AQUI PARA VISUALIZAR / BAIXAR
                                          @if (substr($var_download,-3)=="pdf")
                                            <img src="{{ url('/images/pdf.png') }}" alt="Baixar Arquivo" />
                                          @elseif (substr($var_download,-4)=="xlsx")
                                            <img src="{{ url('/images/excel.png') }}" alt="Baixar Arquivo" />
                                          @elseif (substr($var_download,-3)=="csv")
                                            <img src="{{ url('/images/csv.jpg') }}" alt="Baixar Arquivo" />
                                          @elseif (substr($var_download,-4)=="docx")
                                             <img src="{{ url('/images/microsoft-word-icon.png') }}" alt="Baixar Arquivo" />
                                          @endif
                                        </a>
                                      @endif

                              </div>
                          </div>

            </div><!-- /.row -->

        <div class="overlay modal" style="display: none">
            <i class="fa fa-refresh fa-spin"></i>
        </div>

         </div><!-- fim box-body"-->
     </div><!-- box box-primary -->

        <div class="box-footer">
            <button class = 'btn btn-primary' type ='submit' onclick="myApp.showPleaseWait();">Pesquisar</button>
            <a href="{{ url('/' . \Session::get('route') )}}" class="btn btn-default">Limpar</a>
        </div>

        </form>

    </div>

</div>


<script type="text/javascript">

      var myApp;
      myApp = myApp || (function () {

          return {
              showPleaseWait: function() {
                  $(".overlay").show();
              }
          };
      })();

        /*Prepara checkbox bootstrap*/
       $(function () {

            $("#menu_celulas").addClass("treeview active");

      });


</script>

@include('configuracoes.script_estruturas')
@endsection