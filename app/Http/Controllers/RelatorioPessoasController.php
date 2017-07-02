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

class RelatorioPessoasController extends Controller
{

    public function __construct()
    {
        $this->rota = "relpessoas"; //Define nome da rota que será usada na classe
        $this->middleware('auth');

        //Validação de permissão de acesso a pagina
        if (Gate::allows('verifica_permissao', [\Config::get('app.' . $this->rota),'acessar']))
        {
            $this->dados_login = \Session::get('dados_login');
        }
    }

    public function CarregarView($var_download, $var_mensagem) {

        $disponibilidades = \App\Models\disponibilidades::where('clientes_cloud_id', $this->dados_login->empresas_clientes_cloud_id)->orderBy('nome','ASC')->get();
        $dons = \App\Models\dons::where('clientes_cloud_id', $this->dados_login->empresas_clientes_cloud_id)->orderBy('nome','ASC')->get();
        $tiposrelacionamentos = \App\Models\tiposrelacionamentos::where('clientes_cloud_id', $this->dados_login->empresas_clientes_cloud_id)->orderBy('nome','ASC')->get();
        $habilidades = \App\Models\habilidades::where('clientes_cloud_id', $this->dados_login->empresas_clientes_cloud_id)->orderBy('nome','ASC')->get();
        $religioes = \App\Models\religioes::where('clientes_cloud_id', $this->dados_login->empresas_clientes_cloud_id)->orderBy('nome','ASC')->get();
        $atividades = \App\Models\atividades::where('clientes_cloud_id', $this->dados_login->empresas_clientes_cloud_id)->orderBy('nome','ASC')->get();
        $ministerios = \App\Models\ministerios::where('clientes_cloud_id', $this->dados_login->empresas_clientes_cloud_id)->orderBy('nome','ASC')->get();
        $ramos = \App\Models\ramos::where('clientes_cloud_id', $this->dados_login->empresas_clientes_cloud_id)->orderBy('nome','ASC')->get();
        $cargos = \App\Models\cargos::where('clientes_cloud_id', $this->dados_login->empresas_clientes_cloud_id)->orderBy('nome','ASC')->get();
        $profissoes = \App\Models\profissoes::where('clientes_cloud_id', $this->dados_login->empresas_clientes_cloud_id)->orderBy('nome','ASC')->get();
        $graus = \App\Models\graus::where('clientes_cloud_id', $this->dados_login->empresas_clientes_cloud_id)->orderBy('nome','ASC')->get();
        $idiomas = \App\Models\idiomas::where('clientes_cloud_id', $this->dados_login->empresas_clientes_cloud_id)->orderBy('nome','ASC')->get();
        $formacoes = \App\Models\areas::where('clientes_cloud_id', $this->dados_login->empresas_clientes_cloud_id)->orderBy('nome','ASC')->get();
        $motivos = \App\Models\tiposmovimentacao::where('clientes_cloud_id', $this->dados_login->empresas_clientes_cloud_id)->orderBy('nome','ASC')->get();
        $tipos = \App\Models\tipospessoas::where('clientes_cloud_id', $this->dados_login->empresas_clientes_cloud_id)->orderBy('nome','ASC')->get();
        $situacoes = \App\Models\situacoes::where('clientes_cloud_id', $this->dados_login->empresas_clientes_cloud_id)->orderBy('nome','ASC')->get();
        $status = \App\Models\status::where('clientes_cloud_id', $this->dados_login->empresas_clientes_cloud_id)->orderBy('nome','ASC')->get();
        $estadoscivis = \App\Models\civis::where('clientes_cloud_id', $this->dados_login->empresas_clientes_cloud_id)->orderBy('nome','ASC')->get();
        $grupos = \App\Models\grupospessoas::where('empresas_clientes_cloud_id', $this->dados_login->empresas_clientes_cloud_id)->where('empresas_id', $this->dados_login->empresas_id)->orderBy('nome','ASC')->get();
        $igrejas = \App\Models\igrejas::where('clientes_cloud_id', $this->dados_login->empresas_clientes_cloud_id)->orderBy('nome','ASC')->get();

        /*Busca Nivel1*/
        $view1 = \DB::select('select * from view_celulas_nivel1 v1 where v1.empresas_id = ? and v1.empresas_clientes_cloud_id = ? ', [$this->dados_login->empresas_id, $this->dados_login->empresas_clientes_cloud_id]);
        $view2 = \DB::select('select * from view_celulas_nivel2 v2 where v2.empresas_id = ? and v2.empresas_clientes_cloud_id = ? ', [$this->dados_login->empresas_id, $this->dados_login->empresas_clientes_cloud_id]);
        $view3 = \DB::select('select * from view_celulas_nivel3 v3 where v3.empresas_id = ? and v3.empresas_clientes_cloud_id = ? ', [$this->dados_login->empresas_id, $this->dados_login->empresas_clientes_cloud_id]);
        $view4 = \DB::select('select * from view_celulas_nivel4 v4 where v4.empresas_id = ? and v4.empresas_clientes_cloud_id = ? ', [$this->dados_login->empresas_id, $this->dados_login->empresas_clientes_cloud_id]);
        $view5 = \DB::select('select * from view_celulas_nivel5 v5 where v5.empresas_id = ? and v5.empresas_clientes_cloud_id = ? ', [$this->dados_login->empresas_id, $this->dados_login->empresas_clientes_cloud_id]);

        return view($this->rota . '.index',
            [
                'disponibilidades'=>$disponibilidades,
                'dons'=>$dons,
                'tiposrelacionamentos'=>$tiposrelacionamentos,
                'habilidades'=>$habilidades,
                'religioes'=>$religioes,
                'atividades'=>$atividades,
                'ministerios'=>$ministerios,
                'nivel1'=>$view1,
                'nivel2'=>$view2,
                'nivel3'=>$view3,
                'nivel4'=>$view4,
                'nivel5'=>$view5,
                'motivos'=>$motivos,
                'ramos'=>$ramos,
                'cargos'=>$cargos,
                'profissoes'=>$profissoes,
                'graus'=>$graus,
                'idiomas'=>$idiomas,
                'formacoes'=>$formacoes,
                'tipos'=>$tipos,
                'situacoes'=>$situacoes,
                'estadoscivis'=>$estadoscivis,
                'status'=>$status,
                'grupos'=>$grupos,
                'emails'=>'', 'filtros'=>'',
                'var_download' => $var_download,
                'var_mensagem' => $var_mensagem,
                'igrejas'=>$igrejas
                ]);
    }


