<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use URL;
use App\Models\configuracoes;
use Auth;
use Input;
use Gate;

class ConfiguracoesController extends Controller
{

    public function __construct()
    {

        $this->rota = "configuracoes"; //Define nome da rota que será usada na classe
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

        $dados = configuracoes::select('id', 'celulas_nivel1_label', 'celulas_nivel2_label', 'celulas_nivel3_label', 'celulas_nivel4_label', 'celulas_nivel5_label')
        ->where('empresas_id', $this->dados_login->empresas_id)
        ->where('empresas_clientes_cloud_id', $this->dados_login->empresas_clientes_cloud_id)
        ->get();

        return view($this->rota . '.index',compact('dados'));

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
        $dados = configuracoes::findOrfail($id);
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

      /*Validação de campos - request*/
            $this->validate($request, [
                    'nivel1' => 'required',
                    'nivel2' => 'required',
                    'nivel3' => 'required',
                    'nivel4' => 'required',
                    'nivel5' => 'required',
            ]);

        $input = $request->except(array('_token', 'ativo')); //não levar o token

        $dados = configuracoes::findOrfail($id);

        $dados->empresas_id  = $this->dados_login->empresas_id;
        $dados->empresas_clientes_cloud_id  = $this->dados_login->empresas_clientes_cloud_id;
        $dados->celulas_nivel1_label  = $input['nivel1'];
        $dados->celulas_nivel2_label  = $input['nivel2'];
        $dados->celulas_nivel3_label  = $input['nivel3'];
        $dados->celulas_nivel4_label  = $input['nivel4'];
        $dados->celulas_nivel5_label  = $input['nivel5'];
        $dados->save();

        \Session::flash('flash_message', 'Dados Atualizados com Sucesso!!!');

        return redirect('home');

    }

}