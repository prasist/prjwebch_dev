<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use URL;
use App\Models\users;
use App\Models\usuario;
use Auth;
use Input;
use Validator;
use Gate;
use DB;

class LoginMembroController extends Controller
{
    /*
        --MEMBROS APTOS A RECEBER LOGIN
        select count(*) from pessoas where
        tipos_pessoas_id = 11 and ativo = 'S' AND
        empresas_id = 20 and empresas_clientes_cloud_id = 15 and (emailprincipal is not null or emailprincipal <> '')

        --MEMBROS ATIVOS POREM SEM EMAIL
        select count(*) from pessoas where
        tipos_pessoas_id = 11 and ativo = 'S' AND
        empresas_id = 20 and empresas_clientes_cloud_id = 15 and (emailprincipal is  null or emailprincipal = '')

    */

    public function __construct()
    {

        $this->middleware('auth');
        $this->rota = "login_membros"; //Define nome da rota que será usada na classe

        //Validação de permissão de acesso a pagina
        if (Gate::allows('verifica_permissao', [\Config::get('app.login_membros'),'acessar']))
        {
            $this->dados_login = \Session::get('dados_login');
        }

    }

    //Exibir listagem dos grupos
    public function index()
    {
        if (\App\ValidacoesAcesso::PodeAcessarPagina(\Config::get('app.login_membros'))==false)
        {
              return redirect('home');
        }

        //Só exibir todas empresas se for usuário master
        //Somente usuario master pode visualizar dados da igreja sede
        if ($this->dados_login->master==1 && \Session::get('master_sede')->igreja_sede!=null)
        {
            $where = ['usuarios.empresas_clientes_cloud_id' => $this->dados_login->empresas_clientes_cloud_id];
        }
        else
        {
            $where = ['usuarios.empresas_id' => $this->dados_login->empresas_id, 'usuarios.empresas_clientes_cloud_id' => $this->dados_login->empresas_clientes_cloud_id];
        }

        $usuarios = users::select ('data_acesso', 'ip', 'users.id', 'users.name', 'users.email', 'usuarios.master', 'empresas.razaosocial')
        ->join('usuarios', 'usuarios.id' , '=' , 'users.id')
        ->join('empresas', 'empresas.id' , '=' , 'usuarios.empresas_id')
        ->leftJoin('log_users', 'log_users.id' , '=' , 'usuarios.id')
        ->where($where)
        ->where('users.membro', 'S')
        ->get();

        return view('login_membros.index', compact('usuarios'));

    }

