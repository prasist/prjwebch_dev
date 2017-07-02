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

class EmpresasController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');

        //Validação de permissão de acesso a pagina
        if (Gate::allows('verifica_permissao', [\Config::get('app.empresas'),'acessar']))
        {
            $this->dados_login = \Session::get('dados_login');
        }

    }


    public function index()
    {

        if (\App\ValidacoesAcesso::PodeAcessarPagina(\Config::get('app.empresas'))==false)
        {
              return redirect('home');
        }

        //Só exibir todas empresas se for usuário master
        if ($this->dados_login->master==1) {
            $where = ['clientes_cloud_id' => $this->dados_login->empresas_clientes_cloud_id];
        }
        else
        {
            $where = ['clientes_cloud_id' => $this->dados_login->empresas_clientes_cloud_id, 'id' => $this->dados_login->empresas_id];
        }


        $emp = empresas::select('id', 'razaosocial', 'nomefantasia','cnpj', 'inscricaoestadual', 'igreja_sede')
        ->where($where)
        ->get();

        return view('empresas.index',compact('emp'));

    }


    //
    public function create() {

        if (\App\ValidacoesAcesso::PodeAcessarPagina(\Config::get('app.empresas'))==false)
        {
              return redirect('home');
        }

        return view('empresas.registrar');

    }


/*
* ClientesCloudRequesempresas = Validação de campos
*
*/
    public function store(\Illuminate\Http\Request  $request)
    {

        /*Validação de campos - request*/
        $this->validate($request, [
                'razaosocial' => 'required|max:255:min:3',
                'foneprincipal' => 'required|min:10',
                'emailprincipal' => 'email',
                'emailsecundario' => 'email',
         ]);

        $image = $request->file('caminhologo');

        $input = $request->except(array('_token', 'ativo')); //não levar o token

        $usuarios   = new usuario();

        $empresas = new empresas();

        $empresas->razaosocial = $input['razaosocial'];
        $empresas->nomefantasia = $input['nomefantasia'];
        $empresas->cnpj = preg_replace("/[^0-9]/", '', $input['cnpj']);
        $empresas->inscricaoestadual = $input['inscricaoestadual'];
        $empresas->endereco = $input['endereco'];
        $empresas->numero = $input['numero'];
        $empresas->bairro = $input['bairro'];
        $empresas->cep = $input['cep'];
        $empresas->complemento = $input['complemento'];
        $empresas->cidade = $input['cidade'];
        $empresas->estado = $input['estado'];
        $empresas->foneprincipal = preg_replace("/[^0-9]/", '', $input['foneprincipal']);
        $empresas->fonesecundario = preg_replace("/[^0-9]/", '', $input['fonesecundario']);
        $empresas->emailprincipal = $input['emailprincipal'];
        $empresas->emailsecundario = $input['emailsecundario'];
        $empresas->nomecontato = $input['nomecontato'];
        $empresas->celular = $input['celular'];
        $empresas->ativo = 'S'; //Sempre ativo quando cadastrar ?
        $empresas->website = $input['website'];

        $cadastrou = usuario::find(Auth::user()->id);

        if ($cadastrou)
        {
            $empresas->clientes_cloud_id = $cadastrou['empresas_clientes_cloud_id'];
        }


        if ($image) {
            $empresas->caminhologo = $image->getClientOriginalName();
        }

        $empresas->save();

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

        return redirect('empresas');

    }

   public function show(Request $request, $id)
   {

        if($request->ajax())
        {
            return URL::to('empresas/'. $id . '/edit');
        }

        $empresas = empresas::findOrfail($id);

        //Preview = true, somente visualização, desabilita botao gravar
        return view('empresas.edit', ['empresas' => $empresas, 'preview' => 'true']);
    }

    public function edit(Request $request, $id)
    {
        if($request->ajax())
        {
            return URL::to('empresas/'. $id . '/edit');
        }

        $empresas = empresas::findOrfail($id);

        //Preview = false, habilita botao gravar
        return view('empresas.edit', ['empresas' => $empresas, 'preview' => 'false']);
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
         ]);

        $image = $request->file('caminhologo');

        $input = $request->except(array('_token', 'ativo')); //não levar o token

        $empresas = empresas::findOrfail($id);

        $empresas->razaosocial  = $input['razaosocial'];
        $empresas->nomefantasia = $input['nomefantasia'];
        $empresas->cnpj  = preg_replace("/[^0-9]/", '', $input['cnpj']);
        $empresas->inscricaoestadual = $input['inscricaoestadual'];
        $empresas->endereco = $input['endereco'];
        $empresas->numero = $input['numero'];
        $empresas->bairro = $input['bairro'];
        $empresas->cep = $input['cep'];
        $empresas->complemento = $input['complemento'];
        $empresas->cidade = $input['cidade'];
        $empresas->estado = $input['estado'];
        $empresas->foneprincipal = preg_replace("/[^0-9]/", '', $input['foneprincipal']);
        $empresas->fonesecundario = preg_replace("/[^0-9]/", '', $input['fonesecundario']);
        $empresas->emailprincipal = $input['emailprincipal'];
        $empresas->emailsecundario = $input['emailsecundario'];
        $empresas->nomecontato = $input['nomecontato'];
        $empresas->celular = $input['celular'];
        //$empresas->ativo = $input['ativo'];
        $empresas->website = $input['website'];

        if ($image) {
            $empresas->caminhologo = $image->getClientOriginalName();
        }

        $empresas->save();

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

        return redirect('empresas');

    }


    /**
     * Remove the specified resource from storage.
     *
     * @param    int  $id
     * @return  \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $empresas = empresas::findOrfail($id);
        $empresas->delete();
        return redirect('empresas');
    }

    public function remove_image ($id)
    {

         $empresas = empresas::findOrfail($id);

         if(!\File::delete(public_path() . '/images/clients/' . $empresas->caminhologo))
         {

            \Session::flash('flash_message_erros', 'Erro ao remover imagem');
         }
         else
         {

            $empresas->caminhologo = '';
            $empresas->save();

            \Session::flash('flash_message', 'Imagem Removida com Sucesso!!!');

         }

         return redirect('empresas');

    }

}