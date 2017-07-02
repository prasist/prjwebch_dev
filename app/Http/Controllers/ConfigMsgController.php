<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use URL;
use App\Models\parametros;
use Auth;
use Input;
use Validator;
use Gate;

class ConfigMsgController extends Controller
{
    //

    public function __construct()
    {

        $this->middleware('auth');
        $this->rota = "configmsg"; //Define nome da rota que será usada na classe

        //Validação de permissão de acesso a pagina
        if (Gate::allows('verifica_permissao', [\Config::get('app.configmsg'),'acessar']))
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

        $where = ['empresas_id' => $this->dados_login->empresas_id, 'empresas_clientes_cloud_id' => $this->dados_login->empresas_clientes_cloud_id];

        $dados = parametros::where($where)->get();

        return view($this->rota . '.atualizacao', ['dados' =>$dados, 'preview' => '', 'tipo_operacao'=> ($dados->count()>0 ? "editar" : "incluir")]);


    }


    //Abre tela para edicao ou somente visualização dos registros
    private function exibir ($request, $id, $preview, $perfil)
    {

        $where = ['empresas_id' => $this->dados_login->empresas_id, 'empresas_clientes_cloud_id' => $this->dados_login->empresas_clientes_cloud_id];

        $dados = parametros::where($where)->get();

        return view($this->rota . '.atualizacao', ['dados' =>$dados, 'preview' => $preview]);

    }

/*
* Grava dados no banco
*
*/
    public function store(\Illuminate\Http\Request  $request)
    {

        /*Validação de campos - request*/
        $this->validate($request, [
                'email' => 'required',
                'password' => 'required|min:6',
                'ddd' => 'required|min:2',
         ]);

        $input = $request->except(array('_token', 'ativo')); //não levar o token

        $dados = new parametros();
        $dados->empresas_id  =  $this->dados_login->empresas_id;
        $dados->empresas_clientes_cloud_id  =  $this->dados_login->empresas_clientes_cloud_id;
        $dados->login_provedor_mensagens  = $input['email'];
        $dados->senha_provedor_mensagens  = ($input['password']);
        $dados->sms_marketing  = (isset($input['sms_marketing']) ? "S" : "N");
        $dados->sms_corporativo  = (isset($input['sms_corporativo']) ? "S" : "N");
        $dados->whatsapp  = (isset($input['whatsapp']) ? "S" : "N");
        $dados->ddd  = $input['ddd'];

        $dados->save();

        \Session::flash('flash_message', 'Dados Atualizados com Sucesso!!!');

        return redirect('home');

    }


    //Visualizar registro
    public function show (\Illuminate\Http\Request $request, $id)
    {

            return $this->exibir($request, $id, 'true', 'false');

    }

    //Direciona para tela de alteracao
    public function edit(\Illuminate\Http\Request $request, $id)
    {
            return $this->exibir($request, $id, 'false', 'false');
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
                'email' => 'required',
                'password' => 'required|min:6',
                'ddd' => 'required|min:2',
         ]);


        $input = $request->except(array('_token', 'ativo')); //não levar o token

        //-------------Atualiza Usuario
        $dados = parametros::findOrfail($id);
        $dados->empresas_id  =  $this->dados_login->empresas_id;
        $dados->empresas_clientes_cloud_id  =  $this->dados_login->empresas_clientes_cloud_id;
        $dados->login_provedor_mensagens  = $input['email'];
        $dados->senha_provedor_mensagens  = $input['password'];
        $dados->sms_marketing  = (isset($input['sms_marketing']) ? "S" : "N");
        $dados->sms_corporativo  = (isset($input['sms_corporativo']) ? "S" : "N");
        $dados->whatsapp  = (isset($input['whatsapp']) ? "S" : "N");
        $dados->ddd  = $input['ddd'];

        $dados->save();//-------------FIM - Atualiza Usuario

        \Session::flash('flash_message', 'Dados Atualizados com Sucesso!!!');

        return redirect('home');

    }


}