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

class UsersController extends Controller
{
    //

    public function __construct()
    {

        $this->middleware('auth');

        //Validação de permissão de acesso a pagina
        if (Gate::allows('verifica_permissao', [\Config::get('app.usuarios'),'acessar']))
        {
            $this->dados_login = \Session::get('dados_login');
        }


    }

    //Exibir listagem dos grupos
    public function index()
    {
        if (\App\ValidacoesAcesso::PodeAcessarPagina(\Config::get('app.usuarios'))==false)
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


        $usuarios = users::select ('users.path_foto', 'users.id', 'users.name', 'users.email', 'usuarios.master', 'empresas.razaosocial')
        ->join('usuarios', 'usuarios.id' , '=' , 'users.id')
        ->join('empresas', 'empresas.id' , '=' , 'usuarios.empresas_id')
        ->where('usuarios.membro', '<>', 'S')
        ->where($where)
        ->get();


        return view('usuarios.index', compact('usuarios'));

    }

    //Criar novo registro
    public function create()
    {

        if (\App\ValidacoesAcesso::PodeAcessarPagina(\Config::get('app.usuarios'))==false)
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

        //Query para trazer empresas na dropdown
        $empresas = \App\Models\empresas::select('empresas.id', 'empresas.razaosocial')
        ->where($where)
        ->get();

        return view('usuarios.registrar', ['dados' => $dados, 'empresas'=>$empresas, 'dados_login'=>$this->dados_login]);

    }


/*
* Grava dados no banco
*
*/
    public function store(\Illuminate\Http\Request  $request)
    {

            /*Validação de campos - request*/
            $this->validate($request, [
                   'name' => 'required|max:255',
                   'email' => 'required|email|max:255|unique:users',
                   'password' => 'required|confirmed|min:6',
                   'empresa' => 'required',
                   'grupo' => 'required',
             ]);

            $image = $request->file('caminhologo'); //Pega imagem

            $input = $request->except(array('_token', 'ativo')); //não levar o token


            //----------------------Grava novo usuario (Tabela USERS)
            $dados = new users();
            $dados->name  = $input['name'];
            $dados->email  = strtolower($input['email']);
            $dados->confirmed                              = 1; //Se for criado usuario pelo usuario.
            $dados->password  = bcrypt($input['password']);

            if ($image)
            {
                $dados->path_foto = $image->getClientOriginalName();
            }

            if ($input['mydata']!="") //Imagem tirada pela webcam
            {
                $dados->path_foto = str_replace(" ","", (strtolower($input['name']) . date("his")) ) . '_webcam.jpg';
            }


            $dados->save();
            //----------------------FIM - Grava novo usuario (Tabela USERS)


            //-----------------Pega dados do usuarios admin (id da empresa e cliente cloud)
            $usuario_master = usuario::find(Auth::user()->id);


            //-----------------Cria registro na tabela usuarios para associar com a tabela users
            $usuarios = new usuario();
            $usuarios->id                                           =   $dados->id;    //id recem cadastrado na tabela users
            $usuarios->empresas_id                          =  $input['empresa'];
            //$usuarios->confirmed                              = 1; //Se for criado usuario pelo usuario.
            $usuarios->empresas_clientes_cloud_id  =  $usuario_master['empresas_clientes_cloud_id'];


            if ($input['sera_admin']==1) //Se estiver criando usuário ADMIN
            {
                //Se este for de outra empresa, cria como MASTER
                //if ($input['empresa']!=$this->dados_login->empresas_id)
                //{
                //    $usuarios->master = 1; //MASTER tem acesso total e nao pode ser excluido

                //} else
                //{
                 //   $usuarios->master = 0;
               // }

            }
            else
            {
                $usuarios->master = 0;
            }

            $usuarios->admin = $input['sera_admin'];
            $usuarios->save();
            //-----------------FIM - Cria registro na tabela usuarios para associar com a tabela users


            //Se usuário master estiver criando um admin para outras igrejas/instituições, cria um usuario como admin.
            if ($input['sera_admin']==1)
            {

                    //Cria o novo grupo somente se o usuário for pertencer a outra empresa
                    //Caso seja da mesma empresa associa ao grupo existente
                    if ($input['empresa']!=$this->dados_login->empresas_id) {

                         //----------------------------------Cria grupo padrão Administrador (Se já não existir)
                         //A tabela grupos, dispara a triiger de INSERT e chama a  spCriarPermissoesPadrao(NEW.id) que cria as permissoes padrao para o Administrador
                         $grupo_padrao = \App\Models\grupos::firstOrCreate(
                            [
                                'nome' => 'Administrador',
                                'empresas_id' => $input['empresa'],
                                'empresas_clientes_cloud_id' => $usuario_master['empresas_clientes_cloud_id'],
                                'default' => '1'
                            ]);
                         //----------------------------------FIM - Cria grupo padrão Administrador


                         //------------------------------------Grava usuario e grupo
                         //Usuario Admin com grupo padrão admin (com todas permissões)
                         $usuarios_grupo = new \App\Models\usuarios_grupo();
                         $usuarios_grupo->usuarios_id = $dados->id;
                         $usuarios_grupo->usuarios_empresas_id = $input['empresa'];
                         $usuarios_grupo->usuarios_empresas_clientes_cloud_id = $usuario_master['empresas_clientes_cloud_id'];
                         $usuarios_grupo->grupos_id = $grupo_padrao->id;
                         $usuarios_grupo->save();
                        //------------------------------------FIM Grava usuario e grupo
                    } else
                    {
                           //Grava Grupo que o usuário iŕa pertencer
                            $grupo_usuario = new \App\Models\usuarios_grupo();
                            $grupo_usuario->usuarios_id = $dados->id;
                            $grupo_usuario->usuarios_empresas_id = $input['empresa'];
                            $grupo_usuario->usuarios_empresas_clientes_cloud_id = $usuario_master['empresas_clientes_cloud_id'];
                            $grupo_usuario->grupos_id = $input['grupo'];
                            $grupo_usuario->save();
                    }

            } else {

                //Grava Grupo que o usuário iŕa pertencer
                $grupo_usuario = new \App\Models\usuarios_grupo();
                $grupo_usuario->usuarios_id = $dados->id;
                $grupo_usuario->usuarios_empresas_id = $input['empresa'];
                $grupo_usuario->usuarios_empresas_clientes_cloud_id = $usuario_master['empresas_clientes_cloud_id'];
                $grupo_usuario->grupos_id = $input['grupo'];
                $grupo_usuario->save();

            }

            //----------------------------------Foto do usuário

            if ($image)
            {
                    /*Regras validação imagem*/
                    $rules = array(
                        'image' => 'image',
                        'image' => array('mimes:jpeg,jpg,png', 'max:200px'),
                    );

                    // Validar regras
                    $validator = Validator::make([$image], $rules);

                    // Check to see if validation fails or passes
                    if ($validator->fails()) {

                        dd($validator);

                    } else {

                        $destinationPath = base_path() . '/public/images/users'; //caminho onde será gravado
                        if(!$image->move($destinationPath, $image->getClientOriginalName())) //move para pasta destino com nome fixo logo
                        {
                            return $this->errors(['message' => 'Erro ao salvar imagem.', 'code' => 400]);
                        }
                    }
             }//----------------------------------FIM - Foto do usuário


              if ($input['mydata']!="") //Imagem da webcam
             {
                 $encoded_data = $input['mydata'];

                 $binary_data = base64_decode($encoded_data);

                 //caminho onde será gravado
                 $destinationPath = base_path() . '/public/images/users';

                 // Salva no path definido, alterando o nome da imagem com o nome da pessoa
                 $result = file_put_contents( $destinationPath . '/' . str_replace(" ","", (strtolower($input['name']) . date("his"))) . '_webcam.jpg', $binary_data );
             }




            \Session::flash('flash_message', 'Dados Atualizados com Sucesso!!!');

            return redirect('usuarios');

    }

