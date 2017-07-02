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

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->rota = "home"; //Define nome da rota que será usada na classe
    }


     public function confirm($codigo)
    {

        if(!$codigo)
        {
            throw new InvalidConfirmationCodeException;
        }

        $user = User::whereConfirmationCode($codigo)->first();

        if ( ! $user)
        {
            throw new InvalidConfirmationCodeException;
        }

        $user->confirmed = 1;
        $user->confirmation_code = null;
        $user->save();

        \Session::flash('flash_message', 'Conta Verificada com Sucesso!');

        return redirect('home');  //Ainda nao cadastrou, solicitar o cadastro

    }

  public function Avisos() {

    $query = " select CURRENT_DATE - (data_aviso-  INTERVAL '1 DAY')  :: DATE as aviso, CURRENT_DATE - (data_acesso -  INTERVAL '1 DAY')  :: DATE  AS DIAS, users.id, name, razaosocial, data_acesso, users.email from usuarios  ";
    $query .= " inner join users on users.id = usuarios.id ";
    $query .= " inner join empresas on empresas.id = usuarios.empresas_id ";
    $query .= " inner join log_users on log_users.id = usuarios.id";
    $query .= " WHERE CURRENT_DATE - (data_acesso -  INTERVAL '1 DAY')  :: DATE > 40";

    //busca informacoes do membro
    $membro = \DB::select($query);


    if ($membro)
    {

            foreach ($membro as $item) {

                if ($item->aviso==null || $item->aviso >= 30) {

                    \Mail::send('emails.inativos', ['email'=> $item->email, 'data' => date("d/m/Y", strtotime($item->data_acesso)), 'nome'=>$item->name], function($message) use ($item)
                    {
                        $message->from('contato@sigma3sistemas.com.br', 'Sigma3');
                        $message->subject('SIGMA3 - Gestão para Igrejas');
                        $message->to($item->email);
                    });

                    $log = \App\Models\log_users::find($item->id);

                    if($log) {
                       $log->data_aviso =  date('Y-m-d h:i:s');
                       $log->save();
                    }

                }

            }
    }


  }

    public function jalogado()
    {
            Auth::logout();
            \Session::flush();
            return view('home', ['erros'=>'Usuário já logado em outra máquina']);
    }


    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(\Illuminate\Http\Request  $request)
    {

        //retirado da construct
        //Validação de permissão de acesso a pagina

        //Verificar se foi cadastrado os dados da igreja
        if (usuario::find(Auth::user()->id))
       {

            $avisos='';

            //Busca ID do cliente cloud e ID da empresa
            $this->dados_login = usuario::find(Auth::user()->id);


            /*VALIDAÇÃO PARA LOGIN UNICO.*/
            $log = \App\Models\log_users::find(Auth::user()->id);

            if($log) //Achou
            {

               \Session::put('ultimo_acesso', $log->data_acesso);
               \Session::put('ip', $log->ip);

               if (\Session::get('token')=="")
               {
                   $token_acesso = str_random(30);
                   $log->token = $token_acesso;
                   \Session::put('token', $token_acesso);
               }
               else if (\Session::get('token')!=$log->token)
               {
                    //dd('já logado :' . \Session::get('token'));
                    return redirect('userlogged')->withErrors(['msg', 'Usuário já logado em outra máquina.']);
               }

               $log->data_acesso =  date('Y-m-d h:i:s');
               $log->ip = $request->ip();
               $log->save();

            }
            else //Primeiro acesso
            {
                $token_acesso = str_random(30);

                $log = new \App\Models\log_users();
                $log->id = Auth::user()->id;
                $log->token = $token_acesso;
                $log->data_acesso =  date('Y-m-d h:i:s');
                $log->empresas_id = $this->dados_login->empresas_id;
                $log->empresas_clientes_cloud_id = $this->dados_login->empresas_clientes_cloud_id;
                $log->ip = $request->ip();
                $log->save();
                \Session::put('token', $token_acesso);
                \Session::put('ultimo_acesso', $log->data_acesso);
                \Session::put('ip', $log->ip);
            }


            \Session::put('titulo', 'Home | Dashboard');
            \Session::put('subtitulo', '');
            \Session::put('route', '');
            \Session::put('dados_login', $this->dados_login);
            \Session::put('tour_rapido', $this->dados_login->tutorial);
            \Session::put('tour_visaogeral', $this->dados_login->tutorial_visaogeral);
            \Session::put('admin', $this->dados_login->admin);


        /*
        Busca Configuracao de labels para menu de estrutura de celulas
        */
        $menu_celulas = \App\Models\configuracoes::where('empresas_id', $this->dados_login->empresas_id)
                ->where('empresas_clientes_cloud_id', $this->dados_login->empresas_clientes_cloud_id)
                ->get();

        if ($menu_celulas)
        {
             \Session::put('nivel1', $menu_celulas[0]->celulas_nivel1_label);
             \Session::put('nivel2', $menu_celulas[0]->celulas_nivel2_label);
             \Session::put('nivel3', $menu_celulas[0]->celulas_nivel3_label);
             \Session::put('nivel4', $menu_celulas[0]->celulas_nivel4_label);
             \Session::put('nivel5', $menu_celulas[0]->celulas_nivel5_label);

             /*Variaveis para configuracoes gerais do sistema*/
             \Session::put('padrao_textos', $menu_celulas[0]->padrao_textos);
             \Session::put('label_celulas', $menu_celulas[0]->label_celulas);
             \Session::put('label_celulas_singular', $menu_celulas[0]->label_celulas_singular);
             \Session::put('label_encontros', $menu_celulas[0]->label_encontros);
             \Session::put('label_encontros_singular', $menu_celulas[0]->label_encontros_singular);
             \Session::put('label_lider_singular', $menu_celulas[0]->label_lider_singular);
             \Session::put('label_lider_plural', $menu_celulas[0]->label_lider_plural);
             \Session::put('label_lider_treinamento', $menu_celulas[0]->label_lider_treinamento);
             \Session::put('label_anfitriao', $menu_celulas[0]->label_anfitriao);
             \Session::put('label_lider_suplente', $menu_celulas[0]->label_lider_suplente);
             \Session::put('label_participantes', $menu_celulas[0]->label_participantes);
        }


            if (Auth::user()->membro!="S")
            {

                        $avisos = \DB::select('select * from avisos where id not in (select avisos_id from log_avisos where users_id = ' .  Auth::user()->id . ')');

                        //Verificar se usuario logado é LIDER DE CELULA
                        $funcoes = new  \App\Functions\FuncoesGerais();

                        $lider_logado = $funcoes->verifica_se_lider();

                        //Verifica se é alguém da liderança (Lider de Rede, Area, Coordenador, Supervisor, etc)
                        $lideranca = $funcoes->verifica_se_lideranca();

                        //SE for lider, direciona para dashboard da célula
                        if ($lider_logado!=null)
                        {
                             if ($lideranca==null) { //Somente se nao for alguem da lideranca
                                return redirect('dashboard_celulas');
                             }
                        }

                        $where =
                        [
                            'empresas_id' => $this->dados_login->empresas_id,
                            'empresas_clientes_cloud_id' => $this->dados_login->empresas_clientes_cloud_id
                        ];

                        //-------------------Functions no POSTGRES
                        //Total de registro na tabela pessoas
                        $retorno = \DB::select('select  fn_total_pessoas(' . $this->dados_login->empresas_clientes_cloud_id . ', ' . $this->dados_login->empresas_id. ')');
                        $total_pessoas = $retorno[0]->fn_total_pessoas;

                        //Total de membros. Verifica-se no cadastro de tipo de pessoas o registro que contenha a aba membros configurada
                        $retorno = \DB::select('select  fn_total_membros(' . $this->dados_login->empresas_clientes_cloud_id . ', ' . $this->dados_login->empresas_id. ')');
                        $total_membros = $retorno[0]->fn_total_membros;

                        //Total de aniversariantes no mes
                        $retorno = \DB::select('select  fn_total_niver(' . $this->dados_login->empresas_clientes_cloud_id . ', ' . $this->dados_login->empresas_id. ')');
                        $total_aniversariantes = $retorno[0]->fn_total_niver;

                        $retorno = \DB::select('select  fn_total_niver_dia(' . $this->dados_login->empresas_clientes_cloud_id . ', ' . $this->dados_login->empresas_id. ')');
                        $total_aniversariantes_dia = $retorno[0]->fn_total_niver_dia;

                        $retorno = \DB::select('select  fn_total_inativos(' . $this->dados_login->empresas_clientes_cloud_id . ', ' . $this->dados_login->empresas_id. ')');
                        $total_inativos = $retorno[0]->fn_total_inativos;

                        $retorno = \DB::select('select  fn_total_familias(' . $this->dados_login->empresas_clientes_cloud_id . ', ' . $this->dados_login->empresas_id. ')');
                        $total_familias = $retorno[0]->fn_total_familias;

                        //----------------- FIM Functions POSTGRES

                        $pessoas_tipos = \DB::select('select * from view_total_pessoas_tipo vw where vw.empresas_id = ? and vw.empresas_clientes_cloud_id = ? ', [$this->dados_login->empresas_id, $this->dados_login->empresas_clientes_cloud_id]);
                        $pessoas_sexo = \DB::select('select * from view_total_pessoas_sexo vw where vw.empresas_id = ? and vw.empresas_clientes_cloud_id = ? ', [$this->dados_login->empresas_id, $this->dados_login->empresas_clientes_cloud_id]);

                        $pessoas_status = \DB::select('select * from view_total_pessoas_status vw where vw.empresas_id = ? and vw.empresas_clientes_cloud_id = ? ', [$this->dados_login->empresas_id, $this->dados_login->empresas_clientes_cloud_id]);
                        $pessoas_estadoscivis = \DB::select('select * from view_total_pessoas_estadoscivis vw where vw.empresas_id = ? and vw.empresas_clientes_cloud_id = ? ', [$this->dados_login->empresas_id, $this->dados_login->empresas_clientes_cloud_id]);


            }
            else //Area do MEMBRO
            {
                    //busca informacoes do membro
                    $membro = \DB::select('select * from view_login_membro vp where lower(email_membro) = ? and vp.empresas_id = ? and vp.empresas_clientes_cloud_id = ? ', [Auth::user()->email, $this->dados_login->empresas_id, $this->dados_login->empresas_clientes_cloud_id]);


                    $vazio = \App\Models\tabela_vazia::get();


                    if ($membro)
                    {

                        if ($membro[0]->id!="")
                        {
                             //Retorna próxima data de encontro em aberto
                             $strSql =  " SELECT to_char(data_encontro::timestamp with time zone, 'DD-MM-YYYY'::text) AS data_encontro_formatada, ca.id as controle_id, * ";
                             $strSql .=  " FROM controle_atividades ca ";
                             $strSql .=  " left join controle_materiais cm on ca.id = cm.controle_atividades_id and ca.empresas_id = cm.empresas_id and ca.empresas_clientes_cloud_id = cm.empresas_clientes_cloud_id  ";
                             $strSql .=  " where ";
                             $strSql .=  " ca.celulas_id = " . $membro[0]->id . " AND ";
                             $strSql .=  " ca.empresas_id = " . $this->dados_login->empresas_id . " AND ";
                             $strSql .=  " ca.empresas_clientes_cloud_id = " . $this->dados_login->empresas_clientes_cloud_id . " AND ";
                             $strSql .=  " isnull(ca.encontro_encerrado,'N') = 'N' AND ";
                             $strSql .=  " ca.data_encontro >=  to_char( now(), 'YYYY-MM-DD' ) ORDER BY data_encontro asc";


                             $materiais = \DB::select($strSql);

                             if ($materiais!=null)
                             {
                                 $presenca = \App\Models\controle_presencas::select('presenca_simples', 'hora_check_in')
                                 ->where('empresas_id', $this->dados_login->empresas_id)
                                 ->where('empresas_clientes_cloud_id', $this->dados_login->empresas_clientes_cloud_id)
                                 ->where('controle_atividades_id', $materiais[0]->controle_id)
                                 ->where('pessoas_id', $membro[0]->id_membro)
                                 ->get();

                                 if ($presenca->count()==0)
                                 {
                                        $presenca = $vazio;
                                 }
                            } else {
                                $presenca = $vazio;
                            }

                         }
                         else
                         {
                             $materiais = $vazio;
                             $presenca = $vazio;
                         }


                    }else {
                        $materiais = $vazio;
                        $membro = $vazio;
                        $presenca = $vazio;
                    }


            }

            $this->Avisos();

            if (Auth::user()->membro=="S")
            {
                  return view('pages.membros', ['presenca'=>$presenca, 'membro'=>$membro, 'materiais'=>$materiais]);
            }
            else
            {

                return view('pages.dashboard',
                    [
                        'total_pessoas' => $total_pessoas,
                        'total_membros' => $total_membros,
                        'total_aniversariantes' => $total_aniversariantes,
                        'total_aniversariantes_dia'=>$total_aniversariantes_dia,
                        'total_inativos' => $total_inativos,
                        'pessoas_tipos'=>$pessoas_tipos,
                        'total_familias'=>$total_familias,
                        'pessoas_sexo'=>$pessoas_sexo,
                        'pessoas_status'=>$pessoas_status,
                        'pessoas_estadoscivis'=>$pessoas_estadoscivis,
                        'avisos'=>$avisos
                    ]);
            }

        }
        else
        {
            return view('pages.dashboard_blank');  //Ainda nao cadastrou, solicitar o cadastro
        }

    }
}