<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\contas;
use URL;
use Auth;
use Input;
use Gate;

class ContasController extends Controller
{

    public function __construct()
    {

        $this->rota = "contas"; //Define nome da rota que será usada na classe
        $this->middleware('auth');

        /*Instancia a classe de funcoes (Data, valor, etc)*/
        $this->formatador = new  \App\Functions\FuncoesGerais();

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

        $dados = contas::select('contas.nome', 'contas.id', 'contas.saldo_atual', 'contas.saldo_inicial', 'contas.data_alteracao' ,'contas.codigo_contabil',  'users.name as nome_usuario')
        ->where('contas.empresas_clientes_cloud_id', $this->dados_login->empresas_clientes_cloud_id)
        ->leftjoin('users', 'users.id' , '=' , 'contas.users_id')
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

        return view($this->rota . '.registrar');

    }


/*
* Grava dados no banco
*
*/
    public function store(\Illuminate\Http\Request  $request)
    {

           $input = $request->except(array('_token', 'ativo')); //não levar o token

           $dados = new contas();
           $dados->nome  = $input['nome'];
           $dados->codigo_contabil  = $input['codigo_contabil'];
           $dados->saldo_inicial  = ($input["saldo"]!="" ? $this->formatador->GravarCurrency($input["saldo"]) : null);
           $dados->users_id = Auth::user()->id;
           $dados->data_alteracao = date("Y-m-d H:i:s");
           $dados->empresas_id  = $this->dados_login->empresas_id;
           $dados->empresas_clientes_cloud_id  = $this->dados_login->empresas_clientes_cloud_id;
           $dados->save();

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
        $dados = contas::findOrfail($id);
        return view($this->rota . '.edit', ['dados' =>$dados, 'preview' => $preview] );

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

        $input = $request->except(array('_token', 'ativo')); //não levar o token

        $dados = contas::findOrfail($id);
        $dados->nome  = $input['nome'];
        $dados->codigo_contabil  = $input['codigo_contabil'];
        $dados->saldo_inicial  = ($input["saldo"]!="" ? $this->formatador->GravarCurrency($input["saldo"]) : null);
        $dados->users_id = Auth::user()->id;
        $dados->data_alteracao = date("Y-m-d H:i:s");
        $dados->save();

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

            $dados = contas::findOrfail($id);
            $dados->delete();

            return redirect($this->rota);

    }

}