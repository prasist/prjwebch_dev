<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\celulas;
use URL;
use Auth;
use Input;
use Gate;

class CelulasController extends Controller
{

    public function __construct()
    {



        $this->rota = "celulas"; //Define nome da rota que será usada na classe
        $this->middleware('auth');
        $this->sequencia = 0;
        $this->qtd_acumulada=0;
        $this->pais=array();
        $this->celulas_pai_id=null;
        $this->linha='';
        $this->guarda_id = "";
        $this->qtd=0;

        /*Instancia a classe de funcoes (Data, valor, etc)*/
        $this->formatador = new  \App\Functions\FuncoesGerais();


        //Validação de permissão de acesso a pagina
        //if (Gate::allows('verifica_permissao', [\Config::get('app.' . $this->rota),'acessar']) || Gate::allows('verifica_permissao', [\Config::get('app.controle_atividades'),'acessar'])) //
        if (\App\ValidacoesAcesso::PodeAcessarPagina(\Config::get('app.controle_atividades')) || \App\ValidacoesAcesso::PodeAcessarPagina(\Config::get('app.celulas')))

        {

            $this->dados_login = \Session::get('dados_login');


            //Verificar se usuario logado é LIDER
            $this->lider_logado = $this->formatador->verifica_se_lider();

            //Verifica se é alguém da liderança (Lider de Rede, Area, Coordenador, Supervisor, etc)
            $this->lideranca = $this->formatador->verifica_se_lideranca();

            $this->id_lideres="";

            //Preenche variavel com os lideres abaixo da hierarquia
            if ($this->lideranca!=null) {
                 foreach ($this->lideranca as $item) {
                    if ($this->id_lideres=="") {
                       $this->id_lideres =  $item->id_lideres;
                    } else {
                       $this->id_lideres .=  ", " . $item->id_lideres;
                    }
                 }
            }


            //Verifica se é alguém da liderança (Lider de Rede, Area, Coordenador, Supervisor, etc) e retorna os niveis correspondentes
            $this->permissao_lideranca = $this->formatador->verifica_niveis_permitidos();

            $this->id_niveis1="";
            $this->id_niveis2="";
            $this->id_niveis3="";
            $this->id_niveis4="";
            $this->id_niveis5="";

            //Preenche variavel com os lideres abaixo da hierarquia
            if ($this->permissao_lideranca!=null) {
                 foreach ($this->permissao_lideranca as $item) {

                    //NIVEL 1
                    if ($this->id_niveis1=="") {
                       $this->id_niveis1 =  $item->n1;
                    } else {
                       $this->id_niveis1 .=  ", " . $item->n1;
                    }

                    //NIVEL 2
                    if ($this->id_niveis2=="") {
                       $this->id_niveis2 =  $item->n2;
                    } else {
                       $this->id_niveis2 .=  ", " . $item->n2;
                    }

                    //NIVEL 3
                    if ($this->id_niveis3=="") {
                       $this->id_niveis3=  $item->n3;
                    } else {
                       $this->id_niveis3 .=  ", " . $item->n3;
                    }

                    //NIVEL 4
                    if ($this->id_niveis4=="") {
                       $this->id_niveis4=  $item->n4;
                    } else {
                       $this->id_niveis4 .=  ", " . $item->n4;
                    }

                    //NIVEL 5
                    if ($this->id_niveis5=="") {
                       $this->id_niveis5=  $item->n5;
                    } else {
                       $this->id_niveis5 .=  ", " . $item->n5;
                    }

                 }
            }


        }

    }

    /**//**
    * Description : load data from select 'local of meeting'
    * @return var JSON
    */
    public function loadSelect() {
        $users = \App\Models\users::select('id', 'name')->get();
        return json_encode($users);
    }

    public function getEstruturas()
    {

            //Busca primeiro nivel das estruturas
            $strSql = " SELECT DISTINCT nome_1, celulas_nivel1_id, foto1  FROM view_estruturas";
            $strSql .=  " WHERE ";
            $strSql .=  " empresas_id = " . $this->dados_login->empresas_id . " AND ";
            $strSql .=  " empresas_clientes_cloud_id = " . $this->dados_login->empresas_clientes_cloud_id . "  ";

            $level1 = \DB::select($strSql);

            $linha = "<h5><ul class='treeview2'>";
            foreach ($level1 as $key => $value)
            {

                   //NIVEL1
                   $linha .= "      <li>";

                   if  ($value->foto1!="") {
                        $linha .= "<img src='./images/persons/" . $value->foto1 . "' class='img-circle' width='40' height='40' alt='Pessoa' />";
                   }


                   $linha .= "             <i class='fa  fa-sitemap'></i>&nbsp;<a href='#'>" . $value->nome_1 . "</a>";
                   //$linha .= "             (<i class='fa fa-print'></i>&nbsp;<a href='#' onclick='abrir_relatorio_nivel(1, 1, " . $value->celulas_nivel1_id . ");'>Resumo</a>)";


                   $linha .= '  <select id="tiporelatorio[]"  name="tiporelatorio[]" onchange="changeFunc(this, 1, ' . $value->celulas_nivel1_id . ', \'' . $value->nome_1 . '\');"> ';
                   $linha .= '        <option  value="">Relatórios Disponíveis...</option>';
                   $linha .= '        <option  value="1">Resumo Células Geral</option>';
                   $linha .= '        <option  value="2">Batismos (Anual - Últimos 5 anos)</option>';
                   $linha .= '        <option  value="3">Batismos (Mensal - Ano Corrente)</option>';
                   $linha .= '        <option  value="4">Multiplicação (Anual - Últimos 5 anos)</option>';
                   $linha .= '        <option  value="5">Multiplicação (Mensal - Ano Corrente)</option>';
                   $linha .= '  </select>';


                           //---------------------------------------------NIVEL2-----------------------------------------------------
                           $strSql = " SELECT Distinct nome_2, celulas_nivel2_id, celulas_nivel1_id, foto2 FROM view_estruturas";
                           $strSql .=  " WHERE ";
                           $strSql .=  " empresas_id = " . $this->dados_login->empresas_id . " AND ";
                           $strSql .=  " empresas_clientes_cloud_id = " . $this->dados_login->empresas_clientes_cloud_id . "  ";
                           $strSql .=  " AND celulas_nivel1_id = " . $value->celulas_nivel1_id;
                           $level2 = \DB::select($strSql);

                            $linha .= "<ul>";
                            foreach ($level2 as $key => $value)
                            {

                                 $linha .= "      <li>";

                                 if  ($value->foto2!="") {
                                        $linha .= "<img src='./images/persons/" . $value->foto2 . "' class='img-circle' width='40' height='40' alt='Pessoa' />";
                                 }

                                  $linha .= "             <i class='fa  fa-user'></i>&nbsp;<a href='#'>" . $value->nome_2 . "</a>";
                                  //$linha .= "             (<i class='fa fa-print'></i>&nbsp;<a href='#' onclick='abrir_relatorio_nivel(1, 2, " . $value->celulas_nivel2_id . ");'>Resumo</a>)";

                                   $linha .= '  <select id="tiporelatorio[]"  name="tiporelatorio[]" onchange="changeFunc(this, 2, ' . $value->celulas_nivel2_id . ', \'' . $value->nome_2 . '\');"> ';
                                   $linha .= '        <option  value="">Relatórios Disponíveis...</option>';
                                   $linha .= '        <option  value="1">Resumo Células Geral</option>';
                                   $linha .= '        <option  value="2">Batismos (Anual - Últimos 5 anos)</option>';
                                   $linha .= '        <option  value="3">Batismos (Mensal - Ano Corrente)</option>';
                                   $linha .= '        <option  value="4">Multiplicação (Anual - Últimos 5 anos)</option>';
                                   $linha .= '        <option  value="5">Multiplicação (Mensal - Ano Corrente)</option>';
                                   $linha .= '  </select>';

                                   //NIVEL3
                                   $strSql = " SELECT Distinct nome_3, celulas_nivel3_id, celulas_nivel2_id, celulas_nivel1_id, foto3 FROM view_estruturas";
                                   $strSql .=  " WHERE ";
                                   $strSql .=  " empresas_id = " . $this->dados_login->empresas_id . " AND ";
                                   $strSql .=  " empresas_clientes_cloud_id = " . $this->dados_login->empresas_clientes_cloud_id . "  ";
                                   $strSql .=  " AND celulas_nivel2_id = " . $value->celulas_nivel2_id;

                                    $level3 = \DB::select($strSql);

                                    $linha .= "<ul>";
                                    foreach ($level3 as $key => $value)
                                    {

                                         $linha .= "      <li>";

                                         if  ($value->foto3!="") {
                                                $linha .= "<img src='./images/persons/" . $value->foto3 . "' class='img-circle' width='40' height='40' alt='Pessoa' />";
                                         }

                                         $linha .= "             <i class='fa  fa-user'></i>&nbsp;<a href='#'>" . $value->nome_3 . "</a>";
                                          //$linha .= "             (<i class='fa fa-print'></i>&nbsp;<a href='#' onclick='abrir_relatorio_nivel(1, 3, " . $value->celulas_nivel3_id . ");'>Resumo</a>)";

                                         $linha .= '  <select id="tiporelatorio[]"  name="tiporelatorio[]" onchange="changeFunc(this, 3, ' . $value->celulas_nivel3_id . ', \'' . $value->nome_3 . '\');"> ';
                                         $linha .= '        <option  value="">Relatórios Disponíveis...</option>';
                                         $linha .= '        <option  value="1">Resumo Células Geral</option>';
                                         $linha .= '        <option  value="2">Batismos (Anual - Últimos 5 anos)</option>';
                                         $linha .= '        <option  value="3">Batismos (Mensal - Ano Corrente)</option>';
                                         $linha .= '        <option  value="4">Multiplicação (Anual - Últimos 5 anos)</option>';
                                         $linha .= '        <option  value="5">Multiplicação (Mensal - Ano Corrente)</option>';
                                         $linha .= '  </select>';


                                           //NIVEL4
                                          $strSql = " SELECT Distinct nome_4, celulas_nivel4_id, celulas_nivel3_id, celulas_nivel2_id, celulas_nivel1_id,foto4 FROM view_estruturas";
                                          $strSql .=  " WHERE ";
                                          $strSql .=  " empresas_id = " . $this->dados_login->empresas_id . " AND ";
                                          $strSql .=  " empresas_clientes_cloud_id = " . $this->dados_login->empresas_clientes_cloud_id . "  ";
                                          $strSql .=  " AND celulas_nivel3_id = " . $value->celulas_nivel3_id;

                                          $level4 = \DB::select($strSql);

                                            $linha .= "<ul>";
                                            foreach ($level4 as $key => $value)
                                            {

                                                  $linha .= "      <li>";

                                                 if  ($value->foto4!="") {
                                                      $linha .= "<img src='./images/persons/" . $value->foto4 . "' class='img-circle' width='40' height='40' alt='Pessoa' />";
                                                 }

                                                  $linha .= "             <i class='fa  fa-user'></i>&nbsp;<a href='#'>" . $value->nome_4 . "</a>";
                                                  //$linha .= "             (<i class='fa fa-print'></i>&nbsp;<a href='#' onclick='abrir_relatorio_nivel(1, 4, " . $value->celulas_nivel4_id . ");'>Resumo</a>)";

                                                  $linha .= '  <select id="tiporelatorio[]"  name="tiporelatorio[]" onchange="changeFunc(this, 4, ' . $value->celulas_nivel4_id . ', \'' . $value->nome_4 . '\');"> ';
                                                  $linha .= '        <option  value="">Relatórios Disponíveis...</option>';
                                                  $linha .= '        <option  value="1">Resumo Células Geral</option>';
                                                  $linha .= '        <option  value="2">Batismos (Anual - Últimos 5 anos)</option>';
                                                  $linha .= '        <option  value="3">Batismos (Mensal - Ano Corrente)</option>';
                                                  $linha .= '        <option  value="4">Multiplicação (Anual - Últimos 5 anos)</option>';
                                                  $linha .= '        <option  value="5">Multiplicação (Mensal - Ano Corrente)</option>';
                                                  $linha .= '  </select>';

                                                           //NIVEL5
                                                           $strSql = " SELECT Distinct nome, id, celulas_nivel4_id, celulas_nivel3_id, celulas_nivel2_id, celulas_nivel1_id,foto5 FROM view_estruturas";
                                                           $strSql .=  " WHERE ";
                                                           $strSql .=  " empresas_id = " . $this->dados_login->empresas_id . " AND ";
                                                           $strSql .=  " empresas_clientes_cloud_id = " . $this->dados_login->empresas_clientes_cloud_id . "  ";
                                                           $strSql .=  " AND celulas_nivel4_id = " . $value->celulas_nivel4_id;

                                                            $level5 = \DB::select($strSql);

                                                            $linha .= "<ul>";
                                                            foreach ($level5 as $key => $value)
                                                            {

                                                                  $linha .= "      <li>";

                                                                  if  ($value->foto5!="")
                                                                  {
                                                                        $linha .= "<img src='./images/persons/" . $value->foto5 . "' class='img-circle' width='40' height='40' alt='Pessoa' />";
                                                                  }

                                                                  $linha .= "           <i class='fa  fa-users'></i>&nbsp;<a href='#'>" . $value->nome . "</a>";
                                                                  //$linha .= "             (<i class='fa fa-print'></i>&nbsp;<a href='#' onclick='abrir_relatorio_nivel(1, 5, " . $value->id . ");'>Resumo</a>)";

                                                                   $linha .= '  <select id="tiporelatorio[]"  name="tiporelatorio[]" onchange="changeFunc(this, 1, ' . $value->id . ', \'' . $value->nome . '\');"> ';
                                                                   $linha .= '        <option  value="">Relatórios Disponíveis...</option>';
                                                                   $linha .= '        <option  value="1">Resumo Células Geral</option>';
                                                                   $linha .= '        <option  value="2">Batismos (Anual - Últimos 5 anos)</option>';
                                                                   $linha .= '        <option  value="3">Batismos (Mensal - Ano Corrente)</option>';
                                                                   $linha .= '        <option  value="4">Multiplicação (Anual - Últimos 5 anos)</option>';
                                                                   $linha .= '        <option  value="5">Multiplicação (Mensal - Ano Corrente)</option>';
                                                                   $linha .= '  </select>';

                                                                              //LIDERES
                                                                               $strSql = " SELECT celulas.nome,  lider_pessoas_id, razaosocial , caminhofoto, ";
                                                                               $strSql .=  " ( SELECT count(cp.pessoas_id) AS count ";
                                                                               $strSql .=  "     FROM celulas_pessoas cp ";
                                                                               $strSql .=  "       JOIN celulas c ON cp.celulas_id = c.id AND cp.empresas_id = c.empresas_id AND cp.empresas_clientes_cloud_id = c.empresas_clientes_cloud_id ";
                                                                               $strSql .=  "    WHERE cp.empresas_id = celulas.empresas_id AND cp.empresas_clientes_cloud_id = celulas.empresas_clientes_cloud_id AND cp.celulas_id = celulas.id) AS tot ";
                                                                               $strSql .=  "    , ";
                                                                               $strSql .=  "     ( SELECT count(mh.pessoas_id) AS count      ";
                                                                               $strSql .=  "     FROM celulas_pessoas cp          ";
                                                                               $strSql .=  "     JOIN celulas c ON cp.celulas_id = c.id AND cp.empresas_id = c.empresas_id AND cp.empresas_clientes_cloud_id = c.empresas_clientes_cloud_id     ";
                                                                               $strSql .=  "     JOIN membros_historicos mh ON mh.pessoas_id = cp.pessoas_id AND mh.empresas_id = cp.empresas_id AND mh.empresas_clientes_cloud_id = cp.empresas_clientes_cloud_id     ";
                                                                               $strSql .=  "     WHERE mh.empresas_id = celulas.empresas_id AND mh.empresas_clientes_cloud_id = celulas.empresas_clientes_cloud_id AND cp.celulas_id = celulas.id and isnull(mh.data_batismo,'') = '') AS tot_batizados  ";
                                                                               $strSql .=  " from celulas";
                                                                               $strSql .=  " inner join pessoas on pessoas.id = celulas.lider_pessoas_id ";
                                                                               $strSql .=  " WHERE ";
                                                                               $strSql .=  " celulas.empresas_id = " . $this->dados_login->empresas_id . " AND ";
                                                                               $strSql .=  " celulas.empresas_clientes_cloud_id = " . $this->dados_login->empresas_clientes_cloud_id . "  ";
                                                                               $strSql .=  " AND celulas_nivel5_id = " . $value->id;
                                                                               $strSql .=  " order by razaosocial ";

                                                                               $lideres = \DB::select($strSql);


                                                                                $linha .= "<ul>";
                                                                                foreach ($lideres as $key => $value)
                                                                                {
                                                                                      $linha .= "      <li>";

                                                                                      if  ($value->caminhofoto!="")
                                                                                      {
                                                                                             $linha .= "<img src='./images/persons/" . $value->caminhofoto . "' class='img-circle' width='40' height='40' alt='Pessoa' />";
                                                                                      }

                                                                                      $linha .= "        <a href='#' title='List: '>" . $value->nome . ' - ' . $value->razaosocial .  "<span class='pull-right badge bg-yellow'>" . $value->tot_batizados . " batizados.</span><span class='pull-right badge bg-green'>" . $value->tot . " participantes.</span></a>";
                                                                                      $linha .= "        ";
                                                                                      $linha .= "     </li>";
                                                                                }
                                                                                $linha .= "</ul>";

                                                                  $linha .= "     </li>";

                                                            }
                                                            $linha .= "</ul>";

                                                    $linha .= "     </li>";
                                            }
                                            $linha .= "</ul>";

                                         $linha .= "     </li>";
                                    }

                                    $linha .= "</ul>";
                                $linha .= "     </li>";

                            }
                            $linha .= "</ul>";

                $linha .= "     </li>";
            }

            $linha .= "</ul></h5>";

        return $linha;

    }


