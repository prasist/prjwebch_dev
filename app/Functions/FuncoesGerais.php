<?php

namespace App\Functions;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use URL;
use Auth;
use Input;
use Gate;

class FuncoesGerais extends Controller
{

    public function __construct()
    {

    }

    /**
     * Retirar Acentos
     */
   public function tirarAcentos($string){
        return preg_replace(array("/(á|à|ã|â|ä)/","/(Á|À|Ã|Â|Ä)/","/(é|è|ê|ë)/","/(É|È|Ê|Ë)/","/(í|ì|î|ï)/","/(Í|Ì|Î|Ï)/","/(ó|ò|õ|ô|ö)/","/(Ó|Ò|Õ|Ô|Ö)/","/(ú|ù|û|ü)/","/(Ú|Ù|Û|Ü)/","/(ñ)/","/(Ñ)/"),explode(" ","a A e E i I o O u U n N"),$string);
   }


    /**
     * Description = Retira caracteres especiais em campos com mascara, por exemplo CEP, TELEFONE, CNPJ, CPF
     * @param type $dados = Conteudo a ser formatado
     * @return type  string = Retorna conteudo sem caracteres
     */
    public function RetirarCaracteres($dados)
    {
            return preg_replace("/[^0-9]/", '', $dados);
    }


    /*
    * Recebe data d/m/y e retorna y-m-d para insert no banco de dados
    */
    public function FormatarData($valor)
    {

        if ($valor=="") /*Se data estiver em branco grava nulo no banco de dados*/
        {
            return null;
        }

            $data_formatada = \DateTime::createFromFormat('d/m/Y', $valor);

            return $data_formatada->format('Y-m-d'); //Retorna data preparada para insert

    }


    /*
    * Recebe data Y-m-d gravada no banco e retorna d/m/y para exibição correta
    */
    public function ExibirData($valor) {

        if ($valor==null) /*Se data estiver em branco grava nulo no banco de dados*/
        {
            return "";
        }

            $data_formatada = \DateTime::createFromFormat('Y-m-d', $valor);
            return $data_formatada->format('d/m/Y'); //Retorna data preparada para insert
    }

    public function GravarCurrency($valor)
    {

            if ($valor=="") return "0";

            $converterValor = str_replace('.','',$valor);
            $converterValor = str_replace(',','.',$converterValor);
            return $converterValor;
    }

    public function ExibirCurrency($valor)
    {
            //number_format($valor,0,",",".");
            return number_format($valor, 2, ',', '.'); // retorna R$100,000.50
    }



    //Verificar se a pessoa logada é lider de célula
    public function verifica_se_lider()
    {

        if (\App\Models\usuario::find(Auth::user()->id))
       {
            //Busca ID do cliente cloud e ID da empresa
            $this->dados_login = \App\Models\usuario::find(Auth::user()->id);
        }

       $email = Auth::user()->email;

       $strSql =  " SELECT id, lider_pessoas_id ";
       $strSql .=  " FROM celulas ";
       $strSql .=  " where ";
       $strSql .=  " (lider_pessoas_id in (select id from pessoas where upper(emailprincipal) = '" .  strtoupper($email)  . "') or vicelider_pessoas_id in (select id from pessoas where upper(emailprincipal) = '" .  strtoupper($email) . "'))";
       $strSql .=  " and empresas_id = " . $this->dados_login->empresas_id . " ";
       $strSql .=  " and empresas_clientes_cloud_id = " . $this->dados_login->empresas_clientes_cloud_id . " ";

       $lider_logado = \DB::select($strSql);

       return $lider_logado;

    }