    public function index()
    {

        if (\App\ValidacoesAcesso::PodeAcessarPagina(\Config::get('app.' . $this->rota))==false)
        {
              return redirect('home');
        }

        return $this->CarregarView('','');

    }



      public function pesquisar_aniversariantes($querystring)
      {

            /*------------------------------------------INICIALIZA PARAMETROS JASPER--------------------------------------------------*/
            //Pega dados de conexao com o banco para o JASPER REPORT
            $database = \Config::get('database.connections.jasper_report');
            $ext = "pdf"; //Tipo saída (PDF, XLS)
            $output = public_path() . '/relatorios/resultados/' . $ext . '/relatorio_' . $this->dados_login->empresas_id . '_' . Auth::user()->id; //Path para cada tipo de relatorio
            $path_download = '/relatorios/resultados/' . $ext . '/relatorio_' . $this->dados_login->empresas_id . '_' .  Auth::user()->id; //Path para cada tipo de relatorio
            /*------------------------------------------INICIALIZA PARAMETROS JASPER--------------------------------------------------*/


            //Parametros JASPER REPORT
            $parametros = array
            (
                "empresas_id"=> $this->dados_login->empresas_id,
                "empresas_clientes_cloud_id"=> $this->dados_login->empresas_clientes_cloud_id
            );

            //$parametros = array_add($parametros, 'ordem', 'razaosocial');

            if ($querystring=="mes")
            {
                    $nome_relatorio = public_path() . '/relatorios/listagem_aniversariantes_mes.jasper';
            }
            else if ($querystring=="dia")
            {
                    $nome_relatorio = public_path() . '/relatorios/listagem_aniversariantes_dia.jasper';
            }

           //$nome_relatorio = public_path() . '/relatorios/listagem_aniversariantes.jasper';

            //Executa JasperReport
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
                    //header('Content-Transfer-Encoding: binary');
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

public function relatorio_pessoas_tipo($conteudo, $opcao='') {

    //Pega dados de conexao com o banco para o JASPER REPORT
    $database = \Config::get('database.connections.jasper_report');
    $ext = "pdf";
    $output = public_path() . '/relatorios/resultados/' . $ext . '/relatorio_' . $this->dados_login->empresas_id . '_' . Auth::user()->id; //Path para cada tipo de relatorio
    $path_download = '/relatorios/resultados/' . $ext . '/relatorio_' . $this->dados_login->empresas_id . '_' .  Auth::user()->id; //Path para cada tipo de relatorio
    $nome_relatorio = public_path() . '/relatorios/listagem_pessoas_tipo.jasper';
    /*------------------------------------------INICIALIZA PARAMETROS JASPER--------------------------------------------------*/

    //Parametros JASPER REPORT
    $parametros = array
    (
        "empresas_id"=> $this->dados_login->empresas_id,
        "empresas_clientes_cloud_id"=> $this->dados_login->empresas_clientes_cloud_id,
        "empresas_clientes_cloud_id"=> $this->dados_login->empresas_clientes_cloud_id,
    );

    if ($opcao=="tipo") {
        $tipos = \App\Models\tipospessoas::select('id', 'nome')->where('id', $conteudo)->get();
        $parametros = array_add($parametros, 'tipos', $conteudo);
        $parametros = array_add($parametros, 'filtros', "' Tipo de Pessoa : " . ($tipos[0]->nome) . "'");
    } else if ($opcao=="sexo") {
        $parametros = array_add($parametros, 'sexo', $conteudo);
        $parametros = array_add($parametros, 'filtros', "' Sexo : " . $conteudo . "'");
    } else if ($opcao=="estadoscivis") {
        $tipos = \App\Models\civis::select('id', 'nome')->where('id', $conteudo)->get();
        $parametros = array_add($parametros, 'estadoscivis', $conteudo);
        $parametros = array_add($parametros, 'filtros', "' Estado Civil : " . ($tipos[0]->nome) . "'");
    } else if ($opcao=="status") {
        $tipos = \App\Models\status::select('id', 'nome')->where('id', $conteudo)->get();
        $parametros = array_add($parametros, 'status_id', $conteudo);
        $parametros = array_add($parametros, 'filtros', "' Status  : " . ($tipos[0]->nome) . "'");
    }


     //Executa JasperReport
     \JasperPHP::process(
            $nome_relatorio,
            $output,
            array($ext),
            $parametros,
            $database,
            false,
            false
        )->execute();

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

  public function pesquisar(\Illuminate\Http\Request  $request)
  {

     /*Pega todos campos enviados no post*/
    $input = $request->except(array('_token', 'ativo')); //não levar o token
    /*------------------------------------------INICIALIZA PARAMETROS JASPER--------------------------------------------------*/
    //Pega dados de conexao com o banco para o JASPER REPORT
    $database = \Config::get('database.connections.jasper_report');
    $ext = $input["resultado"]; //Tipo saída (PDF, XLS)
    $output = public_path() . '/relatorios/resultados/' . $ext . '/relatorio_' . $this->dados_login->empresas_id . '_' . Auth::user()->id; //Path para cada tipo de relatorio
    $path_download = '/relatorios/resultados/' . $ext . '/relatorio_' . $this->dados_login->empresas_id . '_' .  Auth::user()->id; //Path para cada tipo de relatorio
    /*------------------------------------------INICIALIZA PARAMETROS JASPER--------------------------------------------------*/
    /*Instancia biblioteca de funcoes globais*/
    $formatador = new  \App\Functions\FuncoesGerais();
    $filtros = "";
    $descricao_status="";
    $descricao_situacoes="";
    $descricao_formacao="";
    $descricao_tipos="";
    $descricao_estado_civil="";
    $descricao_motivo_ent="";
    $descricao_motivo_sai="";
    $descricao_profissao="";
    $descricao_grupo="";
    $descricao_nivel1="";
    $descricao_nivel2="";
    $descricao_nivel3="";
    $descricao_nivel4="";
    $descricao_nivel5="";
    $descricao_idiomas="";
    $descricao_graus="";
    $descricao_ramos="";
    $descricao_cargos="";
    $descricao_disponibilidade="";
    $descricao_religiao="";
    $descricao_dons="";
    $descricao_habilidade="";
    $descricao_atividade="";
    $descricao_ministerio="";
    $where="";
    if ($input["situacoes"]!="") $descricao_situacoes = explode("|", $input["situacoes"]);
    if ($input["estadoscivis"]!="") $descricao_estado_civil = explode("|", $input["estadoscivis"]);
    if ($input["tipos"]!="") $descricao_tipos = explode("|", $input["tipos"]);
    if ($input["status_id"]!="") $descricao_status = explode("|", $input["status_id"]);
    if ($input["idiomas_id"]!="") $descricao_idiomas = explode("|", $input["idiomas_id"]);
    if ($input["formacoes_id"]!="") $descricao_formacao = explode("|", $input["formacoes_id"]);
    if ($input["profissoes_id"]!="") $descricao_profissao = explode("|", $input["profissoes_id"]);
    if ($input["religioes_id"]!="") $descricao_religiao = explode("|", $input["religioes_id"]);
    if ($input["ramos_id"]!="") $descricao_ramos = explode("|", $input["ramos_id"]);
    if ($input["cargos_id"]!="") $descricao_cargos = explode("|", $input["cargos_id"]);
    if ($input["graus_id"]!="") $descricao_graus = explode("|", $input["graus_id"]);
    if ($input["habilidades_id"]!="") $descricao_habilidade = explode("|", $input["habilidades_id"]);
    if ($input["ministerios_id"]!="") $descricao_ministerio = explode("|", $input["ministerios_id"]);
    if ($input["dons_id"]!="") $descricao_don = explode("|", $input["dons_id"]);
    if ($input["atividades_id"]!="") $descricao_atividade = explode("|", $input["atividades_id"]);
    if ($input["disponibilidades_id"]!="") $descricao_disponibilidade = explode("|", $input["disponibilidades_id"]);
    if ($input["motivoentrada"]!="") $descricao_motivo_ent = explode("|", $input["motivoentrada"]);
    if ($input["motivosaida"]!="") $descricao_motivo_sai = explode("|", $input["motivosaida"]);
    if ($input["grupo"]!="") $descricao_grupo = explode("|", $input["grupo"]);
    if ($input["nivel1_up"]!="") $descricao_nivel1 = explode("|", $input["nivel1_up"]);
    if ($input["nivel2_up"]!="") $descricao_nivel2 = explode("|", $input["nivel2_up"]);
    if ($input["nivel3_up"]!="") $descricao_nivel3 = explode("|", $input["nivel3_up"]);
    if ($input["nivel4_up"]!="") $descricao_nivel4 = explode("|", $input["nivel4_up"]);
    if ($input["nivel5_up"]!="") $descricao_nivel5 = explode("|", $input["nivel5_up"]);
    $where = " where p.empresas_id = " . $this->dados_login->empresas_id . "  and p.empresas_clientes_cloud_id = " . $this->dados_login->empresas_clientes_cloud_id . " and (emailprincipal is not null and emailprincipal<> '') ";
    /*Filtros utilizados*/
    if ($input["possui_necessidades_especiais"]!="")
    {
        $filtros .= "   Possui Necessidades Esp.: " . ($input["possui_necessidades_especiais"]=="1" ? "Sim" : "Nao");
        $where .= " and possui_necessidades_especiais = " . ($input["possui_necessidades_especiais"]=="true" ? "true" : "false");
    }
    if ($input["doador_orgaos"]!="")
    {
        $filtros .= "   Doador Orgaos: " . ($input["doador_orgaos"]=="1" ? "Sim" : "Nao");
        $where .= " and doador_orgaos = " . ($input["doador_orgaos"]=="1" ? "true" : "false");
    }
    if ($input["doador_sangue"]!="")
    {
        $filtros .= "   Doador Sangue : " . ($input["doador_sangue"]=="1" ? "Sim" : "Nao");
        $where .= " and doador_sangue = " . ($input["doador_sangue"]=="1" ? "true" : "false");
    }
    if ($input["status"]!="")
    {
        $filtros .= "   Status Cadastro : " . ($input["status"]=="S" ? "Ativo" : "Inativo");
        $where .= " and ativo = '" . $input["status"] . "'";
    }
    if ($input["graus_id"]!="")
    {
        $filtros .= "   Grau Instrucao : " . $descricao_graus[1];
        $where .= " and graus_id = " . $descricao_graus[0];
    }
    if ($input["formacoes_id"]!="")
    {
        $filtros .= "   Area de Formacao : " . $descricao_formacao[1];
        $where .= " and formacoes_id = " . $descricao_formacao[0];
    }
    if ($input["profissoes_id"]!="")
    {
        $filtros .= "   Profissao : " . $descricao_profissao[1];
        $where .= " and mprof.profissoes_id = " . $descricao_profissao[0];
    }
    if ($input["ramos_id"]!="")
    {
        $filtros .= "   Ramo Atividade : " . $descricao_ramos[1];
        $where .= " and ramos_id = " . $descricao_ramos[0];
    }
    if ($input["cargos_id"]!="")
    {
        $filtros .= "   Cargo : " . $descricao_cargos[1];
        $where .= " and cargos_id = " . $descricao_cargos[0];
    }
    if ($input["disponibilidades_id"]!="")
    {
        $filtros .= "   Disponibilidade : " . $descricao_disponibilidade[1];
        $where .= " and disponibilidades_id = " . $descricao_disponibilidade[0];
    }
    if ($input["tipo_sangue"]!="")
    {
        $filtros .= "   Tipo Sanguineo : " . strtoupper($input["tipo_sangue"]);
        $where .= " and grupo_sanguinio = '" . strtoupper($input["tipo_sangue"]) . "'";
    }
    if ($input["religioes_id"]!="")
    {
        $filtros .= "   Religiao : " . $descricao_religiao[1];
        $where .= " and religioes_id = " . $descricao_religiao[0];
    }
    if ($input["dons_id"]!="")
    {
        $filtros .= "   Don : " . $descricao_don[1];
        $where .= " and dons_id = " . $descricao_don[0];
    }
    if ($input["habilidades_id"]!="")
    {
        $filtros .= "   Habilidade : " . $descricao_habilidade[1];
        $where .= " and habilidades_id = " . $descricao_habilidade[0];
    }
    if ($input["atividades_id"]!="")
    {
        $filtros .= "   Atividade : " . $descricao_atividade[1];
        $where .= " and atividades_id = " . $descricao_atividade[0];
    }
    if ($input["ministerios_id"]!="")
    {
        $filtros .= "   Ministerio : " . $descricao_ministerio[1];
        $where .= " and ministerios_id = " . $descricao_ministerio[0];
    }
    if ($input["idiomas_id"]!="")
    {
        $filtros .= "   Idioma : " . $descricao_idiomas[1];
        $where .= " and mi.idiomas_id = " . $descricao_idiomas[0];
    }
    if ($input["mes"]!="")
    {

        if ($input["r1"]=="1") { //nascimento

            $filtros .= "   Mes Aniversario : " . $input["mes"];
            $where .= " and to_char(p.datanasc, 'MM') = '" . $input["mes"] . "'";

        } else if ($input["r1"]=="2") { //casamento

            $filtros .= "   Mes Casamento : " . $input["mes"];
            $where .= " and date_part('month', to_date(data_casamento,'yyyy-MM-dd')) = '" . $input["mes"] . "'";

        } else if ($input["r1"]=="3") { //batismo

            $filtros .= "   Mes Batismo: " . $input["mes"];
            $where .= " and date_part('month', to_date(data_batismo,'yyyy-MM-dd')) = '" . $input["mes"] . "'";

        }


    }
    if ($input["ano_inicial"]!="" && $input["ano_final"]!="" )
    {
        $filtros .= "   Periodo Ano : " . $input["ano_inicial"] . " - " . $input["ano_final"];
        $where .= " and ano >= '" . $input["ano_inicial"] . "'";
        $where .= " and ano <= '" . $input["ano_final"] . "'";
    }
    if ($input["sexo"]!="")
    {
        $filtros .= "   Sexo : " . ($input["sexo"]=="M" ? "Masculino" : "Feminino");
        $where .= " and sexo = '" . $input["sexo"] . "'";
    }
    if ($descricao_estado_civil!="")
    {
        $filtros .= "   Estado Civil : " . $descricao_estado_civil[1];
        $where .= " and estadoscivis_id = " . $descricao_estado_civil[0];
    }
    if ($descricao_grupo!="")
    {
        $filtros .= "   Grupo : " . $descricao_grupo[1];
        $where .= " and grupos_pessoas_id = " . $descricao_grupo[0];
    }
    if ($descricao_situacoes!="")
    {
        $filtros .= "   Situacao : " . $descricao_situacoes[1];
        $where .= " and situacoes_id = " . $descricao_situacoes[0];
    }
    if ($descricao_tipos!="")
    {
        $filtros .= "   Tipo Pessoa : " . $descricao_tipos[1];
        $where .= " and tipos_pessoas_id = " . $descricao_tipos[0];
    }
    if ($descricao_status!="")
    {
        $filtros .= "   Status : " . $descricao_status[1];
        $where .= " and mp.status_id = " . $descricao_status[0];
    }
    if ($descricao_motivo_ent!="")
    {
        $filtros .= "   Motivo Entrada : " . $descricao_motivo_ent[1];
        $where .= " and motivos_entrada_id = " . $descricao_motivo_ent[0];
    }
    if ($descricao_motivo_sai!="")
    {
        $filtros .= "   Motivo Saida : " . ($descricao_motivo_sai[1]);
        $where .= " and motivos_saida_id = " . $descricao_motivo_sai[0];
    }
    if ($input["data_entrada"]!="")
    {
        $filtros .= "   Entrada : " . $input["data_entrada"] . " até " . $input["data_entrada_ate"] ;
        $where .= " and data_entrada >= '" . $formatador->FormatarData($input["data_entrada"]) . "'";
        $where .= " and data_entrada <= '" . $formatador->FormatarData($input["data_entrada_ate"]) . "'";
    }
    if ($input["data_saida"]!="")
    {
        $filtros .= "   Saida : " . $input["data_saida"] . " até " . $input["data_saida_ate"] ;
        $where .= " and data_saida >= '" . $formatador->FormatarData($input["data_saida"]) . "'";
        $where .= " and data_saida < '" . $formatador->FormatarData($input["data_saida_ate"]) . "'";
    }
    if ($input["data_batismo"]!="")
    {
        $filtros .= "   Batismo : " . $input["data_batismo"] . " até " . $input["data_batismo_ate"] ;
        $where .= " and data_batismo >= '" . $formatador->FormatarData($input["data_batismo"]) . "'";
        $where .= " and data_batismo <= '" . $formatador->FormatarData($input["data_batismo_ate"]) . "'";
    }
    if ($input["data_casamento"]!="")
    {
        if ($input["ordem"]!="razaosocial" || $input["mes"]!="" || $input["ano_inicial"]!="" || $input["ano_final"]!="")
        {
            //nothing
        }
        else
        {
            $filtros .= "   Casamento : " . $input["data_casamento"] . " até " . $input["data_casamento_ate"] ;
            $where .= " and data_casamento >= '" . $formatador->FormatarData($input["data_casamento"]) . "'";
            $where .= " and data_casamento <= '" . $formatador->FormatarData($input["data_casamento_ate"]) . "'";
        }
    }
    if ($input["nivel1_up"]!="0")
    {
        $filtros .= "<br/>" . \Session::get('nivel1') . " : " . $descricao_nivel1[1];
        $where .= " and celulas_nivel1_id = " . $descricao_nivel1[0];
    }
    if ($input["nivel2_up"]!="0")
    {
        $filtros .= "" . \Session::get('nivel2') . " : " . $descricao_nivel2[1];
        $where .= " and celulas_nivel2_id = " . $descricao_nivel2[0];
    }
    if ($input["nivel3_up"]!="0")
    {
        $filtros .= "<br/>" . \Session::get('nivel3') . " : " . $descricao_nivel3[1];
        $where .= " and celulas_nivel3_id = " . $descricao_nivel3[0];
    }
    if ($input["nivel4_up"]!="0")
    {
        $filtros .= "" . \Session::get('nivel4') . " : " . $descricao_nivel4[1];
        $where .= " and celulas_nivel4_id = " . $descricao_nivel4[0];
    }
    if ($input["nivel5_up"]!="0")
    {
        $filtros .= "" . \Session::get('nivel5') . " : " . $descricao_nivel5[1];
        $where .= " and celulas_nivel5_id = " . $descricao_nivel5[0];
    }
    //Parametros JASPER REPORT
    $parametros = array
    (
        "empresas_id"=> $this->dados_login->empresas_id,
        "empresas_clientes_cloud_id"=> $this->dados_login->empresas_clientes_cloud_id,
        "sexo"=>"'" . $input["sexo"] . "'",
        "status"=>"'" . $input["status"] . "'",
        "nivel1"=> ($descricao_nivel1=="" ? 0 : $descricao_nivel1[0]),
        "nivel2"=> ($descricao_nivel2=="" ? 0 : $descricao_nivel2[0]),
        "nivel3"=> ($descricao_nivel3=="" ? 0 : $descricao_nivel3[0]),
        "nivel4"=> ($descricao_nivel4=="" ? 0 : $descricao_nivel4[0]),
        "nivel5"=> ($descricao_nivel5=="" ? 0 : $descricao_nivel5[0]),
        "doador_sangue" => ($input["doador_sangue"]=="1" ? "true" : "false"),
        "doador_orgaos" => ($input["doador_orgaos"]=="1" ? "true" : "false"),
        "possui_necessidades_especiais" => ($input["possui_necessidades_especiais"]==true ? "true" : "false"),
        "idiomas_id" => ($descricao_idiomas=="" ? 0 : $descricao_idiomas[0]),
        "graus_id" => ($descricao_graus=="" ? 0 : $descricao_graus[0]),
        "estadoscivis"=> ($descricao_estado_civil=="" ? 0 : $descricao_estado_civil[0]),
        "situacoes"=> ($descricao_situacoes=="" ? 0 : $descricao_situacoes[0]),
        "tipos"=> ($descricao_tipos=="" ? 0 : $descricao_tipos[0]),
        "grupo"=> ($descricao_grupo=="" ? 0 : $descricao_grupo[0]),
        "status_id"=> ($descricao_status=="" ? 0 : $descricao_status[0]),
        "motivo_entrada"=> ($descricao_motivo_ent=="" ? 0 : $descricao_motivo_ent[0]),
        "motivo_saida"=> ($descricao_motivo_sai=="" ? 0 : $descricao_motivo_sai[0]),
        "data_entrada_inicial"=>"'" . ($input["data_entrada"]=="" ? '' : $formatador->FormatarData($input["data_entrada"])) . "'",
        "data_entrada_final"=>"'" . ($input["data_entrada_ate"]=="" ? '' : $formatador->FormatarData($input["data_entrada_ate"])) . "'",
        "filtros"=> "'" . ($filtros) . "'",
    );
    //A ordem DEFAULT do relatório é DIA/MES da data de nascimento. Se não for relatório de aniversariantes, altera a ordem

   if ($input["mes"]!="")
    {

        if ($input["r1"]=="1") { //nascimento

            $parametros = array_add($parametros, 'mes', $input["mes"]);

        } else if ($input["r1"]=="2") { //casamento

            $parametros = array_add($parametros, 'mes_casamento', $input["mes"]);

        } else if ($input["r1"]=="3") { //batismo

            $parametros = array_add($parametros, 'mes_batismo', $input["mes"]);
        }

    }


    if ($input["ordem"]=="razaosocial")
    {
        $parametros = array_add($parametros, 'ordem', 'razaosocial');
    }
    else if ($input["ordem"]=="idade")
    {
        $parametros = array_add($parametros, 'ordem', 'idade');
    }
    else if ($input["ordem"]=="ano")
    {
        $parametros = array_add($parametros, 'ordem', '"ano, idade"');
    }

    /*Se foi passado filtro por ano de nascimento*/
    if ($input["ano_inicial"]!="" && $input["ano_final"]!="")
    {
        $parametros = array_add($parametros, 'ano_inicial', $input["ano_inicial"]);
        $parametros = array_add($parametros, 'ano_final', $input["ano_final"]);
    }
    //Data de saida
    if ($input["data_saida"]!="" && $input["data_saida_ate"]!="")
    {
        $parametros = array_add($parametros, 'data_saida_inicial', ($input["data_saida"]=="" ? '' : $formatador->FormatarData($input["data_saida"])));
        $parametros = array_add($parametros, 'data_saida_final', ($input["data_saida_ate"]=="" ? '' : $formatador->FormatarData($input["data_saida_ate"])));
    }
    if ($input["tipo_sangue"]!="")
    {
        $parametros = array_add($parametros, 'grupo_sanguinio', strtoupper($input["tipo_sangue"]));
    }
    if ($input["formacoes_id"]!="")
    {
        $parametros = array_add($parametros, 'formacoes_id', ($descricao_formacao=="" ? 0 : $descricao_formacao[0]));
    }
    if ($input["profissoes_id"]!="")
    {
        $parametros = array_add($parametros, 'profissoes_id', ($descricao_profissao=="" ? 0 : $descricao_profissao[0]));
    }
    if ($input["ramos_id"]!="")
    {
        $parametros = array_add($parametros, 'ramos_id', ($descricao_ramos=="" ? 0 : $descricao_ramos[0]));
    }
    if ($input["cargos_id"]!="")
    {
        $parametros = array_add($parametros, 'cargos_id', ($descricao_cargos=="" ? 0 : $descricao_cargos[0]));
    }
    if ($input["disponibilidades_id"]!="")
    {
        $parametros = array_add($parametros, 'disponibilidades_id', ($descricao_disponibilidade=="" ? 0 : $descricao_disponibilidade[0]));
    }
    if ($input["religioes_id"]!="")
    {
        $parametros = array_add($parametros, 'religioes_id', ($descricao_religiao=="" ? 0 : $descricao_religiao[0]));
    }
    if ($input["dons_id"]!="")
    {
        $parametros = array_add($parametros, 'dons_id', ($descricao_don=="" ? 0 : $descricao_don[0]));
    }
    if ($input["habilidades_id"]!="")
    {
        $parametros = array_add($parametros, 'habilidades_id', ($descricao_habilidade=="" ? 0 : $descricao_habilidade[0]));
    }
    if ($input["atividades_id"]!="")
    {
        $parametros = array_add($parametros, 'atividades_id', ($descricao_atividade=="" ? 0 : $descricao_atividade[0]));
    }
    if ($input["ministerios_id"]!="")
    {
        $parametros = array_add($parametros, 'ministerios_id', ($descricao_ministerio=="" ? 0 : $descricao_ministerio[0]));
    }
    //Data de batismo
    if ($input["data_batismo"]!="" && $input["data_batismo_ate"]!="")
    {
        $parametros = array_add($parametros, 'data_batismo_inicial', ($input["data_batismo"]=="" ? '' : $formatador->FormatarData($input["data_batismo"])));
        $parametros = array_add($parametros, 'data_batismo_final', ($input["data_batismo_ate"]=="" ? '' : $formatador->FormatarData($input["data_batismo_ate"])));
    }
    //Data de casamento
    if ($input["data_casamento"]!="" && $input["data_casamento_ate"]!="")
    {
        if ($input["ordem"]!="razaosocial" || $input["mes"]!="" || $input["ano_inicial"]!="" || $input["ano_final"]!="") {
            //nothing
        }
        else
        {
            $parametros = array_add($parametros, 'data_casamento_inicial', ($input["data_casamento"]=="" ? '' : $formatador->FormatarData($input["data_casamento"])));
            $parametros = array_add($parametros, 'data_casamento_final', ($input["data_casamento_ate"]=="" ? '' : $formatador->FormatarData($input["data_casamento_ate"])));
        }
    }
   //QUANDO PESQUISAR E RESULTADO FOR CELULAR OU EMAIL
    if ($input["resultado"]=="email" || $input["resultado"]=="celular")
    {
        //Busca configuracao do provedor SMS
        //Se for SMS, verifica se foi contratado o servico
        if ($input["resultado"]=="celular")
        {
            $parametros = \App\Models\parametros::where(['empresas_clientes_cloud_id' => $this->dados_login->empresas_clientes_cloud_id, 'empresas_id' =>  $this->dados_login->empresas_id])->get();
            if ($parametros->count()<=0)
            {
                \Session::flash('flash_message_erro', 'Não foi configurado o serviço de envio. Acesse o menu Configurações / Config SMS/Whatsapp');
                return redirect($this->rota);
            }
        }
        //$emails = \DB::select('select distinct razaosocial, emailprincipal from view_pessoas_geral_celulas' . $where . ' order by razaosocial');
        $strSql = " SELECT DISTINCT ";
        $strSql .= " c.celulas_nivel1_id,      c.celulas_nivel2_id,     c.celulas_nivel3_id,      c.celulas_nivel4_id,      c.celulas_nivel5_id, ";
        $strSql .= " p.empresas_id,  p.empresas_clientes_cloud_id, ";
        $strSql .= " p.id,  p.tipos_pessoas_id,  p.razaosocial, ";
        $strSql .= " to_char(p.datanasc, 'MM') AS mes, ";
        $strSql .= " p.nomefantasia,  p.fone_principal,  p.fone_celular,  p.emailprincipal,  p.ativo,  p.datanasc, ";
        $strSql .= " mp.sexo,  mp.status_id,     mp.estadoscivis_id,     p.grupos_pessoas_id,     mh.data_entrada,     mh.data_saida,     mh.data_batismo, ";
        $strSql .= " mh.motivos_entrada_id,     mh.motivos_saida_id,     mp.doador_orgaos,     mp.doador_sangue,     mp.possui_necessidades_especiais, ";
        $strSql .= " mp.idiomas_id,    mp.graus_id ";
        $strSql .= " FROM pessoas p ";
        $strSql .= "   LEFT JOIN membros_dados_pessoais mp ON mp.pessoas_id = p.id AND mp.empresas_id = p.empresas_id AND mp.empresas_clientes_cloud_id = p.empresas_clientes_cloud_id ";
        $strSql .= "   LEFT JOIN celulas_pessoas cp ON cp.pessoas_id = p.id AND cp.empresas_id = p.empresas_id AND cp.empresas_clientes_cloud_id = p.empresas_clientes_cloud_id";
        $strSql .= "   LEFT JOIN celulas c ON cp.celulas_id = c.id AND cp.empresas_id = c.empresas_id AND cp.empresas_clientes_cloud_id = c.empresas_clientes_cloud_id";
        $strSql .= "   LEFT JOIN membros_historicos mh ON mh.pessoas_id = p.id AND mh.empresas_id = p.empresas_id AND mh.empresas_clientes_cloud_id = p.empresas_clientes_cloud_id";
        $strSql .= "   LEFT JOIN membros_formacoes mf ON mf.pessoas_id = p.id AND mf.empresas_id = p.empresas_id AND mf.empresas_clientes_cloud_id = p.empresas_clientes_cloud_id";
        $strSql .= "   LEFT JOIN membros_familiares mfa ON mfa.pessoas_id = p.id AND mfa.empresas_id = p.empresas_id AND mfa.empresas_clientes_cloud_id = p.empresas_clientes_cloud_id";
        $strSql .= "   LEFT JOIN membros_profissionais mprof ON mprof.pessoas_id = p.id AND mprof.empresas_id = p.empresas_id AND mprof.empresas_clientes_cloud_id = p.empresas_clientes_cloud_id";
        $strSql .= "   LEFT JOIN membros_ministerios mm ON mm.pessoas_id = p.id AND mm.empresas_id = p.empresas_id AND mm.empresas_clientes_cloud_id = p.empresas_clientes_cloud_id";
        $strSql .= "   LEFT JOIN membros_situacoes ms ON ms.pessoas_id = p.id AND ms.empresas_id = p.empresas_id AND ms.empresas_clientes_cloud_id = p.empresas_clientes_cloud_id";
        $strSql .= "   LEFT JOIN membros_dons md ON md.pessoas_id = p.id AND md.empresas_id = p.empresas_id AND md.empresas_clientes_cloud_id = p.empresas_clientes_cloud_id";
        $strSql .= "   LEFT JOIN membros_atividades ma ON ma.pessoas_id = p.id AND ma.empresas_id = p.empresas_id AND ma.empresas_clientes_cloud_id = p.empresas_clientes_cloud_id";
        $strSql .= "   LEFT JOIN membros_habilidades mhab ON mhab.pessoas_id = p.id AND mhab.empresas_id = p.empresas_id AND mhab.empresas_clientes_cloud_id = p.empresas_clientes_cloud_id";
        $strSql .= "   LEFT JOIN membros_idiomas mi ON mi.pessoas_id = p.id AND mi.empresas_id = p.empresas_id AND mi.empresas_clientes_cloud_id = p.empresas_clientes_cloud_id";
        $strSql .=  $where;
        $emails = \DB::select($strSql);
        return view($this->rota . '.listaremails', ['parametros'=>$parametros, 'emails'=>$emails, 'filtros'=>$filtros, 'resultado'=>$input["resultado"]]);
    }
     else
    {
        /*Exibir quebras por estrutura de celulas*/
            if ($input["ckEstruturas"])
            {
                if ($descricao_situacoes!="")
                {
                    $nome_relatorio = public_path() . '/relatorios/listagem_pessoas_geral_celulas_situacoes.jasper';
                }
                else
                {
                    $nome_relatorio = public_path() . '/relatorios/listagem_pessoas_geral_celulas.jasper';
                }
            }
            else
            {
                if ($descricao_situacoes!="")
                {
                    $nome_relatorio = public_path() . '/relatorios/listagem_pessoas_geral_situacoes.jasper';
                }
                else
                {
                    if ($input["ordem"]!="razaosocial" || $input["mes"]!="" || $input["ano_inicial"]!="" || $input["ano_final"]!="")
                    {

                            if ($input["r1"]=="1") { //nascimento

                                $nome_relatorio = public_path() . '/relatorios/listagem_aniversariantes.jasper';

                            } else if ($input["r1"]=="2") { //casamento

                                $nome_relatorio = public_path() . '/relatorios/listagem_aniversariantes_casamento.jasper';

                            } else if ($input["r1"]=="3") { //batismo

                                $nome_relatorio = public_path() . '/relatorios/listagem_aniversariantes_batismo.jasper';
                            }

                    }
                    else
                    {
                        if ($input["ckExibirCelula"]) {
                            $nome_relatorio = public_path() . '/relatorios/listagem_pessoas_geral_completo2.jasper';
                        } else {
                            $nome_relatorio = public_path() . '/relatorios/listagem_pessoas_geral_completo.jasper';
                        }

                        //$nome_relatorio = public_path() . '/relatorios/listagem_pessoas_geral.jasper';
                    }
                }
            }

            //RELATORIO DE VISITAS
             if ($input["modelo"]=="2") {
                $nome_relatorio = public_path() . '/relatorios/listagem_pessoas_agenda.jasper';
             }

            //Executa JasperReport
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
                    header('Content-Disposition: inline; filename=' . $output . '.' . $ext . '');
                    //header('Content-Transfer-Encoding: binary');
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


}