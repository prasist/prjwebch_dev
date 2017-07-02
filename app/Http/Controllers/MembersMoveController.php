<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\membros_movimentacoes;
use URL;
use Auth;
use Input;
use Gate;
use DB;

class MembersMoveController extends Controller
{

    public function __construct()
    {

        $this->rota = "membersmove"; //Define nome da rota que será usada na classe
        $this->middleware('auth');

        /*Instancia a classe de funcoes (Data, valor, etc)*/
        $this->formatador = new  \App\Functions\FuncoesGerais();

        //Validação de permissão de acesso a pagina
        if (Gate::allows('verifica_permissao', [\Config::get('app.' . $this->rota),'acessar']))
        {
            $this->dados_login = \Session::get('dados_login');
        }

        //Verifica se é alguém da liderança (Lider de Rede, Area, Coordenador, Supervisor, etc)
        $this->lideranca = $this->formatador->verifica_se_lideranca();

        $this->id_lideres="";

        //Preenche variavel com os lideres abaixo da hierarquia
        if ($this->lideranca!=null)
        {
             foreach ($this->lideranca as $item) {
                if ($this->id_lideres=="") {
                   $this->id_lideres =  $item->id_lideres;
                } else {
                   $this->id_lideres .=  ", " . $item->id_lideres;
                }
             }
        }

    }


    //Exibir listagem
    public function index()
    {

        if (\App\ValidacoesAcesso::PodeAcessarPagina(\Config::get('app.' . $this->rota))==false)
        {
              return redirect('home');
        }


       $funcoes = new  \App\Functions\FuncoesGerais();

       $lider_logado = $funcoes->verifica_se_lider();

       $motivos = \App\Models\tiposmovimentacao::where('clientes_cloud_id', $this->dados_login->empresas_clientes_cloud_id)->orderBy('nome','ASC')->get();

       //if ($lider_logado!=null)
       //{
       //     $celulas = \DB::select('select id, descricao_concatenada as nome from view_celulas_simples  where lider_pessoas_id = ? and  empresas_id = ? and empresas_clientes_cloud_id = ? ', [$lider_logado[0]->lider_pessoas_id, $this->dados_login->empresas_id, $this->dados_login->empresas_clientes_cloud_id]);
       //} else {
       //     $celulas = \DB::select('select id, descricao_concatenada as nome from view_celulas_simples  where empresas_id = ? and empresas_clientes_cloud_id = ? ', [$this->dados_login->empresas_id, $this->dados_login->empresas_clientes_cloud_id]);
       //}

       $sSql  = " SELECT id, descricao_concatenada as nome FROM view_celulas_simples ";
       $sSql .= " WHERE ";
       $sSql .= " empresas_id = " . $this->dados_login->empresas_id;
       $sSql .= " AND empresas_clientes_cloud_id = " . $this->dados_login->empresas_clientes_cloud_id;

       //Trazer somente celula do lider logado... ou
       if ($lider_logado!=null)
       {
            if ($this->id_lideres!="") {
                $sSql .= " AND lider_pessoas_id IN (" . $lider_logado[0]->lider_pessoas_id . ", " . $this->id_lideres . ")";
            } else {
                $sSql .= " AND lider_pessoas_id IN (" . $lider_logado[0]->lider_pessoas_id . ")";
            }
            //$celulas = \DB::select('select id, descricao_concatenada as nome from view_celulas_simples  where lider_pessoas_id = ? and  empresas_id = ? and empresas_clientes_cloud_id = ? ', [$lider_logado[0]->lider_pessoas_id, $this->dados_login->empresas_id, $this->dados_login->empresas_clientes_cloud_id]);

       } else { //verificar se é alguém da lideranca (supervisor, coordenador, etc) e trazer somente as celulas subordinadas

            if ($this->id_lideres!="") {
                $sSql .= " AND lider_pessoas_id IN (" . $this->id_lideres . ")";
            }
       }

       $celulas = \DB::select($sSql);

        return view($this->rota . '.atualizacao',
            [
                'preview'=>'false',
                'celulas'=>$celulas,
                'motivos'=>$motivos
             ]);

    }

  public function salvar($request, $id, $tipo_operacao)
  {

         /* ------------------ INICIA TRANSACTION -----------------------*/
         \DB::transaction(function() use ($request, $id, $tipo_operacao)
         {

            $input = $request->except(array('_token')); //não levar o token

            $this->validate($request, [
                'celulas' => 'required',
                'data_mov' => 'required',
                'tipos_mov' => 'required',
            ]);

              $descricao_celula = explode("|", $input["celulas"]);
              $descricao_celula_nova = explode("|", $input["celulas_nova"]);


              if (isset($input['topics'])) //PESSOA(S) A SER(EM) ADICIONADA(S) NA NOVA CELULA
              {

                      //PERCORRER LISTA DA NOVA CELULA
                      foreach($input['topics'] as $selected)
                      {

                              if ($selected!="") //PESSOA
                              {
                                   $dados = new membros_movimentacoes();
                                   $dados->empresas_clientes_cloud_id = $this->dados_login->empresas_clientes_cloud_id;
                                   $dados->empresas_id = $this->dados_login->empresas_id;
                                   $dados->celulas_id_atual = $descricao_celula[0];
                                   $dados->celulas_id_nova = $descricao_celula_nova[0];
                                   $dados->data_movimentacao = $this->formatador->FormatarData($input['data_mov']);
                                   $dados->pessoas_id = $selected;
                                   $dados->motivos_id = $input['tipos_mov'];
                                   $dados->observacao = trim($input['obs']);
                                   $dados->save();
                             }


                             //-------------------------------REMOVER CELULA ANTERIOR
                              /*Clausula where padrao para as tabelas auxiliares*/
                             $where =
                             [
                                'empresas_clientes_cloud_id' => $this->dados_login->empresas_clientes_cloud_id,
                                'empresas_id' =>  $this->dados_login->empresas_id,
                                'celulas_id' => $descricao_celula[0],
                                'pessoas_id'=>$selected
                             ];
                             $excluir = \App\Models\celulaspessoas::where($where)->delete();
                             //-------------------------------FIM - REMOVER CELULA ANTERIOR



                             //----------------------------------ADICIONAR CELULA NOVA
                             $whereForEach =
                             [
                                     'empresas_clientes_cloud_id' => $this->dados_login->empresas_clientes_cloud_id,
                                     'empresas_id' =>  $this->dados_login->empresas_id,
                                     'pessoas_id' => $selected,
                                     'celulas_id' => $descricao_celula_nova[0]
                             ];

                              if ($tipo_operacao=="create")  //novo registro
                              {
                                  $dados = new \App\Models\celulaspessoas();
                              }
                              else //Alteracao
                              {
                                  $dados = \App\Models\celulaspessoas::firstOrNew($whereForEach);
                              }

                              $valores =
                              [
                                  'pessoas_id' => $selected,
                                  'empresas_id' =>  $this->dados_login->empresas_id,
                                  'empresas_clientes_cloud_id' => $this->dados_login->empresas_clientes_cloud_id,
                                  'celulas_id' => $descricao_celula_nova[0],
                                  'lider_pessoas_id' => substr($descricao_celula_nova[1],0,9)
                              ];

                              $dados->fill($valores)->save();
                              $dados->save();
                             //----------------------------------FIM ADICIONAR CELULA NOVA


                      } //end for each visitantes

            }

      });// ------------ FIM TRANSACTION

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



}