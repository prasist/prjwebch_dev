@extends('principal.master')

@section('content')

{{ \Session::put('titulo', 'Login Membros') }}
{{ \Session::put('subtitulo', 'Inclusão') }}
{{ \Session::put('route', 'login_membros') }}

<div class = 'row'>

    <div class="col-md-12">

        <div>
            <a href="{{ url('/login_membros')}}" class="btn btn-default"><i class="fa fa-arrow-circle-left"></i> Voltar</a>
        </div>

        <form method = 'POST' class="form-horizontal" enctype="multipart/form-data"  action = "{{ url('/login_membros/gravar')}}">

        {!! csrf_field() !!}

            <div class="box box-primary">

                 <div class="box-body"> <!--anterior box-body-->

                          <div class="row">
                              <div class="col-xs-12">
                                  <p class="text-info"><b>Serão gerados automaticamente Logins para Membros ATIVOS, que tenham o email cadastrado e que pelo menos um dos campos esteja preenchido (Data Nascimento ou CPF)</b></p>
                              </div>

                          </div>

                          <div class="row{{ $errors->has('grupo') ? ' has-error' : '' }}">
                                  <div class="col-xs-6">
                                        <label for="grupo" class="control-label">Informe a qual grupo de permissões os membros pertencerão</label>

                                        <select name="grupo" class="form-control select2" style="width: 100%;">
                                         <option  value=""></option>
                                        @foreach($dados as $item)
                                              <option  value="{{$item->id}}">{{$item->nome}}</option>
                                        @endforeach
                                        </select>

                                        <!-- se houver erros na validacao do form request -->
                                           @if ($errors->has('grupo'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('grupo') }}</strong>
                                            </span>
                                           @endif

                                  </div>
                          </div>


                         <div class="row">
                                  <div class="col-xs-6">

                                        <label for="quem" class="control-label">Para Quem ?</label>
                                        <select id="quem" name="quem" data-live-search="true" data-none-selected-text="(Selecionar)" class="form-control selectpicker" style="width: 100%;">
                                            <option  value="1">Todos os Membros</option>
                                            <option  value="2">Pessoa Específica</option>
                                        </select>

                                  </div>
                          </div>

                          <div id="div_pessoa" class="row" style="display: none">
                                  <div class="col-xs-6 {{ $errors->has('pessoas') ? ' has-error' : '' }}">
                                            <label for="pessoas" class="control-label"><span class="text-danger">*</span> Pessoa Específica</label>
                                            <div class="input-group">
                                                     <div class="input-group-addon">
                                                        <button  id="buscarpessoa" type="button"  data-toggle="modal" data-target="#modal_lider" >
                                                               <i class="fa fa-search"></i> ...
                                                         </button>
                                                         &nbsp;<a href="#" onclick="remover_pessoa('pessoas');" title="Limpar Campo"><spam class="fa fa-close"></spam></a>
                                                      </div>

                                                      @include('modal_buscar_pessoas', array('qual_campo'=>'pessoas', 'modal' => 'modal_lider'))

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
                                  <div class="col-xs-6">

                                        <label for="gerar" class="control-label">Como gerar a senha ?</label>
                                        <select id="gerar" name="gerar" data-live-search="true" data-none-selected-text="(Selecionar)" class="form-control selectpicker" style="width: 100%;">
                                            <option  value="1">6 Primeiros dígitos CPF (Caso não exista o CPF, será gerado o mês e ano de nascimento Ex: mmaaaa )</option>
                                            <option  value="2">Senha Específica</option>
                                        </select>

                                  </div>
                          </div>

                          <div class="row">
                                <div class="col-xs-6">
                                      <label for="ckenviar" class="control-label">Enviar Email ao Membro Informando seus dados para acesso</label>
                                      <div class="input-group">
                                             <div class="input-group-addon">
                                                  <input  id= "ckenviar" name="ckenviar" data-group-cls="btn-group-sm" type="checkbox" class="ckenviar" />
                                             </div>
                                      </div>
                                </div>
                          </div>


                          <div id="div_senha" class="row" style="display: none">
                                  <div class="col-xs-6">
                                          <label for="password" class="control-label">Senha Específica</label>
                                          <input id="password" maxlength="60" placeholder = "Informar um senha..." name = "password" type="password" class="form-control" value="">
                                  </div>
                          </div>


            </div><!-- fim box-body"-->
        </div><!-- box box-primary -->

        <div class="box-footer">
            <button class = 'btn btn-primary' type ='submit' id='gravar'><i class="fa  fa-unlock-alt"></i> Gerar</button>
            <a href="{{ url('/login_membros')}}" class="btn btn-default">Cancelar</a>
        </div>

       </form>

    </div><!-- <col-md-12 -->

</div><!-- row -->
<script type="text/javascript">

    function remover_pessoa(var_objeto)
    {
        $('#' + var_objeto).val('');
    }

    $(document).ready(function()
    {


        $('.ckenviar').checkboxpicker({
                offLabel : 'Não',
                onLabel : 'Sim',
        });

        $("#quem").change(function()
        {
            if ($(this).val()=="2") //pessoa especifica
            {
                $("#div_pessoa").show();
            } else {
                $("#div_pessoa").hide();
            }

        });

        $("#gerar").change(function()
        {
            if ($(this).val()=="2") //Senha especifica
            {
                $("#div_senha").show();
            } else {
                $("#div_senha").hide();
            }

        });

    });

</script>
@endsection