 //Lista celulas filhas e filhas das filhas das filhas,,,, enquanto houverem
   protected function retorna_filho($celulas_id, $pai)
   {

            $this->gerar_proximo_nivel = "";

            //BUSCA AS CELULAS FILHOS DE UM DETERMINADO PAI
            $strSql = " SELECT celulas_pai_id, celulas.Id, nome, razaosocial , caminhofoto, origem, ";
            $strSql .= " CASE  WHEN nome <> ''::text AND razaosocial <> ''::text THEN (nome || ' - '::text) || razaosocial ";
            $strSql .= "       ELSE COALESCE(razaosocial, nome) ";
            $strSql .= "       END AS nome";
            $strSql .=  " FROM  celulas ";
            $strSql .=  " INNER JOIN pessoas on pessoas.id = celulas.lider_pessoas_id AND pessoas.empresas_id = celulas.empresas_id AND pessoas.empresas_clientes_cloud_id = celulas.empresas_clientes_cloud_id";
            $strSql .=  " WHERE ";
            $strSql .=  " isnull_int(celulas_pai_id ,0) = " . $celulas_id . " AND ";
            $strSql .=  " celulas.empresas_id = " . $this->dados_login->empresas_id . " AND ";
            $strSql .=  " celulas.empresas_clientes_cloud_id = " . $this->dados_login->empresas_clientes_cloud_id . "  ";

            $retornar = \DB::select($strSql);

            foreach ($retornar as $key => $value)
            {

                  //Verificar se a celula filha tem PAI
                  $this->gerar_proximo_nivel = $value->id;

                  //PEGA SOMENTE O PAIZAO... QUEM INICIOU TUDO
                  $this->celulas_pai_id = $value->celulas_pai_id;

                  //SE TIVER OUTRO FILHO, GERA NOVAMENTE (EXECUTA NOVAMENTE A FUNCTION ATÉ NAO EXISTIR MAIS FILHOS/NETOS)
                  if ($this->gerar_proximo_nivel!="")
                  {
                     $this->guarda_id = $this->guarda_id . ", " . $this->gerar_proximo_nivel;
                     $exec = $this->retorna_filho($this->gerar_proximo_nivel, $this->celulas_pai_id);
                  }

            }

   }




   //Lista celulas filhas e suas filhas,,,, enquanto houverem
   protected function buscaProximoNivel($celulas_id, $pai)
   {

            $this->gerar_proximo_nivel = "";

            //BUSCA AS CELULAS FILHOS DE UM DETERMINADO PAI
            $strSql = " SELECT celulas_pai_id, celulas.Id, nome, razaosocial , caminhofoto, origem, ";
            $strSql .= " CASE  WHEN nome <> ''::text AND razaosocial <> ''::text THEN (nome || ' - '::text) || razaosocial ";
            $strSql .= "       ELSE COALESCE(razaosocial, nome) ";
            $strSql .= "       END AS nome";
            $strSql .=  " FROM  celulas ";
            $strSql .=  " INNER JOIN pessoas on pessoas.id = celulas.lider_pessoas_id AND pessoas.empresas_id = celulas.empresas_id AND pessoas.empresas_clientes_cloud_id = celulas.empresas_clientes_cloud_id";
            $strSql .=  " WHERE ";
            $strSql .=  " isnull_int(celulas_pai_id ,0) = " . $celulas_id . " AND ";
            $strSql .=  " celulas.empresas_id = " . $this->dados_login->empresas_id . " AND ";
            $strSql .=  " celulas.empresas_clientes_cloud_id = " . $this->dados_login->empresas_clientes_cloud_id . "  ";

            $retornar = \DB::select($strSql);

            //ABRE NOVA TAG E CONTABILIZA SE ENCONTRAR FILHOS
            if (count($retornar)>0)
            {
                $this->linha .= "<ul>";
                $this->sequencia = $this->sequencia + 1;
            }


            foreach ($retornar as $key => $value)
            {
                  $this->linha .= "      <li>";

                  if  (rtrim(ltrim($value->caminhofoto))!="")
                  {
                         $this->linha .= "<img src='./images/persons/" . $value->caminhofoto . "' class='img-circle' width='40' height='40' alt='Pessoa' />";
                  }

                  //$this->linha .= "        <a href='#'>" .  $value->razaosocial .  ' - ' . ($value->origem==1 ? "Multiplicação" : "Vínculo (ou Célula Filha)") . " Pai-> " . $value->celulas_pai_id . "</a>";
                  $this->linha .= "        <a href='#'>" .  $value->razaosocial .  ' - ' . ($value->origem==1 ? "Multiplicação" : "Vínculo (ou Célula Filha)") . "</a>";

                  //Verificar se a celula filha tem PAI
                  $this->gerar_proximo_nivel = $value->id;

                  //PEGA SOMENTE O PAIZAO... QUEM INICIOU TUDO
                  $this->celulas_pai_id = $value->celulas_pai_id;

                  $this->pais[] = $value->celulas_pai_id;

                  //SE TIVER OUTRO FILHO, GERA NOVAMENTE (EXECUTA NOVAMENTE A FUNCTION ATÉ NAO EXISTIR MAIS FILHOS/NETOS)
                  if ($this->gerar_proximo_nivel!="")
                  {

                     $mesmo_pai = array_search($value->celulas_pai_id, $this->pais);
                     $mais = $this->buscaProximoNivel($this->gerar_proximo_nivel, $this->celulas_pai_id);

                     if ($mesmo_pai!=null)
                     {
                            //NAO TEM  MAIS NIVEIS, FECHAS AS TAGS
                            //for ($i=$this->sequencia; $i >1 ; $i--)
                            //{
                                  $this->linha .= "     </li>";
                                  $this->linha .= "</ul>";
                                  //$this->linha .= "<ul>";
                                  //$this->linha .= "<li>";
                            //}
                            $mais="";
                     }
                     //dd($mais);
                  }
                  else
                  {
                    //NAO TEM  MAIS NIVEIS, FECHAS AS TAGS
                      for ($i=$this->sequencia; $i >1 ; $i--)
                      {
                            $this->linha .= "     </li>";
                            $this->linha .= "</ul>";
                      }

                      $mais="";
                  }

            }

            /*
            //SE TIVER OUTRO FILHO, GERA NOVAMENTE (EXECUTA NOVAMENTE A FUNCTION ATÉ NAO EXISTIR MAIS FILHOS/NETOS)
            if ($this->gerar_proximo_nivel!="")
            {
               $mais = $this->buscaProximoNivel($this->gerar_proximo_nivel);
               dd($mais);
            }
            else
            {
              //NAO TEM  MAIS NIVEIS, FECHAS AS TAGS
                for ($i=$this->sequencia; $i >1 ; $i--) {
                      $this->linha .= "     </li>";
                      $this->linha .= "</ul>";
                }

                $mais="";
            }
            */

   }


