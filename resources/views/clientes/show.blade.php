@extends('principal.master')

@section('content')

  <div class = 'container'>

{{ \Session::put('titulo', 'Igreja Sede') }}
{{ \Session::put('subtitulo', 'Visualização') }}
{{ \Session::put('route', 'clientes') }}

        <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">

                <div class="box-body">

                        <table class="table table-bordered table-hover">
                            <thead>
                                <th></th>
                                <th></th>
                            </thead>
                            <tbody>


                                <tr>
                                    <td>
                                        <b><i>Razão Social : </i></b>
                                    </td>
                                    <td>{{$clientes_cloud->razaosocial}}</td>
                                </tr>

                                <tr>
                                    <td>
                                        <b><i>Nome Fantasia : </i></b>
                                    </td>
                                    <td>{{$clientes_cloud->nomefantasia}}</td>
                                </tr>

                                <tr>
                                    <td>
                                        <b><i>cnpj : </i></b>
                                    </td>
                                    <td>{{$clientes_cloud->cnpj}}</td>
                                </tr>

                                <tr>
                                    <td>
                                        <b><i>Inscr. Estadual : </i></b>
                                    </td>
                                    <td>{{$clientes_cloud->inscricaoestadual}}</td>
                                </tr>

                                <tr>
                                    <td>
                                        <b><i>Endereço : </i></b>
                                    </td>
                                    <td>{{$clientes_cloud->endereco}}</td>
                                </tr>

                                <tr>
                                    <td>
                                        <b><i>Número</i></b>
                                    </td>
                                    <td>{{$clientes_cloud->numero}}</td>
                                </tr>

                                <tr>
                                    <td>
                                        <b><i>Bairro : </i></b>
                                    </td>
                                    <td>{{$clientes_cloud->bairro}}</td>
                                </tr>

                                <tr>
                                    <td>
                                        <b><i>CEP : </i></b>
                                    </td>
                                    <td>{{$clientes_cloud->cep}}</td>
                                </tr>

                                <tr>
                                    <td>
                                        <b><i>Complemento : </i></b>
                                    </td>
                                    <td>{{$clientes_cloud->complemento}}</td>
                                </tr>

                                <tr>
                                    <td>
                                        <b><i>Cidade : </i></b>
                                    </td>
                                    <td>{{$clientes_cloud->cidade}}</td>
                                </tr>

                                <tr>
                                    <td>
                                        <b><i>Estado : </i></b>
                                    </td>
                                    <td>{{$clientes_cloud->estado}}</td>
                                </tr>

                                <tr>
                                    <td>
                                        <b><i>Fone principal : </i></b>
                                    </td>
                                    <td>{{$clientes_cloud->foneprincipal}}</td>
                                </tr>

                                <tr>
                                    <td>
                                        <b><i>Fone II : </i></b>
                                    </td>
                                    <td>{{$clientes_cloud->fonesecundario}}</td>
                                </tr>

                                <tr>
                                    <td>
                                        <b><i>Email : </i></b>
                                    </td>
                                    <td>{{$clientes_cloud->emailprincipal}}</td>
                                </tr>

                                <tr>
                                    <td>
                                        <b><i>Email alternativo : </i></b>
                                    </td>
                                    <td>{{$clientes_cloud->emailsecundario}}</td>
                                </tr>

                                <tr>
                                    <td>
                                        <b><i>Contato : </i></b>
                                    </td>
                                    <td>{{$clientes_cloud->nomecontato}}</td>
                                </tr>

                                <tr>
                                    <td>
                                        <b><i>Celular : </i></b>
                                    </td>
                                    <td>{{$clientes_cloud->celular}}</td>
                                </tr>

                                <tr>
                                    <td>
                                        <b><i>Status : </i></b>
                                    </td>
                                    <td>{{$clientes_cloud->ativo}}</td>
                                </tr>

                                <tr>
                                    <td>
                                        <b><i>Website : </i></b>
                                    </td>
                                    <td>{{$clientes_cloud->website}}</td>
                                </tr>

                                <tr>
                                    <td>
                                        <b><i>Logo : </i></b>
                                    </td>
                                    <td>{{$clientes_cloud->caminhologo}}</td>
                                </tr>



                            </tbody>
                        </table>
                </div>
                </div>
                </div>
                </div>
                </div>
                </div>

@endsection