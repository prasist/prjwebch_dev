<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use URL;
use App\Models\usuario;
use App\Models\grupos;
use Auth;
use Input;
//use Validator;
use Gate;
use App\Exceptions\CustomException;

class GruposController extends Controller
{
    //

    public function __construct()
    {
        $this->middleware('auth');

        //Validação de permissão de acesso a pagina
        if (Gate::allows('verifica_permissao', [\Config::get('app.grupos'),'acessar']))
        {
            $this->dados_login = \Session::get('dados_login');
        }

    }

    //Exibir listagem dos grupos
    public function index()
    {

        if (\App\ValidacoesAcesso::PodeAcessarPagina(\Config::get('app.grupos'))==false)
        {
              return redirect('home');
        }

        $where = ['empresas_id' => $this->dados_login->empresas_id, 'empresas_clientes_cloud_id' => $this->dados_login->empresas_clientes_cloud_id];

        $dados = grupos::where($where)->get();

        return view('grupos.index',compact('dados'));

    }

    //Criar novo registro
    public function create()
    {

        if (\App\ValidacoesAcesso::PodeAcessarPagina(\Config::get('app.grupos'))==false)
        {
              return redirect('home');
        }

        return view('grupos.registrar');

    }


/*
* Grava dados no banco
*
*/
    public function store(\Illuminate\Http\Request  $request)
    {

        try
        {

            /*Validação de campos - request*/
            $this->validate($request, [
                    'nome' => 'required|max:45:min:3',
            ]);

            /*
            *    Verificar se foi cadastrado os dados da igreja
            *    Caso encontre, busca somente os dados da empresa que o usuário pertence
            */

           $input = $request->except(array('_token', 'ativo')); //não levar o token

           $grupos = new grupos();
           $grupos->nome  = $input['nome'];
           $grupos->empresas_id  = $this->dados_login->empresas_id;
           $grupos->empresas_clientes_cloud_id  = $this->dados_login->empresas_clientes_cloud_id;
           $grupos->save();

           \Session::flash('flash_message', 'Dados Atualizados com Sucesso!!!');

            return redirect('grupos');

        }

        catch (Exception $e)

        {

            \Session::flash('flash_message', 'Erro : ' . $e);
            return redirect('grupos');

        }

    }

    //Abre tela para edicao ou somente visualização dos registros
    private function exibir ($request, $id, $preview)
    {
        if($request->ajax())
        {
            return URL::to('grupos/'. $id . '/edit');
        }

        if (\App\ValidacoesAcesso::PodeAcessarPagina(\Config::get('app.grupos'))==false)
        {
              return redirect('home');
        }

        //preview = true, somente visualizacao, desabilita botao gravar
        $dados = grupos::findOrfail($id);
        return view('grupos.edit', ['dados' =>$dados, 'preview' => $preview] );

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

        /*Validação de campos - request*/
        $this->validate($request, [
                'nome' => 'required|max:45:min:3',
         ]);

        $input = $request->except(array('_token', 'ativo')); //não levar o token

        $grupos = grupos::findOrfail($id);

        $grupos->nome  = $input['nome'];

        $grupos->save();

        \Session::flash('flash_message', 'Dados Atualizados com Sucesso!!!');

        return redirect('grupos');

    }


    public function update_inline(\Illuminate\Http\Request  $request, $id)
    {
        $input = $request->except(array('_token', 'ativo')); //não levar o token
        $grupos = grupos::findOrfail($id);
        $grupos->nome  = $input["value"];
        $grupos->save();
        return response()->json([ 'code'=>200], 200);
    }


    /**
     * Excluir registro do banco.
     *
     * @param    int  $id
     * @return  \Illuminate\Http\Response
     */
    public function destroy($id)
    {
            $grupos = grupos::findOrfail($id);
            $grupos->delete();
            return redirect('grupos');
    }

}