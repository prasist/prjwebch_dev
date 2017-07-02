@extends('principal.master')

@section('content')

{{ \Session::put('titulo', 'Movimentação de Membros') }}
{{ \Session::put('subtitulo', 'Inclusão') }}
{{ \Session::put('route', 'membersmove') }}
{{ \Session::put('id_pagina', '67') }}

<div class = 'row'>

<div class="col-md-12">
          <a href="{{ url('/' . \Session::get('route')) }}" class="btn btn-default"><i class="fa fa-arrow-circle-left"></i> Voltar</a>
</div>


<form method = 'POST' class="form-horizontal" enctype="multipart/form-data" action ="{{ url('/' . \Session::get('route') . '/gravar')}}">
{!! csrf_field() !!}

  <!-- Main content -->
  <section class="content">
      <div class="row">
        <!-- left column -->

        <div class="col-md-12">

              <!-- INICIO CONTEUDO -->

                <!-- Horizontal Form -->
                <div class="box box-info">
                  <!-- /.box-header -->
                  <!-- form start -->
                  <div class="form-horizontal">
                    <div class="box-body">

                        <div class="row">
                                 <div class="col-xs-3">
                                      <label for="data_mov" class="control-label"><span class="text-danger">*</span> Data Movimentação</label>
                                      <div class="input-group">
                                              <div class="input-group-addon">
                                                  <i class="fa fa-calendar"></i>
                                              </div>

                                              <input id ="data_mov" name = "data_mov" onblur="validar_data(this);" type="text" class="form-control" data-inputmask='"mask": "99/99/9999"' data-mask  value="{{old('data_mov')}}">

                                      </div>
                                 </div>

                                 <div class="col-xs-9 {{ $errors->has('tipos_mov') ? ' has-error' : '' }}">
                                          <span class="text-danger">*</span>
                                          @include('carregar_combos', array('dados'=>$motivos, 'titulo' =>'Motivos', 'id_combo'=>'tipos_mov', 'complemento'=>'', 'comparar'=>'', 'id_pagina'=> '18'))
                                          @include('modal_cadastro_basico', array('qual_campo'=>'tipos_mov', 'modal' => 'modal_tipos_mov', 'tabela' => 'tipos_movimentacao'))

                                         <!-- se houver erros na validacao do form request -->
                                          @if ($errors->has('tipos_mov'))
                                          <span class="help-block">
                                              <strong>{{ $errors->first('tipos_mov') }}</strong>
                                          </span>
                                          @endif
                                 </div>

                       </div>

                       <div class="row">
                                 <div class="col-xs-12">
                                        <label for="obs" class="control-label">Observação</label>
                                        <input id="obs"  placeholder="(Opcional)" name = "obs" type="text" class="form-control" value="{{old('obs')}}">
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



       <div class="col-md-12" id="box_participantes">

          <div class="box box-default">

                <div class="box-body">


                          <div class="row">
                            <div class="col-xs-5 {{ $errors->has('celulas') ? ' has-error' : '' }}">

                                    <label for="celulas" class="control-label"><span class="text-danger">*</span> {!! \Session::get('label_celulas_singular') !!} Atual</label>
                                    <select id="celulas" placeholder="(Selecionar)" name="celulas" data-live-search="true" data-none-selected-text="Nenhum item selecionado" class="form-control" style="width: 100%;">
                                    <option  value="0"></option>
                                    @foreach($celulas as $item)
                                            <option  value="{{$item->id . '|' . $item->nome}}">{{$item->nome}}</option>
                                    @endforeach
                                    </select>

                                    <!-- se houver erros na validacao do form request -->
                                    @if ($errors->has('celulas'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('celulas') }}</strong>
                                    </span>
                                    @endif

                            </div>

                           <div class="col-xs-1">

                           </div>

                           <div class="col-xs-5 {{ $errors->has('celulas_nova') ? ' has-error' : '' }}">

                                    <label for="celulas_nova" class="control-label"><span class="text-danger">*</span> Transferirar para {!! \Session::get('label_celulas_singular') !!}</label>
                                    <select id="celulas_nova" placeholder="(Selecionar)" name="celulas_nova" data-live-search="true" data-none-selected-text="Nenhum item selecionado" class="form-control" style="width: 100%;">
                                    <option  value="0"></option>
                                    @foreach($celulas as $item)
                                             <option  value="{{$item->id . '|' . $item->nome}}" {{ (old('celulas_nova')== $item->id ? 'selected' : '') }}>{{$item->nome}}</option>
                                    @endforeach
                                    </select>

                                    <!-- se houver erros na validacao do form request -->
                                    @if ($errors->has('celulas_nova'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('celulas_nova') }}</strong>
                                    </span>
                                    @endif

                           </div>

                      </div>

                        <form name="selection" method="post" onSubmit="return selectAll()">

                              <div class="row">

                                   <div class="col-xs-5">
                                            <select multiple size="10" id="from" class="form-control"></select>
                                   </div>

                                   <div class="col-xs-1">
                                          <div class="btn-group-vertical">
                                              <a href="javascript:moveAll('from', 'to')" class="btn btn-default xs"><i class="fa  fa-angle-double-right"></i></a>
                                              <a href="javascript:moveSelected('from', 'to')" class="btn btn-default xs"><i class="fa  fa-angle-right"></i></a>
                                              <a href="javascript:moveSelected('to', 'from')" class="btn btn-default xs"><i class="fa  fa-angle-left"></i></a>
                                              <a href="javascript:moveAll('to', 'from')" href="#" class="btn btn-default xs"><i class="fa  fa-angle-double-left"></i></a>
                                            </div>
                                   </div>

                                   <div class="col-xs-5">
                                          <select multiple id="to" size="10" name="topics[]" class="form-control"></select>
                                   </div>

                              </div>

                        </form>

                  </div><!-- fim box-body"-->
              </div><!-- box box-primary -->

       </div>

      </div><!-- /.row -->


      <div class="box-footer">
            <button class = 'btn btn-primary' type ='submit' {{ ($preview=='true' ? 'disabled=disabled' : "" ) }}><i class="fa fa-save"></i> Salvar</button>
            <a href="{{ url('/' . \Session::get('route') )}}" class="btn btn-default">Cancelar</a>
            <br/><span class="text-danger">*</span><i>Campos Obrigatórios</i>
      </div>

    </section>

 </form>