   public function pegarSomenteId($celulas_id)
    {

            $strSql = " SELECT celulas.id ";
            $strSql .=  " FROM  celulas ";
            $strSql .=  " WHERE ";
            $strSql .=  " celulas.id = " . $celulas_id . " AND ";
            $strSql .=  " celulas.empresas_id = " . $this->dados_login->empresas_id . " AND ";
            $strSql .=  " celulas.empresas_clientes_cloud_id = " . $this->dados_login->empresas_clientes_cloud_id . "  ";

            $retornar = \DB::select($strSql);

            $this->guarda_id = $celulas_id; //GUARDA NO ARRAY O ID DA CELULA MATRIZ


            if (count($retornar)>0)
                $this->retorna_filho($retornar[0]->id, ''); //ACRESCENTA NO ARRAY TODOS OS FILHOS...

    }



    //MONTA ARVORE HIERARQUICA DE MULTIPLICACOES E CELULAS FILHAS...
    public function getEstruturasCelulasOrigem($celulas_id)
    {


            $strSql = " SELECT caminhofoto, ";
            $strSql .= " CASE  WHEN nome <> ''::text AND razaosocial <> ''::text THEN (nome || ' - '::text) || razaosocial ";
            $strSql .= "       ELSE COALESCE(razaosocial, nome) ";
            $strSql .= "       END AS nome";
            $strSql .=  " FROM  celulas ";
            $strSql .=  " INNER JOIN pessoas on pessoas.id = celulas.lider_pessoas_id ";
            $strSql .=  " WHERE ";
            $strSql .=  " celulas.id = " . $celulas_id . " AND ";
            $strSql .=  " celulas.empresas_id = " . $this->dados_login->empresas_id . " AND ";
            $strSql .=  " celulas.empresas_clientes_cloud_id = " . $this->dados_login->empresas_clientes_cloud_id . "  ";

            $retornar = \DB::select($strSql);

            $this->linha = "<h3 class='box-title'>Árvore Hierárquica da Célula (Multiplicação / Vínculos)</h3>&nbsp;(<i class='text'>Clique para expandir</i>)";
            $this->linha .= "<h5><ul class='treeview2'>";

            $this->linha .= "      <li>";

            if  ($retornar[0]->caminhofoto!="")
            {
                   $this->linha .= "      <img src='./images/persons/" . $retornar[0]->caminhofoto . "' class='img-circle' width='40' height='40' alt='Pessoa' />";
            }

            $this->linha .= "                   <a href='#'>" . $retornar[0]->nome .  "</a>";

            //GERA NIVEIS FILHOS
            $niveis = $this->buscaProximoNivel($celulas_id, '');

            //Finaliza
            $this->linha .= "</h5>";

            //Não exibir se não houverem niveis abaixo
            if ($this->sequencia ==0)
            {
               $this->linha = '';
            }
            return $this->linha;
    }


    public function buscar_dados($id)
    {

            $buscar = \App\Models\celulas::select('dia_encontro')
            ->where('empresas_clientes_cloud_id', $this->dados_login->empresas_clientes_cloud_id)
            ->where('empresas_id', $this->dados_login->empresas_id)
            ->where('id', $id)
            ->get();

            if ($buscar)
            {
                return $buscar[0]->dia_encontro;
            }
            else
            {
                return ""; //Retorna vazio
            }

    }

    //Verifica se houve encontro avulso para a celula / mes / ano
    public function buscar_data_avulsa($id, $mes, $ano)
    {
            $buscar = \App\Models\controle_atividades::select('data_encontro')
            ->where('empresas_clientes_cloud_id', $this->dados_login->empresas_clientes_cloud_id)
            ->where('empresas_id', $this->dados_login->empresas_id)
            ->where('encontro_avulso', 1)
            ->where('mes', $mes)
            ->where('ano', $ano)
            ->where('celulas_id', $id)
            ->get();

            /*
            if ($buscar->count()>0)
            {
                return date("d/m/Y", strtotime($buscar[0]->data_encontro));
            }
            else
            {
                return ""; //Retorna vazio
            }
            */

            if ($buscar->count()>0) {
                return $buscar;
            } else {
                return ""; //Retorna vazio
            }
    }


   public function buscar_segundo_dia_encontro($id)
    {

            $buscar = \App\Models\celulas::select('segundo_dia_encontro')
            ->where('empresas_clientes_cloud_id', $this->dados_login->empresas_clientes_cloud_id)
            ->where('empresas_id', $this->dados_login->empresas_id)
            ->where('id', $id)
            ->get();

            if ($buscar)
            {
                return $buscar[0]->segundo_dia_encontro;
            }
            else
            {
                return ""; //Retorna vazio
            }

    }

  protected function participantes_presenca () {

        $strSql  = " SELECT * FROM view_participantes_celula_ultima_presenca" ;
        $strSql .= " WHERE ";
        $strSql .= " empresas_id = " . $this->dados_login->empresas_id . " AND ";
        $strSql .= " empresas_clientes_cloud_id = " . $this->dados_login->empresas_clientes_cloud_id . "  ";

        //SE for lider, direciona para dashboard da célula
        if ($this->lider_logado!=null) {
            $strSql .=  " AND lider_pessoas_id  = '" . $this->lider_logado[0]->lider_pessoas_id . "'";
        }

        $participantes_presenca = \DB::select($strSql);
        return $participantes_presenca;

  }

  protected function resumo_perguntas($mes, $ano)  {

            //RESUMO por Respostas
            $strSql = " SELECT c.empresas_id, c.empresas_clientes_cloud_id, ca.mes, ca.ano, qe.pergunta, ";
            $strSql .=  " sum(cast(resposta as int)) as total ";
            $strSql .=  " FROM controle_atividades ca  ";
            $strSql .=  " inner join celulas c on c.id = ca.celulas_id ";
            //$strSql .=  " inner join pessoas p on p.id = ca.lider_pessoas_id ";
            $strSql .=  " inner join controle_questions cq on cq.controle_atividades_id = ca.id and cq.empresas_id = ca.empresas_id and cq.empresas_clientes_cloud_id = ca.empresas_clientes_cloud_id ";
            $strSql .=  " inner join questionarios_encontros qe on qe.id = cq.questionarios_id ";
            $strSql .=  " where qe.tipo_resposta = 2  and cq.resposta is not null and cq.resposta <> '' AND ";
            $strSql .=  " ca.empresas_id = " . $this->dados_login->empresas_id . " AND ";
            $strSql .=  " ca.empresas_clientes_cloud_id = " . $this->dados_login->empresas_clientes_cloud_id . " AND ";
            $strSql .=  " ca.mes  = '" . $mes . "' AND ";
            $strSql .=  " ca.ano  = '" . $ano . "'";

            //Busca LIDERES, se for lider logado retorna somente dados dele mesmo
            if ($this->lider_logado!=null) {
                if ($this->id_lideres!="") {
                    $strSql .=  " AND ca.lider_pessoas_id  in (" . $this->lider_logado[0]->lider_pessoas_id . "," . $this->id_lideres . ")";
                }else {
                    $strSql .=  " AND ca.lider_pessoas_id  in (" . $this->lider_logado[0]->lider_pessoas_id . ")";
                }
            }

            //O usuario logado é da liderança
            if ($this->lider_logado==null && $this->id_lideres!="") {
                $strSql .=  " AND ca.lider_pessoas_id  in (" . $this->id_lideres . ")";
            }

            $strSql .=  " group by c.empresas_id, c.empresas_clientes_cloud_id, ca.mes, ca.ano, qe.pergunta ";

            $resumo_perguntas = \DB::select($strSql);
            return $resumo_perguntas;
  }

