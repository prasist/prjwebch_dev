<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\pessoas;
use App\Functions;
use URL;
use Auth;
use DB;
use Input;
use Gate;

class MembroDadosController extends Controller
{

    public function __construct()
    {

        $this->rota = "membro_dados"; //Define nome da rota que será usada na classe
        $this->middleware('auth');

        //Validação de permissão de acesso a pagina
        if (Gate::allows('verifica_permissao', [\Config::get('app.' . $this->rota),'acessar']))
        {
            $this->dados_login = \Session::get('dados_login');
        }

    }


/*
* Grava dados no banco
*
*/
public function salvar($request, $id) {

        /*Clausula where padrao para as tabelas auxiliares*/
        $where =
        [
            'empresas_clientes_cloud_id' => $this->dados_login->empresas_clientes_cloud_id,
            'empresas_id' =>  $this->dados_login->empresas_id,
            'pessoas_id' => $id
        ];


              /*Instancia biblioteca de funcoes globais*/
               $formatador = new  \App\Functions\FuncoesGerais();

                /*Validação de campos - request*/
                $this->validate($request, [
                        'emailprincipal' => 'email',
                 ]);

                $image = $request->file('caminhologo'); //Imagem / Logo
                $input = $request->except(array('_token', 'ativo')); //não levar o token

                $pessoas = pessoas::findOrfail($id);

                $pessoas->endereco = $input['endereco'];
                $pessoas->numero = $input['numero'];
                $pessoas->bairro = $input['bairro'];
                $pessoas->cep = $input['cep'];
                $pessoas->complemento = $input['complemento'];
                $pessoas->cidade = $input['cidade'];
                $pessoas->estado = $input['estado'];
                $pessoas->fone_principal = $formatador->RetirarCaracteres($input['foneprincipal']); //preg_replace("/[^0-9]/", '', $input['foneprincipal']);
                $pessoas->fone_secundario = $formatador->RetirarCaracteres($input['fonesecundario']);//preg_replace("/[^0-9]/", '', $input['fonesecundario']);
                $pessoas->fone_recado = $input['fonerecado'];
                $pessoas->fone_celular = $input['celular'];
                $pessoas->emailprincipal = $input['email'];

                if ($image) //Imagem Enviada computador
                {
                    $pessoas->caminhofoto = str_replace(" ","", $input['razaosocial']) . '.' . $image->getClientOriginalExtension();
                }

                $pessoas->save();


                /*------------------------------FIM  CADASTRO DE PESSOAS------------------- */



               /*-------------------------------------------------- UPLOAD IMAGEM */
               if ($image) //Imagem enviada
               {
                        /*Regras validação imagem*/
                        $rules = array (
                            'image' => 'image',
                            'image' => array('mimes:jpeg,jpg,png', 'max:2000kb'),
                        );

                        // Validar regras
                        $validator = \Validator::make([$image], $rules);

                        // Check to see if validation fails or passes
                        if ($validator->fails())
                        {
                            \Session::flash('flash_message_erro', 'Os dados foram salvos, porém houve erro no envio da imagem.');
                            return redirect($this->rota);
                        }
                        else
                        {

                            //caminho onde será gravado
                            $destinationPath = base_path() . '/public/images/persons';

                            // Cria uma instancia
                            $img = \Image::make($image->getRealPath());

                            //redimenciolna a imagem
                            $img->resize(320, 240);

                            //Salva a imagem no path definido, criando com nome da pessoa e a extencao original do arquivo
                            $img->save($destinationPath . '/' . str_replace(" ","", $input['razaosocial']) . '.' . $image->getClientOriginalExtension());

                        }
                 }
}


    //Abre tela para edicao ou somente visualização dos registros
    private function exibir ($request, $id, $preview, $bool_exibir_perfil)
    {


        if($request->ajax())
        {
            return URL::to($this->rota . '/'. $id . '/edit');
        }

        //Validação de permissão
        if (\App\ValidacoesAcesso::PodeAcessarPagina(\Config::get('app.' . $this->rota))==false)
        {
              return redirect('home');
        }

        $sQuery = "select to_char(datanasc, 'DD-MM-YYYY') AS datanasc_formatada, * ";
        $sQuery .= " from pessoas ";
        $sQuery .= " where id = ? ";
        $sQuery .= " and empresas_id = ? ";
        $sQuery .= " and  empresas_clientes_cloud_id = ? ";
        $sQuery .= " order by razaosocial ";
        $pessoas = \DB::select($sQuery, [$id, $this->dados_login->empresas_id, $this->dados_login->empresas_clientes_cloud_id]);

         return view($this->rota . '.perfil' , ['pessoas' => $pessoas]);


    }


    //Visualizar registro
    public function show (\Illuminate\Http\Request $request, $id, $id_tipo_pessoa)
    {
          return $this->exibir($request, $id, 'true', 'false');
    }

    //Direciona para tela de alteracao
    public function edit(\Illuminate\Http\Request $request, $id)
    {
          return $this->exibir($request, $id,  'false', 'false');
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
            $this->salvar($request, $id);
            \Session::flash('flash_message', 'Dados Atualizados com Sucesso!!!');
            return redirect('home');
    }

}