    //Criar novo registro
    public function create()
    {

        if (\App\ValidacoesAcesso::PodeAcessarPagina(\Config::get('app.login_membros'))==false)
        {
              return redirect('home');
        }

        //Query para mostrar os grupos da empresa e cliente logados na dropdown
        $dados  = \App\Models\grupos::select('grupos.id', 'grupos.nome')
        ->where('grupos.empresas_id', $this->dados_login->empresas_id)
        ->where('grupos.empresas_clientes_cloud_id', $this->dados_login->empresas_clientes_cloud_id)
        ->get();


        //Só exibir todas empresas se for usuário master
        if ($this->dados_login->master==1)
        {
            $where = ['clientes_cloud_id' => $this->dados_login->empresas_clientes_cloud_id];
        }
        else
        {
            $where = ['empresas.id' => $this->dados_login->empresas_id, 'clientes_cloud_id' => $this->dados_login->empresas_clientes_cloud_id];
        }

        return view('login_membros.registrar', ['dados' => $dados, 'dados_login'=>$this->dados_login]);

    }


/*
* Grava dados no banco
*
*/
public function store(\Illuminate\Http\Request  $request)
{

    /* ------------------ INICIA TRANSACTION -----------------------*/
     \DB::transaction(function() use ($request)
     {

            $input = $request->except(array('_token')); //não levar o token

            /*Validação de campos - request*/
            if ($input['quem']=="2") {
                $this->validate($request, ['grupo' => 'required', 'pessoas'=> 'required']);
            } else {
                $this->validate($request, ['grupo' => 'required']);
            }

            //Pega tipo de pessoa MEMBRO
            $tipos = \App\Models\tipospessoas::select('id')
            ->where('clientes_cloud_id', $this->dados_login->empresas_clientes_cloud_id)
            ->where('membro', 't')
            ->get();


            if ($input["pessoas"]!="")  //PESSOA ESPECIFICA
           {
               /*
               $pessoas = \App\Models\pessoas::select('emailprincipal', 'razaosocial', 'datanasc', 'cpf')
               ->where('empresas_id', $this->dados_login->empresas_id)
               ->where('empresas_clientes_cloud_id', $this->dados_login->empresas_clientes_cloud_id)
               ->where('emailprincipal', '<>', '')
               ->where('id', substr($input['pessoas'],0,9))
               ->get();
                */

               $sSql = " SELECT emailprincipal, razaosocial, datanasc, cpf FROM pessoas ";
               $sSql .= " WHERE empresas_id = " .  $this->dados_login->empresas_id . "";
               $sSql .= " AND empresas_clientes_cloud_id = " .  $this->dados_login->empresas_clientes_cloud_id . "";
               $sSql .= " and emailprincipal <> '' ";
               $sSql .= " and emailprincipal not in (select email from users)";
               $sSql .= " and id = " . substr($input['pessoas'],0,9);
               $pessoas = \DB::select($sSql);


           } else {

               //Lista tipos de pessoas, será usado no botão novo registro para indicar qual tipo de cadastro efetuar
               /*$pessoas = \App\Models\pessoas::select('emailprincipal', 'razaosocial', 'datanasc', 'cpf')
               ->where('empresas_id', $this->dados_login->empresas_id)
               ->where('empresas_clientes_cloud_id', $this->dados_login->empresas_clientes_cloud_id)
               ->where('emailprincipal', '<>', '')
               ->where('tipos_pessoas_id', '=', $tipos[0]->id) //SOMENTE MEMBROS
               ->where('ativo', '=', 'S') //ATIVOS
               ->get();
                */

               $sSql = " SELECT emailprincipal, razaosocial, datanasc, cpf FROM pessoas ";
               $sSql .= " WHERE empresas_id = " .  $this->dados_login->empresas_id;
               $sSql .= " AND empresas_clientes_cloud_id = " .  $this->dados_login->empresas_clientes_cloud_id;
               $sSql .= " and emailprincipal <> '' ";
               $sSql .= " and emailprincipal not in (select email from users)";
               $sSql .= " and tipos_pessoas_id = " . $tipos[0]->id;
               $sSql .= " and ativo = 'S' ";
               $pessoas = \DB::select($sSql);


            }

            $iQtd=0;

           foreach ($pessoas as $item)
           {

                if (rtrim(ltrim($item->cpf))!="" ||  rtrim(ltrim($item->datanasc))!="" || rtrim(ltrim($input['password']))) //Deve exisitr pelo menos um dos dois
                {

                        $iQtd++;
                        $dados = users::firstOrNew(['email' => strtolower($item->emailprincipal)]);
                        $dados->name  = $item->razaosocial;
                        $dados->email  = strtolower($item->emailprincipal);
                        $dados->confirmed = 1; //Se for criado usuario pelo usuario.

                        if ($input["gerar"]=="1")  //CPF
                        {
                            if (rtrim(ltrim($item->cpf))!="") //se houver cpf
                            {
                                 $sSenha= substr($item->cpf, 0,6);
                                 $dados->password = bcrypt(substr($item->cpf, 0,6));
                            }
                            else if (rtrim(ltrim($item->datanasc))!="") //nao tem cpf, mas tem data de nascimento
                            {
                                $dados->password = bcrypt((substr($item->datanasc,5,2) . substr($item->datanasc,0,4)));
                                $sSenha= (substr($item->datanasc,5,2) . substr($item->datanasc,0,4));
                            }
                            else
                            { //nao tem nenhum
                                 $dados->password = "";
                            }
                        }
                        else if ($input["gerar"]=="2")  //Especifico
                        {
                            $dados->password = bcrypt($input['password']);
                            $sSenha = $input['password'];
                        }

                        $dados->membro = "S";
                        $dados->save();

                        //-----------------Cria registro na tabela usuarios para associar com a tabela users
                        $usuarios = usuario::firstOrNew(['id' => $dados->id, 'empresas_id'=>$this->dados_login->empresas_id, 'empresas_clientes_cloud_id'=>$this->dados_login->empresas_clientes_cloud_id]);
                        $usuarios->id                                         =  $dados->id;    //id recem cadastrado na tabela users
                        $usuarios->empresas_id                         =  $this->dados_login->empresas_id;
                        $usuarios->empresas_clientes_cloud_id  =  $this->dados_login->empresas_clientes_cloud_id;
                        $usuarios->master = 0;
                        $usuarios->membro = 'S';
                        $usuarios->save();
                        //-----------------FIM - Cria registro na tabela usuarios para associar com a tabela users

                        //Grava Grupo que o usuário iŕa pertencer
                        $grupo_usuario = \App\Models\usuarios_grupo::firstOrNew(['usuarios_id' => $dados->id, 'usuarios_empresas_id'=>$this->dados_login->empresas_id, 'usuarios_empresas_clientes_cloud_id'=>$this->dados_login->empresas_clientes_cloud_id]);
                        $grupo_usuario->usuarios_id = $dados->id;
                        $grupo_usuario->usuarios_empresas_id = $this->dados_login->empresas_id;
                        $grupo_usuario->usuarios_empresas_clientes_cloud_id = $this->dados_login->empresas_clientes_cloud_id;
                        $grupo_usuario->grupos_id = $input['grupo'];
                        $grupo_usuario->save();

                        $data = ['email'=>$item->emailprincipal, 'nome_igreja'=>\Session::get('nome_igreja'), 'nome'=>$item->razaosocial, 'senha'=>$sSenha];


                        if (isset($input["ckenviar"]))
                        {
                                \Mail::send('emails.bemvindo', ['nome' => $data["nome"], 'nome_igreja'=>$data["nome_igreja"], 'email'=>$data["email"], 'senha'=>$data["senha"]], function($message) use ($data)
                                {
                                    $message->from('contato@sigma3sistemas.com.br', 'Sigma3');
                                    $message->subject('Acesso a Área do Membro - ' . $data['nome_igreja']);
                                    $message->to($data['email']);
                                });
                        }

                }

           } //loop


            if ($iQtd>0) {
                \Session::flash('flash_message', 'Dados Atualizados com Sucesso!!!');
            }else{
                \Session::flash('flash_message_erro', 'Nenhum registro Atualizado, verifique se o(s) membro(s) possue(m) email cadastrado, CPF ou data de nascimento');
            }

         }); //FIM TRANSACTION

        return redirect('login_membros');

    }