    protected function resumo_tipo_pessoas($mes, $ano, $opcao)
    {

           //RESUMO POR TIPO DE PESSOA
            if ($opcao=="Geral")
            {

                $strSql = " SELECT c.empresas_id, c.empresas_clientes_cloud_id, tp.nome,  count(*) as total";
                $strSql .=  " from celulas_pessoas ca   ";
                $strSql .=  " inner join celulas c on c.id = ca.celulas_id ";
                $strSql .=  " inner join pessoas p on p.id = ca.pessoas_id ";
                $strSql .=  " inner join tipos_pessoas tp on tp.id = p.tipos_pessoas_id ";
                $strSql .=  " WHERE ";
                $strSql .=  " ca.empresas_id = " . $this->dados_login->empresas_id . " AND ";
                $strSql .=  " ca.empresas_clientes_cloud_id = " . $this->dados_login->empresas_clientes_cloud_id . "";

                //Busca LIDERES, se for lider logado retorna somente dados dele mesmo
                if ($this->lider_logado!=null) {
                    if ($this->id_lideres!="") {
                        $strSql .=  " AND c.lider_pessoas_id  in (" . $this->lider_logado[0]->lider_pessoas_id . "," . $this->id_lideres . ")";
                    }else {
                        $strSql .=  " AND c.lider_pessoas_id  in (" . $this->lider_logado[0]->lider_pessoas_id . ")";
                    }
                }

                //O usuario logado é da liderança
                if ($this->lider_logado==null && $this->id_lideres!="") {
                    $strSql .=  " AND c.lider_pessoas_id  in (" . $this->id_lideres . ")";
                }

                $strSql .=  " group by c.empresas_id, c.empresas_clientes_cloud_id, tp.nome ";

            }
            else
            {
                //POR  PESSOA MES E ANO ESPECIFICOS
                $strSql = " SELECT c.empresas_id, c.empresas_clientes_cloud_id, ca.mes, ca.ano, tp.nome, ";
                $strSql .=  " sum(total) as total ";
                $strSql .=  " from controle_atividades ca ";
                $strSql .=  " inner join celulas c on c.id = ca.celulas_id ";
                $strSql .=  " inner join pessoas p on p.id = ca.pessoas_id ";
                $strSql .=  " inner join controle_resumo_tipo_pessoa cr on cr.controle_atividades_id = ca.id ";
                $strSql .=  " inner join tipos_pessoas tp on tp.id = cr.tipos_pessoas_id ";
                $strSql .=  " WHERE ";
                $strSql .=  " ca.empresas_id = " . $this->dados_login->empresas_id . " AND ";
                $strSql .=  " ca.empresas_clientes_cloud_id = " . $this->dados_login->empresas_clientes_cloud_id . " AND ";
                $strSql .=  " ca.mes  = '" . $mes . "' AND ";
                $strSql .=  " ca.ano  = '" . $ano . "'";

                //Busca LIDERES, se for lider logado retorna somente dados dele mesmo
                if ($this->lider_logado!=null) {
                    if ($this->id_lideres!="") {
                        $strSql .=  " AND c.lider_pessoas_id  in (" . $this->lider_logado[0]->lider_pessoas_id . "," . $this->id_lideres . ")";
                    }else {
                        $strSql .=  " AND c.lider_pessoas_id  in (" . $this->lider_logado[0]->lider_pessoas_id . ")";
                    }
                }

                //O usuario logado é da liderança
                if ($this->lider_logado==null && $this->id_lideres!="") {
                    $strSql .=  " AND c.lider_pessoas_id  in (" . $this->id_lideres . ")";
                }

                $strSql .=  " group by c.empresas_id, c.empresas_clientes_cloud_id, ca.mes, ca.ano, tp.nome ";
            }

            $resumo_tipo_pessoas = \DB::select($strSql);

            return $resumo_tipo_pessoas;


    }

    protected function resumo_geral($mes, $ano) {
            //RESUMO GERAL - total geral de presentes
            $strSql = " SELECT sum(total) as total ";
            $strSql .=  " FROM controle_atividades ca  ";
            $strSql .=  " inner join celulas c on c.id = ca.celulas_id ";
            //$strSql .=  " inner join pessoas p on p.id = ca.lider_pessoas_id ";
            $strSql .=  " inner join controle_resumo_tipo_pessoa cr on cr.controle_atividades_id = ca.id ";
            $strSql .=  " WHERE ";
            $strSql .=  " ca.empresas_id = " . $this->dados_login->empresas_id . " AND ";
            $strSql .=  " ca.empresas_clientes_cloud_id = " . $this->dados_login->empresas_clientes_cloud_id . " AND ";
            $strSql .=  " ca.mes  = '" . $mes . "' AND ";
            $strSql .=  " ca.ano  = '" . $ano . "'";

            //Busca LIDERES, se for lider logado retorna somente dados dele mesmo
            if ($this->lider_logado!=null) {
                if ($this->id_lideres!="") {
                    $strSql .=  " AND ca.lider_pessoas_id  in (" . $this->lider_logado[0]->lider_pessoas_id . "," . $this->id_lideres . ")";
                }else {
                    $strSql .=  " AND ca.lider_pessoas_id  in (" . $this->lider_logado[0]->lider_pessoas_id . ")";
                }
            }

            //O usuario logado é da liderança
            if ($this->lider_logado==null && $this->id_lideres!="") {
                $strSql .=  " AND ca.lider_pessoas_id  in (" . $this->id_lideres . ")";
            }

            $resumo_geral = \DB::select($strSql);

            return $resumo_geral;

    }

    protected function resumo_presencas($mes, $ano)
    {

            //RESUMO DE PRESENCAS
            $strSql = " SELECT c.empresas_id, c.empresas_clientes_cloud_id, ca.mes, ca.ano, ";
            $strSql .=  " sum(total_membros) as total_membros, sum(total_visitantes) as total_visitantes, sum(total_geral) as total_geral ";
            $strSql .=  " FROM controle_atividades ca ";
            $strSql .=  " inner join celulas c on c.id = ca.celulas_id ";
            //$strSql .=  " inner join pessoas p on p.id = ca.lider_pessoas_id ";
            $strSql .=  " inner join controle_resumo cr on cr.controle_atividades_id = ca.id ";
            $strSql .=  " WHERE ";
            //$strSql .=  " ca.id = " . $id . " AND ";
            $strSql .=  " ca.empresas_id = " . $this->dados_login->empresas_id . " AND ";
            $strSql .=  " ca.empresas_clientes_cloud_id = " . $this->dados_login->empresas_clientes_cloud_id . " AND ";
            $strSql .=  " ca.mes  = '" . $mes . "' AND ";
            $strSql .=  " ca.ano  = '" . $ano . "'";

            //Busca LIDERES, se for lider logado retorna somente dados dele mesmo
            if ($this->lider_logado!=null) {
                if ($this->id_lideres!="") {
                    $strSql .=  " AND ca.lider_pessoas_id  in (" . $this->lider_logado[0]->lider_pessoas_id . "," . $this->id_lideres . ")";
                }else {
                    $strSql .=  " AND ca.lider_pessoas_id  in (" . $this->lider_logado[0]->lider_pessoas_id . ")";
                }
            }

            //O usuario logado é da liderança
            if ($this->lider_logado==null && $this->id_lideres!="") {
                $strSql .=  " AND ca.lider_pessoas_id  in (" . $this->id_lideres . ")";
            }

            $strSql .=  " GROUP BY c.empresas_id, c.empresas_clientes_cloud_id, ca.mes, ca.ano";

            $resumo = \DB::select($strSql);

            return $resumo;

    }

    public function grafico_mensal($opcao, $mes, $ano)
    {
        //Frequencia mes atual e ultimos meses
        //% percentual do total

        if ($opcao=="visitantes")
        {

            $retorna = array();

            //ULTIMOS 3 MESES
            $resumo = $this->resumo_presencas(($mes-2), $ano); //Mes atual menos 2

            foreach ($resumo as $item)
            {
                    $descricao_mes = $this->retorna_mes($item->mes);
                    $retorna[] = array("mes" => $descricao_mes, "total" => $item->total_visitantes);
            }

            $resumo = $this->resumo_presencas(($mes-1), $ano); //Mes atual menos 1

            foreach ($resumo as $item)
            {
                    $descricao_mes = $this->retorna_mes($item->mes);
                    $retorna[] = array("mes" => $descricao_mes, "total" => $item->total_visitantes);
            }

            $resumo = $this->resumo_presencas($mes, $ano); //Mes Atual

            foreach ($resumo as $item)
            {
                    $descricao_mes = $this->retorna_mes($item->mes);
                    $retorna[] = array("mes" => $descricao_mes, "total" => $item->total_visitantes);
            }


        }
        else if ($opcao=="frequencia")
        {

                    //Se for integrante da lideranca (supervisor, coordenador, etc)
                    if ($this->id_lideres!="") {
                       $strSql = " select count(*)  as tot from celulas_pessoas";
                       $strSql .=  " WHERE ";
                       $strSql .=  " empresas_id = " . $this->dados_login->empresas_id . " AND ";
                       $strSql .=  " empresas_clientes_cloud_id = " . $this->dados_login->empresas_clientes_cloud_id . "  AND ";
                       $strSql .=  " lider_pessoas_id IN (" . $this->id_lideres . ")";
                       $retorno = \DB::select($strSql);

                       if ($retorno) {
                          $total_participantes = $retorno[0]->tot;
                       }

                    } else {

                        $retorno = \DB::select('select  fn_total_participantes(' . $this->dados_login->empresas_clientes_cloud_id . ', ' . $this->dados_login->empresas_id. ')');
                        $total_participantes = $retorno[0]->fn_total_participantes;

                    }

                    $retorna = array();

                    //ULTIMOS 3 MESES
                    $resumo = $this->resumo_presencas(($mes-2), $ano); //Mes atual menos 2

                    foreach ($resumo as $item)
                    {
                            $retorna[] = array("mes" => ($item->ano . '-' . $item->mes), "total" => ($item->total_visitantes / $total_participantes * 100));
                    }

                    $resumo = $this->resumo_presencas(($mes-1), $ano); //Mes atual menos 1

                    foreach ($resumo as $item)
                    {
                            $retorna[] = array("mes" => ($item->ano . '-' . $item->mes), "total" => ($item->total_visitantes / $total_participantes * 100));
                    }

                    $resumo = $this->resumo_presencas($mes, $ano); //Mes Atual

                    foreach ($resumo as $item)
                    {
                            $retorna[] = array("mes" => ($item->ano . '-' . '08'), "total" => ($item->total_visitantes / $total_participantes * 100));
                    }


        }
        else if ($opcao=="tipo_pessoa")
        {

                    $retorna = array();

                    //ULTIMOS 3 MESES
                    $resumo = $this->resumo_tipo_pessoas($mes, $ano, "Geral");

                    foreach ($resumo as $item)
                    {
                            $retorna[] = array('label' => $item->nome, 'value' => $item->total);
                    }

        }

        return json_encode($retorna);

    }

    protected function retorna_mes($mes) {

        switch ($mes)
        {
                        case 1:
                            $descricao_mes = "Janeiro";
                            break;
                            case 2:
                            $descricao_mes = "Fevereiro";
                            break;
                            case 3:
                            $descricao_mes = "Março";
                            break;
                            case 4:
                            $descricao_mes = "Abril";
                            break;
                            case 5:
                            $descricao_mes = "Maio";
                            break;
                            case 6:
                            $descricao_mes = "Junho";
                            break;
                            case 7:
                            $descricao_mes = "Julho";
                            break;
                            case 8:
                            $descricao_mes = "Agosto";
                            break;
                            case 9:
                            $descricao_mes = "Setembro";
                            break;
                            case 10:
                            $descricao_mes = "Outubro";
                            break;
                            case 11:
                            $descricao_mes = "Novembro";
                            break;
                            case 12:
                            $descricao_mes = "Dezembro";
                            break;

                        default:
                            $descricao_mes="";
                            break;
          }

          return $descricao_mes;

    }


    public function dashboard_filtros($mes, $ano)  {

        return $this->view_dashboard($mes, $ano);

    }

    /*
    EXIBE RESUMOS ESTATISTICOS DO MES CORRENTE CASO NAO SEJA PASSADO PARAMETRO MES/ANO ESPECIFICOS
    */
    public function dashboard()
    {

        return $this->view_dashboard("","");

    }


