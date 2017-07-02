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

class PerfilController extends Controller
{
    //

    public function __construct()
    {

        $this->middleware('auth');

        //Validação de permissão de acesso a pagina
        if (Gate::allows('verifica_permissao', [\Config::get('app.profile'),'acessar']))
        {
            $this->dados_login = \Session::get('dados_login');
        }

    }


    //Abre tela para edicao ou somente visualização dos registros
    private function exibir ($request, $id, $preview, $perfil)
    {

        if (\App\ValidacoesAcesso::PodeAcessarPagina(\Config::get('app.profile'))==false)
        {
              return redirect('home');
        }

        //preview = true, somente visualizacao, desabilita botao gravar
        $dados = users::findOrfail($id);

        $where = ['empresas.id' => $this->dados_login->empresas_id, 'clientes_cloud_id' => $this->dados_login->empresas_clientes_cloud_id];

        //Todas igrejas/instituições pertencentes a igreja sede
        $empresas = \App\Models\empresas::select('id', 'razaosocial')
        ->where($where)
        ->get();

        return view('profile.perfil', ['dados' =>$dados, 'preview' => $preview,  'dados_login'=>$this->dados_login]);

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


        \Session::flash('flash_message', 'Dados Atualizados com Sucesso!!!');

        return redirect('home');

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

         return redirect('home');

    }

}