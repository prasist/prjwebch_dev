<?php
//ZP3993081153
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\controle_atividades;
use URL;
use Auth;
use Input;
use Gate;
use DB;

class ControleAtividadesController extends Controller
{

    public function __construct()
    {

        $this->rota = "controle_atividades"; //Define nome da rota que será usada na classe
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


    public  function checkin(\Illuminate\Http\Request  $request, $controle_id, $pessoa_id, $user_id)
    {

            $this->dados_login = \App\Models\usuario::find($user_id);

            $whereForEach =
                            [
                                'empresas_clientes_cloud_id' => $this->dados_login->empresas_clientes_cloud_id,
                                'empresas_id' =>  $this->dados_login->empresas_id,
                                'controle_atividades_id' => $controle_id,
                                'pessoas_id' => $pessoa_id
                            ];

            $controle_presencas = \App\Models\controle_presencas::firstOrNew($whereForEach);
            $controle_presencas->presenca_simples = "S";
            $controle_presencas->check_in = "S";
            $controle_presencas->hora_check_in = date("H:i:s");

            $controle_presencas->save();

            return redirect('home');

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

        //get questions from database
        $questions = \App\Models\questionarios_encontros::select('id', 'pergunta', 'tipo_resposta')
        ->where('empresas_id', $this->dados_login->empresas_id)
        ->where('empresas_clientes_cloud_id', $this->dados_login->empresas_clientes_cloud_id)
        ->get();

        return view($this->rota . '.atualizacao',
            [
                'preview'=>'false',
                'tipo_operacao'=>'incluir',
                'celulas'=>$celulas,
                'participantes'=>'',
                'questions' =>$questions,
                'questions_saved'=>'',
                'controle_materiais'=>''
             ]);

    }

  public function salvar($request, $id, $tipo_operacao)
  {

     /* ------------------ INICIA TRANSACTION -----------------------*/
     \DB::transaction(function() use ($request, $id, $tipo_operacao)
    {

        /*Instancia biblioteca de funcoes globais*/
        $formatador = new  \App\Functions\FuncoesGerais();

        $input = $request->except(array('_token')); //não levar o token

        $this->validate($request, [
            'celulas' => 'required',
            'mes' => 'required',
            'ano' => 'required',
            'data_encontro' => 'required',
        ]);


         $descricao_celula = explode("|", $input["celulas"]);

         if ($tipo_operacao=="create")
         {
            $dados = new controle_atividades();
         }
         else
         {
            $dados = controle_atividades::firstOrNew(['id'=>$id]);
         }

         $dados->empresas_clientes_cloud_id = $this->dados_login->empresas_clientes_cloud_id;
         $dados->empresas_id = $this->dados_login->empresas_id;
         $dados->celulas_id = $descricao_celula[0];

         //Se for encontro avulso pega data avulsa
         if ($input["data_encontro"]==" E") {
             $dados->data_encontro = $formatador->FormatarData($input['data_avulsa']);
             $dados->dia = substr($input['data_avulsa'], 0,2);
             $dados->encontro_avulso = 1;
         } else {
              $dados->data_encontro = $input['ano'] . "-" . $input['mes'] . "-" . $input['data_encontro'];
              $dados->dia = $input['data_encontro'];
              $dados->encontro_avulso = 0;
         }

         $dados->mes = $input['mes'];
         $dados->ano = $input['ano'];
         $dados->hora_inicio = $input['hora_inicio'];
         $dados->hora_fim = $input['hora_fim'];
         $dados->obs = trim($input['observacao']);
         $dados->link_externo = trim($input['link_externo']);
         $dados->texto = trim($input['texto_encontro']);
         $dados->lider_pessoas_id = substr($descricao_celula[1],0,9);

         if (isset($input["ckFinalizar"]))
         {
           $dados->encontro_encerrado = ($input["ckFinalizar"] ? "S" : "N");
         }

         $dados->save();

         $id_atividade = $dados->id; //Pega ID recem criado

         //Controle de presenca
         if ($id_atividade!="")
         {

                $i_index=0; /*initialize*/
                $var_total_membros_presentes=0;

                /*
                    $input['id_obs_membro'] have all indexes with ID
                */

               if (isset($input['id_obs_membro'])) {

                  foreach($input['id_obs_membro'] as $selected)
                  {

                              $whereForEach =
                              [
                                  'empresas_clientes_cloud_id' => $this->dados_login->empresas_clientes_cloud_id,
                                  'empresas_id' =>  $this->dados_login->empresas_id,
                                  'controle_atividades_id' => $id_atividade,
                                  'pessoas_id' => $selected
                              ];

                              $controle_presencas = \App\Models\controle_presencas::firstOrNew($whereForEach);

                              $presenca=""; //initialize

                              if (isset($input['presenca']))
                              {
                                  //if found value in ck_resposta array
                                  if (in_array($selected, $input['presenca']))
                                  {
                                      $presenca = "S"; //Yes
                                      $var_total_membros_presentes = $var_total_membros_presentes + 1;
                                  }
                              }


                              $valores =
                              [
                                  'pessoas_id' => $selected,
                                  'empresas_id' =>  $this->dados_login->empresas_id,
                                  'empresas_clientes_cloud_id' => $this->dados_login->empresas_clientes_cloud_id,
                                  'controle_atividades_id' => $id_atividade,
                                  'presenca_simples' => $presenca,
                                  'observacao' => ($input['obs_membro'][$i_index]=="" ? null : $input['obs_membro'][$i_index])
                              ];

                              $controle_presencas->fill($valores)->save();
                              $controle_presencas->save();

                              $i_index = $i_index + 1; //Incrementa sequencia do array para pegar proximos campos (se houver)

                  } //end foreach
              }


                //Visitantes
                $i_index=0; /*initialize*/
                $var_total_visitantes=0;

                //Excluir antes...
                $where = ['empresas_clientes_cloud_id' => $this->dados_login->empresas_clientes_cloud_id,
                                 'empresas_id' =>  $this->dados_login->empresas_id,
                                 'controle_atividades_id' => $id_atividade];

                $excluir = \App\Models\controle_visitantes::where($where)->delete();

                if (isset($input['nome_visitante']))
                {
                      foreach($input['nome_visitante'] as $selected)
                      {

                              if ($selected!="") {

                                  $whereForEach =
                                  [
                                      'empresas_clientes_cloud_id' => $this->dados_login->empresas_clientes_cloud_id,
                                      'empresas_id' =>  $this->dados_login->empresas_id,
                                      'controle_atividades_id' => $id_atividade,
                                      'nome' => $selected
                                  ];

                                  $controle_visitantes = \App\Models\controle_visitantes::firstOrNew($whereForEach);

                                  $valores =
                                  [
                                      'nome' => $selected,
                                      'empresas_id' =>  $this->dados_login->empresas_id,
                                      'empresas_clientes_cloud_id' => $this->dados_login->empresas_clientes_cloud_id,
                                      'controle_atividades_id' => $id_atividade,
                                      'fone' => ($input['fone_visitante'][$i_index]=="" ? null : $input['fone_visitante'][$i_index]),
                                      'email' => ($input['email_visitante'][$i_index]=="" ? null : $input['email_visitante'][$i_index])
                                  ];


                                  $controle_visitantes->fill($valores)->save();
                                  $controle_visitantes->save();


                                  $i_index = $i_index + 1; //Incrementa sequencia do array para pegar proximos campos (se houver)
                                  $var_total_visitantes=$var_total_visitantes+1;
                             }


                      } //end for each visitantes
                }


                //questions
                $i_index=0; /*initialize*/

                if (isset($input['id_hidden_pergunta']))
                {
                    foreach($input['id_hidden_pergunta'] as $selected)
                    {

                                $whereForEach =
                                [
                                    'empresas_clientes_cloud_id' => $this->dados_login->empresas_clientes_cloud_id,
                                    'empresas_id' =>  $this->dados_login->empresas_id,
                                    'controle_atividades_id' => $id_atividade,
                                    'questionarios_id' => $selected
                                ];

                                $controle_questions = \App\Models\controle_questions::firstOrNew($whereForEach);

                                $answer=""; //initialize

                                //if found value in ck_resposta array
                                if (in_array($selected, $input['ck_resposta'])) {
                                    $answer = "S";
                                }

                                if($answer=="")
                                {
                                      if (array_key_exists($i_index, $input['text_resposta']))
                                      {
                                          $answer = $input['text_resposta'][$i_index];
                                      }
                                }

                                $valores =
                                [
                                    'questionarios_id' => $selected,
                                    'empresas_id' =>  $this->dados_login->empresas_id,
                                    'empresas_clientes_cloud_id' => $this->dados_login->empresas_clientes_cloud_id,
                                    'controle_atividades_id' => $id_atividade,
                                    'resposta' => $answer
                                ];

                                $controle_questions->fill($valores)->save();
                                $controle_questions->save();

                                $i_index = $i_index + 1; //Incrementa sequencia do array para pegar proximos campos (se houver)

                    } //end for each question
                }

          }



      //----------------------------RESUMO ENCONTRO-------------------------------------
       $whereForEach =
        [
            'empresas_clientes_cloud_id' => $this->dados_login->empresas_clientes_cloud_id,
            'empresas_id' =>  $this->dados_login->empresas_id,
            'controle_atividades_id' => $id_atividade
        ];

        $controle_resumo = \App\Models\controle_resumo::firstOrNew($whereForEach);

        $valores =
        [
            'empresas_id' =>  $this->dados_login->empresas_id,
            'empresas_clientes_cloud_id' => $this->dados_login->empresas_clientes_cloud_id,
            'controle_atividades_id' => $id_atividade,
            'total_membros' => $var_total_membros_presentes,
            'total_visitantes' => $var_total_visitantes,
            'total_geral' => ($var_total_membros_presentes + $var_total_visitantes)
        ];

        $controle_resumo->fill($valores)->save();
        $controle_resumo->save();

       //----------------------------FIM RESUMO ENCONTRO-------------------------------------



        /*
        //--------------------------RESUMO POR TIPOS DE PESSOAS

        //Excluir antes...
        $where = [
                          'empresas_clientes_cloud_id' => $this->dados_login->empresas_clientes_cloud_id,
                          'empresas_id' =>  $this->dados_login->empresas_id,
                          'controle_atividades_id' => $id_atividade
                        ];

        $excluir = \App\Models\controle_resumo_tipo_pessoa::where($where)->delete();


        $strSql =  " INSERT INTO controle_resumo_tipo_pessoa (empresas_id, empresas_clientes_cloud_id, controle_atividades_id, tipos_pessoas_id, total)";
        $strSql .=  " SELECT cp.empresas_id, cp.empresas_clientes_cloud_id , cp.controle_atividades_id , p.tipos_pessoas_id, count(p.tipos_pessoas_id) FROM ";
        $strSql .=  " controle_presencas cp INNER JOIN pessoas p on cp.pessoas_id = p.id and cp.empresas_id = p.empresas_id and cp.empresas_clientes_cloud_id = p.empresas_clientes_cloud_id ";
        $strSql .=  " WHERE ";
        //$strSql .=  " cp.presenca_simples = 'S' AND ";
        $strSql .=  " cp.controle_atividades_id = " . $id_atividade . " AND ";
        $strSql .=  " cp.empresas_id = " . $this->dados_login->empresas_id . " AND ";
        $strSql .=  " cp.empresas_clientes_cloud_id = " . $this->dados_login->empresas_clientes_cloud_id . "";
        $strSql .=  " group by cp.empresas_id, cp.empresas_clientes_cloud_id , cp.controle_atividades_id , p.tipos_pessoas_id";

        $gravar_resumo = \DB::select($strSql);

        //--------------------------FIM - RESUMO POR TIPOS DE PESSOAS
       */



           //-------------------------------------------------Material para encontro--------------------------------------------------
          //UPLOAD FILES
           $fileName="";
           $file_count=0;
           $uploadcount = 0;
           $lista_arquivos="";
           $seq=0;

           $arquivo = $request->file('upload_arquivo');


           if ($request->hasFile('upload_arquivo'))
           {

                 $file_count = count($arquivo);

                 foreach($arquivo as $file)
                 {

                     if ($_FILES["upload_arquivo"]["size"][$seq] <= 200000) //verifica tamanho permitido
                     {
                            //caminho onde será gravado
                            $destinationPath = base_path() . '/public/arquivos/encontros';

                            $fileName = $file->getClientOriginalName(); // renameing image

                            $file->move($destinationPath, $fileName); // uploading file to given path

                            $whereForEach =
                                              [
                                                  'empresas_clientes_cloud_id' => $this->dados_login->empresas_clientes_cloud_id,
                                                  'empresas_id' =>  $this->dados_login->empresas_id,
                                                  'controle_atividades_id' => $id_atividade,
                                                  'arquivo' => $fileName
                                              ];

                              $controle_materiais = \App\Models\controle_materiais::firstOrNew($whereForEach);
                              $controle_materiais->empresas_clientes_cloud_id = $this->dados_login->empresas_clientes_cloud_id;
                              $controle_materiais->empresas_id = $this->dados_login->empresas_id;
                              $controle_materiais->controle_atividades_id = $id_atividade;
                              $controle_materiais->arquivo = $fileName;
                              $controle_materiais->save();

                              $uploadcount ++; //contabiliza somente enviados

                      } else {

                          if ($lista_arquivos=="")
                          {
                                $lista_arquivos = $file->getClientOriginalName();
                          }
                          else
                          {
                                $lista_arquivos .= "," . $file->getClientOriginalName();
                          }

                      }

                      $seq++; //sequencial de arquivos
                  }

            }

            if ($uploadcount!=$file_count) {
                \Session::flash('flash_message_erro', 'Os dados foram salvos, porém existe(m) arquivo(s) com tamanho máximo excedido : ' . $lista_arquivos );
                return redirect($this->rota);
            }



          //-------------------------------------------------FIM Material para encontro--------------------------------------------------


          return $id_atividade;

      });// ------------ FIM TRANSACTION

  }

  public function buscar($cell_id, $day, $month, $year)
  {

        $dados = controle_atividades::select('id', 'celulas_id', 'hora_inicio', 'hora_fim', 'valor_oferta', 'obs')
        ->where('empresas_id', $this->dados_login->empresas_id)
        ->where('empresas_clientes_cloud_id', $this->dados_login->empresas_clientes_cloud_id)
        ->where('celulas_id', $cell_id)
        ->where('dia', $day)
        ->where('mes', $month)
        ->where('ano', $year)
        ->get();

        //return \Datatables::of($dados)->make(true);
        return $dados;

  }

    //Criar novo registro
    public function create()
    {

        if (\App\ValidacoesAcesso::PodeAcessarPagina(\Config::get('app.' . $this->rota))==false)
        {
              return redirect('home');
        }

        $controle_atividades = \DB::select('select id, descricao_concatenada as nome from view_controle_atividades_simples  where empresas_id = ? and empresas_clientes_cloud_id = ? ', [$this->dados_login->empresas_id, $this->dados_login->empresas_clientes_cloud_id]);

        $celulas = \DB::select('select id, descricao_concatenada as nome from view_celulas_simples  where empresas_id = ? and empresas_clientes_cloud_id = ? ', [$this->dados_login->empresas_id, $this->dados_login->empresas_clientes_cloud_id]);

        return view($this->rota . '.atualizacao',
            [
                'preview'=>'false',
                'tipo_operacao'=>'incluir',
                'celulas'=>$celulas,
                'controle_atividades'=>$controle_atividades,
                'participantes'=>''
            ]);

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

        //Controle de Atividades
        $dados = controle_atividades::select('texto', 'link_externo', 'controle_atividades.id', 'celulas_id', 'hora_inicio', 'hora_fim', 'valor_oferta', 'controle_atividades.obs', 'dia', 'mes', 'ano', 'celulas.dia_encontro', 'celulas.segundo_dia_encontro', 'encontro_encerrado')
        ->join('celulas', 'celulas.id', '=', 'controle_atividades.celulas_id')
        ->where('controle_atividades.empresas_id', $this->dados_login->empresas_id)
        ->where('controle_atividades.empresas_clientes_cloud_id', $this->dados_login->empresas_clientes_cloud_id)
        ->where('controle_atividades.id', $id)
        ->get();

        //members of cell
        /*
        $participantes = \App\Models\celulaspessoas::select('pessoas.id', 'pessoas.razaosocial', 'controle_presencas.observacao', 'controle_presencas.presenca_simples')
        ->join('pessoas', 'pessoas.id', '=', 'celulas_pessoas.pessoas_id')
        ->leftjoin('controle_presencas', 'controle_presencas.pessoas_id', '=', 'celulas_pessoas.pessoas_id')
        ->leftjoin('controle_atividades', 'controle_atividades.id', '=', 'controle_presencas.controle_atividades_id')
        ->where('celulas_pessoas.empresas_id', $this->dados_login->empresas_id)
        ->where('celulas_pessoas.empresas_clientes_cloud_id', $this->dados_login->empresas_clientes_cloud_id)
        ->where('celulas_pessoas.celulas_id', $dados[0]->celulas_id)
        ->where('controle_atividades.id', $id)
        ->orderBy('pessoas.razaosocial')
        ->get();
        */


        //------------------INICIO
       //Busca participantes que nao esteja gravadas no controle de presencas

       $strSql = " SELECT celulas_pessoas.pessoas_id as id, pessoas.razaosocial, '' AS observacao, '' AS presenca_simples ";
       $strSql .=  " FROM celulas_pessoas inner join pessoas on pessoas.id = celulas_pessoas.pessoas_id ";
       $strSql .=  " WHERE  ";
       $strSql .=  " celulas_pessoas.empresas_id = " . $this->dados_login->empresas_id . "  and ";
       $strSql .=  " celulas_pessoas.empresas_clientes_cloud_id = " . $this->dados_login->empresas_clientes_cloud_id . " and  ";
       $strSql .=  " celulas_id = " . $dados[0]->celulas_id . " and  ";
       $strSql .=  " pessoas_id not in ";
       $strSql .=  " (select pessoas_id from controle_presencas                  ";
       $strSql .=  " where controle_atividades_id = " . $id . " and                   ";
       $strSql .=  " empresas_id = " . $this->dados_login->empresas_id . " and                  ";
       $strSql .=  " empresas_clientes_cloud_id = " . $this->dados_login->empresas_clientes_cloud_id . ") ";

       $strSql .=  " union all ";

       $strSql .=  " SELECT pessoas.id as id, pessoas.razaosocial, controle_presencas.observacao, controle_presencas.presenca_simples ";
       $strSql .=  " FROM controle_presencas ";
       $strSql .=  " inner join pessoas on pessoas.id = controle_presencas.pessoas_id ";
       $strSql .=  " where ";
       $strSql .=  " controle_presencas.controle_atividades_id= " . $id . " and ";
       $strSql .=  " controle_presencas.empresas_id = " . $this->dados_login->empresas_id . " and  ";
       $strSql .=  " controle_presencas.empresas_clientes_cloud_id = " . $this->dados_login->empresas_clientes_cloud_id . " ";
       $strSql .=  " order by razaosocial";

       $participantes = \DB::select($strSql);

       //-------------------FIM



       //Questionarios gravados
        $controle_questions = \App\Models\controle_questions::select('id')
        ->where('empresas_id', $this->dados_login->empresas_id)
        ->where('empresas_clientes_cloud_id', $this->dados_login->empresas_clientes_cloud_id)
        ->where('controle_atividades_id', $id)
        ->get();


        //Materiais Enviados
        $controle_materiais = \App\Models\controle_materiais::select('arquivo', 'id')
        ->where('empresas_id', $this->dados_login->empresas_id)
        ->where('empresas_clientes_cloud_id', $this->dados_login->empresas_clientes_cloud_id)
        ->where('controle_atividades_id', $id)
        ->get();


        if ($controle_materiais->count()==0)
        {
              $controle_materiais = \App\Models\tabela_vazia::get();
        }

        $visitantes = \App\Models\controle_visitantes::select('id', 'nome', 'fone', 'email')
        ->where('empresas_id', $this->dados_login->empresas_id)
        ->where('empresas_clientes_cloud_id', $this->dados_login->empresas_clientes_cloud_id)
        ->where('controle_atividades_id', $id)
        ->get();

        $questions = \App\Models\questionarios_encontros::select('id', 'pergunta', 'tipo_resposta')
        ->where('empresas_id', $this->dados_login->empresas_id)
        ->where('empresas_clientes_cloud_id', $this->dados_login->empresas_clientes_cloud_id)
        ->get();


        if ($controle_questions->count()!=0)
        {
            //get saved questions from database
            //$questions_saved = \App\Models\questionarios_encontros::select('controle_questions.questionarios_id', 'questionarios_encontros.id', 'pergunta', 'tipo_resposta', 'resposta')
            //->leftjoin('controle_questions', 'controle_questions.questionarios_id',  '=', 'questionarios_encontros.id')
            //->where('questionarios_encontros.empresas_id', $this->dados_login->empresas_id)
            //->where('questionarios_encontros.empresas_clientes_cloud_id', $this->dados_login->empresas_clientes_cloud_id)
            //->where('controle_questions.controle_atividades_id', $id);

           //Busca perguntas que nao esteja gravadas no encontro
             $strSql = " select q.id as questionarios_id, q.id, pergunta, q.tipo_resposta, '' as resposta  from questionarios_encontros q ";
             $strSql .=  " where  q.empresas_id = " . $this->dados_login->empresas_id . " ";
             $strSql .=  " and q.empresas_clientes_cloud_id = " . $this->dados_login->empresas_clientes_cloud_id . " and ";
             $strSql .=  " q.id not in (select c.questionarios_id from questionarios_encontros q ";
             $strSql .=  "                  inner join controle_questions c on q.id = c.questionarios_id ";
             $strSql .=  "                  where c.controle_atividades_id =" . $id . " and ";
             $strSql .=  "                  c.empresas_id = " . $this->dados_login->empresas_id . " and ";
             $strSql .=  "                  c.empresas_clientes_cloud_id = " . $this->dados_login->empresas_clientes_cloud_id . ")";

             $strSql .=  " union all"; //Unira as duas querys para trazer todas as perguntas, mesmo que nao esteja gravadas para o encontro

             //Busca perguntas somente do encontro
             $strSql .=  " select q.id as questionarios_id, q.id, q.pergunta, q.tipo_resposta, c.resposta from questionarios_encontros q";
             $strSql .=  " inner join controle_questions c on q.id = c.questionarios_id ";
             $strSql .=  " where c.controle_atividades_id=" . $id . " and ";
             $strSql .=  " c.empresas_id = " . $this->dados_login->empresas_id . " and ";
             $strSql .=  " c.empresas_clientes_cloud_id = " . $this->dados_login->empresas_clientes_cloud_id . "";
             $strSql .=  " order by pergunta";

             $questions = \DB::select($strSql);
             $questions_saved = $questions;


        }
        else
        {
          //Artificio para tabelas vazias com objetos collection
            $questions_saved = \App\Models\tabela_vazia::get();
        }

        //Load all dates by day of week (mondays, tuesdays, etc)
        $dates_of_meeting = $this->return_dates($dados);

        $celulas = \DB::select('select id, descricao_concatenada as nome from view_celulas_simples  where empresas_id = ? and empresas_clientes_cloud_id = ? ', [$this->dados_login->empresas_id, $this->dados_login->empresas_clientes_cloud_id]);

        return view($this->rota . '.atualizacao',
            [
                'preview'=>'false',
                'tipo_operacao'=>'editar',
                'celulas'=>$celulas,
                'dados'=>$dados,
                'dates_of_meeting'=>$dates_of_meeting,
                'participantes'=>$participantes,
                'questions'=>$questions,
                'questions_saved'=>$questions_saved,
                'visitantes'=>$visitantes,
                'controle_materiais'=>$controle_materiais
             ]);

    }


   //Return all dates in a month by dayOfWeek
   private function return_dates($dados)
   {

        $var_month = $dados[0]->mes;
        $var_year = $dados[0]->ano;
        $var_dayOfWeek = $dados[0]->dia_encontro;
        $var_counting_days = cal_days_in_month(CAL_GREGORIAN, $var_month, $var_year); //days of month

        $dini = mktime(0,0,0,$var_month,1,$var_year);
        $dfim = mktime(0,0,0,$var_month,$var_counting_days,$var_year);

        $return_d = array();

        while($dini <= $dfim) //Enquanto uma data for inferior a outra
        {
            $dt = date("d/m/Y",$dini); //Convertendo a data no formato dia/mes/ano
            $diasemana = date("w", $dini);

            if($diasemana == $var_dayOfWeek)
            { // [0 Domingo] - [1 Segunda] - [2 Terca] - [3 Quarta] - [4 Quinta] - [5 Sexta] - [6 Sabado]
                array_push($return_d, $dt);
            }

            $dini += 86400; // Adicionando mais 1 dia (em segundos) na data inicial
        }

        //Segundo dia encontro
        $var_month = $dados[0]->mes;
        $var_year = $dados[0]->ano;
        $var_dayOfWeek = $dados[0]->segundo_dia_encontro;
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

        array_push($return_d, "");
        array_push($return_d, " Encontro Avulso (Criar Novo) ");

        //Verifica se houve encontro avulso para a celula / mes / ano
        $dt_encontro_avulso = $this->buscar_data_avulsa($dados[0]->celulas_id, $var_month, $var_year);

        if ($dt_encontro_avulso!=null) {
            array_push($return_d, "");
            array_push($return_d, " Houve Encontro Avulso : ");

            foreach ($dt_encontro_avulso as $item) {
               array_push($return_d, date("d/m/Y", strtotime($item->data_encontro)));
            }
        }

        return ($return_d);

   }


  public function buscar_data_avulsa($id, $mes, $ano)
  {
            $buscar = \App\Models\controle_atividades::select('data_encontro')
            ->where('empresas_clientes_cloud_id', $this->dados_login->empresas_clientes_cloud_id)
            ->where('empresas_id', $this->dados_login->empresas_id)
            ->where('encontro_avulso', 1)
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
                return null; //Retorna vazio
            }
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
           return redirect($this->rota);
    }


