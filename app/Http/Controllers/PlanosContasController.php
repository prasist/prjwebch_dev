<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\planos_contas;
use URL;
use Auth;
use Input;
use Gate;

class PlanosContasController extends Controller
{

    public function __construct()
    {

        $this->rota = "planos_contas"; //Define nome da rota que será usada na classe
        $this->middleware('auth');

        //Validação de permissão de acesso a pagina
        if (Gate::allows('verifica_permissao', [\Config::get('app.' . $this->rota),'acessar']))
        {
            $this->dados_login = \Session::get('dados_login');
        }

    }

    //Exibir listagem
    public function index()
    {

        if (\App\ValidacoesAcesso::PodeAcessarPagina(\Config::get('app.' . $this->rota))==false)
        {
              return redirect('home');
        }

        $dados = planos_contas::where('empresas_clientes_cloud_id', $this->dados_login->empresas_clientes_cloud_id)
        ->where('empresas_id', $this->dados_login->empresas_id)
        ->get();

        return view($this->rota . '.index',compact('dados'));

    }

    //Criar novo registro
    public function create()
    {

        if (\App\ValidacoesAcesso::PodeAcessarPagina(\Config::get('app.' . $this->rota))==false)
        {
              return redirect('home');
        }

        return view($this->rota . '.atualizacao', ['tipo_operacao'=>'incluir', 'preview'=>'false']);

    }

public function salvar($request, $id, $tipo_operacao)
  {

            /*Validação de campos - request*/
            $this->validate($request, [
                    'nome' => 'required',
            ]);

           $input = $request->except(array('_token')); //não levar o token

           if ($tipo_operacao=="create")
           {
                $planos_contas = new planos_contas();
           }
           else
           {
                $planos_contas= planos_contas::findOrfail($id);
           }

           $planos_contas->nome  = $input['nome'];
           $planos_contas->codigo_contabil = $input['codigo_contabil'];
           $planos_contas->empresas_clientes_cloud_id  = $this->dados_login->empresas_clientes_cloud_id;
           $planos_contas->empresas_id  = $this->dados_login->empresas_id;
           $planos_contas->save();

  }
/*
* Grava dados no banco
*
*/
    public function store(\Illuminate\Http\Request  $request)
    {

            $this->salvar($request, "", "create");
            \Session::flash('flash_message', 'Dados Atualizados com Sucesso!!!');
            return redirect($this->rota);
    }


    //Abre tela para edicao ou somente visualização dos registros
    private function exibir ($request, $id, $preview)
    {
        if($request->ajax())
        {
            return URL::to($this->rota . '/'. $id . '/edit');
        }

        if (\App\ValidacoesAcesso::PodeAcessarPagina(\Config::get('app.' . $this->rota))==false)
        {
              return redirect('home');
        }

        //preview = true, somente visualizacao, desabilita botao gravar
        $dados = planos_contas::findOrfail($id);
        return view($this->rota . '.atualizacao', ['dados' =>$dados, 'preview' => $preview, 'tipo_operacao'=>'editar']);

    }

    //Visualizar registro
    public function show (\Illuminate\Http\Request $request, $id)
    {

            return $this->exibir($request, $id, 'true');

    }

    //Direciona para tela de alteracao
    public function edit(\Illuminate\Http\Request $request, $id)
    {

            return $this->exibir($request, $id, 'false');

    }


    /**
     * Atualiza dados no banco
     *
     * @param    \Illuminate\Http\Request  $request
     * @param    int  $id
     * @return  \Illuminate\Http\Response
     */
    public function update(\Illuminate\Http\Request  $request, $id)
    {
        $this->salvar($request, $id,  "update");
        \Session::flash('flash_message', 'Dados Atualizados com Sucesso!!!');
        return redirect($this->rota);
    }


    /**
     * Excluir registro do banco.
     *
     * @param    int  $id
     * @return  \Illuminate\Http\Response
     */
    public function destroy($id)
    {
            $dados = planos_contas::findOrfail($id);
            $dados->delete();
            return redirect($this->rota);
    }

}