    /**
     * Pelo email da liderança, o sistema buscará todas as células vinculadas. A função buscará em todos os níveis disponiveis (Lider de Rede, Area, coordenador, supervisor, etc)
     * Retorna um array com ID das celulas encontradas para a hierarquia
     *
     * */
    public function verifica_se_lideranca() {

       if (\App\Models\usuario::find(Auth::user()->id)) {
            //Busca ID do cliente cloud e ID da empresa
            $this->dados_login = \App\Models\usuario::find(Auth::user()->id);
       }

        $email = Auth::user()->email;

        $strSql =  " SELECT distinct celulas.lider_pessoas_id  as id_lideres FROM celulas     ";
        $strSql .=  " JOIN celulas_nivel1 ON celulas_nivel1.id = celulas.celulas_nivel1_id AND celulas_nivel1.empresas_id = celulas.empresas_id AND celulas_nivel1.empresas_clientes_cloud_id = celulas.empresas_clientes_cloud_id ";
        $strSql .=  " JOIN celulas_nivel2 ON celulas_nivel2.id = celulas.celulas_nivel2_id AND celulas_nivel2.empresas_id = celulas.empresas_id AND celulas_nivel2.empresas_clientes_cloud_id = celulas.empresas_clientes_cloud_id ";
        $strSql .=  " JOIN celulas_nivel3 ON celulas_nivel3.id = celulas.celulas_nivel3_id AND celulas_nivel3.empresas_id = celulas.empresas_id AND celulas_nivel3.empresas_clientes_cloud_id = celulas.empresas_clientes_cloud_id ";
        $strSql .=  " JOIN celulas_nivel4 ON celulas_nivel4.id = celulas.celulas_nivel4_id AND celulas_nivel4.empresas_id = celulas.empresas_id AND celulas_nivel4.empresas_clientes_cloud_id = celulas.empresas_clientes_cloud_id ";
        $strSql .=  " JOIN celulas_nivel5 ON celulas_nivel5.id = celulas.celulas_nivel5_id AND celulas_nivel5.empresas_id = celulas.empresas_id AND celulas_nivel5.empresas_clientes_cloud_id = celulas.empresas_clientes_cloud_id ";
        $strSql .=  " LEFT JOIN pessoas pessoa_celula1 ON pessoa_celula1.id = celulas_nivel1.pessoas_id AND celulas_nivel1.empresas_id = pessoa_celula1.empresas_id AND celulas_nivel1.empresas_clientes_cloud_id = pessoa_celula1.empresas_clientes_cloud_id ";
        $strSql .=  " LEFT JOIN pessoas pessoa_celula2 ON pessoa_celula2.id = celulas_nivel2.pessoas_id AND celulas_nivel2.empresas_id = pessoa_celula2.empresas_id AND celulas_nivel2.empresas_clientes_cloud_id = pessoa_celula2.empresas_clientes_cloud_id ";
        $strSql .=  " LEFT JOIN pessoas pessoa_celula3 ON pessoa_celula3.id = celulas_nivel3.pessoas_id AND celulas_nivel3.empresas_id = pessoa_celula3.empresas_id AND celulas_nivel3.empresas_clientes_cloud_id = pessoa_celula3.empresas_clientes_cloud_id ";
        $strSql .=  " LEFT JOIN pessoas pessoa_celula4 ON pessoa_celula4.id = celulas_nivel4.pessoas_id AND celulas_nivel4.empresas_id = pessoa_celula4.empresas_id AND celulas_nivel4.empresas_clientes_cloud_id = pessoa_celula4.empresas_clientes_cloud_id ";
        $strSql .=  " LEFT JOIN pessoas pessoa_celula5 ON pessoa_celula5.id = celulas_nivel5.pessoas_id AND celulas_nivel5.empresas_id = pessoa_celula5.empresas_id AND celulas_nivel5.empresas_clientes_cloud_id = pessoa_celula5.empresas_clientes_cloud_id ";
        $strSql .=  " WHERE  ";
        $strSql .=  " celulas.empresas_id = " . $this->dados_login->empresas_id . " ";
        $strSql .=  " and celulas.empresas_clientes_cloud_id = " . $this->dados_login->empresas_clientes_cloud_id . " ";
        $strSql .=  " and ( upper(pessoa_celula1.emailprincipal) ilike '%" . strtoupper($email) . "%'  ";
        $strSql .=  " or upper(pessoa_celula2.emailprincipal) ilike '%" . strtoupper($email) . "%'  ";
        $strSql .=  " or upper(pessoa_celula3.emailprincipal) ilike '%" . strtoupper($email) . "%'  ";
        $strSql .=  " or upper(pessoa_celula4.emailprincipal) ilike '%" . strtoupper($email) . "%'  ";
        $strSql .=  " or upper(pessoa_celula5.emailprincipal) ilike '%" . strtoupper($email) . "%'  )";

        $lider_logado = \DB::select($strSql);

        if (count($lider_logado)>0) {
            return $lider_logado;
        } else {
            return null;
        }


    }


