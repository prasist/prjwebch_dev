<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Functions;
use URL;
use Auth;
use Input;
use Gate;

class FuncoesController extends Controller
{

    public function __construct()
    {

        $this->rota = "pessoas"; //Define nome da rota que será usada na classe
        $this->middleware('auth');

        /*Instancia a classe de funcoes (Data, valor, etc)*/
        $this->formatador = new  \App\Functions\FuncoesGerais();


        //Validação de permissão de acesso a pagina
        if (Gate::allows('verifica_permissao', [\Config::get('app.' . $this->rota),'acessar']) || Gate::allows('verifica_permissao', [\Config::get('app.celulas'),'acessar']) || Gate::allows('verifica_permissao', [\Config::get('app.controle_atividades'),'acessar']))
        {
            $this->dados_login = \Session::get('dados_login');
        }

    }

/**
 * Description : Verificar se o CPF ou CNPJ informado já está cadastrado para outra pessoa
 * @param  $id = CPF ou CNPJ passado, tipo de validação (cpf ou cnpj)
 * @return  string = Nome da pessoa (se encontrar)
 */
    public function validar($id)
    {

            /*Instancia biblioteca de funcoes globais*/
            $formatador = new  \App\Functions\FuncoesGerais();
            $cpf_cnpj = $formatador->RetirarCaracteres($id);

            //Verificar se CPF ou CNPJ passado está cadastrado para outra pessoa
            $buscar = \App\Models\pessoas::select('razaosocial')
            ->where('empresas_clientes_cloud_id', $this->dados_login->empresas_clientes_cloud_id)
            ->where('empresas_id', $this->dados_login->empresas_id)
            ->where('cnpj_cpf', $cpf_cnpj)
            ->get();

            if ($buscar)
            {
                return $buscar[0]->razaosocial; //Retorna o nome da pessoa
            }
            else
            {
                return ""; //Retorna vazio
            }

    }

    //VERIFICAR SE A PESSOA PARTICIPA DE ALGUMA CELULA
    public function validar_participante($id)
    {

            $buscar = \App\Models\celulaspessoas::select('id')
            ->where('empresas_clientes_cloud_id', $this->dados_login->empresas_clientes_cloud_id)
            ->where('empresas_id', $this->dados_login->empresas_id)
            ->where('pessoas_id', $id)
            ->get();

            if ($buscar->count()>0)
            {
                return 1; //NAO ACHOU
            }
            else
            {
                return 0; //NAO ACHOU
            }

    }

    public function validar_celulas($id)
    {

            //Verificar se célula existe
            $buscar = \App\Models\celulaspessoas::select('celulas_id')
            ->where('empresas_clientes_cloud_id', $this->dados_login->empresas_clientes_cloud_id)
            ->where('empresas_id', $this->dados_login->empresas_id)
            ->where('celulas_id', $id)
            ->get();

            if ($buscar->count()>0)
            {
                return $buscar[0]->celulas_id;
            }
            else
            {
                return ""; //Retorna vazio
            }
    }

 /*Pesquisa pessoas pelas iniciais da razaosocial passada por parametro*/
    public function buscarpessoa($id)
    {

            $buscar = \App\Models\pessoas::select('id', 'razaosocial')
            ->where('empresas_clientes_cloud_id', $this->dados_login->empresas_clientes_cloud_id)
            ->where('empresas_id', $this->dados_login->empresas_id)
            ->where('razaosocial', 'ilike', '%' . $this->formatador->tirarAcentos($id) . '%')
            ->orderBy('razaosocial')
            ->take(50)
            ->get()->toArray();

            if ($buscar)
            {

                foreach ($buscar as $key => $value)
                {
                    $array[] = str_repeat("0", (9-strlen($value['id']))) . $value['id'] . ' - ' . $value['razaosocial'];
                }

                echo json_encode($array);

            }
            else
            {
                return ""; //Retorna vazio
            }

    }


}