    //Abre tela para edicao ou somente visualização dos registros
    private function exibir ($request, $id, $preview, $perfil)
    {
        if($request->ajax())
        {
            return URL::to('usuarios/'. $id . '/edit');
        }

        if (\App\ValidacoesAcesso::PodeAcessarPagina(\Config::get('app.usuarios'))==false)
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

        //Todas igrejas/instituições pertencentes a igreja sede
        $empresas = \App\Models\empresas::select('id', 'razaosocial')
        ->where($where)
        ->get();

        if ($perfil=='true')
        {
            return view('usuarios.perfil', ['dados' =>$dados, 'preview' => $preview, 'grupos'=>$grupos, 'empresas'=>$empresas, 'grupo_do_usuario' =>$grupo_do_usuario, 'dados_login'=>$this->dados_login]);
        }
        else
        {
            return view('usuarios.edit', ['dados' =>$dados, 'preview' => $preview, 'grupos'=>$grupos, 'empresas'=>$empresas, 'grupo_do_usuario' =>$grupo_do_usuario, 'dados_login'=>$this->dados_login]);
        }


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
     * Atualiza dados no banco
     *
     * @param    \Illuminate\Http\Request  $request
     * @param    int  $id
     * @return  \Illuminate\Http\Response
     */
    public function update(\Illuminate\Http\Request  $request, $id)
    {

       /*Validação de campos - request*/
        $this->validate($request, [
               'name' => 'required|max:255',
                'email' => 'required|email|max:255',
                'password' => 'required|confirmed|min:6',
         ]);

        $image = $request->file('caminhologo'); //Pega imagem

        $input = $request->except(array('_token', 'ativo')); //não levar o token

        //-------------Atualiza Usuario
        $dados = users::findOrfail($id);
        $dados->name  = $input['name'];
        $dados->email  = $input['email'];
        $dados->password  = bcrypt($input['password']);


        if ($image)
        {
            $dados->path_foto  = $image->getClientOriginalName();
        }

        if ($input['mydata']!="") //Imagem tirada pela webcam
        {

            $dados->path_foto = str_replace(" ","", (strtolower($input['name']) . date("his")) ) . '_webcam.jpg';
        }

        $dados->save();//-------------FIM - Atualiza Usuario


        //----------------------------------Foto do usuário
        if ($image)
        {
                /*Regras validação imagem*/
                $rules = array(
                    'image' => 'image',
                    'image' => array('mimes:jpeg,jpg,png', 'max:200px'),
                );

                // Validar regras
                $validator = Validator::make([$image], $rules);

                // Check to see if validation fails or passes
                if ($validator->fails()) {

                    dd($validator);

                } else {

                    $destinationPath = base_path() . '/public/images/users'; //caminho onde será gravado
                    if(!$image->move($destinationPath, $image->getClientOriginalName())) //move para pasta destino com nome fixo logo
                    {
                        return $this->errors(['message' => 'Erro ao salvar imagem.', 'code' => 400]);
                    }
                }
         }//-----FIM upload

         if ($input['mydata']!="") //Imagem da webcam
         {
             $encoded_data = $input['mydata'];

             $binary_data = base64_decode($encoded_data);

             //caminho onde será gravado
             $destinationPath = base_path() . '/public/images/users';

             // Salva no path definido, alterando o nome da imagem com o nome da pessoa
             $result = file_put_contents( $destinationPath . '/' . str_replace(" ","", (strtolower($input['name']) . date("his"))) . '_webcam.jpg', $binary_data );
         }



         //-----------------Cria registro na tabela usuarios para associar com a tabela users
         $where = ['empresas_clientes_cloud_id' => $this->dados_login->empresas_clientes_cloud_id, 'empresas_id' =>  $input['empresa'], 'id' => $id];

         $update = \DB::table('usuarios')->where($where)->update(array('empresas_id'    =>  $input['empresa'],'admin' =>  $input['sera_admin']));
         //-----------------FIM - Cria registro na tabela usuarios para associar com a tabela users


        //------------------Atualizar tabela USUARIOS_GRUPO
        $where = ['usuarios_empresas_clientes_cloud_id' => $this->dados_login->empresas_clientes_cloud_id, 'usuarios_id' => $id];

        $update = \DB::table('usuarios_grupo')->where($where)
        ->update(array(
                        'usuarios_empresas_id'    =>  $input['empresa'],
                        'grupos_id'    => $input['grupo']));
        //------------------FIM - Atualizar tabela USUARIOS_GRUPO


        \Session::flash('flash_message', 'Dados Atualizados com Sucesso!!!');
        return redirect('usuarios');

    }


    /**
     * Excluir registro do banco.
     *
     * @param    int  $id
     * @return  \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        try {

            //Apaga tabela USERS
            $dados = users::findOrfail($id);
            $dados->delete();

            //Apaga tabela USUARIOS_GRUPO
            $where = [
            'usuarios_empresas_clientes_cloud_id' => $this->dados_login->empresas_clientes_cloud_id,
            'usuarios_id' => $id];

            \DB::table('usuarios_grupo')->where($where)->delete();

            //Apaga tabela USUARIOS
            $where = [
            'empresas_clientes_cloud_id' => $this->dados_login->empresas_clientes_cloud_id,
            'id' => $id];

            \DB::table('usuarios')->where($where)->delete();

            return redirect('usuarios');

        } catch (Exception $e) {

            \Session::flash('flash_message_erro', 'Erro ao tentar excluir o registro. Detalhes : ' . $e);
            return redirect('usuarios');

        }

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

    public function remove_image ($id)
    {

         $dados = users::findOrfail($id);

         if(!\File::delete(public_path() . '/images/users/' . $dados->path_foto))
         {

            \Session::flash('flash_message_erros', 'Erro ao remover imagem');
         }
         else
         {

            $dados->path_foto = '';
            $dados->save();

            \Session::flash('flash_message', 'Imagem Removida com Sucesso!!!');

         }

         return redirect('usuarios');

    }

}
