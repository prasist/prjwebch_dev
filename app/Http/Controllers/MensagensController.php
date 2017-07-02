<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use URL;
use Auth;
use Input;
use Gate;

class MensagensController extends Controller
{

    public function __construct()
    {

        $this->rota = "mensagens"; //Define nome da rota que será usada na classe
        $this->middleware('auth');

        //Validação de permissão de acesso a pagina
        if (Gate::allows('verifica_permissao', [\Config::get('app.' . $this->rota),'acessar']))
        {
            $this->dados_login = \Session::get('dados_login');
            //Busca configuracao do provedor SMS
            $where = ['empresas_clientes_cloud_id' => $this->dados_login->empresas_clientes_cloud_id, 'empresas_id' =>  $this->dados_login->empresas_id];
            $this->parametros = \App\Models\parametros::where($where)->get();
        }

    }

    //Criar novo registro
    public function create()
    {

        if (\App\ValidacoesAcesso::PodeAcessarPagina(\Config::get('app.' . $this->rota))==false)
        {
              return redirect('home');
        }


        //SE nao encontrar configuracao
        if ($this->parametros->count()<=0)
        {
            \Session::flash('flash_message_erro', 'Não foi configurado o serviço de envio. Acesse o menu Configurações / Config SMS/Whatsapp');
            return redirect('home');
        }

        return view($this->rota . '.registrar', ['parametros'=>$this->parametros]);

    }


/*
* Grava dados no banco
*
*/
    public function enviar(\Illuminate\Http\Request  $request)
    {


          if ($this->parametros->count()<=0)
          {
              \Session::flash('flash_message_erro', 'Não foi configurado o serviço de envio. Acesse o menu Configurações / Config SMS/Whatsapp');
              return redirect('home');
          }

          $input = $request->except(array('_token', 'ativo')); //não levar o token

          $get_telefones = explode(";", $input["telefone"]); //pega input com telefones
          $get_telefones = str_replace("(", "", str_replace(")", "", str_replace("-", "", str_replace(".", "", str_replace(" ", "", $get_telefones))))); //substitui caracteres e espaco em branco
          $corrige_fones="";
          $listagem="";

          //percorre lista de email e confere se tem DDD
          foreach ($get_telefones as $key => $value) {


              if ($this->parametros[0]->ddd != substr($value,0,2)) //NAO TEM DDD Cnforme localidade do cliente
              {
                  $corrige_fones =  rtrim(ltrim($this->parametros[0]->ddd)) . rtrim(ltrim($value)); //incluir ddd
              } else
              {
                  $corrige_fones =  rtrim(ltrim($value)); //tem ddd
              }

              //Monta listagem corrigida
              if ($listagem!="")
              {
                    $listagem = $listagem . ';' . $corrige_fones;
              } else
              {
                    $listagem = $corrige_fones;
              }

          }


          $urlMensagem = "http://54.233.99.254/plataforma/api5.php?usuario=" .  $this->parametros[0]->login_provedor_mensagens .  "&senha=" . $this->parametros[0]->senha_provedor_mensagens . "&destinatario=" . $listagem . "&msg=" . urlencode($input["mensagem"]) .  "&tipo=" . $input["tipo_envio"];
          //$urlMensagem  = "http://www.iagentesms.com.br/webservices/smslote.php?usuario=fabiano@prasist.com.br&senha=e74b50&mensagem=" .  urlencode($input["mensagem"])  . "&celulares=" . $input["telefone"] . "";

          $api_http = file_get_contents($urlMensagem);

          if (rtrim(ltrim($api_http))=="000 - Mensagem Enviada") {
                \Session::flash('flash_message', $api_http);
          } else {
                \Session::flash('flash_message_erro', 'Não foi possível enviar a mensagem : ' . $api_http);
          }


          return redirect($this->rota);

    }


}