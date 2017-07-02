@extends('principal.master')

@section('content')

{{ \Session::put('titulo', 'Dados Cadastrais') }}
{{ \Session::put('subtitulo', 'Alteração') }}
{{ \Session::put('route', 'membrosdados') }}
{{ \Session::put('id_pagina', '63') }}

<div class = 'row'>

    <div class="col-md-12">

        <form method = 'POST' class="form-horizontal" enctype="multipart/form-data" action = "{{ url('/membro_dados/' . $pessoas[0]->id . '/update')}}">

        {!! csrf_field() !!}

            <div class="box box-primary">

                 <div class="box-body"> <!--anterior box-body-->

                            <div class="row">
                                    <div class="col-xs-12">
                                          <label for="razaosocial" class="control-label">Nome</label>
                                          <input id="razaosocial"  name = "razaosocial" type="text" class="form-control" value="{{ $pessoas[0]->razaosocial }}" readonly="true">
                                    </div>
                            </div>

                            <div class="row{{ $errors->has('email') ? ' has-error' : '' }}">
                                    <div class="col-xs-12">
                                          <label for="email" class="control-label">Email</label>

                                          <input id="email" maxlength="255"  name = "email" type="text" class="form-control" value="{{ $pessoas[0]->emailprincipal }}">

                                             <!-- se houver erros na validacao do form request -->
                                             @if ($errors->has('email'))
                                              <span class="help-block">
                                                  <strong>{{ $errors->first('email') }}</strong>
                                              </span>
                                             @endif

                                    </div>
                            </div>

                               <div class="row">
                                          <div class="col-xs-3">
                                              <label for="foneprincipal" class="control-label">Fone Principal</label>

                                              <div class="input-group{{ $errors->has('foneprincipal') ? ' has-error' : '' }}">
                                                     <div class="input-group-addon">
                                                      <i class="fa fa-phone"></i>
                                                      </div>

                                                      <input id="foneprincipal"  name = "foneprincipal" type="text" class="form-control" value="{{$pessoas[0]->fone_principal}}"  >

                                                       <!-- se houver erros na validacao do form request -->
                                                       @if ($errors->has('foneprincipal'))
                                                        <span class="help-block">
                                                            <strong>{{ $errors->first('foneprincipal') }}</strong>
                                                        </span>
                                                       @endif

                                              </div>

                                        </div>

                                           <div class="col-xs-3">
                                                  <label for="fonesecundario" class="control-label">Fone Secundário</label>

                                                  <div class="input-group">
                                                         <div class="input-group-addon">
                                                          <i class="fa fa-phone"></i>
                                                          </div>

                                                          <input id="fonesecundario" name = "fonesecundario" type="text" class="form-control"   value="{{$pessoas[0]->fone_secundario}}">
                                                  </div>

                                           </div>

                                          <div class="col-xs-3">
                                                  <label for="fonerecado" class="control-label">Fone Recado</label>

                                                  <div class="input-group">
                                                         <div class="input-group-addon">
                                                          <i class="fa fa-phone"></i>
                                                          </div>

                                                          <input id="fonerecado" name = "fonerecado" type="text" class="form-control"   value="{{$pessoas[0]->fone_recado}}">
                                                  </div>

                                           </div>

                                          <div class="col-xs-3">
                                              <label for="celular" class="control-label">Celular</label>

                                              <div class="input-group">
                                                         <div class="input-group-addon">
                                                          <i class="fa fa-phone"></i>
                                                          </div>
                                                          <input id="celular"   name = "celular" type="text" class="form-control" value="{{$pessoas[0]->fone_celular}}">
                                              </div>
                                          </div>

                         </div>

                                      <div class="row">

                                            <div class="col-xs-3">
                                                      <label for="cep" class="control-label">CEP</label>
                                                      <div class="input-group">
                                                               <div class="input-group-addon">
                                                                  <a href="#" data-toggle="tooltip" title="Digite o CEP para buscar automaticamente o endereço. Não informar pontos ou traços.">
                                                                        <img src="{{ url('/images/help.png') }}" class="user-image" alt="Ajuda"  />
                                                                   </a>
                                                                </div>

                                                                <input id="cep" maxlength="8" name = "cep" type="text" class="form-control" value="{{$pessoas[0]->cep}}">
                                                        </div>
                                           </div>


                                            <div class="col-xs-7">
                                                    <label for="endereco" class="control-label">Endereço</label>
                                                    <input id="endereco" maxlength="150" name = "endereco" type="text" class="form-control" value="{{$pessoas[0]->endereco}}">
                                            </div>

                                            <div class="col-xs-2">
                                                    <label for="numero" class="control-label">Número</label>
                                                    <input id="numero" maxlength="10" name = "numero" type="text" class="form-control" value="{{$pessoas[0]->numero}}">
                                            </div>
                                      </div>

                                      <div class="row">
                                            <div class="col-xs-6">
                                                  <label for="bairro" class="control-label">Bairro</label>
                                                  <input id="bairro" maxlength="50" name = "bairro" type="text" class="form-control" value="{{$pessoas[0]->bairro}}">
                                             </div>

                                            <div class="col-xs-6">
                                                <label for="complemento" class="control-label">Complemento</label>
                                                <input id="complemento" name = "complemento" type="text" class="form-control" value="{{$pessoas[0]->complemento}}">
                                            </div>

                                      </div>

                                    <div class="row">
                                            <div class="col-xs-10">
                                                    <label for="cidade" class="control-label">Cidade</label>
                                                    <input id="cidade" maxlength="60" name = "cidade" type="text" class="form-control" value="{{$pessoas[0]->cidade}}">
                                            </div>

                                            <div class="col-xs-2">
                                                <label for="estado" class="control-label">Estado</label>
                                                <input id="estado" maxlength="2" name = "estado" type="text" class="form-control" value="{{$pessoas[0]->estado}}">
                                            </div>
                                    </div>

                         <div class="row">
                                  <div class="col-xs-5">
                                          <label for="caminhologo" class="control-label">Foto</label>
                                          <input type="file" id="caminhologo" maxlength="255" name = "caminhologo" >
                                  </div>

                                    @if ($pessoas[0]->caminhofoto!="")
                                        <p></p>
                                        <div class="col-xs-3">
                                              <img src="{{ url('/images/persons/' . $pessoas[0]->caminhofoto) }}" width="160px" height="160px">
                                              <a href="{{ url('/profile/' . $pessoas[0]->id . '/remover')}}"><i class="fa fa-remove"> Remover Imagem</i> </a>
                                        </div>

                                    @endif
                          </div>


            </div><!-- fim box-body"-->
        </div><!-- box box-primary -->

        <div class="box-footer">
            <button class = 'btn btn-primary' type ='submit'><i class="fa fa-save"></i> Salvar</button>
            <a href="{{ url('/home')}}" class="btn btn-default">Cancelar</a>
        </div>

       </form>

    </div><!-- <col-md-12 -->

</div><!-- row -->

@endsection

@include('pessoas.script_pessoas')