        /**
     * Pelo email da liderança, o sistema buscará toda a hierarquia ao qual pertence. A função buscará em todos os níveis disponiveis (Lider de Rede, Area, coordenador, supervisor, etc)
     * Retorna dataset com todas as hierarquias
     *
     * */
    public function verifica_niveis_permitidos() {

       if (\App\Models\usuario::find(Auth::user()->id)) {
            //Busca ID do cliente cloud e ID da empresa
            $this->dados_login = \App\Models\usuario::find(Auth::user()->id);
       }

        $email = Auth::user()->email; //pega email do usuario logado

        $strSql =  " SELECT distinct celulas_nivel1.id as n1, celulas_nivel2.id as n2, celulas_nivel3.id as n3, celulas_nivel4.id as n4, celulas_nivel5.id as n5  FROM celulas     ";
        $strSql .=  " JOIN celulas_nivel1 ON celulas_nivel1.id = celulas.celulas_nivel1_id AND celulas_nivel1.empresas_id = celulas.empresas_id AND celulas_nivel1.empresas_clientes_cloud_id = celulas.empresas_clientes_cloud_id ";
        $strSql .=  " JOIN celulas_nivel2 ON celulas_nivel2.id = celulas.celulas_nivel2_id AND celulas_nivel2.empresas_id = celulas.empresas_id AND celulas_nivel2.empresas_clientes_cloud_id = celulas.empresas_clientes_cloud_id ";
        $strSql .=  " JOIN celulas_nivel3 ON celulas_nivel3.id = celulas.celulas_nivel3_id AND celulas_nivel3.empresas_id = celulas.empresas_id AND celulas_nivel3.empresas_clientes_cloud_id = celulas.empresas_clientes_cloud_id ";
        $strSql .=  " JOIN celulas_nivel4 ON celulas_nivel4.id = celulas.celulas_nivel4_id AND celulas_nivel4.empresas_id = celulas.empresas_id AND celulas_nivel4.empresas_clientes_cloud_id = celulas.empresas_clientes_cloud_id ";
        $strSql .=  " JOIN celulas_nivel5 ON celulas_nivel5.id = celulas.celulas_nivel5_id AND celulas_nivel5.empresas_id = celulas.empresas_id AND celulas_nivel5.empresas_clientes_cloud_id = celulas.empresas_clientes_cloud_id ";
        $strSql .=  " LEFT JOIN pessoas pessoa_celula1 ON pessoa_celula1.id = celulas_nivel1.pessoas_id AND celulas_nivel1.empresas_id = pessoa_celula1.empresas_id AND celulas_nivel1.empresas_clientes_cloud_id = pessoa_celula1.empresas_clientes_cloud_id ";
        $strSql .=  " LEFT JOIN pessoas pessoa_celula2 ON pessoa_celula2.id = celulas_nivel2.pessoas_id AND celulas_nivel2.empresas_id = pessoa_celula2.empresas_id AND celulas_nivel2.empresas_clientes_cloud_id = pessoa_celula2.empresas_clientes_cloud_id ";
        $strSql .=  " LEFT JOIN pessoas pessoa_celula3 ON pessoa_celula3.id = celulas_nivel3.pessoas_id AND celulas_nivel3.empresas_id = pessoa_celula3.empresas_id AND celulas_nivel3.empresas_clientes_cloud_id = pessoa_celula3.empresas_clientes_cloud_id ";
        $strSql .=  " LEFT JOIN pessoas pessoa_celula4 ON pessoa_celula4.id = celulas_nivel4.pessoas_id AND celulas_nivel4.empresas_id = pessoa_celula4.empresas_id AND celulas_nivel4.empresas_clientes_cloud_id = pessoa_celula4.empresas_clientes_cloud_id ";
        $strSql .=  " LEFT JOIN pessoas pessoa_celula5 ON pessoa_celula5.id = celulas_nivel5.pessoas_id AND celulas_nivel5.empresas_id = pessoa_celula5.empresas_id AND celulas_nivel5.empresas_clientes_cloud_id = pessoa_celula5.empresas_clientes_cloud_id ";
        $strSql .=  " WHERE  ";
        $strSql .=  " celulas.empresas_id = " . $this->dados_login->empresas_id . " ";
        $strSql .=  " and celulas.empresas_clientes_cloud_id = " . $this->dados_login->empresas_clientes_cloud_id . " ";
        $strSql .=  " and ( upper(pessoa_celula1.emailprincipal) ilike '%" . strtoupper($email) . "%'  ";
        $strSql .=  " or upper(pessoa_celula2.emailprincipal) ilike '%" . strtoupper($email) . "%'  ";
        $strSql .=  " or upper(pessoa_celula3.emailprincipal) ilike '%" . strtoupper($email) . "%'  ";
        $strSql .=  " or upper(pessoa_celula4.emailprincipal) ilike '%" . strtoupper($email) . "%'  ";
        $strSql .=  " or upper(pessoa_celula5.emailprincipal) ilike '%" . strtoupper($email) . "%'  )";

        $strSql .=  " UNION ";

        $strSql .=  " SELECT distinct celulas_nivel1_id as n1, celulas_nivel2_id as n2, celulas_nivel3_id as n3, celulas_nivel4_id as n4, celulas_nivel5_id as n5  ";
        $strSql .=  " FROM celulas ";
        $strSql .=  " where ";
        $strSql .=  " (lider_pessoas_id in (select id from pessoas where upper(emailprincipal) = '" .  strtoupper($email)  . "') or vicelider_pessoas_id in (select id from pessoas where upper(emailprincipal) = '" .  strtoupper($email) . "'))";
        $strSql .=  " and empresas_id = " . $this->dados_login->empresas_id . " ";
        $strSql .=  " and empresas_clientes_cloud_id = " . $this->dados_login->empresas_clientes_cloud_id . " ";


        $lider_logado = \DB::select($strSql);

        if (count($lider_logado)>0) {
            return $lider_logado;
        } else {
            return null;
        }

    }



}