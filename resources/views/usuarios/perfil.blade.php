@extends('principal.master')

@section('content')

{{ \Session::put('titulo', 'Perfil do Usuário') }}
{{ \Session::put('subtitulo', 'Alteração') }}
{{ \Session::put('route', 'usuarios') }}

<div class = 'row'>

    <div class="col-md-12">

        <div>
            <a href="{{ url('/usuarios')}}" class="btn btn-default"><i class="fa fa-arrow-circle-left"></i> Voltar</a>
        </div>

        <h4>Alteração Perfil Usuário</h4>
        <form method = 'POST' class="form-horizontal" enctype="multipart/form-data" action = {{ url('/usuarios/' . $dados->id . '/update')}}>

        {!! csrf_field() !!}

            <div class="box box-primary">

                 <div class="box-body"> <!--anterior box-body-->

                          <div style="display:none;">
                                <select name="empresa" class="form-control select2" >

                                @foreach($empresas as $item)
                                      <option  {{ ($item->id == $grupo_do_usuario[0]->usuarios_empresas_id ? 'selected' : '')  }} value="{{$item->id}}">{{$item->razaosocial}}</option>
                                @endforeach
                                </select>
                          </div>

                          <div style="display:none;">
                              <select name="grupo" class="form-control select2" >

                              @foreach($grupos as $item)
                                    <option  {{ ($item->id == $grupo_do_usuario[0]->grupos_id ? 'selected' : '')  }} value="{{$item->id}}">{{$item->nome}}</option>
                              @endforeach
                              </select>
                          </div>

                          <!--Somente usuário MASTER poderá criar usuários ADMIN-->
                          <input  name="admin" type="hidden"  value="0" />
                           @if ($dados_login->master==1)
                                <div style="display:none;">
                                    <input  name="admin" type="checkbox" style="display:none;" class="acessar" value="1" {{ ($grupo_do_usuario[0]->admin==1 ? 'checked' : '') }} />
                                </div>

                           @endif

                            <input  id="sera_admin" name="sera_admin" type="hidden"  value="0" />

                            <div class="row{{ $errors->has('name') ? ' has-error' : '' }}">
                                    <div class="col-xs-10">
                                          <label for="name" class="control-label">Nome</label>

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
                                          <label for="email" class="control-label">Email</label>

                                          <input id="email" maxlength="255"  name = "email" type="text" class="form-control" value="{{ $dados->email }}">

                                             <!-- se houver erros na validacao do form request -->
                                             @if ($errors->has('email'))
                                              <span class="help-block">
                                                  <strong>{{ $errors->first('email') }}</strong>
                                              </span>
                                             @endif

                                    </div>
                            </div>

                            <div class="row{{ $errors->has('password') ? ' has-error' : '' }}">
                                    <div class="col-xs-5">
                                          <label for="password" class="control-label">Senha</label>

                                          <input id="password" maxlength="60"  name = "password" type="password" class="form-control" value="">

                                             <!-- se houver erros na validacao do form request -->
                                             @if ($errors->has('password'))
                                              <span class="help-block">
                                                  <strong>{{ $errors->first('password') }}</strong>
                                              </span>
                                             @endif

                                    </div>

                                    <div class="col-xs-5">
                                          <label for="password_confirmation" class="control-label">Confirmação Senha</label>

                                          <input id="password_confirmation" maxlength="60"  name = "password_confirmation" type="password" class="form-control" value="">

                                             <!-- se houver erros na validacao do form request -->
                                             @if ($errors->has('password_confirmation'))
                                              <span class="help-block">
                                                  <strong>{{ $errors->first('password_confirmation') }}</strong>
                                              </span>
                                             @endif

                                    </div>

                            </div>

                          <div class="row">
                                  <div class="col-xs-5">
                                          <label for="caminhologo" class="control-label">Foto</label>
                                          <input type="file" id="caminhologo" maxlength="255" name = "caminhologo" >
                                  </div>

                                    @if ($dados->path_foto!="")
                                        <p></p>
                                        <div class="col-xs-3">
                                              <img src="{{ url('/images/users/' . $dados->path_foto) }}" width="160px" height="160px">
                                              <a href="{{ url('/usuarios/' . $dados->id . '/remover')}}"><i class="fa fa-remove"> Remover Imagem</i> </a>
                                        </div>

                                    @endif
                          </div>


            </div><!-- fim box-body"-->
        </div><!-- box box-primary -->

        <div class="box-footer">
            <button class = 'btn btn-primary' type ='submit' {{ ($preview=='true' ? 'disabled=disabled' : "" ) }}><i class="fa fa-save"></i> Salvar</button>
            <a href="{{ url('/usuarios')}}" class="btn btn-default">Cancelar</a>
        </div>

       </form>

    </div><!-- <col-md-12 -->

</div><!-- row -->

@endsection