@extends('principal.master')

@section('content')

{{ \Session::put('titulo', 'Perfil') }}
{{ \Session::put('subtitulo', 'Visualizar') }}
{{ \Session::put('id_pagina', '28') }}


<div class = 'row'>

    <div class="col-md-12">

    <!-- Main content -->
    <section class="content">

      <div class="row">
        <div class="col-md-4">

          <!-- Profile Image -->
          <div class="box box-primary">
            <div class="box-body box-profile">

            @if (rtrim($perfil[0]->caminhofoto)!="")
                     <img class="profile-user-img img-responsive img-circle" src="{{ url('/images/persons/' . $perfil[0]->caminhofoto) }}" alt="Foto">
            @endif


              <h3 class="profile-username text-center">{{$perfil[0]->razaosocial }}</h3>

              <p class="text-muted text-center">{{ $perfil[0]->ativo=='S' ? 'Ativo' : 'Inativo' }}</p>

              <ul class="list-group list-group-unbordered">
                <li class="list-group-item">

                  @if ($perfil[0]->estadoscivis_id)

                        <b>{{$perfil[0]->razaosocial }}</b> é <i><b>{{$perfil[0]->estado_civil}}</b></i>
                        @if (isset($membros_familiares))
                        @if ($membros_familiares[0]->conjuge_id)
                               com <i><b>{{$membros_familiares[0]->razaosocial}}</b></i>
                        @endif
                        @endif
                        <br/>
                  @endif

                  @if ($perfil[0]->datanasc_formatada)
                         Nasceu em  <i><b>{{$perfil[0]->datanasc_formatada}}</b></i>
                  @endif

                  @if ($perfil[0]->naturalidade)
                         Natural de  <i><b>{{$perfil[0]->naturalidade}} - {{$perfil[0]->uf_naturalidade}}</b></i>
                  @endif

                  @if(isset($membros_celula))
                      Participa da Célula <i><b>{{$membros_celula[0]->nome}}</b></i>

                      @if (rtrim($membros_celula[0]->data_entrada_celula)!="")
                            desde <i><b>{{$membros_celula[0]->data_entrada_celula}}</b></i>
                      @endif
                  @else
                      Não Participa de Células.
                  @endif

                   <br/>
                    @if($perfil[0]->profissao)
                        É <i><b>{{$perfil[0]->profissao}}</b></i>
                    @endif

                    @if($perfil[0]->nome_empresa)
                        e trabalha na <i><b>{{$perfil[0]->nome_empresa}}</b></i>
                    @endif

                    @if($perfil[0]->cargo)
                        como  <i><b>{{$perfil[0]->cargo}}</b></i>
                    @endif

                </li>

                <li class="list-group-item">

                     @if ($perfil[0]->fone_principal)
                        <i class="fa fa-home"></i> {{$perfil[0]->fone_principal}}
                    @endif

                    @if ($perfil[0]->fone_secundario)
                        &nbsp;&nbsp;<i class="fa fa-phone"></i> {{$perfil[0]->fone_secundario}}
                    @endif

                    @if ($perfil[0]->fone_celular)
                        <br/><i class="fa fa-mobile-phone"></i> {{$perfil[0]->fone_celular}}
                    @endif

                    @if ($perfil[0]->emailprincipal)
                           <br/><i class="fa fa-envelope-o"></i> {{$perfil[0]->emailprincipal}}
                    @endif
                </li>

                @can('verifica_permissao', [\Session::get('id_pagina') ,'alterar'])
                 <li class="list-group-item">
                      <a class="btn  btn-info btn-sm" href="{{ url('/pessoas/' . $perfil[0]->id .'/edit/' . $perfil[0]->tipos_pessoas_id)}}"><spam class="glyphicon glyphicon-pencil"></spam> Alterar/Visualizar Dados Cadastrais</a>
                 </li>
                @endcan
              </ul>


            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->

          <!-- About Me Box -->
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Resumo</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <strong><i class="fa fa-book margin-r-5"></i> Educação</strong>

              <p class="text-muted">
                      {{$perfil[0]->grau_instrucao}}
                      @if (isset($membros_formacoes))
                          em <i><b>{{$membros_formacoes[0]->nome}}</b></i>
                      @endif
              </p>

              <hr>

              <strong><i class="fa fa-map-marker margin-r-5"></i> Endereço</strong>

              <p class="text-muted">

                @if ($perfil[0]->endereco)
                        {{$perfil[0]->endereco}}, {{$perfil[0]->numero}} - {{$perfil[0]->bairro}}<br/>
                        {{$perfil[0]->cidade}} - {{$perfil[0]->estado}}
                @endif

              </p>

              <hr>

              <strong><i class="fa fa-file-text-o margin-r-5"></i> Notas</strong>

              <p>

                  @if ($perfil[0]->prefere_trabalhar_com)
                        Prefere trabalhar com <i><b>{{($perfil[0]->prefere_trabalhar_com=="P" ? "Pessoas" : "Tarefas")}}</b></i>
                  @endif

                  @if ($perfil[0]->considera_se)
                        Considera-se <i><b>{{($perfil[0]->considera_se=="M" ? "Muito Estruturado" : ($perfil[0]->considera_se=="E" ? "Estruturado" : "Pouco Estruturado"))}}</b></i>
                  @endif

                  @if ($perfil[0]->obs)
                        <br/><br/>{{$perfil[0]->obs}}
                  @endif

              </p>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
        <div class="col-md-8">
          <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
                <li class="active"><a href="#activity" data-toggle="tab">Vínculos e Relacionamentos</a></li>
                <li><a href="#settings" data-toggle="tab">Vida Eclesiástica</a></li>
                <li><a href="#timeline" data-toggle="tab">Linha do Tempo</a></li>
                <li><a href="#acomp" data-toggle="tab">Acompanhamento Pastoral</a></li>
            </ul>
            <div class="tab-content">
              <div class="active tab-pane" id="activity">
                <!-- Post -->
                <div class="post">
                  <div class="user-block">

                          <b>Relacionamentos</b>
                          <br/><br/>
                          @if (isset($membros_relacionamentos))
                              @foreach ($membros_relacionamentos as $item)
                                   @if ($item->nome!="")
                                        {{$item->nome}} de {{$item->razaosocial}}<br/>
                                   @endif
                              @endforeach
                          @endif

                           <br/><br/>
                           <b>Vínculos Familiares</b>
                          <br/><br/>
                          @if (isset($membros_familiares))
                               @if ($membros_familiares[0]->razaosocial_pai)
                                      Pai <i><b>{{$membros_familiares[0]->razaosocial_pai}}</b></i>
                               @endif

                               @if ($membros_familiares[0]->nome_pai)
                                      Pai <i><b>{{$membros_familiares[0]->nome_pai}}</b></i>
                               @endif

                               <br/>
                               @if ($membros_familiares[0]->razaosocial_mae)
                                      Mãe <i><b>{{$membros_familiares[0]->razaosocial_mae}}</b></i>
                               @endif

                               @if ($membros_familiares[0]->nome_mae)
                                      Mãe <i><b>{{$membros_familiares[0]->nome_mae}}</b></i>
                               @endif
                      @endif
                               <br/>
                                @if (isset($membros_filhos))
                                      @foreach($membros_filhos as $item)
                                            @if ($item->filhos_id)
                                                    Filho(a)(s) <i><b>{{$item->filhos_id}}</b></i>
                                            @endif

                                            @if ($item->nome_filho)
                                                    Filho(a)(s) <i><b>{{$item->nome_filho}}</b></i>
                                            @endif
                                            <br/>
                                      @endforeach
                               @endif

                           <br/>
                           <br/>
                           <br/><br/>
                           <br/><br/>
                           <br/><br/>
                           <br/>
                           <br/>
                           <br/>
                           <br/>
                           <br/><br/>
                           <br/><br/>
                           <br/>
                           <br/><br/>
                           <br/><br/>

                  </div>
                  <!-- /.user-block -->
                </div>
                <!-- /.post -->


              </div>
              <!-- /.tab-pane -->
              <div class="tab-pane" id="timeline">
                <!-- The timeline -->
                   <!-- The timeline -->
                <ul class="timeline timeline-inverse">

                 @if (isset($view_pessoas_movimentacoes))
                      @foreach ($view_pessoas_movimentacoes as $item)
                            <!-- timeline time label -->
                            <li class="time-label">
                                  <span class="bg-blue">
                                        {{$item->data_movimentacao}}
                                  </span>
                            </li>
                            <!-- /.timeline-label -->
                            <!-- timeline item -->
                            <li>
                              <i class="fa fa-hourglass-end"></i>

                              <div class="timeline-item">
                                <h3 class="timeline-header"><a href="#">{!! $item->nome !!} de : <b><i>{!! $item->celula_atual !!}</i></b> para : <b><i>{!! $item->celula_nova !!}</i></b></a></h3>

                              </div>
                            </li>
                            <!-- END timeline item -->
                      @endforeach
                 @endif



                 @if (rtrim($pessoas_timeline[0]->data_saida))
                  <!-- timeline time label -->
                  <li class="time-label">
                        <span class="bg-green">
                              {{$pessoas_timeline[0]->data_saida}}
                        </span>
                  </li>
                  <!-- /.timeline-label -->
                  <!-- timeline item -->
                  <li>
                    <i class="fa fa-hourglass-end"></i>

                    <div class="timeline-item">
                      <h3 class="timeline-header"><a href="#">Saiu da Igreja</a></h3>

                    </div>
                  </li>
                  <!-- END timeline item -->
                  @endif


                  @if (rtrim($pessoas_timeline[0]->data_entrada_celula) && rtrim($pessoas_timeline[0]->data_entrada_celula) != "01/01/0001")
                  <!-- timeline time label -->
                  <li class="time-label">
                        <span class="bg-green">
                              {{$pessoas_timeline[0]->data_entrada_celula}}
                        </span>
                  </li>
                  <!-- /.timeline-label -->
                  <!-- timeline item -->
                  <li>
                    <i class="fa fa-hourglass-end"></i>

                    <div class="timeline-item">
                      <h3 class="timeline-header"><a href="#">Começou a participar de Célula</a></h3>

                    </div>
                  </li>
                  <!-- END timeline item -->
                  @endif


                  <!-- timeline time label -->
                  @if ($pessoas_timeline[0]->data_batismo)
                  <li class="time-label">
                        <span class="bg-red">
                            {{$pessoas_timeline[0]->data_batismo}}
                        </span>
                  </li>
                  <!-- /.timeline-label -->
                  <!-- timeline item -->
                  <li>
                    <i class="fa fa-hourglass-end"></i>

                    <div class="timeline-item">

                      <h3 class="timeline-header"><a href="#">Batizou-se</a></h3>

                    </div>
                  </li>
                  @endif

                  <!-- END timeline item -->


                  @if (rtrim($pessoas_timeline[0]->data_entrada))
                  <!-- timeline time label -->
                  <li class="time-label">
                        <span class="bg-green">
                              {{$pessoas_timeline[0]->data_entrada}}
                        </span>
                  </li>
                  <!-- /.timeline-label -->
                  <!-- timeline item -->
                  <li>
                    <i class="fa fa-hourglass-end"></i>

                    <div class="timeline-item">
                      <h3 class="timeline-header"><a href="#">Entrou na Igreja</a></h3>

                    </div>
                  </li>
                  <!-- END timeline item -->
                  @endif


                  <li>
                    <i class="fa fa-clock-o bg-gray"></i>
                  </li>
                </ul>
              </div>
              <!-- /.tab-pane -->

              <div class="tab-pane" id="settings">

                  <div class="post">
                    <div class="user-block">
                      @if (isset($membros_dons))
                      <b>Dons Espirituais</b>
                      <br/><br/>
                            @foreach ($membros_dons as $item)
                              <i><b>{{$item->nome}}</b></i><br/>
                            @endforeach
                      @endif

                      @if (isset($membros_habilidades))
                      <br/><br/>
                      <b>Habilidades</b>
                      <br/><br/>
                          @foreach ($membros_habilidades as $item)
                            <i><b>{{$item->nome}}</b></i><br/>
                          @endforeach
                      @endif


                      @if (isset($membros_ministerios))
                      <br/><br/>
                      <b>Ministérios</b>
                      <br/><br/>
                            @foreach ($membros_ministerios as $item)
                              <i><b>{{$item->nome}}</b></i><br/>
                            @endforeach
                      @endif

                      @if (isset($membros_atividades))
                      <br/><br/>
                      <b>Atividades</b>
                      <br/><br/>
                            @foreach ($membros_atividades as $item)
                              <i><b>{{$item->nome}}</b></i><br/>
                            @endforeach
                      @endif
                    </div>
                 </div>

              </div>
              <!-- /.tab-pane -->

              <div class="tab-pane" id="acomp">
                    <textarea name="acomp" class="form-control" rows="10" placeholder="Digite o texto..." ></textarea>

                    <div class="box-footer">
                        <button class = 'btn btn-primary' type ='submit'  disabled><i class="fa fa-save"></i> Salvar</button>
                    </div>
              </div>



            </div>
            <!-- /.tab-content -->
          </div>
          <!-- /.nav-tabs-custom -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->

    </section>

    </div>

</div>

@endsection