    protected function view_dashboard($mes, $ano) {


      if ($mes=="") {
          $mes = date('m');
      }

      if ($ano=="") {
        $ano = date('Y');
      }

      if (\App\ValidacoesAcesso::PodeAcessarPagina(\Config::get('app.controle_atividades')) || \App\ValidacoesAcesso::PodeAcessarPagina(\Config::get('app.celulas')))
        {
              $this->dados_login = \Session::get('dados_login');

             //Verificar se usuario logado é LIDER
             $this->lider_logado = $this->formatador->verifica_se_lider();
        }
        else
        {
                return redirect('home');
        }



        //Verificar se foi cadastrado os dados da igreja
        if (\App\Models\usuario::find(Auth::user()->id))
        {

            $publicos = \App\Models\publicos::where('clientes_cloud_id', $this->dados_login->empresas_clientes_cloud_id)->get();
            $faixas = \App\Models\faixas::where('clientes_cloud_id', $this->dados_login->empresas_clientes_cloud_id)->get();


            //busca da proxima multiplicacao
            $strSql = "SELECT * FROM view_lideres ";
            $strSql .=  " WHERE  empresas_id = " . $this->dados_login->empresas_id;
            $strSql .=  " AND empresas_clientes_cloud_id = " . $this->dados_login->empresas_clientes_cloud_id;



            //Busca LIDERES, se for lider logado retorna somente dados dele mesmo
            if ($this->lider_logado!=null)
            {
                if ($this->id_lideres!=""){
                    $strSql .=  " AND id  in (" . $this->lider_logado[0]->lider_pessoas_id . "," . $this->id_lideres . ")";
                }else {
                    $strSql .=  " AND id  in (" . $this->lider_logado[0]->lider_pessoas_id . ")";
                }
            }

            //O usuario logado é da liderança
            if ($this->lider_logado==null && $this->id_lideres!="")
            {
                $strSql .=  " AND id  in (" . $this->id_lideres . ")";
            }

            //dd($strSql);
            $lideres = \DB::select($strSql);


            /*Busca vice - Lideres*/
            $vice_lider = \DB::select('select * from view_vicelideres where empresas_id = ? and empresas_clientes_cloud_id = ? ', [$this->dados_login->empresas_id, $this->dados_login->empresas_clientes_cloud_id]);

            $var_download="";
            $var_mensagem="";

            /*Busca Niveis*/
            //$view1 = \DB::select('select * from view_celulas_nivel1 v1 where v1.empresas_id = ? and v1.empresas_clientes_cloud_id = ? ', [$this->dados_login->empresas_id, $this->dados_login->empresas_clientes_cloud_id]);
            //$view2 = \DB::select('select * from view_celulas_nivel2 v2 where v2.empresas_id = ? and v2.empresas_clientes_cloud_id = ? ', [$this->dados_login->empresas_id, $this->dados_login->empresas_clientes_cloud_id]);
            //$view3 = \DB::select('select * from view_celulas_nivel3 v3 where v3.empresas_id = ? and v3.empresas_clientes_cloud_id = ? ', [$this->dados_login->empresas_id, $this->dados_login->empresas_clientes_cloud_id]);
            //$view4 = \DB::select('select * from view_celulas_nivel4 v4 where v4.empresas_id = ? and v4.empresas_clientes_cloud_id = ? ', [$this->dados_login->empresas_id, $this->dados_login->empresas_clientes_cloud_id]);
            //$view5 = \DB::select('select * from view_celulas_nivel5 v5 where v5.empresas_id = ? and v5.empresas_clientes_cloud_id = ? ', [$this->dados_login->empresas_id, $this->dados_login->empresas_clientes_cloud_id]);

           //NIVEL HIERARQUICO 1
            $sSql  = " SELECT * FROM view_celulas_nivel1 v1  WHERE  v1.empresas_id = " . $this->dados_login->empresas_id . " AND v1.empresas_clientes_cloud_id = " . $this->dados_login->empresas_clientes_cloud_id . " ";

            if ($this->id_niveis1!="") { /*Busca NIVEL especifico (se for alguem da hierarquia de lideranca logado*/
               $sSql .= " AND v1.id in (" . $this->id_niveis1 . ") ";
            }

            $view1 = \DB::select($sSql);

            //NIVEL HIERARQUICO 2
            $sSql  = " SELECT * FROM view_celulas_nivel2 v2  WHERE  v2.empresas_id = " . $this->dados_login->empresas_id . " AND v2.empresas_clientes_cloud_id = " . $this->dados_login->empresas_clientes_cloud_id . " ";

            if ($this->id_niveis2!="") { /*Busca NIVEL especifico (se for alguem da hierarquia de lideranca logado*/
               $sSql .= " AND v2.id in (" . $this->id_niveis2 . ") ";
            }

            $view2 = \DB::select($sSql);

            //NIVEL HIERARQUICO 3
            $sSql  = " SELECT * FROM view_celulas_nivel3 v3  WHERE  v3.empresas_id = " . $this->dados_login->empresas_id . " AND v3.empresas_clientes_cloud_id = " . $this->dados_login->empresas_clientes_cloud_id . " ";

            if ($this->id_niveis3!="") { /*Busca NIVEL especifico (se for alguem da hierarquia de lideranca logado*/
               $sSql .= " AND v3.id in (" . $this->id_niveis3 . ") ";
            }

            $view3 = \DB::select($sSql);


            //NIVEL HIERARQUICO 4
            $sSql  = " SELECT * FROM view_celulas_nivel4 v4  WHERE  v4.empresas_id = " . $this->dados_login->empresas_id . " AND v4.empresas_clientes_cloud_id = " . $this->dados_login->empresas_clientes_cloud_id . " ";

            if ($this->id_niveis4!="") { /*Busca NIVEL especifico (se for alguem da hierarquia de lideranca logado*/
               $sSql .= " AND v4.id in (" . $this->id_niveis4 . ") ";
            }

            $view4 = \DB::select($sSql);


            //NIVEL HIERARQUICO 5
            $sSql  = " SELECT * FROM view_celulas_nivel5 v5  WHERE  v5.empresas_id = " . $this->dados_login->empresas_id . " AND v5.empresas_clientes_cloud_id = " . $this->dados_login->empresas_clientes_cloud_id . " ";

            if ($this->id_niveis5!="") { /*Busca NIVEL especifico (se for alguem da hierarquia de lideranca logado*/
               $sSql .= " AND v5.id in (" . $this->id_niveis5 . ") ";
            }

            $view5 = \DB::select($sSql);


            //$retorno = \DB::select('select  fn_total_celulas(' . $this->dados_login->empresas_clientes_cloud_id . ', ' . $this->dados_login->empresas_id. ')');
            //$total_celulas = $retorno[0]->fn_total_celulas;

            //Se for integrante da lideranca (supervisor, coordenador, etc) mostra totais somente de suas celulas subordinadas
            if ($this->id_lideres!="") {
               $strSql = " select count(*)  as tot from celulas";
               $strSql .=  " WHERE ";
               $strSql .=  " empresas_id = " . $this->dados_login->empresas_id . " AND ";
               $strSql .=  " empresas_clientes_cloud_id = " . $this->dados_login->empresas_clientes_cloud_id . "  AND ";
               $strSql .=  " lider_pessoas_id IN (" . $this->id_lideres . ")";
               $retorno = \DB::select($strSql);

               if ($retorno) {
                  $total_celulas = $retorno[0]->tot;
               }

            } else {

                $retorno = \DB::select('select  fn_total_celulas(' . $this->dados_login->empresas_clientes_cloud_id . ', ' . $this->dados_login->empresas_id. ')');
                $total_celulas = $retorno[0]->fn_total_celulas;

            }

            //$retorno = \DB::select('select  fn_total_participantes(' . $this->dados_login->empresas_clientes_cloud_id . ', ' . $this->dados_login->empresas_id. ')');
            //$total_participantes = $retorno[0]->fn_total_participantes;

            //Se for integrante da lideranca (supervisor, coordenador, etc) mostra totais somente de suas celulas subordinadas
            if ($this->id_lideres!="") {
               $strSql = " SELECT count(*)  as tot FROM celulas_pessoas";
               $strSql .=  " WHERE ";
               $strSql .=  " empresas_id = " . $this->dados_login->empresas_id . " AND ";
               $strSql .=  " empresas_clientes_cloud_id = " . $this->dados_login->empresas_clientes_cloud_id . "  AND ";
               $strSql .=  " lider_pessoas_id IN (" . $this->id_lideres . ")";
               $retorno = \DB::select($strSql);

               if ($retorno) {
                   $total_participantes = $retorno[0]->tot;
               }

            } else {

                $retorno = \DB::select('select  fn_total_participantes(' . $this->dados_login->empresas_clientes_cloud_id . ', ' . $this->dados_login->empresas_id. ')');
                $total_participantes = $retorno[0]->fn_total_participantes;
            }


            $celulas_faixas = \DB::select('select * from view_total_celulas_faixa_etaria vw where vw.empresas_id = ? and vw.empresas_clientes_cloud_id = ? ', [$this->dados_login->empresas_id, $this->dados_login->empresas_clientes_cloud_id]);
            $celulas_publicos = \DB::select('select * from view_total_celulas_publico_alvo vw where vw.empresas_id = ? and vw.empresas_clientes_cloud_id = ? ', [$this->dados_login->empresas_id, $this->dados_login->empresas_clientes_cloud_id]);

            $resumo = $this->resumo_presencas($mes, $ano);

            $resumo_geral = $this->resumo_geral($mes, $ano);

            $resumo_tipo_pessoas = $this->resumo_tipo_pessoas($mes, $ano, 'Geral');

            $resumo_perguntas = $this->resumo_perguntas($mes, $ano);

            //AQUI
            //Busca ID do cliente cloud e ID da empresa
            $this->dados_login = \App\Models\usuario::find(Auth::user()->id);

            //SE for lider, direciona para dashboard da célula
            if ($this->lider_logado!=null)
            {
                $qual_pagina = ".dashboard_lider";
                $participantes_presenca = $this->participantes_presenca();

                //busca da proxima multiplicacao
                $strSql = "SELECT data_previsao_multiplicacao from view_celulas_simples ";
                $strSql .=  " WHERE  empresas_id = " . $this->dados_login->empresas_id;
                $strSql .=  " AND empresas_clientes_cloud_id = " . $this->dados_login->empresas_clientes_cloud_id;
                $strSql .=  " AND lider_pessoas_id  = '" . $this->lider_logado[0]->lider_pessoas_id . "'";
                $dados = \DB::select($strSql);

                //Verifica se ultimo encontro ja foi encerrado
                $strSql = " SELECT  to_char(to_date(data_encontro, 'yyyy-MM-dd'), 'DD-MM-YYYY') AS data_encontro, id from controle_atividades ";
                $strSql .=  " WHERE ";
                $strSql .=  " lider_pessoas_id  = '" . $this->lider_logado[0]->lider_pessoas_id . "'";
                $strSql .=  " AND encontro_encerrado <> 'S' and  ";
                $strSql .=  " to_char(to_date(data_encontro, 'yyyy-MM-dd'), 'DD-MM-YYYY') < to_char( now(), 'yyyy-MM-dd' ) ";
                $aberto = \DB::select($strSql);

                $gerar_treeview = '';

            }
            else
            {
                $gerar_treeview = $this->getEstruturas();
                $qual_pagina = ".dashboard";
                $participantes_presenca = '';
                $dados='';
                $aberto='';
            }

             $mostrar_texto = "Exibindo dados de : " . $mes . "/" . $ano;

              return view($this->rota . $qual_pagina,
                 [
                 'aberto'=>$aberto,
                  'dados'=>$dados,
                  'resumo'=>$resumo,
                  'resumo_geral'=>$resumo_geral,
                  'resumo_tipo_pessoas'=>$resumo_tipo_pessoas,
                  'total_celulas'=>$total_celulas,
                  'total_participantes'=>$total_participantes,
                  'celulas_faixas'=>$celulas_faixas,
                  'celulas_publicos'=>$celulas_publicos,
                  'resumo_perguntas'=>$resumo_perguntas,
                  'vice_lider'=>$vice_lider,
                   'nivel1'=>$view1,
                   'nivel2'=>$view2,
                   'nivel3'=>$view3,
                   'nivel4'=>$view4,
                   'nivel5'=>$view5,
                   'publicos'=>$publicos,
                   'faixas'=>$faixas,
                   'lideres'=>$lideres,
                   'var_download'=>'',
                   'var_mensagem'=>'',
                   'participantes_presenca'=> $participantes_presenca,
                   'gerar_treeview'=>$gerar_treeview,
                   'mostrar_texto' =>$mostrar_texto
                ]);
        }

    }