    /**
     * Excluir registro do banco.
     *
     * @param    int  $id
     * @return  \Illuminate\Http\Response
     */
    public function destroy($id)
    {
            $dados = controle_atividades::findOrfail($id);
            $dados->delete();
            return redirect($this->rota);
    }


    public function remove_image ($id)
    {

         $encontro_materiais = \App\Models\controle_materiais::findOrfail($id);

         if(!\File::delete(public_path() . '/arquivos/encontros/' . $encontro_materiais->arquivo))
         {
            return "false";
         }
         else
         {
            $encontro_materiais->delete();
            return "true";
         }

    }


 public function relatorio_encontro($id, $tipo, $data)
 {

    /*------------------------------------------INICIALIZA PARAMETROS JASPER--------------------------------------------------*/
    //Pega dados de conexao com o banco para o JASPER REPORT
    $database = \Config::get('database.connections.jasper_report');
    $ext = "pdf"; //Tipo saída (PDF, XLS)
    $output = public_path() . '/relatorios/resultados/' . $ext . '/encontro_' . $this->dados_login->empresas_id . '_' . Auth::user()->id; //Path para cada tipo de relatorio
    $path_download = '/relatorios/resultados/' . $ext . '/encontro_' . $this->dados_login->empresas_id . '_' .  Auth::user()->id; //Path para cada tipo de relatorio
    /*------------------------------------------INICIALIZA PARAMETROS JASPER--------------------------------------------------*/


   //make where clausure for query in jasper report
   $sWhere = " ca.empresas_id = " . $this->dados_login->empresas_id . " and ca.empresas_clientes_cloud_id = " .$this->dados_login->empresas_clientes_cloud_id . "";
   $sWhere .= " and ca.id = " . $id;


    $parametros = array
    (
        "empresas_id"=> $this->dados_login->empresas_id,
        "empresas_clientes_cloud_id"=> $this->dados_login->empresas_clientes_cloud_id,
        "data_encontro"=> "'" . $data . "'",
        "SUBREPORT_DIR"=> "'" . public_path() . '/relatorios/' . "'"
    );


    //se houver logo informada
    if (rtrim(ltrim(\Session::get('logo')))!="")
    {
        $parametros = array_add($parametros, 'path_logo', public_path() . '/images/clients/' . \Session::get('logo'));
    }

    //Relatorio Resumido
    if ($tipo=="R")
    {
        $parametros = array_add($parametros, 'exibir_pessoas', 0);
    }


   //set parameter sWhere for query in report
   $parametros = array_add($parametros, 'sWhere', "'" . $sWhere . "'");

   $nome_relatorio = public_path() . '/relatorios/relatorio_encontro.jasper';


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
            }
                else
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

 }//fim relatorio


}