<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Functions;
use URL;
use Auth;
use Input;
use Gate;
use JasperPHP\JasperPHP as JasperPHP;

class RelatorioFinanceiroController extends Controller
{

    public function __construct()
    {
        $this->rota = "relfinanceiro"; //Define nome da rota que será usada na classe
        $this->middleware('auth');

        //Validação de permissão de acesso a pagina
        if (Gate::allows('verifica_permissao', [\Config::get('app.' . $this->rota),'acessar']))
        {
            $this->dados_login = \Session::get('dados_login');
        }
    }

  public function CarregarView($var_download, $var_mensagem) {

    $contas = \App\Models\contas::where('empresas_clientes_cloud_id', $this->dados_login->empresas_clientes_cloud_id)
    ->where('empresas_id', $this->dados_login->empresas_id)
    ->OrderBy('nome')
    ->get();

    $plano_contas = \App\Models\planos_contas::where('empresas_clientes_cloud_id', $this->dados_login->empresas_clientes_cloud_id)
    ->where('empresas_id', $this->dados_login->empresas_id)
    ->OrderBy('nome')
    ->get();

    $centros_custos = \App\Models\centros_custos::where('empresas_clientes_cloud_id', $this->dados_login->empresas_clientes_cloud_id)
    ->where('empresas_id', $this->dados_login->empresas_id)
    ->OrderBy('nome')
    ->get();

    $grupos_titulos = \App\Models\grupos_titulos::where('empresas_clientes_cloud_id', $this->dados_login->empresas_clientes_cloud_id)
    ->where('empresas_id', $this->dados_login->empresas_id)
    ->OrderBy('nome')
    ->get();

    return view($this->rota . '.index',
        [
            'var_download' => $var_download,
            'centros_custos'=>$centros_custos,
            'planos_contas'=>$plano_contas,
            'contas'=>$contas,
            'grupos_titulos'=>$grupos_titulos,
            'var_mensagem'=>$var_mensagem
            ]);
}


public function index() {

    if (\App\ValidacoesAcesso::PodeAcessarPagina(\Config::get('app.' . $this->rota))==false) {
          return redirect('home');
    }

    return $this->CarregarView('', '');

}