   //Return all dates in a month by dayOfWeek
   public function return_dates($id, $var_month, $var_year)
   {

        //Primeiro dia encontro
        $var_dayOfWeek = $this->buscar_dados($id); //pega dia do encontro da celula

        $var_counting_days = cal_days_in_month(CAL_GREGORIAN, $var_month, $var_year); //days of month

        //echo "dias " . $var_counting_days;

        $dini = mktime(0,0,0,$var_month,1,$var_year);
        $dfim = mktime(0,0,0,$var_month,$var_counting_days,$var_year);

        $dfim += 86400; //Artificio para pegar meses com 5 semanas

        $return_d = array();
        //echo "ini " . $dini . "<br/>";
        //echo "fim " . $dfim . "<br/>";

        while($dini <= $dfim) //Enquanto uma data for inferior a outra
        {
            $dt = date("d/m/Y",$dini); //Convertendo a data no formato dia/mes/ano
            $diasemana = date("w", $dini);

            if($diasemana == $var_dayOfWeek)
            { // [0 Domingo] - [1 Segunda] - [2 Terca] - [3 Quarta] - [4 Quinta] - [5 Sexta] - [6 Sabado]
                //echo " select " . $dt . "<br/>";
                array_push($return_d, $dt);
            }

            $dini += 86400; // Adicionando mais 1 dia (em segundos) na data inicial
            //echo " data " . $dt . "<br/>";
            //echo $dini . "<br/>";
        }

        //Segundo dia encontro
        $var_dayOfWeek = $this->buscar_segundo_dia_encontro($id); //pega dia do encontro da celula

        if ($var_dayOfWeek!="") {
            $var_counting_days = cal_days_in_month(CAL_GREGORIAN, $var_month, $var_year); //days of month

            $dini = mktime(0,0,0,$var_month,1,$var_year);
            $dfim = mktime(0,0,0,$var_month,$var_counting_days,$var_year);

            $bPrimeiro = false;

            while($dini <= $dfim) //Enquanto uma data for inferior a outra
            {
                $dt = date("d/m/Y",$dini); //Convertendo a data no formato dia/mes/ano
                $diasemana = date("w", $dini);

                if($diasemana == $var_dayOfWeek)
                { // [0 Domingo] - [1 Segunda] - [2 Terca] - [3 Quarta] - [4 Quinta] - [5 Sexta] - [6 Sabado]

                   if ($bPrimeiro==false) {
                      array_push($return_d, "");
                      array_push($return_d, " Segundo Dia Encontro ");
                   }
                    array_push($return_d, $dt);
                    $bPrimeiro=true;
                }

                $dini += 86400; // Adicionando mais 1 dia (em segundos) na data inicial
            }
        }

        array_push($return_d, "");
        array_push($return_d, " Encontro Avulso (Criar Novo) ");

        //Verificar se houve encontro avulso
        $dt_encontro_avulso = $this->buscar_data_avulsa($id, $var_month, $var_year);

        if ($dt_encontro_avulso!="") {
            array_push($return_d, "");
            array_push($return_d, " Houve Encontro Avulso : ");

            foreach ($dt_encontro_avulso as $item) {
                array_push($return_d, date("d/m/Y", strtotime($item->data_encontro)));
            }
        }

        return ($return_d);
   }



