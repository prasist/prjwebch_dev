<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use App\Models\usuario;
use App\Http\Controllers\Controller;
use URL;
use Auth;
use Input;
use Gate;
use App\User;


class FinanceiroController extends Controller
{

    public function __construct()
    {

        $this->middleware('auth');
        $this->rota = "financeiro"; //Define nome da rota que será usada na classe

        //Validação de permissão de acesso a pagina
        if (Gate::allows('verifica_permissao', [\Config::get('app.' . $this->rota),'acessar']))
        {
            $this->dados_login = \Session::get('dados_login');
        }

    }

    //Exibir listagem
    public function index()
    {

        if (\App\ValidacoesAcesso::PodeAcessarPagina(\Config::get('app.' . $this->rota))==false)
        {
              return redirect('home');
        }

        //Verificar se foi cadastrado os dados da igreja
        if (usuario::find(Auth::user()->id))
       {
              //Busca ID do cliente cloud e ID da empresa
              $this->dados_login = usuario::find(Auth::user()->id);
              $this->formatador = new  \App\Functions\FuncoesGerais();

              //$dados = bancos::where('clientes_cloud_id', $this->dados_login->empresas_clientes_cloud_id)->get();

              $retorno = \DB::select('select  fn_total_titulos_aberto(' . $this->dados_login->empresas_clientes_cloud_id . ', ' . $this->dados_login->empresas_id . ', ' . "'R'" . ')');
              $total_receber_aberto = $this->formatador->ExibirCurrency($retorno[0]->fn_total_titulos_aberto);

              $retorno = \DB::select('select  fn_total_titulos_mes(' . $this->dados_login->empresas_clientes_cloud_id . ', ' . $this->dados_login->empresas_id . ', ' . "'R'" . ')');
              $total_receber_mes = $this->formatador->ExibirCurrency($retorno[0]->fn_total_titulos_mes);

              $retorno = \DB::select('select  fn_total_titulos_aberto(' . $this->dados_login->empresas_clientes_cloud_id . ', ' . $this->dados_login->empresas_id . ', ' . "'P'" . ')');
              $total_pagar_aberto = $this->formatador->ExibirCurrency($retorno[0]->fn_total_titulos_aberto);

              $retorno = \DB::select('select  fn_total_titulos_mes(' . $this->dados_login->empresas_clientes_cloud_id . ', ' . $this->dados_login->empresas_id . ', ' . "'P'" . ')');
              $total_pagar_mes = $this->formatador->ExibirCurrency($retorno[0]->fn_total_titulos_mes);

              $retorno = \DB::select('select  fn_saldo_contas(' . $this->dados_login->empresas_clientes_cloud_id . ', ' . $this->dados_login->empresas_id . ')');
              $saldo_contas = $this->formatador->ExibirCurrency($retorno[0]->fn_saldo_contas);

              $todas_contas = \App\Models\contas::select('nome', 'saldo_atual')
              ->where('empresas_id', $this->dados_login->empresas_id)
              ->where('empresas_clientes_cloud_id', $this->dados_login->empresas_clientes_cloud_id)
              ->get();

             //BUSCA TÍTULOS VENCIDOS
              $sQuery = " select id, descricao as nome, tipo , valor , to_char(to_date(data_vencimento, 'yyyy-MM-dd'), 'DD/MM/YYYY') as vencimento, CURRENT_DATE - (to_date(data_vencimento, 'yyyy-MM-dd')-  INTERVAL '1 DAY')  :: DATE  AS DIAS from titulos where  ";
              $sQuery .= " empresas_id = " . $this->dados_login->empresas_id;
              $sQuery .= " and empresas_clientes_cloud_id = " . $this->dados_login->empresas_clientes_cloud_id;
              $sQuery .= " and status <> 'B' ";
              $sQuery .= " and CURRENT_DATE > to_date(data_vencimento, 'yyyy-mm-dd') ";
              $sQuery .= " order by id ";

              $vencidos = \DB::select($sQuery);


              return view($this->rota . '.dashboard', ['vencidos'=>$vencidos, 'todas_contas'=>$todas_contas, 'total_receber_aberto'=>$total_receber_aberto, 'total_receber_mes'=>$total_receber_mes, 'total_pagar_aberto'=>$total_pagar_aberto, 'total_pagar_mes'=>$total_pagar_mes, 'saldo_contas'=>$saldo_contas]);
       }

    }


}