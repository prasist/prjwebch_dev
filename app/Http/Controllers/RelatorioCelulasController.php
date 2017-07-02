<?php
/*
    RELATORIOS E SUAS VIEWS
    listagem_celulas => view_celulas_completo
    listagem_celulas_pessoas_analitico => view_celulas_pessoas
    listagem_celulas_pessoas_niveis => view_celulas_pessoas_niveis
    listagem_celulas_sintetico => view_celulas_niveis
 */
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Functions;
use URL;
use Auth;
use Input;
use Gate;
use JasperPHP\JasperPHP as JasperPHP;

class RelatorioCelulasController extends Controller
{

    public function __construct()
    {

        $this->rota = "relcelulas"; //Define nome da rota que será usada na classe
        $this->middleware('auth');

        /*Instancia a classe de funcoes (Data, valor, etc)*/
        $this->formatador = new  \App\Functions\FuncoesGerais();


        //Validação de permissão de acesso a pagina
        if (Gate::allows('verifica_permissao', [\Config::get('app.' . $this->rota),'acessar']) || Gate::allows('verifica_permissao', [\Config::get('app.relencontro'),'acessar']))
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


 public function CarregarView($var_download, $var_mensagem, $var_rota="")
{

        $publicos = \App\Models\publicos::where('clientes_cloud_id', $this->dados_login->empresas_clientes_cloud_id)->get();
        $faixas = \App\Models\faixas::where('clientes_cloud_id', $this->dados_login->empresas_clientes_cloud_id)->get();

        /*Busca Lideres*/
        ///$lideres = \DB::select('select * from view_lideres where empresas_id = ? and empresas_clientes_cloud_id = ? ', [$this->dados_login->empresas_id, $this->dados_login->empresas_clientes_cloud_id]);

        $strSql  = " SELECT * FROM view_lideres ";
        $strSql .= " WHERE  empresas_id = " . $this->dados_login->empresas_id;
        $strSql .= " AND empresas_clientes_cloud_id = " . $this->dados_login->empresas_clientes_cloud_id;

        //Trazer somente celula do lider logado... ou
        if ($this->lider_logado!=null) {
              if ($this->id_lideres!="") {
                  $strSql .= " AND id IN (" . $this->lider_logado[0]->lider_pessoas_id . ", " . $this->id_lideres . ")";
              } else {
                  $strSql .= " AND id IN (" . $this->lider_logado[0]->lider_pessoas_id . ")";
              }
              //$celulas = \DB::select('select id, descricao_concatenada as nome from view_celulas_simples  where lider_pessoas_id = ? and  empresas_id = ? and empresas_clientes_cloud_id = ? ', [$lider_logado[0]->lider_pessoas_id, $this->dados_login->empresas_id, $this->dados_login->empresas_clientes_cloud_id]);

        } else { //verificar se é alguém da lideranca (supervisor, coordenador, etc) e trazer somente as celulas subordinadas

              if ($this->id_lideres!="") {
                  $strSql .= " AND id IN (" . $this->id_lideres . ")";
              }
        }

        $lideres = \DB::select($strSql);

        /*Busca vice - Lideres*/
        $vice_lider = \DB::select('select * from view_vicelideres where empresas_id = ? and empresas_clientes_cloud_id = ? ', [$this->dados_login->empresas_id, $this->dados_login->empresas_clientes_cloud_id]);


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

        //$view2 = \DB::select('select * from view_celulas_nivel2 v2 where v2.empresas_id = ? and v2.empresas_clientes_cloud_id = ? ', [$this->dados_login->empresas_id, $this->dados_login->empresas_clientes_cloud_id]);
        //$view3 = \DB::select('select * from view_celulas_nivel3 v3 where v3.empresas_id = ? and v3.empresas_clientes_cloud_id = ? ', [$this->dados_login->empresas_id, $this->dados_login->empresas_clientes_cloud_id]);
        //$view4 = \DB::select('select * from view_celulas_nivel4 v4 where v4.empresas_id = ? and v4.empresas_clientes_cloud_id = ? ', [$this->dados_login->empresas_id, $this->dados_login->empresas_clientes_cloud_id]);
        //$view5 = \DB::select('select * from view_celulas_nivel5 v5 where v5.empresas_id = ? and v5.empresas_clientes_cloud_id = ? ', [$this->dados_login->empresas_id, $this->dados_login->empresas_clientes_cloud_id]);

        return view(($var_rota=="" ? $this->rota : $var_rota) . '.index', ['vice_lider'=>$vice_lider, 'nivel1'=>$view1, 'nivel2'=>$view2, 'nivel3'=>$view3, 'nivel4'=>$view4, 'nivel5'=>$view5, 'publicos'=>$publicos, 'faixas'=>$faixas, 'lideres'=>$lideres, 'var_download' => $var_download, 'var_mensagem'=>$var_mensagem]);

}

public function index()
{

        if (\App\ValidacoesAcesso::PodeAcessarPagina(\Config::get('app.' . $this->rota))==false)
        {
              return redirect('home');
        }

        return $this->CarregarView('','');
}


public function index_movimentacoes()
{

        if (\App\ValidacoesAcesso::PodeAcessarPagina(\Config::get('app.' . $this->rota))==false)
        {
              return redirect('home');
        }

        $publicos = \App\Models\publicos::where('clientes_cloud_id', $this->dados_login->empresas_clientes_cloud_id)->get();
        $faixas = \App\Models\faixas::where('clientes_cloud_id', $this->dados_login->empresas_clientes_cloud_id)->get();
        $motivos = \App\Models\tiposmovimentacao::where('clientes_cloud_id', $this->dados_login->empresas_clientes_cloud_id)->get();

        /*Busca Lideres*/
        //$lideres = \DB::select('select * from view_lideres where empresas_id = ? and empresas_clientes_cloud_id = ? ', [$this->dados_login->empresas_id, $this->dados_login->empresas_clientes_cloud_id]);
        $lideres = \DB::select('select id, descricao_concatenada as nome from view_celulas_simples  where empresas_id = ? and empresas_clientes_cloud_id = ? ', [$this->dados_login->empresas_id, $this->dados_login->empresas_clientes_cloud_id]);

        /*Busca Niveis*/
        $view1 = \DB::select('select * from view_celulas_nivel1 v1 where v1.empresas_id = ? and v1.empresas_clientes_cloud_id = ? ', [$this->dados_login->empresas_id, $this->dados_login->empresas_clientes_cloud_id]);
        $view2 = \DB::select('select * from view_celulas_nivel2 v2 where v2.empresas_id = ? and v2.empresas_clientes_cloud_id = ? ', [$this->dados_login->empresas_id, $this->dados_login->empresas_clientes_cloud_id]);
        $view3 = \DB::select('select * from view_celulas_nivel3 v3 where v3.empresas_id = ? and v3.empresas_clientes_cloud_id = ? ', [$this->dados_login->empresas_id, $this->dados_login->empresas_clientes_cloud_id]);
        $view4 = \DB::select('select * from view_celulas_nivel4 v4 where v4.empresas_id = ? and v4.empresas_clientes_cloud_id = ? ', [$this->dados_login->empresas_id, $this->dados_login->empresas_clientes_cloud_id]);
        $view5 = \DB::select('select * from view_celulas_nivel5 v5 where v5.empresas_id = ? and v5.empresas_clientes_cloud_id = ? ', [$this->dados_login->empresas_id, $this->dados_login->empresas_clientes_cloud_id]);

        return view('relmovimentacoes.index', ['motivos'=>$motivos,  'nivel1'=>$view1, 'nivel2'=>$view2, 'nivel3'=>$view3, 'nivel4'=>$view4, 'nivel5'=>$view5, 'publicos'=>$publicos, 'faixas'=>$faixas, 'lideres'=>$lideres, 'var_download' => '', 'var_mensagem'=>'']);

}


//RELATORIO DE ENCONTROS E CELULAS
public function pesquisar(\Illuminate\Http\Request  $request, $tipo_relatorio)
{

    /*Pega todos campos enviados no post*/
    $input = $request->except(array('_token', 'ativo')); //não levar o token

    /*------------------------------------------INICIALIZA PARAMETROS JASPER--------------------------------------------------*/
    //Pega dados de conexao com o banco para o JASPER REPORT
    $database = \Config::get('database.connections.jasper_report');
    $ext = $input["resultado"]; //Tipo saída (PDF, XLS)
    $output = public_path() . '/relatorios/resultados/' . $ext . '/celulas_' . $this->dados_login->empresas_id . '_' . Auth::user()->id; //Path para cada tipo de relatorio
    $path_download = '/relatorios/resultados/' . $ext . '/celulas_' . $this->dados_login->empresas_id . '_' .  Auth::user()->id; //Path para cada tipo de relatorio
    /*------------------------------------------INICIALIZA PARAMETROS JASPER--------------------------------------------------*/

    $filtros = "";
    $descricao_publico_alvo="";
    $descricao_faixa_etaria="";
    $descricao_lider="";
    $descricao_vice_lider="";
    $descricao_nivel1="";
    $descricao_nivel2="";
    $descricao_nivel3="";
    $descricao_nivel4="";
    $descricao_nivel5="";
    $descricao_motivo="";


    if (isset($input["data_movimentacao"]))
    {
         if ($input["data_movimentacao"]!="")
            $filtros .= "     Data Mov. Inicial : " . $input["data_movimentacao"];
    }

    if (isset($input["data_movimentacao_ate"]))
    {
         if ($input["data_movimentacao_ate"]!="")
            $filtros .= "     Data Mov. Final : " . $input["data_movimentacao_ate"];
    }

    if (isset($input["motivos"]))
        if ($input["motivos"]!="") $descricao_motivo = explode("|", $input["motivos"]);

    if (isset($input["publico_alvo"]))
    {
         if ($input["publico_alvo"]!="") $descricao_publico_alvo = explode("|", $input["publico_alvo"]);
         if ($descricao_publico_alvo[0]!="0")  $filtros .= "     Publico Alvo : " . $descricao_publico_alvo[1];
     }

    if (isset($input["faixa_etaria"])) {
        if ($input["faixa_etaria"]!="") $descricao_faixa_etaria = explode("|", $input["faixa_etaria"]);
        if ($descricao_faixa_etaria[0]!="0")  $filtros .= "     Faixa Etaria : " . $descricao_faixa_etaria[1];
    }

    if (isset($input["lideres"])) {
        if ($input["lideres"]!="") $descricao_lider = explode("|", $input["lideres"]);

        if ($descricao_lider[0]!="0")  {

            if ($tipo_relatorio=="movimentacoes")  //RELATORIO MOVIMENTACOES
            {
                $filtros .= "     Celula Anterior : " . $descricao_lider[1];
            }
            else
            {
                 $filtros .= "     Lider : " . $descricao_lider[1];
            }
        }
    }


    if (isset($input["vice_lider"]))
    {
        if ($input["vice_lider"]!="") $descricao_vice_lider = explode("|", $input["vice_lider"]);

        if ($descricao_vice_lider[0]!="0")  {

            if ($tipo_relatorio=="movimentacoes")  //RELATORIO MOVIMENTACOES
            {
                $filtros .= "     Nova Celula : " . $descricao_vice_lider[1];
            }
            else
            {
                 $filtros .= "     Lider em Treinamento: " . $descricao_vice_lider[1];
            }
        }
    }

    if (isset($input["nivel1_up"]))
        if ($input["nivel1_up"]!="") $descricao_nivel1 = explode("|", $input["nivel1_up"]);

    if (isset($input["nivel2_up"]))
        if ($input["nivel2_up"]!="") $descricao_nivel2 = explode("|", $input["nivel2_up"]);

    if (isset($input["nivel3_up"]))
        if ($input["nivel3_up"]!="") $descricao_nivel3 = explode("|", $input["nivel3_up"]);

    if (isset($input["nivel4_up"]))
        if ($input["nivel4_up"]!="") $descricao_nivel4 = explode("|", $input["nivel4_up"]);

    if (isset($input["nivel5_up"]))
        if ($input["nivel5_up"]!="") $descricao_nivel5 = explode("|", $input["nivel5_up"]);

    $sDiaEncontro = "";

    if (isset($input["dia_encontro"])) {
        switch ($input["dia_encontro"]) {
                case '1':
                $sDiaEncontro = "Segunda-Feira";
                break;

                case '2':
                $sDiaEncontro = "Terca-Feira";
                break;

                case '3':
                $sDiaEncontro = "Quarta-Feira";
                break;

                case '4':
                $sDiaEncontro = "Quinta-Feira";
                break;

                case '5':
                $sDiaEncontro = "Sexta-Feira";
                break;

                case '6':
                $sDiaEncontro = "Sabado";
                break;

                case '0':
                $sDiaEncontro = "Domingo";
                break;

            default:
                $sDiaEncontro = "";
                break;
        }
    }

   /*Instancia biblioteca de funcoes globais*/
   $formatador = new  \App\Functions\FuncoesGerais();


    if ($tipo_relatorio=="celulas") //SE FOR RELATORIO DE CELULAS
    {
        if ($input["dia_encontro"]!="")  $filtros .= "      Dia Encontro : " . $sDiaEncontro;
        if ($input["turno"]!="")  $filtros .= "         Turno : " . $input["turno"];
        if ($input["segundo_dia_encontro"]!="")  $filtros .= "      Segundo dia encontro : " . $input["segundo_dia_encontro"];
    }
    else if ($tipo_relatorio=="encontro")  //RELATORIO DE ENCONTROS
    {

        if (isset($input["tiporel"])) {
            if ($input["tiporel"]=="0") { //RELATORIO ANUAL
                $filtros .= "     Mes : " . $input["mes"];
                $filtros .= "     Ano : " . $input["ano"];
            } else if ($input["tiporel"]=="1") { //ANUAL
                $filtros .= "     Ano Inicial : " . $input["ano"];
                $filtros .= "     Ano Final : " . $input["ano_final"];
            } else if ($input["tiporel"]=="2") {//MENSAL
                $filtros .= "     Mes Inicial : " . $input["mes"];
                $filtros .= "     Mes Final : " . $input["mes_final"];
                $filtros .= "     Ano : " . $input["ano"];
            }
        }

    }


    if (isset($input["qtd_inicial"]))
        if ($input["qtd_inicial"]!="")  $filtros .= "        Qtd. Multiplicacoes Inicial : " . $input["qtd_inicial"];

    if (isset($input["qtd_final"]))
        if ($input["qtd_final"]!="")  $filtros .= "        Qtd. Multiplicacoes Final : " . $input["qtd_final"];

    if (isset($input["regiao"]))
        if ($input["regiao"]!="")  $filtros .= "        Regiao : " . $input["regiao"];

    if (isset($input["nivel1_up"]))
        if ($input["nivel1_up"]!="0")  $filtros .= "        " . \Session::get('nivel1') . " : " . $descricao_nivel1[1];

    if (isset($input["nivel2_up"]))
        if ($input["nivel2_up"]!="0")  $filtros .= "        " . \Session::get('nivel2') . " : " . $descricao_nivel2[1];

    if (isset($input["nivel3_up"]))
        if ($input["nivel3_up"]!="0")  $filtros .= "        " . \Session::get('nivel3') . " : " . $descricao_nivel3[1];

    if (isset($input["nivel4_up"]))
        if ($input["nivel4_up"]!="0")  $filtros .= "        " . \Session::get('nivel4') . " : " . $descricao_nivel4[1];

    if (isset($input["nivel5_up"]))
        if ($input["nivel5_up"]!="0")  $filtros .= "        " . \Session::get('nivel5') . " : " . $descricao_nivel5[1];

   //make where clausure for query in jasper report
   //for report (encontro), set alias from field empresas_id (celulas.empresas_id)
   if ($tipo_relatorio=="encontro")  {

           if ($input["tiporel"]=="0" || $input["tiporel"]=="3") { //PADRAO
                $sWhere = " celulas.empresas_id = " . $this->dados_login->empresas_id . " and celulas.empresas_clientes_cloud_id = " .$this->dados_login->empresas_clientes_cloud_id . "";
           } else {
                $sWhere = " c.empresas_id = " . $this->dados_login->empresas_id . " and c.empresas_clientes_cloud_id = " .$this->dados_login->empresas_clientes_cloud_id . "";
           }

   } else {

         $sWhere = " empresas_id = " . $this->dados_login->empresas_id . " and empresas_clientes_cloud_id = " .$this->dados_login->empresas_clientes_cloud_id . "";


         if (isset($input["ckExibir"])) {

               if (trim($input["ckExibir"])=="") {
                        if (trim($input["ckEstruturas"])=="") {
                            $sWhere = " vw.empresas_id = " . $this->dados_login->empresas_id . " and vw.empresas_clientes_cloud_id = " .$this->dados_login->empresas_clientes_cloud_id . "";
                        }
                } else if (trim($input["ckEstruturas"])=="") {
                    $sWhere = " vw.empresas_id = " . $this->dados_login->empresas_id . " and vw.empresas_clientes_cloud_id = " .$this->dados_login->empresas_clientes_cloud_id . "";
                }
         }

            if (isset($input["qtd_inicial"]) && isset($input["qtd_final"])) {
                if ($input["qtd_inicial"]!="" && $input["qtd_final"]!="")
                    $sWhere = " vw.empresas_id = " . $this->dados_login->empresas_id . " and vw.empresas_clientes_cloud_id = " .$this->dados_login->empresas_clientes_cloud_id . "";
            }
   }


     //parameters fields to jasper report
    $parametros = array
    (
        "empresas_id"=> $this->dados_login->empresas_id,
        "empresas_clientes_cloud_id"=> $this->dados_login->empresas_clientes_cloud_id,
        "filtros"=> "'" . ($filtros) . "'"
    );

    if (isset($input["data_movimentacao"])) {
         $parametros = array_add($parametros, 'data_mov_inicial', $formatador->FormatarData($input["data_movimentacao"]));
    }

    if (isset($input["data_movimentacao_ate"])) {
          $parametros = array_add($parametros, 'data_mov_final', $formatador->FormatarData($input["data_movimentacao_ate"]));
    }

    if (isset($input["motivos"])) {
            if ($input["motivos"]!="")
                $parametros = array_add($parametros, 'motivos_id', ($descricao_motivo[0]=="" ? 0 : $descricao_motivo[0]));
    }

    if (isset($input["qtd_inicial"]) && isset($input["qtd_final"])) {
            if ($input["qtd_inicial"]!="" && $input["qtd_final"]!="") {
                $parametros = array_add($parametros, 'qtd_inicial', ($input["qtd_inicial"]=="" ? 0 : $input["qtd_inicial"]));

                if ($input["qtd_inicial"]!="") {
                    //$sWhere .= " and qtd_geracao between " . $input["qtd_inicial"] . " and " . $input["qtd_final"];
                    $sWhere .= " and total between " . $input["qtd_inicial"] . " and " . $input["qtd_final"];
                }
            }
    }

    if (isset($input["qtd_final"])) {
       $parametros = array_add($parametros, 'qtd_final', ($input["qtd_final"]=="" ? 0 : $input["qtd_final"]));
    }

    if (isset($input["publico_alvo"]))
    {
        if ($input["publico_alvo"]!="0") {
            $parametros = array_add($parametros, 'publico_alvo', ($descricao_publico_alvo[0]=="" ? 0 : $descricao_publico_alvo[0]));
            $sWhere .= " and publico_alvo_id = " . $descricao_publico_alvo[0];
        }
    }

    if (isset($input["faixa_etaria"]))
    {
        if ($input["faixa_etaria"]!="0"){
            $parametros = array_add($parametros, 'faixa_etaria', ($descricao_faixa_etaria[0]=="" ? 0 : $descricao_faixa_etaria[0]));
            $sWhere .= " and faixa_etaria_id = " . $descricao_faixa_etaria[0];
        }
    }

    if (isset($input["regiao"]))
    {
        if ($input["regiao"]!="") {
            $parametros = array_add($parametros, 'regiao', $input["regiao"]);
        }
    }

    if ($tipo_relatorio!="movimentacoes")  //RELATORIO MOVIMENTACOES
   {
             //PARAMETROS
            $parametros = array_add($parametros, 'nivel1', ($descricao_nivel1=="" ? 0 : $descricao_nivel1[0]));

            if ($descricao_nivel1!="" && $descricao_nivel1[0]!="0") {
                //if (isset($input["tiporel"]) && $input["tiporel"]=="0")  {

                    $sWhere .= " and " . ($tipo_relatorio=="encontro" ? ($input["tiporel"]!=0 ? "c." : "celulas.") : "") . "celulas_nivel1_id = " . $descricao_nivel1[0];
                //} else {
                //    $sWhere .= " and c.celulas_nivel1_id = " . $descricao_nivel1[0];
                //}

            }

            $parametros = array_add($parametros, 'nivel2', ($descricao_nivel2=="" ? 0 : $descricao_nivel2[0]));

            if ($descricao_nivel2!="" && $descricao_nivel2[0]!="0") {
                //if ($input["tiporel"]=="0")  {
                    $sWhere .= " and " . ($tipo_relatorio=="encontro" ? ($input["tiporel"]!=0 ? "c." : "celulas.") : "") . "celulas_nivel2_id = " . $descricao_nivel2[0];
                //} else {
                //    $sWhere .= " and c.celulas_nivel2_id = " . $descricao_nivel2[0];
                //}
            }

            $parametros = array_add($parametros, 'nivel3', ($descricao_nivel3=="" ? 0 : $descricao_nivel3[0]));

            if ($descricao_nivel3!="" && $descricao_nivel3[0]!="0") {
                //if ($input["tiporel"]=="0")  {
                    $sWhere .= " and " . ($tipo_relatorio=="encontro" ? ($input["tiporel"]!=0 ? "c." : "celulas.") : "") . "celulas_nivel3_id = " . $descricao_nivel3[0];
                //} else {
                    //$sWhere .= " and c.celulas_nivel3_id = " . $descricao_nivel3[0];
                //}
            }

            $parametros = array_add($parametros, 'nivel4', ($descricao_nivel4=="" ? 0 : $descricao_nivel4[0]));

            if ($descricao_nivel4!="" && $descricao_nivel4[0]!="0") {
                //if ($input["tiporel"]=="0")  {
                    $sWhere .= " and " . ($tipo_relatorio=="encontro" ? ($input["tiporel"]!=0 ? "c." : "celulas.") : "") . "celulas_nivel4_id = " . $descricao_nivel4[0];
                //} else {
                //    $sWhere .= " and c.celulas_nivel4_id = " . $descricao_nivel4[0];
                //}
            }

            $parametros = array_add($parametros, 'nivel5', ($descricao_nivel5=="" ? 0 : $descricao_nivel5[0]));

            if ($descricao_nivel5!="" && $descricao_nivel5[0]!="0") {
                //if ($input["tiporel"]=="0")  {
                    $sWhere .= " and " . ($tipo_relatorio=="encontro" ? ($input["tiporel"]!=0 ? "c." : "celulas.") : "") . "celulas_nivel5_id = " . $descricao_nivel5[0];
                //} else {
                //    $sWhere .= " and c.celulas_nivel5_id = " . $descricao_nivel5[0];
                //}
            }
   }


    if (isset($input["mes"]) && ($input["tiporel"]=="0" || $input["tiporel"]=="3")) {
        if ($input["mes"]!="") {
            $parametros = array_add($parametros, 'mes', $input["mes"]);
            $sWhere .= " and mes = " . $input["mes"];
        }
    }

    if (isset($input["tiporel"])) {
        if ($input["tiporel"]=="2") { //RELATORIO MENSAL
            if (isset($input["mes"]) && isset($input["mes_final"])) {//MES INICIAL E FINAL
                 $parametros = array_add($parametros, 'mes', $input["mes"]);
                 $parametros = array_add($parametros, 'mes_final', $input["mes_final"]);
            }
        }
    }

    if (isset($input["ano"]) && $input["tiporel"]!="1") { //SOMENTE ANO INICIAL
        if ($input["ano"]!="") {
            $parametros = array_add($parametros, 'ano', $input["ano"]);
            $sWhere .= " and ano = " . $input["ano"];
        }
    }

    if (isset($input["tiporel"])) {
        if ($input["tiporel"]=="1") { //RELATORIO ANUAL
            if (isset($input["ano"]) && isset($input["ano_final"])) { //ANO INICIAL E FINAL
                    $parametros = array_add($parametros, 'ano', $input["ano"]);
                    $parametros = array_add($parametros, 'ano_final', $input["ano_final"]);
            }
        }
    }

   if ($tipo_relatorio=="celulas")  //Relatorio de celulas
   {
        $parametros = array_add($parametros, 'segundo_dia_encontro', $input["segundo_dia_encontro"]);
        $parametros = array_add($parametros, 'turno', $input["turno"]);
        $parametros = array_add($parametros, 'dia_encontro', $input["dia_encontro"] );
        $parametros = array_add($parametros, 'id', 0);


            if ($input["tipo"]=="S") //Sintetico, nao listar endereco, fone e email
            {
                $parametros = array_add($parametros, 'exibir_dados_lider', 'N');
            }

            if ($input["ckExibirDadosParticipantes"]=="")
            {
                $parametros = array_add($parametros, 'exibir_dados', 'N');
            }

            if ($descricao_lider[0]!="0") {
                $parametros = array_add($parametros, 'lideres', $descricao_lider[0]);
                $sWhere .= " and lider_pessoas_id = " . $descricao_lider[0];
            } else { //Se for lider logado e ele nao informou a célula, força trazer resultados somente de sua célula

                if ($this->lider_logado!=null) {
                    $parametros = array_add($parametros, 'lideres', $this->lider_logado[0]->lider_pessoas_id);
                    $sWhere .= " and lider_pessoas_id = " . $this->lider_logado[0]->lider_pessoas_id;
                }
            }

            if ($descricao_vice_lider[0]!="0")
            {
                $parametros = array_add($parametros, 'vice_lider', $descricao_vice_lider[0]);
                $sWhere .= " and vicelider_pessoas_id = " . $descricao_vice_lider[0];
            }

              if ($input["ckExibir"]) //Exibir participantes
              {
                    if ($input["ckEstruturas"]) {
                        //$nome_relatorio = public_path() . '/relatorios/listagem_celulas_pessoas_niveis.jasper';
                        $nome_relatorio = public_path() . '/relatorios/listagem_celulas_pessoas_niveis_mod2.jasper';
                    } else {
                        $nome_relatorio = public_path() . '/relatorios/listagem_celulas_pessoas_analitico.jasper';
                    }

              } else
              {
                    if ($input["ckEstruturas"])                    {
                        $nome_relatorio = public_path() . '/relatorios/listagem_celulas_sintetico.jasper';
                    } else {
                         $nome_relatorio = public_path() . '/relatorios/listagem_celulas.jasper';
                    }
              }

            if (isset($input["qtd_inicial"]) && isset($input["qtd_final"])) {
                if ($input["qtd_inicial"]!="" && $input["qtd_final"]!="")
                    $nome_relatorio = public_path() . '/relatorios/listagem_celulas_mult.jasper';
            }

   }
   else if ($tipo_relatorio=="encontro")  //RELATORIO ENCONTROS
   {

        //show/hiden sub report  cursos/eventos
        if (isset($input["ckExibirCurso"])){
           $parametros = array_add($parametros, 'exibir_cursos', ($input["ckExibirCurso"]=="on" ? 1 : 0));
        } else {
            $parametros = array_add($parametros, 'exibir_cursos', 0);
        }

        if ($input["tiporel"]=="0") { //PADRAO
            $parametros = array_add($parametros, 'SUBREPORT_DIR', public_path() . '/relatorios/');
        }

        if ($descricao_lider[0]!="0") {
            $parametros = array_add($parametros, 'lideres', $descricao_lider[0]);
            $sWhere .= " and " . (($input["tiporel"]=="0" || $input["tiporel"]=="3") ? "celulas" : "c"). ".lider_pessoas_id = " . $descricao_lider[0];
        } else { //Se for lider logado e ele nao informou a célula, força trazer resultados somente de sua célula

            if ($this->lider_logado!=null) {
                $parametros = array_add($parametros, 'lideres', $this->lider_logado[0]->lider_pessoas_id);
                $sWhere .= " and " . (($input["tiporel"]=="0" || $input["tiporel"]=="3") ? "celulas" : "c"). ".lider_pessoas_id = " . $this->lider_logado[0]->lider_pessoas_id;
            }
        }

        //se houver logo informada
        if ($input["tiporel"]=="0") { //PADRAO
            if (rtrim(ltrim(\Session::get('logo')))!="") {
                $parametros = array_add($parametros, 'path_logo', public_path() . '/images/clients/' . \Session::get('logo'));
            }
        }

        if ($input["tiporel"]=="0") { //PADRAO
            if ($input["ckExibir"]=="on") {
                  $parametros = array_add($parametros, 'exibir_pessoas', 1);
                  //$nome_relatorio = public_path() . '/relatorios/relatorio_encontro.jasper';
            } else {
                  //$nome_relatorio = public_path() . '/relatorios/relatorio_encontro_resumo_geral_lider2.jasper';
                $parametros = array_add($parametros, 'exibir_pessoas', 0);
            }
        }

        //TIPO DE RELATORIO
        if ($input["tiporel"]=="0") { //PADRAO
            $nome_relatorio = public_path() . '/relatorios/relatorio_encontro.jasper';
        } else if ($input["tiporel"]=="1") { //RESUMO ANUAL
            $nome_relatorio = public_path() . '/relatorios/resumo_celulas_anual.jasper';
        } else if ($input["tiporel"]=="2") { //RESUMO MENSAL
            //$nome_relatorio = public_path() . '/relatorios/resumo_celulas.jasper';
            $nome_relatorio = public_path() . '/relatorios/resumo_celulas_grafico.jasper';
        } else if ($input["tiporel"]=="3") { //VISITANTES
            $nome_relatorio = public_path() . '/relatorios/relatorio_visitantes_geral.jasper';
        }

        if ($input["tiporel"]!="0" && $input["tiporel"]!="3") {
            if (isset($input["ckExibirGraf"])) {
                $parametros = array_add($parametros, 'exibir_grafico', "'S'");
            }
        }

        //$nome_relatorio = public_path() . '/relatorios/relatorio_encontro_novo.jasper';

   }
   else if ($tipo_relatorio=="movimentacoes")  //RELATORIO MOVIMENTACOES
   {

         $nome_relatorio = public_path() . '/relatorios/movimentacao_membros_niveis.jasper';

         if ($descricao_lider[0]!="0")
         {
             $parametros = array_add($parametros, 'celulas_id_atual', $descricao_lider[0]);
         }

         if ($descricao_vice_lider[0]!="0")
         {
             $parametros = array_add($parametros, 'celulas_id_nova', $descricao_vice_lider[0]);
         }

   }

   //debugando - dd($parametros);

    if ($tipo_relatorio!="movimentacoes") {
         $parametros = array_add($parametros, 'sWhere', "'" . $sWhere . "'");
    }


    //dd($parametros);

    \JasperPHP::process(
            $nome_relatorio,
            $output,
            array($ext),
            $parametros,
            $database,
            false,
            false
        )->execute();


            $Mensagem="";

            //dd($parametros);
            if (filesize($output . '.' . $ext)<=1000) //Se arquivo tiver menos de 1k, provavelmente está vazio...
            {

                $Mensagem = "Nenhum Registro Encontrado";
                if ($tipo_relatorio=="celulas")  {
                    return $this->CarregarView('', $Mensagem);
                } else {

                    header('Content-Description: File Transfer');
                    header('Content-Type: application/pdf');
                    header('Content-Disposition: inline; filename=' . $output .'.' . $ext . '');
                    header('Expires: 0');
                    header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
                    header('Content-Length: ' . filesize($output.'.'.$ext));
                    flush();
                    readfile($output.'.'.$ext);
                    unlink($output.'.'.$ext);

                }

            }
                else
            {

                if ($ext=="pdf") //Se for pdf abre direto na pagina
                {

                    header('Content-Description: File Transfer');
                    header('Content-Type: application/pdf');
                    header('Content-Disposition: inline; filename=' . $output .'.' . $ext . '');
                    header('Expires: 0');
                    header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
                    header('Content-Length: ' . filesize($output.'.'.$ext));
                    flush();
                    readfile($output.'.'.$ext);
                    unlink($output.'.'.$ext);
                }
                else //Gera link para download
                {
                    return $this->CarregarView($path_download . '.' . $ext, $Mensagem, ($tipo_relatorio=="celulas" ? "" : "relencontro") );
                }
            }


 }

   //Relatorios estatisticos : Batismos, Multiplicacao, Geral

    protected function imprimir($tipo_relatorio, $nivel, $valor, $mes, $ano, $nome, $saida)
    {

         /*------------------------------------------INICIALIZA PARAMETROS JASPER--------------------------------------------------*/
        //Pega dados de conexao com o banco para o JASPER REPORT
        $database = \Config::get('database.connections.jasper_report');
        $ext = $saida; //Tipo saída (PDF, XLS)
        $output = public_path() . '/relatorios/resultados/' . $ext . '/estatisticas_' . $this->dados_login->empresas_id . '_' . Auth::user()->id; //Path para cada tipo de relatorio
        $path_download = '/relatorios/resultados/' . $ext . '/estatisticas_' . $this->dados_login->empresas_id . '_' .  Auth::user()->id; //Path para cada tipo de relatorio
        /*------------------------------------------INICIALIZA PARAMETROS JASPER--------------------------------------------------*/

        $filtros="";

        if ($mes!="")
             $filtros .= "Mes : " . $mes;

        if ($ano!="")
             $filtros .= "          Ano : " . $ano;

        //Se foi informado algum nivel da estrutura
        if ($nome!="")
             $filtros .= "          " . \Session::get('nivel' . $nivel) . " : " . $nome;


        $parametros = array
        (
            "empresas_id"=> $this->dados_login->empresas_id,
            "empresas_clientes_cloud_id"=> $this->dados_login->empresas_clientes_cloud_id,
            "filtros"=> "'" . ($filtros) . "'"
        );

        //se foi passado nivel, filtra por estrutura da rede
        if (isset($nivel))
        {
            $parametros = array_add($parametros, 'nivel' . $nivel, $valor);
        }

        switch ($tipo_relatorio) {
            case 1: //Resumo Geral
                $nome_relatorio = public_path() . '/relatorios/total_celulas_anual.jasper';
                break;

           case 2: //Batismos Anual
                $nome_relatorio = public_path() . '/relatorios/total_batismos.jasper';
                $parametros = array_add($parametros, 'ano_inicial', (date("Y")-4));
                $parametros = array_add($parametros, 'ano_final', date("Y"));
                break;

            case 3: //Batismos Mensal
                $nome_relatorio = public_path() . '/relatorios/total_batismos_mensal.jasper';
                $parametros = array_add($parametros, 'ano_inicial', date("Y"));
                $parametros = array_add($parametros, 'ano_final', date("Y"));
                break;

            case 4: //Multiplicacoes ano a ano
                $nome_relatorio = public_path() . '/relatorios/total_multiplicacao_anual.jasper';
                $parametros = array_add($parametros, 'ano_inicial', (date("Y")-4));
                $parametros = array_add($parametros, 'ano_final', date("Y"));
                break;

           case 5: //Multiplicacoes mensal
                $nome_relatorio = public_path() . '/relatorios/total_multiplicacao_mensal.jasper';
                $parametros = array_add($parametros, 'ano_inicial', date("Y"));
                $parametros = array_add($parametros, 'ano_final', date("Y"));
                break;

            default:
                # code...
                break;
        }


        \JasperPHP::process(
                $nome_relatorio,
                $output,
                array($ext),
                $parametros,
                $database,
                false,
                false
            )->execute();

                $Mensagem="";

                if (filesize($output . '.' . $ext)<=1000) { //Se arquivo tiver menos de 1k, provavelmente está vazio...

                    $Mensagem = "Nenhum Registro Encontrado";
                    if ($tipo_relatorio=="celulas")  {
                        return $this->CarregarView('', $Mensagem);
                    } else {
                        return redirect('dashboard_celulas');
                    }

                }
                    else
                {

                    if ($ext=="pdf") { //Se for pdf abre direto na pagina

                        header('Content-Description: File Transfer');
                        header('Content-Type: application/pdf');
                        header('Content-Disposition: inline; filename=' . $output .'.' . $ext . '');
                        header('Expires: 0');
                        header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
                        header('Content-Length: ' . filesize($output.'.'.$ext));
                        flush();
                        readfile($output.'.'.$ext);
                        unlink($output.'.'.$ext);
                    }
                    else //Gera link para download
                    {
                        //return $this->CarregarView($path_download . '.' . $ext, $Mensagem);
                        return redirect('home');
                    }
                }

    }

    public function estatisticas(\Illuminate\Http\Request  $request, $tipo_relatorio)
    {

            $this->imprimir($tipo_relatorio, '', '', '', '', '');

     }

    public function estatisticas_nivel(\Illuminate\Http\Request  $request, $tipo_relatorio, $nivel, $valor, $nome, $saida)
    {

            $this->imprimir($tipo_relatorio, $nivel, $valor, '', '', $nome, $saida);

    }


    public function estatisticas_batismos(\Illuminate\Http\Request  $request, $tipo_relatorio, $nivel, $valor, $mes, $ano, $nome, $saida)
    {

            $this->imprimir($tipo_relatorio, $nivel, $valor, $mes, $ano, $nome, $saida);

    }

}