    //Abre tela para edicao ou somente visualização dos registros
    private function exibir ($request, $id, $preview, $perfil)
    {
        if($request->ajax())
        {
            return URL::to('login_membros/'. $id . '/edit');
        }

        if (\App\ValidacoesAcesso::PodeAcessarPagina(\Config::get('app.login_membros'))==false)
        {
              return redirect('home');
        }

        //Pega dados do grupo do usuario cadastrado
        $grupo_do_usuario = \App\Models\usuarios_grupo::select('usuarios.admin', 'usuarios_grupo.grupos_id' , 'usuarios_grupo.usuarios_empresas_id', 'usuarios_grupo.usuarios_empresas_clientes_cloud_id')
        ->join('usuarios', 'usuarios.id', '=', 'usuarios_grupo.usuarios_id')
        ->join('grupos', 'grupos.id', '=', 'usuarios_grupo.grupos_id')
        ->where('usuarios_grupo.usuarios_id', $id)
        ->get();

        //Todos grupos da empresa
        $grupos = \App\Models\grupos::select('id', 'nome')
        ->where('empresas_id', $this->dados_login->empresas_id)
        ->where('empresas_clientes_cloud_id', $this->dados_login->empresas_clientes_cloud_id)
        ->get();

        //preview = true, somente visualizacao, desabilita botao gravar
        $dados = users::findOrfail($id);


        //Só exibir todas empresas se for usuário master
        if ($this->dados_login->master==1) {
            $where = ['clientes_cloud_id' => $this->dados_login->empresas_clientes_cloud_id];
        }
        else
        {
            $where = ['empresas.id' => $this->dados_login->empresas_id, 'clientes_cloud_id' => $this->dados_login->empresas_clientes_cloud_id];
        }


        return view('login_membros.edit', ['tipo_operacao'=>'editar', 'dados' =>$dados, 'preview' => $preview, 'grupos'=>$grupos, 'grupo_do_usuario' =>$grupo_do_usuario, 'dados_login'=>$this->dados_login]);


    }

    //Visualizar registro
    public function show (\Illuminate\Http\Request $request, $id)
    {

            return $this->exibir($request, $id, 'true', 'false');

    }

    //Direciona para tela de alteracao
    public function edit(\Illuminate\Http\Request $request, $id)
    {
            return $this->exibir($request, $id, 'false', 'false');
    }


    //Direciona para tela de alteração de perfil do usuario
    public function perfil(\Illuminate\Http\Request $request, $id)
    {
            return $this->exibir($request, $id, 'false', 'true');
    }




    /**
     * Excluir registro do banco.
     *
     * @param    int  $id
     * @return  \Illuminate\Http\Response
     */
    public function destroy($id)
    {

            //Apaga tabela USERS
            $dados = users::findOrfail($id);
            $dados->delete();

            //Apaga tabela USUARIOS_GRUPO
            $where = ['usuarios_empresas_clientes_cloud_id' => $this->dados_login->empresas_clientes_cloud_id, 'usuarios_id' => $id];
            \DB::table('usuarios_grupo')->where($where)->delete();

            //Apaga tabela USUARIOS
            $where = ['empresas_clientes_cloud_id' => $this->dados_login->empresas_clientes_cloud_id, 'id' => $id];
            \DB::table('usuarios')->where($where)->delete();

            return redirect('login_membros');
    }


    public function validar($id)
    {

        //Verifica se existe usuário para a congregação e retorna a quantidade de registros. Caso seja nullo, trataremos a mensagem para a view
        //dizendo que não existe usuário e o primeiro deverá ser o ADMIN
        $where = ['empresas_clientes_cloud_id' => $this->dados_login->empresas_clientes_cloud_id, 'empresas_id' =>  $id];

        $quantidade = \App\Models\usuario::where($where)->count();

        //Se não existir usuário e a igreja for diferente da sede = Avisar o usuário para cadastrar o primeiro usuario como ADMIN
        if ($quantidade==0 && $id != $this->dados_login->empresas_id)
        {
            return 0;
        }
        //Já existe usuário para a igreja/instuição = Avisar o usuario que somente o ADMIN daquela igreja é quem poderá cadastrar novos usuarios
        else if ($quantidade>0 && $id != $this->dados_login->empresas_id)
        {
            return 1;
        }
        //Existe usuario pois é a igreja Sede = Deixa cadastrar usuarios mas enconde a opção "É Administrador"
        else if ($quantidade>0 && $id == $this->dados_login->empresas_id)
        {
            return 2;
        }

    }



}