 public function pesquisar(\Illuminate\Http\Request  $request)
 {

        /*Pega todos campos enviados no post*/
        $input = $request->except(array('_token', 'ativo')); //não levar o token

        $this->validate($request, [
            'opTipo' => 'required',
        ]);


        /*------------------------------------------INICIALIZA PARAMETROS JASPER--------------------------------------------------*/
        //Pega dados de conexao com o banco para o JASPER REPORT
        $database = \Config::get('database.connections.jasper_report');
        $ext = $input["resultado"]; //Tipo saída (PDF, XLS)
        $output = public_path() . '/relatorios/resultados/' . $ext . '/financeiro_' . $this->dados_login->empresas_id . '_' . Auth::user()->id; //Path para cada tipo de relatorio
        $path_download = '/relatorios/resultados/' . $ext . '/financeiro_' . $this->dados_login->empresas_id . '_' .  Auth::user()->id; //Path para cada tipo de relatorio
        /*------------------------------------------INICIALIZA PARAMETROS JASPER--------------------------------------------------*/

        /*Instancia biblioteca de funcoes globais*/
        $formatador = new  \App\Functions\FuncoesGerais();

        $filtros = "";
        $descricao_status="";
        $descricao_centrocusto="";
        $descricao_planocontas="";
        $descricao_grupostitulos="";
        $descricao_contas="";

        if ($input["contas"]!="") $descricao_contas = explode("|", $input["contas"]);
        if ($input["planos_contas"]!="") $descricao_planocontas = explode("|", $input["planos_contas"]);
        if ($input["centros_custos"]!="") $descricao_centrocusto = explode("|", $input["centros_custos"]);
        if ($input["status_id"]!="") $descricao_status = explode("|", $input["status_id"]);
        if ($input["grupos"]!="") $descricao_grupostitulos = explode("|", $input["grupos"]);

        //INICIALIZA CLAUSULA WHERE QUE SERA PASSADA AO RELATORIO
        $sWhere = " empresas_id = " . $this->dados_login->empresas_id . " and empresas_clientes_cloud_id = " .$this->dados_login->empresas_clientes_cloud_id . "";
        //$sWhere .= " and tipo = '" . $input["opTipo"] . "'";  //CONTAS A PAGAR OU RECEBER

        if ($input["opTipo"]=="P") {
            $filtros .= "   Tipo : Contas a Pagar";
        } else if ($input["opTipo"]=="R") {
            $filtros .= "   Tipo : Contas a Receber";
        }

        if ($input["opTipo"]!="M") {
            if ($input["status_id"]!="T") {
                $filtros .= "   Status : " . ($input["status_id"]=="A" ? "Aberto" : ($input["status_id"]=="B" ? "Baixado" : "Ambos"));
                //$sWhere .= " and status = '" . $input["status_id"] . "'";  //ABERTO OU BAIXADOS
            }
        }

        if ($input["contas"]!="") {
            $filtros .= "   Conta : " . $descricao_contas[1];
            $sWhere .= " and contas_id = " . ($descricao_contas=="" ? 0 : $descricao_contas[0]);  //CONTA CORRENTE
        }

        if ($input["centros_custos"]!="") {
            $filtros .= "   Centro de Custo : " . $descricao_centrocusto[1];
            $sWhere .= " and centros_custos_id = " . ($descricao_centrocusto=="" ? 0 : $descricao_centrocusto[0]);
        }

        if ($input['fornecedor']!="") {
            $filtros .= "   Fornecedor/Cliente : " . $input['fornecedor'];
            $sWhere .= " and pessoas_id = " . ($input['fornecedor']=="" ? null : substr($input['fornecedor'],0,9));
        }

        if ($input["planos_contas"]!="") {
            $filtros .= "   Plano de Contas : " . $descricao_planocontas[1];
            $sWhere .= " and planos_contas_id = " . ($descricao_planocontas=="" ? 0 : $descricao_planocontas[0]);
        }

        if ($descricao_grupostitulos!="") {
            $filtros .= "   Grupo Titulos : " . $descricao_grupostitulos[1];
            $sWhere .= " and grupos_titulos_id = " . ($descricao_grupostitulos=="" ? 0 : $descricao_grupostitulos[0]);
        }

        if ($input["data_vencimento"]!="") {
            $filtros .= "   Dt. Vencimento : " . $input["data_vencimento"] . " até " . $input["data_vencimento_ate"] ;
        }

        if ($input["data_pagamento"]!="") {
            $filtros .= "   Dt. Pagamento : " . $input["data_pagamento"] . " até " . $input["data_pagamento_ate"] ;
        }

        //Parametros JASPER REPORT
        /*$parametros = array
        (
            "empresas_id"=> $this->dados_login->empresas_id,
            "empresas_clientes_cloud_id"=> $this->dados_login->empresas_clientes_cloud_id,
            "tipo"=>"'" . $input["opTipo"] . "'",
            "centros_custos_id" => ($descricao_centrocusto=="" ? 0 : $descricao_centrocusto[0]),
            "planos_contas_id" => ($descricao_planocontas=="" ? 0 : $descricao_planocontas[0]),
            "grupos_titulos_id"=> ($descricao_grupostitulos=="" ? 0 : $descricao_grupostitulos[0]),
            "pessoas_id"=> ($input['fornecedor']=="" ? 0 : substr($input['fornecedor'],0,9)),
            "filtros"=> "'" . ($filtros) . "'",
            "REPORT_LOCALE"=> "pt",
        );
        */

        //Parametros JASPER REPORT
        $parametros = array
        (
            "filtros"=> "'" . ($filtros) . "'",
            "tipo"=>"'" . $input["opTipo"] . "'",
            "REPORT_LOCALE"=> "pt",
        );


        if ($input["opTipo"]=="M") { //SE FOR RELATORIO DE MOVIMENTACAO DE CONTA / CAIXA

            if ($input["ordem"]=="data_pagamento") {
                $nome_relatorio = public_path() . '/relatorios/listagem_movimentacao.jasper';
            } else if ($input["ordem"]=="centro_custo") {
                $nome_relatorio = public_path() . '/relatorios/listagem_movimentacao_cc.jasper';
            } else if ($input["ordem"]=="plano_contas") {
                $nome_relatorio = public_path() . '/relatorios/listagem_movimentacao_pc.jasper';
            }


        } else {

            //DIRECIONA PARA O RELATORIO CONFORME ORDEM / QUEBRA SELECIONADA
            if ($input["ordem"]=="data_vencimento") {
                $nome_relatorio = public_path() . '/relatorios/listagem_titulos_venc.jasper';
            } else if ($input["ordem"]=="data_pagamento") {
                $nome_relatorio = public_path() . '/relatorios/listagem_titulos_dtpagto.jasper';
            } else if ($input["ordem"]=="centro_custo") {
                $nome_relatorio = public_path() . '/relatorios/listagem_titulos_cc.jasper';
            } else if ($input["ordem"]=="plano_contas") {
                $nome_relatorio = public_path() . '/relatorios/listagem_titulos_pc.jasper';
            } else if ($input["ordem"]=="cc_pc") {
                $nome_relatorio = public_path() . '/relatorios/listagem_titulos_agrupado.jasper';
            }

        }


        //Se status for diferente de ambos
        if ($input["opTipo"]!="M") {
            if ($input["status_id"]!="T") {
                $parametros = array_add($parametros, 'status', $input["status_id"]);
            }
        } else if ($input["opTipo"]=="M") {
            $parametros = array_add($parametros, 'status', "B");
        }

        //Filtra conta corrente
        //if ($input["contas"]!="")
        //{
            //$parametros = array_add($parametros, 'contas_id', ($descricao_contas=="" ? 0 : $descricao_contas[0]));
        //}

        //Data de pagamento
        if ($input["data_pagamento"]!="" && $input["data_pagamento_ate"]!="")
        {
            $parametros = array_add($parametros, 'data_pagamento_inicial', ($input["data_pagamento"]=="" ? '' : $formatador->FormatarData($input["data_pagamento"])));
            $parametros = array_add($parametros, 'data_pagamento_final', ($input["data_pagamento_ate"]=="" ? '' : $formatador->FormatarData($input["data_pagamento_ate"])));
        }

        //Data de vencimento
        if ($input["data_vencimento"]!="" && $input["data_vencimento_ate"]!="")
        {
            $parametros = array_add($parametros, 'data_vencimento_inicial', ($input["data_vencimento"]=="" ? '' : $formatador->FormatarData($input["data_vencimento"])));
            $parametros = array_add($parametros, 'data_vencimento_final', ($input["data_vencimento_ate"]=="" ? '' : $formatador->FormatarData($input["data_vencimento_ate"])));
        }

        //Passando paremetro com clausula where montada
        $parametros = array_add($parametros, 'sWhere', "'" . $sWhere . "'");


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
            return $this->CarregarView('', $Mensagem);
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

}