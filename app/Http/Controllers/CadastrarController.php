<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Functions;
use URL;
use Auth;
use DB;
use Input;
use Gate;

class CadastrarController extends Controller
{

        public function __construct()
        {

            if (\App\Models\usuario::find(Auth::user()->id))
            {
                //Busca ID do cliente cloud e ID da empresa
                $this->dados_login = \App\Models\usuario::find(Auth::user()->id);
            }

        }

       /*Busca pela inicial do nome (alfabeto)*/
       public function cadastrar($conteudo)
       {

            if ($conteudo!="")
            {
                $array_parametros = explode("&", htmlspecialchars_decode($conteudo));

                /*Tabelas com estrutura de empresa e clientes cloud*/
                if (trim($array_parametros[0])=="grupos_pessoas" || trim($array_parametros[0])=="planos_contas" || trim($array_parametros[0])=="centros_custos" || trim($array_parametros[0])=="contas")
                {
                     \DB::insert("insert into " . $array_parametros[0] . " (nome, empresas_id, empresas_clientes_cloud_id) values('" . $array_parametros[1] . "', " . $this->dados_login->empresas_id . ", " . $this->dados_login->empresas_clientes_cloud_id . " ) ");
                }
                else
                {
                      \DB::insert("insert into " . $array_parametros[0] . " (nome, clientes_cloud_id) values('" . $array_parametros[1] . "', " . $this->dados_login->empresas_clientes_cloud_id . " ) ");
                }
            }

       }

       /*Busca pela inicial do nome (alfabeto)*/
       public function carregar_tabela($tabela)
       {

                if (trim($tabela)=="grupos_pessoas" || trim($tabela)=="centros_custos" || trim($tabela)=="planos_contas" || trim($tabela)=="contas")
                {
                    $view = \DB::select('select * from ' . $tabela . ' where  empresas_id = ? and empresas_clientes_cloud_id = ? order by nome', [$this->dados_login->empresas_id, $this->dados_login->empresas_clientes_cloud_id]);
                }
                 else
                {
                    $view = \DB::select('select * from ' . $tabela . ' where clientes_cloud_id = ? order by nome', [$this->dados_login->empresas_clientes_cloud_id]);
                }


                $options = array();

                foreach ($view as $item)
                {
                    $options += array($item->id => $item->nome);
                }

                return \Response::json($options);

       }

}