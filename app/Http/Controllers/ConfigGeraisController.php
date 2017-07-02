<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use URL;
use App\Models\configuracoes;
use Auth;
use Input;
use Validator;
use Gate;

class ConfigGeraisController extends Controller
{

    public function __construct()
    {

        $this->middleware('auth');
        $this->rota = "config_gerais"; //Define nome da rota que será usada na classe

        //Validação de permissão de acesso a pagina
        if (Gate::allows('verifica_permissao', [\Config::get('app.config_gerais'),'acessar']))
        {
            $this->dados_login = \Session::get('dados_login');
        }

    }

    //Exibir listagem
    public function index_json()
    {

        $where = ['empresas_id' => $this->dados_login->empresas_id, 'empresas_clientes_cloud_id' => $this->dados_login->empresas_clientes_cloud_id];

        $dados = configuracoes::where($where)->get();

        return (json_encode($dados));

        //return view($this->rota . '.config_general', ['dados' =>$dados, 'preview' => '', 'tipo_operacao'=> ($dados->count()>0 ? "editar" : "incluir")]);

    }


    //Exibir listagem
    public function index()
    {

        if (\App\ValidacoesAcesso::PodeAcessarPagina(\Config::get('app.' . $this->rota))==false)
        {
              return redirect('home');
        }

        $where = ['empresas_id' => $this->dados_login->empresas_id, 'empresas_clientes_cloud_id' => $this->dados_login->empresas_clientes_cloud_id];

        $dados = configuracoes::where($where)->get();

        //return json_encode($dados);
        return view($this->rota . '.config_general', ['dados' =>$dados, 'preview' => '', 'tipo_operacao'=> ($dados->count()>0 ? "editar" : "incluir")]);


    }


    //Abre tela para edicao ou somente visualização dos registros
    private function exibir ($request, $id, $preview, $perfil)
    {

        $where = ['empresas_id' => $this->dados_login->empresas_id, 'empresas_clientes_cloud_id' => $this->dados_login->empresas_clientes_cloud_id];

        $dados = configuracoes::where($where)->get();

        return view($this->rota . '.config_general', ['dados' =>$dados, 'preview' => $preview]);

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

        $input = $request->except(array('_token')); //não levar o token

        /*Validação de campos - request*/
        $this->validate($request, [
                'label_celulas_singular'=> 'required',
                'label_celulas' => 'required',
                'label_encontros' => 'required',
                'label_lider_singular' => 'required',
                'label_lider_plural' => 'required',
                'label_lider_treinamento' => 'required',
                'label_anfitriao' => 'required',
                'label_participantes' => 'required',
                'label_lider_suplente' => 'required',
                'label_encontros_singular' => 'required'
         ]);

        $dados = configuracoes::findOrfail($id);
        $dados->empresas_id  =  $this->dados_login->empresas_id;
        $dados->empresas_clientes_cloud_id  =  $this->dados_login->empresas_clientes_cloud_id;
      //$dados->padrao_textos  =  $input["padrao_textos"];
        $dados->label_celulas  =  $input["label_celulas"];
        $dados->label_celulas_singular  =  $input["label_celulas_singular"];
        $dados->label_encontros  =  $input["label_encontros"];
        $dados->label_lider_singular  =  $input["label_lider_singular"];
        $dados->label_lider_plural  =  $input["label_lider_plural"];
        $dados->label_lider_treinamento  =  $input["label_lider_treinamento"];
        $dados->label_anfitriao  =  $input["label_anfitriao"];
        $dados->label_participantes  =  $input["label_participantes"];
        $dados->label_lider_suplente  =  $input["label_lider_suplente"];
        $dados->label_encontros_singular  =  $input["label_encontros_singular"];
        $dados->save();

        \Session::flash('flash_message', 'Dados Atualizados com Sucesso!!!');

        return redirect('home');

    }

}