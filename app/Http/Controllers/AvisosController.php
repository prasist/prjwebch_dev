<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\avisos;
use URL;
use Auth;
use Input;
use Gate;

class AvisosController extends Controller
{

    public function __construct()
    {

        $this->rota = "avisos"; //Define nome da rota que será usada na classe
        $this->middleware('auth');

        //Validação de permissão de acesso a pagina
        if (Gate::allows('verifica_permissao', [\Config::get('app.home'),'acessar']))
        {
            $this->dados_login = \Session::get('dados_login');
        }

    }

    //Exibir listagem
    public function listar()
    {

        $dados = avisos::select('id', 'titulo', 'texto', 'data_publicacao')
        ->orderBy('data_publicacao', 'desc')
        ->get();

        return view($this->rota . '.listar',compact('dados'));

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

            /*Validação de campos - request*/
            $this->validate($request, [
                    'nome' => 'required|max:60:min:3',
            ]);

           $input = $request->except(array('_token', 'ativo')); //não levar o token

           $grupos = new avisos();
           $grupos->nome  = $input['nome'];
           $grupos->clientes_cloud_id  = $this->dados_login->empresas_clientes_cloud_id;
           $grupos->save();

           \Session::flash('flash_message', 'Dados Atualizados com Sucesso!!!');

            return redirect($this->rota);

    }

    //Abre tela para edicao ou somente visualização dos registros
    private function exibir ($request, $id)
    {

        //Busca mensagem para leitura
        //$dados = avisos::findOrfail($id);
        $dados  = avisos::where('id', $id)->get();

        $outras  = avisos::where('id', '<>', $id)->orderBy('data_publicacao', 'desc')->get();

        $log = \App\Models\log_avisos::firstOrNew(['users_id' => Auth::user()->id, 'id'=>$id]);
        $log->users_id = Auth::user()->id;
        $log->avisos_id = $id;
        $log->data_leitura = date("Y-m-d");
        $log->save();

         return view($this->rota . '.ler' , ['dados' => $dados, 'outras'=>$outras]);

    }

    //Visualizar registro
    public function show (\Illuminate\Http\Request $request, $id)
    {

            return $this->exibir($request, $id);

    }

    //Direciona para tela de alteracao
    public function edit(\Illuminate\Http\Request $request, $id)
    {

            return $this->exibir($request, $id);

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
                'nome' => 'required|max:60:min:3',
         ]);

        $input = $request->except(array('_token', 'ativo')); //não levar o token

        $dados = avisos::findOrfail($id);
        $dados->nome  = $input['nome'];
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

            $dados = avisos::findOrfail($id);
            $dados->delete();

            return redirect($this->rota);

    }

}