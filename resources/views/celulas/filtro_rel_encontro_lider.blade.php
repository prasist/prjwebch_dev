       <div class = 'row'>

                                   <div class="col-md-12">

                                    <form method = 'POST'  class="form-horizontal" action = "{{ url('/relcelulas/pesquisar/encontro')}}">

                                    {!! csrf_field() !!}

                                     <input  id= "ckExibir" name="ckExibir" type="hidden" value="on" checked />
                                     <input id="tiporel" type="hidden" name="tiporel" value="0">

                                      <div class="box box-default">


                                                  <div class="row">
                                                            <div class="col-xs-6">
                                                                    <label for="lideres" class="control-label">Líder</label>
                                                                    <select id="lideres" placeholder="(Selecionar)" name="lideres" data-live-search="true" data-none-selected-text="Nenhum item selecionado" class="form-control selectpicker" style="width: 100%;">
                                                                            @foreach($lideres as $item)
                                                                                   <option  value="{{$item->id . '|' . $item->nome}}" >{{$item->nome}}</option>
                                                                            @endforeach
                                                                    </select>
                                                            </div>
                                                   </div>

                                                          <div class="row">

                                                                    <div class="col-xs-3">
                                                                         <label for="mes" class="control-label">Mês</label>
                                                                         <select id="mes" placeholder="(Selecionar)" name="mes" data-none-selected-text="Nenhum item selecionado" class="form-control" style="width: 100%;">
                                                                         <option  value=""></option>
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
                                                                          </select>
                                                                    </div>

                                                                    <div class="col-xs-3">
                                                                          <label for="ano" class="control-label">Ano</label>
                                                                          <input id="ano"  name = "ano" type="text" class="form-control" value="{{date('Y')}}">
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

                                          <div class="overlay modal" style="display: none">
                                              <i class="fa fa-refresh fa-spin"></i>
                                          </div>


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

            $('.ckEstruturas').checkboxpicker({
                offLabel : 'Não',
                onLabel : 'Sim',
            });

            $('.ckExibir').checkboxpicker({
                offLabel : 'Não',
                onLabel : 'Sim',
            });

      });


</script>

