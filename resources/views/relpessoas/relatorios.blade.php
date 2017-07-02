@extends('principal.master')

@section('content')


<div class="row">
      <div class="col-md-2">
            <div>
                <a href="javascript: window.history.back();" class="btn btn-default"><i class="fa fa-arrow-circle-left"></i> Voltar</a>
            </div>
       </div>
</div>


<div id="impressao">

     <div class="row">
          <div class="col-md-12">
                {!!$filtros!!}
          </div>
    </div>

     <div class="row">
          <div class="col-md-12">
            <div class="box">
              <div class="box-header" data-original-title>
                  <div class="box-body table-responsive no-padding">

                      <table id="tab_pesquisas" class="table table-responsive table-hover">
                      <thead>
                          <tr>
                          <th>Nome</th>
                          <th>Dia/Mes</th>
                          <th>Idade</th>
                          <th>Telefone</th>
                          <th>Celular</th>
                          <th>Email</th>
                          </tr>
                      </thead>
                      <tbody>


                        @foreach($dados as $item)
                        <tr>
                            <td>{{$item->razaosocial}}</td>
                            <td>{{$item->dia . ($item->dia!="" ? '/' : '') . $item->mes}}</td>
                            <td>{{$item->idade}}</td>
                            <td>{{$item->fone_principal}}</td>
                            <td>{{$item->fone_celular}}</td>
                            <td>{{$item->emailprincipal}}</td>
                        </tr>
                        @endforeach
                      </tbody>

                      </table>
                  </div>
              </div>
            </div>
           </div>
      </div>
</div>

<script type="text/javascript">
    document.title = "";
</script>

@endsection