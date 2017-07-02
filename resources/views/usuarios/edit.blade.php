@extends('principal.master')

@section('content')

{{ \Session::put('titulo', 'Usuários') }}
{{ \Session::put('subtitulo', 'Alteração / Visualização') }}
{{ \Session::put('route', 'usuarios') }}


<div class = 'row'>

    <div class="col-md-12">

        <div>
            <a href="{{ url('/usuarios')}}" class="btn btn-default"><i class="fa fa-arrow-circle-left"></i> Voltar</a>
        </div>

        <form method = 'POST' class="form-horizontal" enctype="multipart/form-data" action ="{{ url('/usuarios/' . $dados->id . '/update')}}">

        {!! csrf_field() !!}

            <div class="box box-primary">

                 <div class="box-body"> <!--anterior box-body-->

                             <div class="row{{ $errors->has('empresa') ? ' has-error' : '' }}">
                                    <div class="col-xs-10">

                                         <!-- Campo hidden para preservar valor da empresa gravado, pois o combo desabilitado nao envia valor para o POST quando disabled-->
                                          <input  name="empresa" type="hidden"  value="{{ $grupo_do_usuario[0]->usuarios_empresas_id }}" />

                                          <label for="empresa" class="control-label"><span class="text-danger">*</span> Igreja / Instituição</label>

                                          <select name="empresa" class="form-control select2" style="width: 100%;" disabled>

                                          @foreach($empresas as $item)
                                                <option  {{ ($item->id == $grupo_do_usuario[0]->usuarios_empresas_id ? 'selected' : '')  }} value="{{$item->id}}">{{$item->razaosocial}}</option>
                                          @endforeach
                                          </select>
                                    </div>
                            </div>

                           <div class="row{{ $errors->has('grupo') ? ' has-error' : '' }}">
                                    <div class="col-xs-10">
                                          <label for="grupo" class="control-label"><span class="text-danger">*</span> Grupo</label>
                                          <!-- Campo hidden para preservar valor do grupo gravado, pois o combo desabilitado nao envia valor para o POST quando disabled-->
                                          <input  name="grupo" type="hidden"  value="{{ $grupo_do_usuario[0]->grupos_id }}" />

                                          <select name="grupo" class="form-control select2" style="width: 100%;" {{ ($dados_login->empresas_id != $grupo_do_usuario[0]->usuarios_empresas_id ? 'disabled' : '') }}>

                                          @foreach($grupos as $item)
                                                <option  {{ ($item->id == $grupo_do_usuario[0]->grupos_id ? 'selected' : '')  }} value="{{$item->id}}">{{$item->nome}}</option>
                                          @endforeach
                                          </select>
                                    </div>
                           </div>

                          <!--Somente usuário MASTER poderá criar usuários ADMIN-->
                          <input  id="sera_admin" name="sera_admin" type="hidden"  value="0" />

                           <div id="ocultar_check">
                           @if ($dados_login->master==1)
                           <div class="row">
                                    <div class="col-xs-10">
                                          <label for="admin" class="control-label">É Administrador ?</label>

                                          <input  name="admin" type="checkbox" class="acessar"  value="1" {{ ($grupo_do_usuario[0]->admin==1 ? 'checked' : '') }} disabled />

                                    </div>
                            </div>
                            @endif
                            </div>

                            <div class="row{{ $errors->has('name') ? ' has-error' : '' }}">
                                    <div class="col-xs-10">
                                          <label for="name" class="control-label"><span class="text-danger">*</span> Nome</label>

                                          <input id="name" maxlength="50"  name = "name" type="text" class="form-control" value="{{ $dados->name }}">

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

                                          <input id="email" maxlength="255"  name = "email" type="text" class="form-control" value="{{ $dados->email }}">

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

                                          <input id="password" maxlength="60"  name = "password" type="password" class="form-control" value="">

                                             <!-- se houver erros na validacao do form request -->
                                             @if ($errors->has('password'))
                                              <span class="help-block">
                                                  <strong>{{ $errors->first('password') }}</strong>
                                              </span>
                                             @endif

                                    </div>

                                    <div class="col-xs-5{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                                          <label for="password_confirmation" class="control-label"><span class="text-danger">*</span> Confirmação Senha</label>

                                          <input id="password_confirmation" maxlength="60"  name = "password_confirmation" type="password" class="form-control" value="">

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

                                                          @if ($dados->path_foto!="")
                                                              <p></p>
                                                              <div class="col-xs-4">
                                                                    <img src="{{ url('/images/users/' . $dados->path_foto) }}" width="160px" height="160px">
                                                                    <div class="col-xs-4">
                                                                          <a href="{{ url('/profile/' . $dados->id . '/remover')}}"><i class="fa fa-trash"></i>&nbsp;Remover</a>
                                                                    </div>
                                                              </div>


                                                          @endif
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
            <button class = 'btn btn-primary' type ='submit' {{ ($preview=='true' ? 'disabled=disabled' : "" ) }}><i class="fa fa-save"></i> Salvar</button>
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