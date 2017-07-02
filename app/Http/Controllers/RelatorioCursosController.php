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

class RelatorioCursosController extends Controller
{

    public function __construct()
    {

        $this->rota = "relcursos"; //Define nome da rota que será usada na classe
        $this->middleware('auth');

        //Validação de permissão de acesso a pagina
        if (Gate::allows('verifica_permissao', [\Config::get('app.' . $this->rota),'acessar']))
        {
            $this->dados_login = \Session::get('dados_login');
        }

    }

 public function CarregarView($var_download, $var_mensagem)
{

        /*Busca Lideres*/
        $lideres = \DB::select('select * from view_lideres where empresas_id = ? and empresas_clientes_cloud_id = ? ', [$this->dados_login->empresas_id, $this->dados_login->empresas_clientes_cloud_id]);

        $cursos = \App\Models\cursos::where(['empresas_id' => $this->dados_login->empresas_id, 'empresas_clientes_cloud_id' => $this->dados_login->empresas_clientes_cloud_id])->orderBy('nome','ASC')->get();

        /*Busca Niveis*/
        $view1 = \DB::select('select * from view_celulas_nivel1 v1 where v1.empresas_id = ? and v1.empresas_clientes_cloud_id = ? ', [$this->dados_login->empresas_id, $this->dados_login->empresas_clientes_cloud_id]);
        $view2 = \DB::select('select * from view_celulas_nivel2 v2 where v2.empresas_id = ? and v2.empresas_clientes_cloud_id = ? ', [$this->dados_login->empresas_id, $this->dados_login->empresas_clientes_cloud_id]);
        $view3 = \DB::select('select * from view_celulas_nivel3 v3 where v3.empresas_id = ? and v3.empresas_clientes_cloud_id = ? ', [$this->dados_login->empresas_id, $this->dados_login->empresas_clientes_cloud_id]);
        $view4 = \DB::select('select * from view_celulas_nivel4 v4 where v4.empresas_id = ? and v4.empresas_clientes_cloud_id = ? ', [$this->dados_login->empresas_id, $this->dados_login->empresas_clientes_cloud_id]);
        $view5 = \DB::select('select * from view_celulas_nivel5 v5 where v5.empresas_id = ? and v5.empresas_clientes_cloud_id = ? ', [$this->dados_login->empresas_id, $this->dados_login->empresas_clientes_cloud_id]);

        return view($this->rota . '.index', ['cursos'=>$cursos, 'nivel1'=>$view1, 'nivel2'=>$view2, 'nivel3'=>$view3, 'nivel4'=>$view4, 'nivel5'=>$view5,  'lideres'=>$lideres, 'var_download' => $var_download, 'var_mensagem'=>$var_mensagem]);

}

public function index()
{

        if (\App\ValidacoesAcesso::PodeAcessarPagina(\Config::get('app.' . $this->rota))==false)
        {
              return redirect('home');
        }

        return $this->CarregarView('','');
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

    /*Instancia biblioteca de funcoes globais*/
    $formatador = new  \App\Functions\FuncoesGerais();

    $filtros = "";
    $descricao_lider="";
    $descricao_curso="";
    $descricao_nivel1="";
    $descricao_nivel2="";
    $descricao_nivel3="";
    $descricao_nivel4="";
    $descricao_nivel5="";

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
   $sWhere = " c.empresas_id = " . $this->dados_login->empresas_id . " and c.empresas_clientes_cloud_id = " .$this->dados_login->empresas_clientes_cloud_id . "";

   //parameters fields to jasper report
   $parametros = array();

   if (isset($input["lideres"])) {
        if ($input["lideres"]!="") $descricao_lider = explode("|", $input["lideres"]);

        if ($descricao_lider[0]!="0")  {
            $filtros .= "     Celula : " . $descricao_lider[1];
            $sWhere .= " and cel.lider_pessoas_id = " . $descricao_lider[0];
        }
   }


   if (isset($input["curso"]))
   {
        if ($input["curso"]!="")  {
            $descricao_curso = explode("|", $input["curso"]);

            $filtros .= "     Curso / Evento : " . $descricao_curso[1];
            $sWhere .= " and cursos_id = " . $descricao_curso[0];
        }
   }

    if (isset($input["ministrante"]))
    {
        if ($input["ministrante"]!="")  {
            $filtros .= "     Ministrante : " . $input["ministrante"];
            $sWhere .= " and ministrante_id = " . substr($input['ministrante'],0,9);
        }
    }

    if (isset($input["participante"]))
    {
        if ($input["participante"]!="")  {
            $filtros .= "     Pessoa : " . $input["participante"];
            $sWhere .= " and cp.pessoas_id = " . substr($input['participante'],0,9);
        }
    }

    if (isset($input["data_inicio"]))
    {
        if (trim($input["data_inicio"])!="") {
             $parametros = array_add($parametros, 'data_inicio', $formatador->FormatarData($input["data_inicio"]));
             $filtros .= "     Data Inicial : " . $input["data_inicio"];
        }
    }

    if (isset($input["data_fim"]))
    {
        if (trim($input["data_fim"])!="") {
             $filtros .= "     Data Final : " . $input["data_fim"];
             $parametros = array_add($parametros, 'data_fim', $formatador->FormatarData($input["data_fim"]));
         }
    }

    if ($descricao_nivel1!="" && $descricao_nivel1[0]!="0") {
        $sWhere .= " and " . ($tipo_relatorio=="encontro" ? "celulas." : "") . "celulas_nivel1_id = " . $descricao_nivel1[0];
    }

    if ($descricao_nivel2!="" && $descricao_nivel2[0]!="0") {
        $sWhere .= " and " . ($tipo_relatorio=="encontro" ? "celulas." : "") . "celulas_nivel2_id = " . $descricao_nivel2[0];
    }

    if ($descricao_nivel3!="" && $descricao_nivel3[0]!="0") {
        $sWhere .= " and " . ($tipo_relatorio=="encontro" ? "celulas." : "") . "celulas_nivel3_id = " . $descricao_nivel3[0];
    }

    if ($descricao_nivel4!="" && $descricao_nivel4[0]!="0") {
        $sWhere .= " and " . ($tipo_relatorio=="encontro" ? "celulas." : "") . "celulas_nivel4_id = " . $descricao_nivel4[0];
    }

    if ($descricao_nivel5!="" && $descricao_nivel5[0]!="0") {
        $sWhere .= " and " . ($tipo_relatorio=="encontro" ? "celulas." : "") . "celulas_nivel5_id = " . $descricao_nivel5[0];
    }

    //Selecionar tipo de relatorio
    if ($input["tipo"]=="1") {
        $nome_relatorio = public_path() . '/relatorios/relatorio_pessoa_cursos.jasper';
    } else if ($input["tipo"]=="2") {
        $nome_relatorio = public_path() . '/relatorios/relatorio_cursos_pessoas.jasper';
    } else if ($input["tipo"]=="3") {
        $nome_relatorio = public_path() . '/relatorios/relatorio_cursos_datas.jasper';
    }

    //set parameter sWhere for query in report
    $parametros = array_add($parametros, 'sWhere', "'" . $sWhere . "'");
    $parametros = array_add($parametros, 'filtros', "'" . $filtros . "'");

    //echo $nome_relatorio;
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
                    return $this->CarregarView($path_download . '.' . $ext, $Mensagem);
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

                if (filesize($output . '.' . $ext)<=1000) //Se arquivo tiver menos de 1k, provavelmente está vazio...
                {

                    $Mensagem = "Nenhum Registro Encontrado";
                    if ($tipo_relatorio=="celulas")  {
                        return $this->CarregarView('', $Mensagem);
                    } else {
                        return redirect('dashboard_celulas');
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