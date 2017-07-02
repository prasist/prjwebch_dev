<div class = 'row'>

    <div class="col-md-12">

    <div>
            <a href={{ url('/' . \Session::get('route')) }} class="btn btn-default"><i class="fa fa-arrow-circle-left"></i> Voltar</a>
    </div>

     <form method = 'POST'  class="form-horizontal" action = {{ url('/' . \Session::get('route') . '/gravar')}}>

       {!! csrf_field() !!}

        <div class="box box-primary">

                 <div class="box-body">

                            <div class="row{{ $errors->has('nome') ? ' has-error' : '' }}">
                                    <div class="col-xs-10">
                                          <label for="nome" class="control-label">Descrição</label>

                                          <input id="nome" maxlength="60"  placeholder="Campo Obrigatório" name = "nome" type="text" class="form-control" value="{{ old('nome') }}">

                                             <!-- se houver erros na validacao do form request -->
                                             @if ($errors->has('nome'))
                                              <span class="help-block">
                                                  <strong>{{ $errors->first('nome') }}</strong>
                                              </span>
                                             @endif

                                    </div>
                            </div>


            </div><!-- fim box-body"-->
        </div><!-- box box-primary -->

        <div class="box-footer">
            <button class = 'btn btn-primary' type ='submit'><i class="fa fa-save"></i> Salvar</button>
            <a href="{{ url('/' . \Session::get('route') )}}" class="btn btn-default">Cancelar</a>
        </div>

        <!--  tour rápido-->
        <div id="tour3"></div>
        <div id="tour4"></div>

        </form>


    </div>

</div>

<script type="text/javascript">
    $(document).ready(function() {
        $("#menu_cadastros_base").addClass("treeview active");
    });
</script>
