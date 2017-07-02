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


  public function pesquisar(\Illuminate\Http\Request  $request)
  {

    /*Pega todos campos enviados no post*/
    $input = $request->except(array('_token', 'ativo')); //não levar o token

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
    if ($input["igrejas_id"]!="") $descricao_igreja = explode("|", $input["igrejas_id"]);
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

    $sWhere = "";
    $sFiltrosUtilizados="";
    $filtros = array(); /*CRIA ARRAY PARA GUARDAR FILTROS UTILIZADOS PARA PESQUISA*/

    $sWhere = " WHERE p.empresas_id = " . $this->dados_login->empresas_id . "  and p.empresas_clientes_cloud_id = " . $this->dados_login->empresas_clientes_cloud_id . "  ";

    //SE FOR RELATORIO PARA LISTAGEM DE EMAILS, FILTRAR SOMENTE COM EMAIL CADASTRADO
    if ($input["resultado"]=="email")
            $sWhere .= " and (emailprincipal is not null and emailprincipal<> '') ";


    /*Filtros utilizados*/
    if ($input["possui_necessidades_especiais"]!="")
    {
        $filtros = array_add($filtros, '1',
            [
                'find' =>  ['possui_necessidades_especiais' => ($input["possui_necessidades_especiais"]=="true" ? "true" : "false")],
                'label' => ['Possui Necessidades Especiais'=>($input["possui_necessidades_especiais"]=="true" ? "Sim" : "Nao")]
            ]);
    }

    if ($input["doador_orgaos"]!="")
    {
        $filtros = array_add($filtros, '2',
            [
                'find' => ['doador_orgaos'=>($input["doador_orgaos"]=="1" ? "true" : "false")],
                'label' => ['Doador Orgãos' =>($input["doador_orgaos"]=="1" ? "Sim" : "Não")]
            ]);
    }

    if ($input["doador_sangue"]!="")
    {
        $filtros = array_add($filtros, '3',
            [
                'find' => ['doador_sangue'=>($input["doador_sangue"]=="true" ? "true" : "false")],
                'label' => ['Doador Sangue'=>($input["doador_sangue"]=="true" ? "Sim" : "Não")]
            ]);
    }

    if ($input["status"]!="")
    {
        $filtros = array_add($filtros, '4',
            [
                'find' =>['ativo'=>($input["status"]=="S" ? "'S'" : "'N'")] ,
                'label' =>['Status Cadastro'=>($input["status"]=="S" ? "Ativo" : "Inativo")]
            ]);
    }

    if ($input["graus_id"]!="")
    {
        $filtros = array_add($filtros, '5',
            [
                'find' => ['graus_id'=>$descricao_graus[0]],
                'label' =>['Grau de Instrução'=> $descricao_graus[1]]
            ]);
    }

    if ($input["formacoes_id"]!="")
    {
        $filtros = array_add($filtros, '6',
            [
                'find' => ['formacoes_id'=>$descricao_formacao[0]],
                'label' =>['Area de Formação'=>$descricao_formacao[1]]
            ]);
    }

    if ($input["profissoes_id"]!="")
    {
        $filtros = array_add($filtros, '7',
            [
                'find' =>['mprof.profissoes_id'=> $descricao_profissao[0]],
                'label' =>['Profissão'=> $descricao_profissao[1]]
            ]);
    }

    if ($input["ramos_id"]!="")
    {
        $filtros = array_add($filtros, '8',
            [
                'find' =>['ramos_id'=>$descricao_ramos[0]] ,
                'label' =>['Ramo de Atividade'=>$descricao_ramos[1]]
            ]);
    }

    if ($input["cargos_id"]!="")
    {
        $filtros = array_add($filtros, '9',
            [
                'find' =>['cargos_id'=>$descricao_cargos[0]] ,
                'label' =>['Cargo'=>$descricao_cargos[1]]
            ]);
    }

    if ($input["disponibilidades_id"]!="")
    {
        $filtros = array_add($filtros, '10',
            [
                'find' =>['disponibilidades_id'=>$descricao_disponibilidade[0]] ,
                'label' =>['Disponibilidade'=>$descricao_disponibilidade[1]]
            ]);
    }


    if ($input["tipo_sangue"]!="")
    {
        $filtros = array_add($filtros, '11',
            [
                'find' =>['grupo_sanguinio'=> "'" . strtoupper($input["tipo_sangue"]) . "'"] ,
                'label' =>['Tipo Sanguineo'=>strtoupper($input["tipo_sangue"])]
            ]);
    }


    if ($input["religioes_id"]!="")
    {
        $filtros = array_add($filtros, '12',
            [
                'find' =>['religioes_id'=>$descricao_religiao[0]] ,
                'label' =>['Religião'=>$descricao_religiao[1]]
            ]);
    }

    if ($input["dons_id"]!="")
    {
        $filtros = array_add($filtros, '13',
            [
                'find' =>['dons_id'=>$descricao_don[0]] ,
                'label' =>['Don'=>$descricao_don[1]]
            ]);
    }

    if ($input["habilidades_id"]!="")
    {
        $filtros = array_add($filtros, '14',
            [
                'find' =>['habilidades_id'=>$descricao_habilidade[0]] ,
                'label' =>['Habilidade'=>$descricao_habilidade[1]]
            ]);
    }

    if ($input["atividades_id"]!="")
    {
        $filtros = array_add($filtros, '15',
            [
                'find' =>['atividades_id'=>$descricao_atividade[0]],
                'label' =>['Atividade'=>$descricao_atividade[1]]
            ]);
    }

    if ($input["ministerios_id"]!="")
    {
        $filtros = array_add($filtros, '16',
            [
                'find' =>['ministerios_id'=>$descricao_ministerio[0]],
                'label' =>['Ministério'=>$descricao_ministerio[1]]
            ]);
    }

    if ($input["idiomas_id"]!="")
    {
        $filtros = array_add($filtros, '17',
            [
                'find' =>['mi.idiomas_id'=>$descricao_idiomas[0]] ,
                'label' =>['Idioma'=>$descricao_idiomas[1]]
            ]);
    }

    if ($input["mes"]!="")
    {

        if ($input["r1"]=="1") { //nascimento

            $filtros = array_add($filtros, '18',
            [
                'find' => ["date_part('month', p.datanasc)"=>"'" . $input["mes"] . "'"] ,
                'label' => ['Mês Aniversário'=>$input["mes"]]
            ]);

        } else if ($input["r1"]=="2") { //casamento

            //date_part('month', to_date(data_casamento,'yyyy-MM-dd')) = '02'
            $filtros = array_add($filtros, '18',
            [
                'find' => ["date_part('month', to_date(data_casamento,'yyyy-MM-dd'))"=>"'" . $input["mes"] . "'"] ,
                'label' => ['Mês Casamento'=>$input["mes"]]
            ]);

        } else if ($input["r1"]=="3") { //batismo

            $filtros = array_add($filtros, '18',
            [
                'find' => ["date_part('month', to_date(data_batismo,'yyyy-MM-dd'))"=>"'" . $input["mes"] . "'"] ,
                'label' => ['Mês Batismo'=>$input["mes"]]
            ]);
        }


    }

/*
    if ($input["ano_inicial"]!="" && $input["ano_final"]!="" )
    {
        $filtros = array_add($filtros, '19',
            [
                'find' =>['to_char(p.datanasc, "YYYY")>='=>"'" . $input["ano_inicial"] . "'"] ,
                'label' =>['Ano Inicial'=>$input["ano_inicial"]]
            ]);

        $filtros = array_add($filtros, '20',
            [
                'find' =>['to_char(p.datanasc, "YYYY")<='=> "'" . $input["ano_final"] . "'"] ,
                'label' =>['Ano Final'=>$input["ano_final"]]
            ]);
    }
    */

    if ($input["sexo"]!="")
    {
        $filtros = array_add($filtros, '21',
            [
                'find' =>['sexo'=>"'" . $input["sexo"] . "'"] ,
                'label' =>['Sexo'=>$input["sexo"]]
            ]);
    }

    if ($descricao_estado_civil!="")
    {
        $filtros = array_add($filtros, '22',
            [
                'find' =>['estadoscivis_id'=>$descricao_estado_civil[0]] ,
                'label' =>['Estado Civil'=>$descricao_estado_civil[1]]
            ]);
    }

    if ($descricao_grupo!="")
    {
        $filtros = array_add($filtros, '23',
            [
                'find' =>['grupos_pessoas_id'=>$descricao_grupo[0]] ,
                'label' =>['Grupo'=>$descricao_grupo[1]]
            ]);
    }

    if ($descricao_situacoes!="")
    {
        $filtros = array_add($filtros, '24',
            [
                'find' =>['situacoes_id'=>$descricao_situacoes[0]] ,
                'label' =>['Situação'=>$descricao_situacoes[1]]
            ]);
    }

    if ($descricao_tipos!="")
    {
        $filtros = array_add($filtros, '25',
            [
                'find' =>['tipos_pessoas_id'=>$descricao_tipos[0]] ,
                'label' =>['Tipo Pessoa'=>$descricao_tipos[1]]
            ]);
    }

    if ($descricao_status!="")
    {
        $filtros = array_add($filtros, '26',
            [
                'find' =>['mp.status_id'=>$descricao_status[0]],
                'label' =>['Status'=>$descricao_status[1]]
            ]);
    }

    if ($descricao_motivo_ent!="")
    {
        $filtros = array_add($filtros, '27',
            [
                'find' =>['motivos_entrada_id'=>$descricao_motivo_ent[0]] ,
                'label' =>['Motivo Entrada'=>$descricao_motivo_ent[1]]
            ]);
    }

    if ($descricao_motivo_sai!="")
    {
        $filtros = array_add($filtros, '28',
            [
                'find' =>['motivos_saida_id'=>$descricao_motivo_sai[0]] ,
                'label' =>['Motivo Saída'=>$descricao_motivo_sai[1]]
            ]);
    }

    if ($input["data_entrada"]!="")
    {
        $filtros = array_add($filtros, '29',
            [
                'find' =>['data_entrada>='=>"'" . $formatador->FormatarData($input["data_entrada"]) . "'"] ,
                'label' =>['Dt. Entrada Inicial'=>$input["data_entrada"]]
            ]);

        $filtros = array_add($filtros, '30',
            [
                'find' =>['data_entrada<='=> "'" . $formatador->FormatarData($input["data_entrada_ate"]) . "'"] ,
                'label' =>['Dt. Entrada Final'=>$input["data_entrada_ate"]]
            ]);
    }

    if ($input["data_saida"]!="")
    {
        $filtros = array_add($filtros, '31',
            [
                'find' =>['data_saida>='=> "'" . $formatador->FormatarData($input["data_saida"]) . "'"] ,
                'label' =>['Dt. Saída Inicial'=>$input["data_saida"]]
            ]);

        $filtros = array_add($filtros, '32',
            [
                'find' =>['data_saida<='=> "'" . $formatador->FormatarData($input["data_saida_ate"]) . "'"] ,
                'label' =>['Dt. Saída Final'=>$input["data_saida_ate"]]
            ]);

    }

    if ($input["data_batismo"]!="")
    {
        $filtros = array_add($filtros, '33',
            [
                'find' =>['data_batismo>='=> "'" . $formatador->FormatarData($input["data_batismo"]) . "'"] ,
                'label' =>['Dt. Batismo Inicial'=>$input["data_batismo"]]
            ]);

        $filtros = array_add($filtros, '34',
            [
                'find' =>['data_batismo<='=> "'" . $formatador->FormatarData($input["data_batismo_ate"]) . "'"] ,
                'label' =>['Dt. Batismo Final'=>$input["data_batismo_ate"]]
            ]);
    }

    if ($input["data_casamento"]!="")
    {
        //if ($input["ordem"]!="razaosocial" || $input["mes"]!="" || $input["ano_inicial"]!="" || $input["ano_final"]!="")
        //{
            //nothing
        //}
        //else
        //{

            $filtros = array_add($filtros, '35',
            [
                'find' =>['data_casamento>='=> "'" . $formatador->FormatarData($input["data_casamento"]) . "'"],
                'label' =>['Dt. Casamento Inicial'=>$input["data_casamento"]]
            ]);

            $filtros = array_add($filtros, '36',
            [
                'find' =>['data_casamento<='=> "'" . $formatador->FormatarData($input["data_casamento_ate"]) . "'"],
                'label' =>['Dt. Casamento Final'=>$input["data_casamento_ate"]]
            ]);
        //}
    }

    if ($input["nivel1_up"]!="0")
    {
        $filtros = array_add($filtros, '37',
            [
                'find' =>['celulas_nivel1_id'=>$descricao_nivel1[0]] ,
                'label' => \Session::get("nivel1") . ' - ' . $descricao_nivel1[1]
            ]);
    }

    if ($input["nivel2_up"]!="0")
    {
        $filtros = array_add($filtros, '38',
            [
                'find' =>['celulas_nivel2_id'=>$descricao_nivel2[0]] ,
                'label' => \Session::get("nivel2") . ' - ' . $descricao_nivel2[1]
            ]);
    }

    if ($input["nivel3_up"]!="0")
    {
        $filtros = array_add($filtros, '39',
            [
                'find' =>['celulas_nivel3_id'=>$descricao_nivel3[0]] ,
                'label' => \Session::get("nivel3") . ' - ' . $descricao_nivel3[1]
            ]);
    }

    if ($input["nivel4_up"]!="0")
    {
        $filtros = array_add($filtros, '40',
            [
                'find' =>['celulas_nivel4_id'=>$descricao_nivel4[0]] ,
                'label' => \Session::get("nivel4") . ' - ' . $descricao_nivel4[1]
            ]);
    }

    if ($input["nivel5_up"]!="0")
    {
        $filtros = array_add($filtros, '41',
            [
                'find' =>['celulas_nivel5_id'=>$descricao_nivel5[0]] ,
                'label' => \Session::get("nivel5") . ' - ' . $descricao_nivel5[1]
            ]);
    }

    if ($input["igrejas_id"]!="")
    {
        $filtros = array_add($filtros, '42',
            [
                'find' =>['igrejas_id'=>$descricao_igreja[0]] ,
                'label' =>['Igreja'=>$descricao_igreja[1]]
            ]);
    }


    //QUANDO PESQUISAR E RESULTADO FOR CELULAR,  EMAIL OU PESQUISA NA TELA
    if ($input["resultado"]=="email" || $input["resultado"]=="celular" || $input["resultado"]=="html")
    {

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


        $strSql = " SELECT DISTINCT ";
        $strSql .= " p.id,  p.tipos_pessoas_id,  p.razaosocial, ";

        if ($input["r1"]=="1") { //nascimento

            $strSql .= " to_char(p.datanasc::timestamp with time zone, 'MM'::text) AS mes, ";
            $strSql .= " to_char(p.datanasc::timestamp with time zone, 'YYYY'::text) AS ano, ";
            $strSql .= " date_part('day'::text, p.datanasc) AS dia, ";

        } else if ($input["r1"]=="2") { //casamento

            $strSql .= " to_char(data_casamento::timestamp with time zone, 'MM'::text) AS mes, ";
            $strSql .= " to_char(data_casamento::timestamp with time zone, 'YYYY'::text) AS ano, ";
            $strSql .= " to_char(data_casamento::timestamp with time zone, 'DD'::text) AS dia, ";

        } else if ($input["r1"]=="3") { //batismo

            $strSql .= " to_char(data_batismo::timestamp with time zone, 'MM'::text) AS mes, ";
            $strSql .= " to_char(data_batismo::timestamp with time zone, 'YYYY'::text) AS ano, ";
            $strSql .= " to_char(data_batismo::timestamp with time zone, 'DD'::text) AS dia, ";
        }


        $strSql .= " to_char(date_part('years'::text, age(now(), p.datanasc::timestamp with time zone)), '9999'::text) AS idade, ";
        $strSql .= " p.nomefantasia,  p.fone_principal,  p.fone_celular,  p.emailprincipal,  p.ativo,  p.datanasc ";
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

        $sFiltrosUtilizados = "<table class='table table-responsive table-hover'>";
        $sFiltrosUtilizados .= '<tr>';
        $iCol=0;

        //PERCORRE ARRAY COM TODOS OS FILTROS INFORMADOS
        foreach ($filtros as $section => $items)
        {
            foreach ($items as $key => $value)
            {
                // check whether the current item is an array!
                if(is_array($value))
                {

                    if ($key=="find") //PEGA CAMPOS E VALORES PARA FILTRAR NA QUERY
                    {
                         foreach($value as $subKey => $subValue)
                         {
                             if (preg_match("/>=/", $subKey)==1 || preg_match("/<=/", $subKey)==1) //VERIFICA SE JA VEIO COM O OPERADOR. NESSE CASO TRATA-SE DE DATAS
                             {
                                $sWhere .= ' And ' . $subKey .  $subValue;
                             }
                             else
                             {
                                $sWhere .= ' And ' . $subKey . ' = ' .  $subValue;
                             }
                         }
                    }

                    if ($key=="label") //MONTA O CABECALHO COM FILTROS SELECIONADOS
                    {
                         foreach($value as $subKey => $subValue)
                         {
                            if ($iCol==4)
                            {
                                 $sFiltrosUtilizados .= '</tr><tr>';
                                 $iCol=0;
                            }
                             $sFiltrosUtilizados .= '<td>' . $subKey . ' : <b>' .  $subValue . '</b></td>';
                             $iCol++; //CONTA COLUNAS TABLE
                         }
                    }
                }
            }
        }

        if ($input["ano_inicial"]!="" && $input["ano_final"]!="" )
        {
            $sWhere .= " And to_char(p.datanasc, 'YYYY')>= '" . $input["ano_inicial"] . "'";
            $sWhere .= " And to_char(p.datanasc, 'YYYY')<= '" . $input["ano_final"] . "'";
        }

        $sFiltrosUtilizados .= "</tr></table>";

        //CONCATENA A STRING DA QUERY A CLAUSULA WHERE
        $strSql .= $sWhere;
        $strSql .=  " ORDER BY dia, mes, p.razaosocial ";

        $emails = \DB::select($strSql);

        if ($input["resultado"]=="html") //RESULTADO PADRAO
        {
            return view($this->rota . '.relatorios', ['dados'=>$emails, 'filtros'=>$sFiltrosUtilizados]);
        }
        else //LISTAGEM DE EMAILS OU DE NUMEROS DE CELULAR
        {
            return view($this->rota . '.listaremails', ['parametros'=>(isset($parametros) ? $parametros : ''), 'emails'=>$emails, 'filtros'=>$sFiltrosUtilizados, 'resultado'=>$input["resultado"]]);
        }

      }

    }

}