    //Exibir listagem
    public function index()
    {

            if (\App\ValidacoesAcesso::PodeAcessarPagina(\Config::get('app.' . $this->rota))==false)
            {
                  return redirect('home');
            }

            $strSql = "SELECT * FROM view_celulas_simples ";
            $strSql .=  " WHERE  empresas_id = " . $this->dados_login->empresas_id;
            $strSql .=  " AND empresas_clientes_cloud_id = " . $this->dados_login->empresas_clientes_cloud_id;

            //SE for lider, direciona para dashboard da célula
            if ($this->lider_logado!=null)
            {
                   $strSql .=  " AND lider_pessoas_id  = '" . $this->lider_logado[0]->lider_pessoas_id . "'";
            }

            if ($this->lideranca!=null)
            {
                 if ($this->id_lideres!=""){
                   $strSql .=  " AND lider_pessoas_id  in (" . $this->id_lideres . ")";
                 }
            }

            $dados = \DB::select($strSql);

            //Listagem de pessoas
            return view($this->rota . '.index',compact('dados'));

    }

public function salvar($request, $id, $tipo_operacao)
{
    $guarda_pai=0;
    $guadar_lider_original=0;

    $input = $request->except(array('_token', 'ativo')); //não levar o token

    $this->validate($request, [
        'pessoas' => 'required',
        'dia_encontro' => 'required',
        'horario' => 'required',
    ]);


    if ($tipo_operacao=="create") //novo registro
    {
         $dados = new celulas();
    }
    else //update
    {
         $dados = celulas::findOrfail($id);
         $guarda_pai = $dados->celulas_pai_id;
         $guadar_lider_original = $dados->lider_pessoas_id;
    }


     $dados->dia_encontro = $input['dia_encontro'];

     if ($input["horario"]<"12:00") //bom dia
     {
            $dados->turno = "M";
     }
     else if ($input["horario"]>"12:00" && $input["horario"]<"18:00") //boa tarde
     {
            $dados->turno = "T";
     }
     else if ($input["horario"]>"18:00") //boa noite
     {
            $dados->turno = "N";
     }

     //$dados->turno = $input['turno'];
     $dados->regiao = $input['regiao'];
     $dados->horario = $input['horario'];
     $dados->horario2 = $input['horario2'];
     $dados->segundo_dia_encontro = $input['segundo_dia_encontro'];
     $dados->obs = $input['obs'];
     $dados->email_grupo = $input['email_grupo'];
     $dados->faixa_etaria_id = ($input['faixa_etaria']=="" ? null : $input['faixa_etaria']);
     $dados->publico_alvo_id = ($input['publico_alvo']=="" ? null : $input['publico_alvo']);
     $dados->nome = $input['nome'];
     $dados->cor = $input['cor'];
     $dados->data_previsao_multiplicacao = $this->formatador->FormatarData($input["data_previsao_multiplicacao"]);
     $dados->celulas_nivel1_id  = ($input['nivel1']=="" ? null : $input['nivel1']);
     $dados->celulas_nivel2_id  = ($input['nivel2']=="" ? null : $input['nivel2']);
     $dados->celulas_nivel3_id  = ($input['nivel3']=="" ? null : $input['nivel3']);
     $dados->celulas_nivel4_id  = ($input['nivel4']=="" ? null : $input['nivel4']);
     $dados->celulas_nivel5_id  = ($input['nivel5']=="" ? null : $input['nivel5']);
     $dados->lider_pessoas_id  = ($input['pessoas']=="" ? null : substr($input['pessoas'],0,9));
     $dados->vicelider_pessoas_id  = ($input['vicelider_pessoas_id']=="" ? null : substr($input['vicelider_pessoas_id'],0,9));
     $dados->suplente1_pessoas_id  = ($input['suplente1_pessoas_id']=="" ? null : substr($input['suplente1_pessoas_id'],0,9));
     $dados->suplente2_pessoas_id  = ($input['suplente2_pessoas_id']=="" ? null : substr($input['suplente2_pessoas_id'],0,9));
     $dados->empresas_clientes_cloud_id = $this->dados_login->empresas_clientes_cloud_id;
     $dados->empresas_id  = $this->dados_login->empresas_id;
     $dados->celulas_pai_id = ($input['celulas_pai_id']=="" ? null : $input['celulas_pai_id']);

     //SE FOR EDICAO E USUARIO TENTAR COLOCAR A CELULA PAI DA PROPRIA CELULA... NAO DEIXAR
     if ($tipo_operacao!="create")
     {
          if ($dados->celulas_pai_id==$id)
          {
                $dados->celulas_pai_id=null;
          }

     } else { //QUANDO CRIAR UMA NOVA CELULA, INICIAR O CONTROLE DE MULTIPLICACOES PARA A PESSOA
          //$this->log_geracoes ($dados->id, $dados->celulas_pai_id, $dados->lider_pessoas_id);
     }

     //VERIFICA SE EXISTE CONTROLE DE MULTIPLICACOES PARA A PESSOA...
     //$this->log_geracoes ($dados->id, $dados->celulas_pai_id, $dados->lider_pessoas_id);

     $dados->origem = ($input['origem']=="" ? null : $input['origem']);

     if (isset($input["endereco_encontro"]))
     {
           $dados->endereco_encontro = ($input['endereco_encontro']=="" ? null : $input['endereco_encontro']);
     }

     if ($input["origem"]=="1")  //Multiplicacao
     {
            $dados->data_multiplicacao = date('Y-m-d');
     }

     //BUSCAR SE O PAI TEM  GERACAO GRAVADA
     //Se for NULO, considerar então celulas_pai_id, caso contrario , pega o conteudo celulas_id_geracao do PAI e replica na celula que esta sendo gravada
     if ($input["origem"]!="") {
         if ($dados->celulas_pai_id!=null && $dados->celulas_pai_id!=0) //CELULA PAI
         {
               if($guarda_pai==0) {
                  $guarda_pai = $dados->celulas_pai_id;
               }

               //BUSCA NA CELULA PAI SE TEM GERACAO INFORMADA
               $busca_geracao = \App\Models\celulas::select('celulas_id_geracao')->where('id', $dados->celulas_pai_id)->get();

               if  ($busca_geracao[0]->celulas_id_geracao==null)  { //NÃO ENCONTROU, ENTAO INICIA O CICLO DA GERACAO NESSA CELULA
                       $dados->celulas_id_geracao = $dados->celulas_pai_id;
               }
               else  //ENCONTROU GERACAO, ENTAO REPLICA PARA ESSA NOVA CELULA PARA SABER QUEM FOI A ORIGEM DE TODAS
               {
                       $dados->celulas_id_geracao = $busca_geracao[0]->celulas_id_geracao;
               }
         }
    } else { //PODE SER CELULA COM ORIGEM NA CELULA MAE

          if ($dados->celulas_pai_id!=null && $dados->celulas_pai_id!=0) {

               //BUSCA NA CELULA PAI SE TEM GERACAO INFORMADA
               $busca_geracao = \App\Models\celulas::select('celulas_id_geracao')->where('id', $dados->celulas_pai_id)->get();

               if  ($busca_geracao[0]->celulas_id_geracao==null)  { //NÃO ENCONTROU, ENTAO INICIA O CICLO DA GERACAO NESSA CELULA
                       $dados->celulas_id_geracao = $dados->celulas_pai_id;
               }
               else  //ENCONTROU GERACAO, ENTAO REPLICA PARA ESSA NOVA CELULA PARA SABER QUEM FOI A ORIGEM DE TODAS
               {
                       $dados->celulas_id_geracao = $busca_geracao[0]->celulas_id_geracao;
               }
         }

    }

    //TRIGGER VERIFICA SE HOUVE ALTERACAO LIDER E ATUALIZA A LOG_GERACOES


    //CELULA MAE - sem pai e nem origem
    if ($dados->celulas_pai_id==null || $dados->celulas_pai_id==0) {
       if ($input["origem"]=="") {
          $dados->celulas_id_geracao = $dados->id;
       }
    }

     $dados->qual_endereco = ($input['local']=="" ? null : $input['local']);

     //Verifique qual endereco sera o encontro conforme selecao do local
     if (isset($input["endereco_encontro"]))
     {
           if ($dados->qual_endereco != "6")
           {
                    switch ($dados->qual_endereco)
                    {
                        case '1': //lider
                            $id_pessoa_endereco = $dados->lider_pessoas_id;
                            break;

                            case '2': //lider em treinamento
                            $id_pessoa_endereco = $dados->vicelider_pessoas_id;
                            break;

                            case '3': //anfitriao
                            $id_pessoa_endereco = $dados->suplente1_pessoas_id;
                            break;

                            case '4': //suplente
                            $id_pessoa_endereco = $dados->suplente2_pessoas_id;
                            break;

                        default:
                            $id_pessoa_endereco = "";
                            break;
                    }

                    if ($dados->qual_endereco=='5') //endereco igreja sede
                    {
                        $pegar_endereco = \App\Models\empresas::select('endereco', 'numero', 'bairro', 'cidade', 'estado', 'complemento')->findOrfail($this->dados_login->empresas_id);
                        $dados->endereco_encontro = $pegar_endereco->endereco . ', ' . $pegar_endereco->numero . ' - ' . $pegar_endereco->bairro . '  ' . $pegar_endereco->complemento;
                    }
                    else
                    {
                        if ($id_pessoa_endereco!="")
                        {
                                $pegar_endereco = \App\Models\pessoas::select('endereco', 'numero', 'bairro', 'cidade', 'estado', 'complemento')->findOrfail($id_pessoa_endereco);
                                $dados->endereco_encontro = $pegar_endereco->endereco . ', ' . $pegar_endereco->numero . ' - ' . $pegar_endereco->bairro . '  ' . $pegar_endereco->complemento;
                        }
                    }

           }

     }

     $dados->data_inicio = ($input["data_inicio"]!="" ? $this->formatador->FormatarData($input["data_inicio"]) : date('Y-m-d'));
     $dados->save();

     //CRIAR LOG GERACOES
     $this->log_geracoes ($dados->id, $dados->celulas_pai_id, $dados->lider_pessoas_id);


     if ($tipo_operacao=="create") {
         //ATUALIZAR AS QUANTIDADES DE FILHOS E GERACOES
         if ($dados->celulas_pai_id!=0) {
            $busca_lider_id = \App\Models\celulas::select('lider_pessoas_id')->where('id', $dados->celulas_pai_id)->get(); //BUSCA O ID DO PAI
            $this->recursiva_atualizar_qtd_filhos($busca_lider_id[0]->lider_pessoas_id, 'S');
         }
     }


     //BUSCAR QTD DE FILHAS APOS INCLUSAO OU ALTERACAO DA CELULA
     /*
     if ($guarda_pai!=0 && $guarda_pai!=null)  { //CELULA PAI
          //PRIMEIRO PAI DO VETOR
          $this->qtd_pais[] = $guarda_pai;
          //MONTA VETOR COM TODOS OS PAIS A PARTIR DESSE PAI
          $this->buscaPai($guarda_pai);
     }

     if (isset($this->qtd_pais)) {
           for ($iSeq=0; $iSeq < count($this->qtd_pais); $iSeq++) {
                if ($this->qtd_pais[$iSeq]!=0)
                    $this->gravaQtdFilhos($this->qtd_pais[$iSeq]);
           }
     }
    */

     return  $dados->id;

}

/**
 * ATUALIZAR EM CASCATA ENQUANTO HOUVER PAIS
 */
protected function recursiva_atualizar_qtd_filhos($id_pai, $atualizar_filhos) {

      $pai = \App\Models\log_geracoes::where('lider_pessoas_id', '=', $id_pai)->firstOrFail();

      if ($atualizar_filhos=="S") { //SO NA PRIMEIRA CHAMADA DA FUNÇÃO IRA ATUALIZAR OS FILHOS
         $pai->qtd_filhas = $pai->qtd_filhas +1;
      } else {
         $pai->qtd_geracao = $pai->qtd_geracao +1;
      }
      $pai->save();

      // INICIO - ATUALIZAR GERACAO DO ANTIGO LIDER TAMBEM.
      if ($pai->lider_pessoas_id_anterior!=null) {
         \DB::statement("update log_geracoes  set qtd_geracao = qtd_geracao + 1 where lider_pessoas_id = " . $pai->lider_pessoas_id_anterior . "");
      }

      \DB::statement("update log_geracoes  set qtd_geracao = qtd_geracao + 1 where lider_pessoas_id_anterior = " . $pai->lider_pessoas_id . "");
      // FIM  - ATUALIZAR GERACAO DO ANTIGO LIDER TAMBEM.

      //ENQUANTO ENCONTRAR PAI, ATUALIZAR A GERACAO
      if ($pai->lider_pessoas_id_pai !=0) {
          $this->recursiva_atualizar_qtd_filhos($pai->lider_pessoas_id_pai, "N");
      }

}

/**
*Função utilizada para criar o controle de multiplicacoes para cada pessoa (lider)
*Existem 3 triggers na tabela CELULAS, as quais serao responsaveis para atualizar as quantidades de FILHAS e GERACOES
*/
protected function log_geracoes ($id_celula, $id_pai, $id_novo_lider) {


    if ($id_pai!=0) { //BUSCA O ID DO LIDER DA CELULA PAI INFORMADA
       $buscar = \App\Models\celulas::select('lider_pessoas_id')
            ->where('empresas_clientes_cloud_id', $this->dados_login->empresas_clientes_cloud_id)
            ->where('empresas_id', $this->dados_login->empresas_id)
            ->where('id', $id_pai)
            ->get();

            if ($buscar) {
                $id_pai = $buscar[0]->lider_pessoas_id;
            }
    }

    //INICIALIZA VARIAVEIS
    $guarda_qtd_filhas=0;
    $guarda_qtd_geracoes =0;

    //VERIFICA SE JA NAO EXISTE UM CONTROLE PARA A PESSOA. SE ACHAR, SIGNIFICA APENAS UMA ALTERACAO
    //NESSE CASO EXCLUI PARA INCLUIR NOVAMENTE ATUALIZADO. DESSA FORMA NAO DISPARA A TRIGGER DE UPDATE GERANDO INCONSISTENCIAS NAS QTDS
    $id_encontrado = \App\Models\log_geracoes::select('id')->where('lider_pessoas_id', $id_novo_lider)->get();

    if ($id_encontrado->count()!=0) { //EXCLUIR PARA INCLUIR CORRETAMENTE
       $log = \App\Models\log_geracoes::find($id_encontrado[0]->id);
       $guarda_qtd_filhas = $log->qtd_filhas; //GUARDA QTD ANTERIOR
       $guarda_qtd_geracoes = $log->qtd_geracao; //GUARDA QTD ANTERIOR
       $log->delete(); //EXCLUIR O REGISTRO
    }

      $log = new \App\Models\log_geracoes(); //CRIA NOVO REGISTRO
      $log->empresas_id                          = $this->dados_login->empresas_id;
      $log->empresas_clientes_cloud_id   = $this->dados_login->empresas_clientes_cloud_id;
      $log->data_inicio                            = date("Y-m-d");
      $log->celulas_id                              = $id_celula;
      $log->lider_pessoas_id                    = $id_novo_lider;
      $log->lider_pessoas_id_pai              = $id_pai;
      $log->qtd_filhas                             = $guarda_qtd_filhas;
      $log->qtd_geracao                         = $guarda_qtd_geracoes;
      $log->save();

}

/*
protected function gravaQtdFilhos($id) {

      //QTD DE FILHOS DE CADA PAI
      $total_filhas= $this->verificaQtdFilhos($id);

      //VAI ACUMULANDO QTD DE FILHOS SOMADOS
      $this->qtd_acumulada = $this->qtd_acumulada + $total_filhas;

      $atualizar = celulas::findOrfail($id);
      $atualizar->qtd_filhas = $total_filhas;
      $atualizar->qtd_geracao = $this->qtd_acumulada;
      $atualizar->save();

}
*/

/*
protected function buscaPai($id) {
      $pai = \App\Models\celulas::select('celulas_pai_id')->where('id', $id)->get();

      if ($pai->count()>=1) {
          if ($pai[0]->celulas_pai_id!=0) {
                $this->qtd_pais[] = $pai[0]->celulas_pai_id;
                $this->buscaPai($pai[0]->celulas_pai_id);
          }
      }
}
*/

/*
protected function verificaQtdFilhos($pai) {
       // QTD DE FILHOS
       $retorno = \DB::select('select  fn_total_filhas(' . $this->dados_login->empresas_clientes_cloud_id . ', ' . $this->dados_login->empresas_id. ',' . $pai . ')');
       return $retorno[0]->fn_total_filhas;
}
*/

 //Criar novo registro
public function create() {

        if (\App\ValidacoesAcesso::PodeAcessarPagina(\Config::get('app.' . $this->rota))==false)
        {
              return redirect('home');
        }

        $publicos = \App\Models\publicos::where('clientes_cloud_id', $this->dados_login->empresas_clientes_cloud_id)->get();
        $faixas = \App\Models\faixas::where('clientes_cloud_id', $this->dados_login->empresas_clientes_cloud_id)->get();
        $celulas = \DB::select('select id, descricao_concatenada as nome from view_celulas_simples  where empresas_id = ? and empresas_clientes_cloud_id = ? ', [$this->dados_login->empresas_id, $this->dados_login->empresas_clientes_cloud_id]);

        $vazio = \App\Models\tabela_vazia::get();

        //Verifica se tem permissao para incluir ou alterar
        if (Gate::allows('verifica_permissao', [\Config::get('app.' . $this->rota),'incluir']) || Gate::allows('verifica_permissao', [\Config::get('app.controle_atividades'),'alterar']))
        {
              $preview = 'false'; //somente visualizacao = false
        } else
        {
              $preview = 'true'; //somente visualizacao = true
        }

        /*Busca NIVEL5*/
        //$view5 = \DB::select('select * from view_celulas_nivel5 v5 where v5.empresas_id = ? and v5.empresas_clientes_cloud_id = ? ', [$this->dados_login->empresas_id, $this->dados_login->empresas_clientes_cloud_id]);

        //NIVEL HIERARQUICO 5
        $sSql  = " SELECT * FROM view_celulas_nivel5 v5  WHERE  v5.empresas_id = " . $this->dados_login->empresas_id . " AND v5.empresas_clientes_cloud_id = " . $this->dados_login->empresas_clientes_cloud_id . " ";

        if ($this->id_niveis5!="") { /*Busca NIVEL especifico (se for alguem da hierarquia de lideranca logado*/
           $sSql .= " AND v5.id in (" . $this->id_niveis5 . ") ";
        }

        $view5 = \DB::select($sSql);


        //return view($this->rota . '.registrar', ['nivel5'=>$view5, 'publicos'=>$publicos, 'faixas'=>$faixas]);
        return view($this->rota . '.atualizacao', [
          'participantes'=>'',
          'preview'=>$preview,
          'nivel5'=>$view5,
          'publicos'=>$publicos,
          'faixas'=>$faixas,
          'tipo_operacao'=>'incluir',
          'dados'=>$vazio,
          'celulas'=>$celulas,
          'vinculos'=>$vazio,
          'total_vinculos'=>'0']);

}

/*
* Grava dados no banco
*
*/
public function store(\Illuminate\Http\Request  $request)  {
          $id_gerado = $this->salvar($request, "", "create");
          \Session::flash('flash_message', 'Dados Atualizados com Sucesso!!!');

          if ($request["quero_incluir_participante"]=="sim")
          {
              return redirect('celulaspessoas/registrar/' . $id_gerado);
          }
          else
          {
              return redirect($this->rota);
          }

}

