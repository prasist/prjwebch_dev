<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\celulaspessoas;
use URL;
use Auth;
use Input;
use Gate;
use JasperPHP\JasperPHP as JasperPHP;


class CelulasPessoasController extends Controller
{

    public function __construct()
    {

        $this->rota = "celulaspessoas"; //Define nome da rota que será usada na classe
        $this->middleware('auth');

        /*Instancia a classe de funcoes (Data, valor, etc)*/
        $this->formatador = new  \App\Functions\FuncoesGerais();

        //Validação de permissão de acesso a pagina
        if (Gate::allows('verifica_permissao', [\Config::get('app.' . $this->rota),'acessar']))
        {
            $this->dados_login = \Session::get('dados_login');

            //Verificar se usuario logado é LIDER
            $this->lider_logado = $this->formatador->verifica_se_lider();

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

        } else if (Gate::allows('verifica_permissao', [\Config::get('app.controle_atividades'),'acessar'])) {

          $this->dados_login = \Session::get('dados_login');

            //Verificar se usuario logado é LIDER
            $this->lider_logado = $this->formatador->verifica_se_lider();

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

    }

    //Exibir listagem
    public function index()
    {

        if (\App\ValidacoesAcesso::PodeAcessarPagina(\Config::get('app.' . $this->rota))==false)
        {
              return redirect('home');
        }

        $strSql  = " SELECT Distinct celulas_id, lider_pessoas_id, descricao_lider_scod  as nome, tot, cor, nome_celula FROM view_celulas_pessoas_participantes ";
        $strSql .= " WHERE  empresas_id = " . $this->dados_login->empresas_id;
        $strSql .= " AND empresas_clientes_cloud_id = " . $this->dados_login->empresas_clientes_cloud_id;

        //Trazer somente celula do lider logado... ou
        if ($this->lider_logado!=null)
        {
              if ($this->id_lideres!="") {
                  $strSql .= " AND lider_pessoas_id IN (" . $this->lider_logado[0]->lider_pessoas_id . ", " . $this->id_lideres . ")";
              } else {
                  $strSql .= " AND lider_pessoas_id IN (" . $this->lider_logado[0]->lider_pessoas_id . ")";
              }
              //$celulas = \DB::select('select id, descricao_concatenada as nome from view_celulas_simples  where lider_pessoas_id = ? and  empresas_id = ? and empresas_clientes_cloud_id = ? ', [$lider_logado[0]->lider_pessoas_id, $this->dados_login->empresas_id, $this->dados_login->empresas_clientes_cloud_id]);

        } else { //verificar se é alguém da lideranca (supervisor, coordenador, etc) e trazer somente as celulas subordinadas

              if ($this->id_lideres!="") {
                  $strSql .= " AND lider_pessoas_id IN (" . $this->id_lideres . ")";
              }
        }

        $dados = \DB::select($strSql);

        return view($this->rota . '.index',compact('dados'));

    }

    //Criar novo registro
    public function create()
    {

        if (\App\ValidacoesAcesso::PodeAcessarPagina(\Config::get('app.' . $this->rota))==false)
        {
              return redirect('home');
        }

        //$celulas = \DB::select('select id, descricao_concatenada as nome from view_celulas_simples  where empresas_id = ? and empresas_clientes_cloud_id = ? ', [$this->dados_login->empresas_id, $this->dados_login->empresas_clientes_cloud_id]);
        $strSql  = " SELECT id, descricao_concatenada as nome FROM view_celulas_simples ";
        $strSql .= " WHERE  empresas_id = " . $this->dados_login->empresas_id;
        $strSql .= " AND empresas_clientes_cloud_id = " . $this->dados_login->empresas_clientes_cloud_id;

        //SE for lider, direciona para dashboard da célula
        if ($this->lider_logado!=null)
        {
               $strSql .=  " AND lider_pessoas_id  = '" . $this->lider_logado[0]->lider_pessoas_id . "'";
        }

        $celulas = \DB::select($strSql);


        return view($this->rota . '.registrar', ['celulas'=>$celulas, 'id_celula'=>'']);

    }

   //Criar novo registro
    public function create_membro($id)
    {

        if (\App\ValidacoesAcesso::PodeAcessarPagina(\Config::get('app.' . $this->rota))==false)
        {
              return redirect('home');
        }

        /*Busca */
        if ($id!="")
        {
            $celulas = \DB::select('select id, descricao_concatenada as nome from view_celulas_simples  where id = ? and empresas_id = ? and empresas_clientes_cloud_id = ? ', [$id, $this->dados_login->empresas_id, $this->dados_login->empresas_clientes_cloud_id]);
        }
        else
        {
            $celulas = \DB::select('select id, descricao_concatenada as nome from view_celulas_simples  where empresas_id = ? and empresas_clientes_cloud_id = ? ', [$this->dados_login->empresas_id, $this->dados_login->empresas_clientes_cloud_id]);
        }

        return view($this->rota . '.registrar', ['celulas'=>$celulas, 'id_celula'=>$id]);

    }


public function salvar($request, $id, $tipo_operacao)
{


        //Pega dados do post
        $input = $request->except(array('_token', 'ativo')); //não levar o token


        $this->validate($request, [
            'celulas' => 'required',
        ]);


        //Trigger tg_atualizar_data - insere a data de inicio do membro na celula

        $i_index=0; /*Inicia sequencia*/

        if ($tipo_operacao=="create" && !isset($input['hidden_celulas']))  //novo registro
        {
             return;
        }


        if ($id!="") {
              //excluir para inserir noamente
              $where =
                            [
                                  'empresas_clientes_cloud_id' => $this->dados_login->empresas_clientes_cloud_id,
                                  'empresas_id' =>  $this->dados_login->empresas_id,
                                  'celulas_id' => $id
                            ];

              $excluir = celulaspessoas::where($where)->delete();
       }


        if (isset($input['hidden_celulas']))
        {
              foreach($input['hidden_celulas'] as $selected)
               {

                   if (isset($input['hidden_pessoas']))
                   {
                        $whereForEach =
                        [
                              'empresas_clientes_cloud_id' => $this->dados_login->empresas_clientes_cloud_id,
                              'empresas_id' =>  $this->dados_login->empresas_id,
                              'pessoas_id' => substr($input['hidden_pessoas'][$i_index],0,9),
                              'celulas_id' => $selected
                        ];

                          if ($tipo_operacao=="create")  //novo registro
                          {
                              $dados = new celulaspessoas();
                          }
                          else //Alteracao
                          {
                              $dados = celulaspessoas::firstOrNew($whereForEach);
                          }

                          $valores =
                          [
                              'pessoas_id' => substr($input['hidden_pessoas'][$i_index],0,9),
                              'empresas_id' =>  $this->dados_login->empresas_id,
                              'empresas_clientes_cloud_id' => $this->dados_login->empresas_clientes_cloud_id,
                              'celulas_id' => $selected,
                              'lider_pessoas_id' => substr($input['hidden_lider_celulas'][$i_index],0,9)
                          ];

                          $dados->fill($valores)->save();
                          $dados->save();

                          $i_index = $i_index + 1;
                    }
               }
       }

}


/*
* Grava dados no banco
*
*/
    public function store(\Illuminate\Http\Request  $request)
    {

            $this->salvar($request, "", "create");
            \Session::flash('flash_message', 'Dados Atualizados com Sucesso!!!');
             //return redirect($this->rota);
             return redirect('celulas');

    }


public function imprimir($id)
 {


/*------------------------------------------INICIALIZA PARAMETROS JASPER--------------------------------------------------*/
    //Pega dados de conexao com o banco para o JASPER REPORT
    $database = \Config::get('database.connections.jasper_report');
    $ext = "pdf"; //Tipo saída (PDF, XLS)
    $output = public_path() . '/relatorios/resultados/' . $ext . '/celulaspessoas_' . $this->dados_login->empresas_id . '_' . Auth::user()->id; //Path para cada tipo de relatorio
    $path_download = '/relatorios/resultados/' . $ext . '/celulaspessoas_' . $this->dados_login->empresas_id . '_' .  Auth::user()->id; //Path para cada tipo de relatorio
    /*------------------------------------------INICIALIZA PARAMETROS JASPER--------------------------------------------------*/

    $parametros = array
    (
        "empresas_id"=> $this->dados_login->empresas_id,
        "empresas_clientes_cloud_id"=> $this->dados_login->empresas_clientes_cloud_id,
        "dia_encontro"=>"'" . "" . "'",
        "regiao"=>"'%" . "" . "%'",
        "turno"=>"'" . "" . "'",
        "segundo_dia_encontro"=>"'" . "" . "'",
        "publico_alvo"=> 0,
        "faixa_etaria"=> 0,
        "lideres"=> 0,
        "id"=> $id,
        "nivel1"=> 0,
        "nivel2"=> 0,
        "nivel3"=> 0,
        "nivel4"=> 0,
        "nivel5"=> 0,
        "filtros"=> ''
    );

    $nome_relatorio = public_path() . '/relatorios/listagem_celulas_pessoas.jasper';

    \JasperPHP::process(
            $nome_relatorio,
            $output,
            array($ext),
            $parametros,
            $database,
            false,
            false
        )->execute();


      header('Content-type: application/pdf');
      header('Content-Disposition: download; filename="' . $output . "." . $ext . '"');
      header('Content-Transfer-Encoding: binary');
      header('Accept-Ranges: bytes');
      @readfile($output . ".pdf");

 }



    //Abre tela para edicao ou somente visualização dos registros
    private function exibir ($request, $id, $preview)
    {
        if($request->ajax())
        {
            return URL::to($this->rota . '/'. $id . '/edit');
        }

        if (\App\ValidacoesAcesso::PodeAcessarPagina(\Config::get('app.' . $this->rota))==false)
        {
              return redirect('home');
        }

        /*Busca */
        //$celulas = \DB::select('select id, descricao_concatenada as nome from view_celulas_simples  where empresas_id = ? and empresas_clientes_cloud_id = ? ', [$this->dados_login->empresas_id, $this->dados_login->empresas_clientes_cloud_id]);

        $strSql = "SELECT id, descricao_concatenada as nome FROM view_celulas_simples ";
        $strSql .=  " WHERE  empresas_id = " . $this->dados_login->empresas_id;
        $strSql .=  " AND empresas_clientes_cloud_id = " . $this->dados_login->empresas_clientes_cloud_id;

        //SE for lider, direciona para dashboard da célula
        if ($this->lider_logado!=null)
        {
               $strSql .=  " AND lider_pessoas_id  = '" . $this->lider_logado[0]->lider_pessoas_id . "'";
        }

        $celulas = \DB::select($strSql);


        $dados = \DB::select('select * from view_celulas_pessoas where celulas_id = ? and empresas_id = ? and empresas_clientes_cloud_id = ? ', [$id, $this->dados_login->empresas_id, $this->dados_login->empresas_clientes_cloud_id]);

        return view($this->rota . '.edit', ['dados' =>$dados, 'preview' => $preview, 'celulas'=>$celulas]);

    }

  //Visualizar registro
  public function show (\Illuminate\Http\Request $request, $id)
  {
        return $this->exibir($request, $id, 'true');
  }


  //Direciona para tela de alteracao
  public function edit(\Illuminate\Http\Request $request, $id)
  {
        return $this->exibir($request, $id, 'false');
  }


  /**
   * Atualiza dados no banco
   *
   * @param    \Illuminate\Http\Request  $request
   * @param    int  $id
   * @return  \Illuminate\Http\Response
   */
  public function update(\Illuminate\Http\Request  $request, $id)
  {
        $this->salvar($request, $id,  "update");
        \Session::flash('flash_message', 'Dados Atualizados com Sucesso!!!');
        return redirect('celulas');
  }


 //Abre tela para edicao ou somente visualização dos registros
 public function listar_participantes_json ($id)
{

        $dados = celulaspessoas::select('pessoas.id', 'pessoas.razaosocial')
        ->join('pessoas', 'pessoas.id', '=', 'celulas_pessoas.pessoas_id')
        ->where('celulas_pessoas.empresas_id', $this->dados_login->empresas_id)
        ->where('celulas_pessoas.empresas_clientes_cloud_id', $this->dados_login->empresas_clientes_cloud_id)
        ->where('celulas_pessoas.celulas_id', $id)
        ->orderBy('razaosocial')
        ->get();

        return json_encode($dados);

}


//Abre tela para edicao ou somente visualização dos registros
public function exibir_participantes_json ($id)
{

        $dados = celulaspessoas::select('pessoas.id', 'pessoas.razaosocial')
        ->join('pessoas', 'pessoas.id', '=', 'celulas_pessoas.pessoas_id')
        ->where('celulas_pessoas.empresas_id', $this->dados_login->empresas_id)
        ->where('celulas_pessoas.empresas_clientes_cloud_id', $this->dados_login->empresas_clientes_cloud_id)
        ->where('celulas_pessoas.celulas_id', $id)
        ->orderBy('pessoas.razaosocial')
        ->get();

        return \Datatables::of($dados)->make(true);

}


/**
 * Excluir registro do banco.
 *
 * @param    int  $id
 * @return  \Illuminate\Http\Response
 */
public function destroy($id)
{

     if ($id!="") //Se for alteração, exclui primeiro, para depois percorrer a tabela e inserir novamente
     {
            /*Clausula where padrao para as tabelas auxiliares*/
           $where =
           [
              'empresas_clientes_cloud_id' => $this->dados_login->empresas_clientes_cloud_id,
              'empresas_id' =>  $this->dados_login->empresas_id,
              'celulas_id' => $id
           ];

           $excluir = celulaspessoas::where($where)->delete();
     }

     return redirect($this->rota);
}


public function remover_membro($id, $pessoas_id)
{

     if ($id!="") //Se for alteração, exclui primeiro, para depois percorrer a tabela e inserir novamente
     {
            /*Clausula where padrao para as tabelas auxiliares*/
           $where =
           [
              'empresas_clientes_cloud_id' => $this->dados_login->empresas_clientes_cloud_id,
              'empresas_id' =>  $this->dados_login->empresas_id,
              'celulas_id' => $id,
              'pessoas_id'=>$pessoas_id
           ];
           $excluir = celulaspessoas::where($where)->delete();
     }

     return redirect($this->rota);

}

}