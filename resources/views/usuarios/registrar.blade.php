@extends('principal.master')

@section('content')

{{ \Session::put('titulo', 'Usuários') }}
{{ \Session::put('subtitulo', 'Inclusão') }}
{{ \Session::put('route', 'usuarios') }}

<div class = 'row'>

    <div class="col-md-12">

        <div>
            <a href="{{ url('/usuarios')}}" class="btn btn-default"><i class="fa fa-arrow-circle-left"></i> Voltar</a>
        </div>

        <form method = 'POST' class="form-horizontal" enctype="multipart/form-data"  action = {{ url('/usuarios/gravar')}}>

        {!! csrf_field() !!}

            <div class="box box-primary">

                 <div class="box-body"> <!--anterior box-body-->

                            <div class="row{{ $errors->has('empresa') ? ' has-error' : '' }}">
                                    <div class="col-xs-10">
                                          <label for="empresa" class="control-label"><span class="text-danger">*</span> Igreja / Instituição</label>

                                          <select id="empresa" name="empresa" class="form-control select2" style="width: 100%;">
                                          <option  selected="selected" value="">(Selecione uma Igreja/Instituição</option>

                                          @foreach($empresas as $item)
                                                <option  value="{{$item->id}}">{{$item->razaosocial}}</option>
                                          @endforeach
                                          </select>

                                          <!-- se houver erros na validacao do form request -->
                                             @if ($errors->has('empresa'))
                                              <span class="help-block">
                                                  <strong>{{ $errors->first('empresa') }}</strong>
                                              </span>
                                             @endif

                                    </div>
                            </div>

                            <!-- Usado para exibir mensagem de validação-->
                            <div class="row">
                                  <div class="col-xs-11">
                                          <p>&nbsp;</p>
                                          <div id="mensagem"></div>
                                          <p></p>
                                   </div>
                            </div>

                            <div id="ocultar_grupo">

                                  <div class="row{{ $errors->has('grupo') ? ' has-error' : '' }}">
                                          <div class="col-xs-10">
                                                <label for="grupo" class="control-label"><span class="text-danger">*</span> Grupo</label>

                                                <select name="grupo" class="form-control select2" style="width: 100%;">

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
                           </div>

                           <div id="tour8"></div>

                           <input  id="sera_admin" name="sera_admin" type="hidden"  value="0" />

                           <div id="ocultar_check">
                                <!--Somente usuário MASTER poderá criar usuários ADMIN-->
                                @if ($dados_login->master==1)
                                <div class="row">
                                          <div class="col-xs-5">
                                                <label for="admin" class="control-label">É Administrador ?</label>

                                                <input  id="chkAdmin" name="admin" type="checkbox" class="checkbox" value="1" disabled />

                                          </div>
                                </div>
                                @endif
                          </div>

                            <div class="row{{ $errors->has('name') ? ' has-error' : '' }}">
                                    <div class="col-xs-10">
                                          <label for="name" class="control-label"><span class="text-danger">*</span> Nome</label>

                                          <input id="name" maxlength="50"  placeholder = "Campo Obrigatório" name = "name" type="text" class="form-control" value="{{ old('name') }}">

                                             <!-- se houver erros na validacao do form request -->
                                             @if ($errors->has('name'))
                                              <span class="help-block">
                                                  <strong>{{ $errors->first('name') }}</strong>
                                              </span>
                                             @endif

                                    </div>
                            </div>

                            <div class="row{{ $errors->has('email') ? ' has-error' : '' }}">
                                    <div class="col-xs-10">
                                          <label for="email" class="control-label"><span class="text-danger">*</span> Email</label>

                                          <input id="email" maxlength="255"  placeholder = "Campo Obrigatório" name = "email" type="text" class="form-control" value="{{ old('email') }}">

                                             <!-- se houver erros na validacao do form request -->
                                             @if ($errors->has('email'))
                                              <span class="help-block">
                                                  <strong>{{ $errors->first('email') }}</strong>
                                              </span>
                                             @endif

                                    </div>
                            </div>

                            <div class="row">
                                    <div class="col-xs-5 {{ $errors->has('password') ? ' has-error' : '' }}">
                                          <label for="password" class="control-label"><span class="text-danger">*</span> Senha</label>

                                          <input id="password" maxlength="60" placeholder = "Campo Obrigatório" name = "password" type="password" class="form-control" value="">

                                             <!-- se houver erros na validacao do form request -->
                                             @if ($errors->has('password'))
                                              <span class="help-block">
                                                  <strong>{{ $errors->first('password') }}</strong>
                                              </span>
                                             @endif

                                    </div>

                                    <div class="col-xs-5 {{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                                          <label for="password_confirmation" class="control-label"><span class="text-danger">*</span> Confirmação Senha</label>

                                          <input id="password_confirmation" placeholder = "Campo Obrigatório" maxlength="60"  name = "password_confirmation" type="password" class="form-control" value="">

                                             <!-- se houver erros na validacao do form request -->
                                             @if ($errors->has('password_confirmation'))
                                              <span class="help-block">
                                                  <strong>{{ $errors->first('password_confirmation') }}</strong>
                                              </span>
                                             @endif

                                    </div>

                            </div>


                                          <br/>
                          <div class="nav-tabs-custom">

                            <ul class="nav nav-tabs">
                              <li class="active"><a href="#tab_1" data-toggle="tab"><b><i class="fa fa-file-image-o"></i>&nbsp;Você pode enviar uma foto...</b></a></li>
                              <li><a href="#tab_2" data-toggle="tab"><b><i class="fa fa-camera"></i>&nbsp;...ou tirar uma agora pela WebCam</b></a></li>
                            </ul>

                            <div class="tab-content">
                                      <!-- TABS-->
                                      <input id="mydata" type="hidden" name="mydata" value=""/>
                                      <div class="tab-pane active" id="tab_1">

                                                <div class="row">
                                                        <div class="col-xs-5">
                                                                <label for="caminhologo" class="control-label">Foto</label>
                                                                <input type="file" id="caminhologo" name = "caminhologo"  onchange="checkPhoto(this)">
                                                                <label id="msg" class="text-danger"></label>
                                                        </div>

                                                </div>


                                      </div><!-- /.tab-pane -->

                                      <div class="tab-pane" id="tab_2">


                                                    <div class="row">
                                                                   <div class="col-md-12">
                                                                          <div class="box box-default">

                                                                                <!--
                                                                                <div class="box-header">
                                                                                        <h3 class="box-title">Tirar foto pela WebCam</h3>
                                                                                </div>
                                                                                -->

                                                                                <p class="text-warning">Importante! A WebCam apresenta problemas de funcionamento no Google Chrome. Sugerimos utilizar o navegador Firefox.</p>

                                                                                <div class="box-body"><!-- box-body-->
                                                                                      <div class="row"><!-- row entrada-->

                                                                                              <div class="col-xs-4">
                                                                                                    <center>
                                                                                                    <label class="control-label"></label>
                                                                                                    <center><a href="javascript:void(ativar_webcam())" class="btn btn-primary"><i class="fa fa-power-off"></i> Iniciar WebCam</a></center>
                                                                                                    <div id="my_camera" style="width:320px; height:240px; border:dotted;"></div>
                                                                                                    <a href="javascript:void(take_snapshot())" class="btn btn-success"><i class="fa fa-camera"></i> Tirar Foto</a></center>
                                                                                              </div>

                                                                                              <div class="col-xs-4">
                                                                                                      <label class="control-label"></label>
                                                                                                      <center>
                                                                                                          <label class="control-label">Foto WebCam</label>
                                                                                                          <div id="my_result" class="row" style="width:320px; height:240px; border:dotted;"></div>
                                                                                                      </center>
                                                                                              </div>

                                                                                    </div>

                                                                             </div> <!-- fim body-->
                                                                     </div>
                                                                </div>
                                                             </div>

                                      </div>
                                      <!--  END TABS-->

                           </div> <!-- TAB CONTENTS -->

                        </div> <!-- nav-tabs-custom -->



            </div><!-- fim box-body"-->
        </div><!-- box box-primary -->

        <div class="box-footer">
            <button class = 'btn btn-primary' type ='submit' id='gravar'>Gravar</button>
            <a href="{{ url('/usuarios')}}" class="btn btn-default">Cancelar</a>
            <br/><span class="text-danger">*</span><i>Campos Obrigatórios</i>
        </div>

       </form>

    </div><!-- <col-md-12 -->

</div><!-- row -->
@endsection

@section('tela_usuarios')

<script type="text/javascript">

                  $(function () {

                            $("#menu_seguranca").addClass("treeview active");
                            //TELA USUARIOS
                            //----Quando abrir a pagina
                            $("#ocultar_check").hide();     //Por padrao ocultar a DIV do check ADMIN
                            //-----------------------------------------------------


                            //------ Quando selecionar uma igreja/instituicao
                            //  Se for diferente da sede, verifica se já existe ou não o ADMIN para aquela igreja...
                                    $('#empresa').change(function () {

                                        var empresa_id = $(this).val();

                                        $.get('./../validar/' + empresa_id + '/user',  function (data)
                                        {

                                            $("#sera_admin").attr('value','0');

                                            if (data==0) //Não existe ADMIN ainda...
                                            {
                                                $('#mensagem').html('<span class="alert alert-warning alert-dismissible">Este será o primeiro usuário para a Igreja/Instituição selecionada. Por padrão será cadastrado como Administrador.</span>');
                                                $("#ocultar_grupo").hide();
                                                $("#ocultar_check").show();
                                                $("#chkAdmin").attr('checked','checked');
                                                $("#sera_admin").attr('value','1');
                                            }
                                            else if (data==1) //Já existe ADMIN, nao deixa criar mais usuarios
                                            {
                                                $('#mensagem').html('<span class="alert alert-warning alert-dismissible">Já existe usuário Administrador cadastrado para essa Igreja/Instituição. Somente o Administrador poderá cadastrar novos usuários.</span>');
                                                $("#ocultar_grupo").hide();
                                                $("#ocultar_check").hide();
                                                $("#gravar").hide();
                                            }
                                            else if (data==2) //Igreja Sede, pode criar usuarios a vontade, porem esconde a check de ADMIN
                                            {
                                                $('#mensagem').html('<span class="mensagem"></span>');
                                                $("#ocultar_check").hide();
                                                $("#chkAdmin").attr('checked','unchecked');
                                            }

                                        });

                                    });

                                            });

   </script>

@endsection
@include('pessoas.script_pessoas')