    //Abre tela para edicao ou somente visualização dos registros
   private function exibir ($request, $id, $preview) {

        if($request->ajax()) {
            return URL::to($this->rota . '/'. $id . '/edit');
        }

        if (\App\ValidacoesAcesso::PodeAcessarPagina(\Config::get('app.' . $this->rota))==false)
        {
              return redirect('home');
        }

        $publicos = \App\Models\publicos::where('clientes_cloud_id', $this->dados_login->empresas_clientes_cloud_id)->get();
        $faixas = \App\Models\faixas::where('clientes_cloud_id', $this->dados_login->empresas_clientes_cloud_id)->get();

        /*Busca NIVEL5*/
        //$view5  = \DB::select('select * from view_celulas_nivel5 v5 where v5.empresas_id = ? and v5.empresas_clientes_cloud_id = ? ', [$this->dados_login->empresas_id, $this->dados_login->empresas_clientes_cloud_id]);

        //NIVEL HIERARQUICO 5
        $sSql  = " SELECT * FROM view_celulas_nivel5 v5  WHERE  v5.empresas_id = " . $this->dados_login->empresas_id . " AND v5.empresas_clientes_cloud_id = " . $this->dados_login->empresas_clientes_cloud_id . " ";

        if ($this->id_niveis5!="") { /*Busca NIVEL especifico (se for alguem da hierarquia de lideranca logado*/
           $sSql .= " AND v5.id in (" . $this->id_niveis5 . ") ";
        }

        $view5 = \DB::select($sSql);


        /*Busca */
        $celulas = \DB::select('select id, descricao_concatenada as nome, tot from view_celulas_simples  where empresas_id = ? and empresas_clientes_cloud_id = ? ', [$this->dados_login->empresas_id, $this->dados_login->empresas_clientes_cloud_id]);

        /*Busca NIVEL4*/
        $dados = \DB::select("select to_char(to_date(data_previsao_multiplicacao, 'yyyy-MM-dd'), 'DD/MM/YYYY') AS data_previsao_multiplicacao_format, to_char(to_date(data_inicio, 'yyyy-MM-dd'), 'DD/MM/YYYY') AS data_inicio_format, * from view_celulas  where id = ? and empresas_id = ? and empresas_clientes_cloud_id = ? ", [$id, $this->dados_login->empresas_id, $this->dados_login->empresas_clientes_cloud_id]);

        $participantes = \DB::select('select * from view_celulas_pessoas where celulas_id = ? and empresas_id = ? and empresas_clientes_cloud_id = ? ', [$id, $this->dados_login->empresas_id, $this->dados_login->empresas_clientes_cloud_id]);


        //CARREGAR UM ARRAY COM TODOS ID'S PERTENCENTES A CELULA PESQUISADA
        $this->pegarSomenteId($id);

        //QUERY MONTA UM ARRAY COM ARVORE HIERARQUICA
        $strSql  = " SELECT celulas.id, CASE WHEN celulas.id = " . $id . " THEN 0 ELSE celulas_pai_id END AS celulas_pai_id, caminhofoto,  origem,";
        $strSql .= " CASE  WHEN nome <> ''::text AND razaosocial <> ''::text THEN (nome || ' - '::text) || razaosocial ";
        $strSql .= "       ELSE COALESCE(razaosocial, nome) ";
        $strSql .= "       END AS nome";
        $strSql .=  " FROM  celulas ";
        $strSql .=  " INNER JOIN pessoas on pessoas.id = celulas.lider_pessoas_id ";
        $strSql .=  " WHERE ";
        $strSql .=  " celulas.id IN (" . $this->guarda_id . ") AND ";
        $strSql .=  " celulas.empresas_id = " . $this->dados_login->empresas_id . " AND ";
        $strSql .=  " celulas.empresas_clientes_cloud_id = " . $this->dados_login->empresas_clientes_cloud_id . "  ORDER BY nome";
        $retornar = \DB::select($strSql);

        $resultArray = json_decode(json_encode($retornar), true); //GERAR ARRAY MULTINIVEIS

        //dd($strSql);
        //BUSCA NOME DO PAI PARA INCLUIR NA ESTRUTURA
        if ($dados[0]->celulas_pai_id!=null || $dados[0]->celulas_pai_id!=0) {
            $nome_pai = \DB::select("SELECT descricao_concatenada FROM view_celulas_simples WHERE id = " .  $dados[0]->celulas_pai_id . "");
            //GERA CODIGO HTML PARA GERAR LISTA UNIFICADA DAS HIERARQUIAS
            //$gerar_estrutura_origem = $this->getEstruturasCelulasOrigem($id);
            $gerar_estrutura_origem = "<h4>Árvore Hierárquica de <b><i>" . $dados[0]->nome . ' - ' . $dados[0]->nome_lider . "</i></b> (Multiplicação/Vínculos)</h4><ul id='ul_nivel0' class='treeview2'><li><a href='#'>" . (count($nome_pai)>0 ? $nome_pai[0]->descricao_concatenada : "Sem Célula Pai") . "</a>" . $this->printListRecursive($resultArray) . "</li></ul>";
        } else {
            $gerar_estrutura_origem = "<h4>Árvore Hierárquica de <b><i>" . $dados[0]->nome . ' - ' . $dados[0]->nome_lider . "</i></b> (Multiplicação/Vínculos)</h4><ul id='ul_nivel0' class='treeview2'><li><a href='#'>Sem Pai</a>" . $this->printListRecursive($resultArray) . "</li></ul>";
        }

        //GERA CODIGO HTML PARA GERAR LISTA UNIFICADA DAS HIERARQUIAS
        //$gerar_estrutura_origem = $this->getEstruturasCelulasOrigem($id);
        //$gerar_estrutura_origem = "<h4>Árvore Hierárquica de <b><i>" . $dados[0]->nome . ' - ' . $dados[0]->nome_lider . "</i></b> (Multiplicação/Vínculos)</h4><ul id='ul_nivel0' class='treeview2'><li><a href='#'>" . (count($nome_pai)>0 ? $nome_pai[0]->descricao_concatenada : "Sem Célula Pai") . "</a>" . $this->printListRecursive($resultArray) . "</li></ul>";

        //GRAVA QTD DE FILHOS, NETOS, BISNETOS, ETC...
        //$grava_qtd = celulas::findOrfail($id);
        //$grava_qtd->qtd_geracao = ($this->qtd - 1);
        //$grava_qtd->save();


        //$temp = \DB::select('select count(*) as tot from view_celulas  where celulas_pai_id = ?  and empresas_id = ? and empresas_clientes_cloud_id = ? ', [$id, $this->dados_login->empresas_id, $this->dados_login->empresas_clientes_cloud_id]);
        //$total_vinculos =$temp[0]->tot;

        $nome_lider_anterior="";
        $lider_anterior = \DB::select('select p.razaosocial from log_geracoes l inner join pessoas p on p.id = l.lider_pessoas_id_anterior where l.celulas_id = ' . $id . ' and l.lider_pessoas_id_anterior is not null');
        if ($lider_anterior) {
           $nome_lider_anterior = $lider_anterior[0]->razaosocial;
        }


        //return view($this->rota . '.edit', ['dados' =>$dados, 'preview' => $preview,  'nivel5' =>$view5, 'publicos'=>$publicos, 'faixas'=>$faixas]);
        return view($this->rota . '.atualizacao', [
              'gerar_estrutura_origem'=>$gerar_estrutura_origem,
              'participantes'=>$participantes,
              'dados' =>$dados,
              'preview' => $preview,
              'nivel5' =>$view5,
              'publicos'=>$publicos,
              'faixas'=>$faixas,
              'tipo_operacao'=>'editar',
              'celulas'=>$celulas,
              'nome_lider_anterior' => $nome_lider_anterior
            ]);

    }


protected   function makeListRecursive(&$list,$parent=0) {
    $result = array();
    for( $i=0,$c=count($list);$i<$c;$i++ )
    {
        if( $list[$i]['celulas_pai_id']==$parent )
        {
            $list[$i]['childs'] = $this->makeListRecursive($list,$list[$i]['id']);
            $result[] = $list[$i];
        }
    }
    return $result;
}

protected  function printListRecursive(&$list,$parent=0) {

      $foundSome = false;
      for( $i=0,$c=count($list);$i<$c;$i++ ) {
          if($list[$i]['celulas_pai_id']==$parent) {
              if($foundSome==false) {
                  $this->linha .= '<ul>';
                  $foundSome = true;
              }
              $this->qtd++; //CONTA A QUANTIDADE DA FAMILIA TODA (FILHOS, NETOS, BISNETOS, ETC)
              $this->linha .=  '<li><a href="#">'.$list[$i]['nome'].  ' - ' . ($list[$i]['origem']==1 ? 'Multiplicação': 'Vínculo (ou Célula Filha)') . '</a></li>';
              $this->printListRecursive($list,$list[$i]['id']);
          }
      }

      if($foundSome) {
          $this->linha .=  '</ul>';
      }

      return $this->linha;
}

//Visualizar registro
public function show (\Illuminate\Http\Request $request, $id) {
     return $this->exibir($request, $id, 'true');
}

//Direciona para tela de alteracao
public function edit(\Illuminate\Http\Request $request, $id) {
     return $this->exibir($request, $id, 'false');
}


/**
* Atualiza dados no banco
*
* @param    \Illuminate\Http\Request  $request
* @param    int  $id
* @return  \Illuminate\Http\Response
*/
public function update(\Illuminate\Http\Request  $request, $id) {
         $this->salvar($request, $id,  "update");
         \Session::flash('flash_message', 'Dados Atualizados com Sucesso!!!');

         if ($request["quero_incluir_participante"]=="sim") {//quando for edicao com membros ja incluidos
              return redirect('celulaspessoas/' . $id . '/edit');
          }
          else if ($request["quero_incluir_participante"]=="simnovo") //nenhum membro inserido ainda...
          {
               return redirect('celulaspessoas/registrar/' . $id);
          }
          else //nao quer incluir participante agora
          {
               return redirect($this->rota);
          }
}


    /**
    * Excluir registro do banco.
    *
    * @param    int  $id
    * @return  \Illuminate\Http\Response
    */
    public function destroy($id) {
           $dados = celulas::findOrfail($id);
           $dados->delete();
           return redirect($this->rota);
    }

}