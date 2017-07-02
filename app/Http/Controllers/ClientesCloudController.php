<?php
/*
* Autor : Oscar Fabiano
* Data  : 29-01-2016
*  Consideraçoes :
*       - Poderia ser usado o método de validações do form request personalizado
*       - Também poderá ser alterado o save() para request->all(),  inclusive retirando caracteres especiais
*       - Por questões de estudo, deixaremos esse controle da forma que está para ser comparado com outro métiodos
*/
namespace App\Http\Controllers;

use App\Models\clientescloud;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use URL;
use App\Models\usuario;
use App\Models\empresas;
use Auth;
use Input;
use Validator;
use Gate;

class ClientesCloudController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
        $this->rota = "clientes"; //Define nome da rota que será usada na classe

        /*
          //Validação de permissão de acesso a pagina
        if (Gate::allows('verifica_permissao', [\Config::get('app.' . $this->rota),'acessar']))
        {
            $this->dados_login = \Session::get('dados_login');
        }
        */

    }


    public function index()
    {

        if (\App\ValidacoesAcesso::PodeAcessarPagina(\Config::get('app.' . $this->rota))==false)
        {
              return redirect('home');
        } else
        {
            $this->dados_login = \Session::get('dados_login');
        }


        //Somente usuario master pode visualizar dados da igreja sede
        if ($this->dados_login->master==1 && \Session::get('master_sede')->igreja_sede!=null)
        {
            $clientes_cloud = clientescloud::all()->where('id', intval($this->dados_login->empresas_clientes_cloud_id));
            return view('clientes.index', ['clientes_cloud'=>$clientes_cloud]);
        }
        else
        {
            \Session::flash('flash_message_erro', 'Somente usuário MASTER tem acesso aos dados cadastrais da Igreja Sede');
            return redirect('home');
        }

    }

    //
    public function create() {

        return view('clientes.registrar');

    }