</div>


<script type="text/javascript">

    function moveAll(from, to)
    {

        if ($('#celulas_nova').val()==0)
        {
                alert("Informe e Célula Destino");
                return;
        }

        $('#'+from+' option').remove().appendTo('#'+to);
    }

    function moveSelected(from, to)
    {
        if ($('#celulas_nova').val()==0)
        {
                alert("Informe e Célula Destino");
                return;
        }

        $('#'+from+' option:selected').remove().appendTo('#'+to);
    }

    function selectAll()
    {
        $("select option").attr("selected","selected");
    }

    $(document).ready(function()
    {

      $("#ampulheta").bind("ajaxStart", function(){
          $(this).show();
      }).bind("ajaxStop", function(){
          $(this).hide();
      });

     $("#menu_celulas").addClass("treeview active");

         //editing data
        if  ($('#hidden_id').val()!="")
        {
            $("[class='obs']").bootstrapSwitch();
        }

        //CARREGAR PARTICIPANTES CONFORME CELULA SELECIONADA
        $("#celulas").change(function()
        {

             var conteudo_celulas = $(this).val().split('|');
             var id_celula = conteudo_celulas[0];
             var urlRoute = "{!! url('/celulaspessoas/listar_participantes/" + id_celula + "') !!}"; //Rota para consulta

            $.getJSON(urlRoute, function(data)
            {

                var $stations = $("#from"); //Instancia o objeto combo nivel3
                $stations.empty();

                var html='';

                $.each(data, function(index)
                {
                    html += '<option value="' + data[index].id +'">' + data[index].razaosocial + '</option>';
                });

                html +='<option value=""></option>';

                $stations.append(html);

            });

        });

    });


</script>


@endsection