/*
* Grava Clientes Cloud, Empresa, associa users com usuarios
* cria grupo padrao chamado Administrador
* (trigger tabela grupos executa CALL spCriarPermissoesPadrao(NEW.id);)
* Associa usuario ao grupo Admin padrão com todas permissões
*
*/
    public function store(\Illuminate\Http\Request  $request)
    {

        //Validação de campos - request
        $this->validate($request, [
                'razaosocial' => 'required|max:255:min:3',
                'foneprincipal' => 'required|min:8',
                'emailprincipal' => 'email',
                'emailsecundario' => 'email',
                'cnpj'      => 'cnpj',
         ]);

        //---------------------------------Cadastro do cliente cloud

        $image = $request->file('caminhologo');

        $input = $request->except(array('_token', 'ativo')); //não levar o token

        $clientes_cloud = new clientescloud();

        $clientes_cloud->razaosocial = $input['razaosocial'];
        $clientes_cloud->nomefantasia = $input['nomefantasia'];
        $clientes_cloud->cnpj = preg_replace("/[^0-9]/", '', $input['cnpj']);
        $clientes_cloud->inscricaoestadual = $input['inscricaoestadual'];
        $clientes_cloud->endereco = $input['endereco'];
        $clientes_cloud->numero = $input['numero'];
        $clientes_cloud->bairro = $input['bairro'];
        $clientes_cloud->cep = $input['cep'];
        $clientes_cloud->complemento = $input['complemento'];
        $clientes_cloud->cidade = $input['cidade'];
        $clientes_cloud->estado = $input['estado'];
        $clientes_cloud->foneprincipal = preg_replace("/[^0-9]/", '', $input['foneprincipal']);
        $clientes_cloud->fonesecundario = preg_replace("/[^0-9]/", '', $input['fonesecundario']);
        $clientes_cloud->emailprincipal = $input['emailprincipal'];
        $clientes_cloud->emailsecundario = $input['emailsecundario'];
        $clientes_cloud->nomecontato = $input['nomecontato'];
        $clientes_cloud->celular = $input['celular'];
        $clientes_cloud->ativo = 'S'; //Sempre ativo quando cadastrar ?
        $clientes_cloud->website = $input['website'];

        if ($image)
        {

            $clientes_cloud->caminhologo = $image->getClientOriginalName();

        }

        $clientes_cloud->save();
        //--------------------------------- FIM - Cadastro do cliente cloud


       //Busca id da tabela empresas vinculada a tabela clientes_cloud
        $id_empresas = empresas::where('clientes_cloud_id', $clientes_cloud->id)->select('id')->first();


       /*------------------------- Vinculo tabela users com usuarios
       *
       * Grava o id (users, clientes_cloud e empresas) na tabela usuarios (id, empresas_clientes_cloud_id, empresas_id)
       */
       $usuarios          = new usuario();
       $usuarios->id                                           =  Auth::user()->id;    //id do usuário logado (tabela users)
       $usuarios->empresas_id                          =  $id_empresas['id']; //Pegar ID do registro recém criado (clientes_cloud)
       $usuarios->empresas_clientes_cloud_id  =  $clientes_cloud->id;
       $usuarios->master = 1; //Criada a empresa a primeira vez, o usuario que cadastrou será o master e nao podera ser removido
       $usuarios->admin = 1; //O Master também é ADMIN
       $usuarios->save();
       //------------------------- FIM - Vinculo tabela users com usuarios

        //---------------------------Upload da imagem
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

                    $destinationPath = base_path() . '/public/images/clients'; //caminho onde será gravado
                    if(!$image->move($destinationPath, $image->getClientOriginalName())) //move para pasta destino com nome fixo logo
                    {
                        return $this->errors(['message' => 'Erro ao salvar imagem.', 'code' => 400]);
                    }
                }
         }
         //---------------------------FIM - Upload da imagem

         //----------------------------------Cria grupo padrão Administrador
         //A tabela grupos, dispara a triiger de INSERT e chama a  spCriarPermissoesPadrao(NEW.id) que cria as permissoes padrao para o Administrador
         $grupo_padrao = new \App\Models\grupos();
         $grupo_padrao->nome = "Administrador";
         $grupo_padrao->empresas_id = $id_empresas['id'];
         $grupo_padrao->empresas_clientes_cloud_id  =  $clientes_cloud->id;
         $grupo_padrao->default = 1; //Grupo padrão
         $grupo_padrao->save(); //Ira disparar a trigger e chamar a spCriarPermissoesPadrao
         //----------------------------------FIM - Cria grupo padrão Administrador


         //------------------------------------Grava usuario e grupo
         //Usuario Admin com grupo padrão admin (com todas permissões)
         $usuarios_grupo = new \App\Models\usuarios_grupo();
         $usuarios_grupo->usuarios_id = Auth::user()->id;
         $usuarios_grupo->usuarios_empresas_id = $id_empresas['id'];
         $usuarios_grupo->usuarios_empresas_clientes_cloud_id = $clientes_cloud->id;
         $usuarios_grupo->grupos_id = $grupo_padrao->id;
         $usuarios_grupo->save();
        //------------------------------------FIM Grava usuario e grupo

         \Session::flash('flash_message', 'Dados Atualizados com Sucesso!!!');

         return redirect('clientes');

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

        //preview = true, somente visualizacao, desabilita botao gravar
        $dados = clientescloud::findOrfail($id);
        return view($this->rota . '.edit', ['dados' =>$dados, 'preview' => $preview] );

    }

    public function show(Request $request, $id)
    {
            return $this->exibir($request, $id, 'true');
    }

    public function edit(Request $request, $id)
    {
        return $this->exibir($request, $id, 'false');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param    \Illuminate\Http\Request  $request
     * @param    int  $id
     * @return  \Illuminate\Http\Response
     */
    public function update(Request  $request, $id)
    {

        /*Validação de campos - request*/
        $this->validate($request, [
                'razaosocial' => 'required|max:255:min:3',
                'foneprincipal' => 'required|min:10',
                'emailprincipal' => 'email',
                'emailsecundario' => 'email',
                'cnpj' => 'cnpj',
         ]);

        $image = $request->file('caminhologo');

        $input = $request->except(array('_token', 'ativo')); //não levar o token

        $clientes_cloud = clientescloud::findOrfail($id);

        $clientes_cloud->razaosocial  = $input['razaosocial'];
        $clientes_cloud->nomefantasia = $input['nomefantasia'];
        $clientes_cloud->cnpj  = preg_replace("/[^0-9]/", '', $input['cnpj']);
        $clientes_cloud->inscricaoestadual = $input['inscricaoestadual'];
        $clientes_cloud->endereco = $input['endereco'];
        $clientes_cloud->numero = $input['numero'];
        $clientes_cloud->bairro = $input['bairro'];
        $clientes_cloud->cep = $input['cep'];
        $clientes_cloud->complemento = $input['complemento'];
        $clientes_cloud->cidade = $input['cidade'];
        $clientes_cloud->estado = $input['estado'];
        $clientes_cloud->foneprincipal = preg_replace("/[^0-9]/", '', $input['foneprincipal']);
        $clientes_cloud->fonesecundario = preg_replace("/[^0-9]/", '', $input['fonesecundario']);
        $clientes_cloud->emailprincipal = $input['emailprincipal'];
        $clientes_cloud->emailsecundario = $input['emailsecundario'];
        $clientes_cloud->nomecontato = $input['nomecontato'];
        $clientes_cloud->celular = $input['celular'];
        //$clientes_cloud->ativo = $input['ativo'];
        $clientes_cloud->website = $input['website'];

        if ($image) {
            $clientes_cloud->caminhologo = $image->getClientOriginalName();
        }

        $clientes_cloud->save();

        if ($image) {
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

                    $destinationPath = base_path() . '/public/images/clients'; //caminho onde será gravado
                    if(!$image->move($destinationPath, $image->getClientOriginalName())) //move para pasta destino com nome fixo logo
                    {
                        return $this->errors(['message' => 'Erro ao salvar imagem.', 'code' => 400]);
                    }
                }
            }

        \Session::flash('flash_message', 'Dados Atualizados com Sucesso!!!');

        return redirect('clientes');

    }

    /**
     * Delete confirmation message by Ajaxis
     *
     * @link  https://github.com/amranidev/ajaxis
     *
     * @return  String
     */
    public function DeleteMsg($id)
    {
        $msg = Ajaxis::MtDeleting('Aviso!!','Confirma exclusão ?','/clientes/'. $id . '/delete/');

        if(Request::ajax())
        {
            return $msg;
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param    int  $id
     * @return  \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $clientes_cloud = clientescloud::findOrfail($id);
        $clientes_cloud->delete();
        return URL::to('clientes');
    }

    public function remove_image ($id) {

         $clientes_cloud = clientescloud::findOrfail($id);

         if(!\File::delete(public_path() . '/images/clients/' . $clientes_cloud->caminhologo))
         {

            \Session::flash('flash_message_erros', 'Erro ao remover imagem');
         }
         else
         {

            $clientes_cloud->caminhologo = '';
            $clientes_cloud->save();

            \Session::flash('flash_message', 'Imagem Removida com Sucesso!!!');

         }

         return redirect('clientes');

    }

}