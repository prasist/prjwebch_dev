<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\usuario;
use URL;
use Input;
use Auth;


class MinhaIgreja extends Controller
{

  public function __construct()
  {

  }

     public function enviar_email(\Illuminate\Http\Request  $request)
    {

          $input = $request->except(array('_token')); //não levar o token

          $buscar = \App\Models\pessoas::select('razaosocial', 'empresas_id', 'empresas_clientes_cloud_id')
          ->where('emailprincipal', $input["email"])
          ->get();


          if ($buscar->count()>0)
          {

              $usuario = User::select('id')->where('email', $input["email"])
              ->where('password', bcrypt($input["password"]))
              ->get();


              if ($usuario->count()>0)
              {

                    return redirect()->guest('login');

              }
              else
              {
                    //criar usuario
                    //Gera token qualquer
                    $dados = str_random(30);
                    $data = $input;

                    $retorno = User::create([
                        'name' => $buscar[0]->razaosocial,
                        'email' => $input["email"],
                        'password' => bcrypt($input["password"]),
                        'confirmation_code' => $dados,
                    ]);

                    usuario::create([
                        'id' => $retorno->id,
                        'empresas_id' => $buscar[0]->razaosocial,
                        'empresas_clientes_cloud_id' => $input["email"]
                    ]);

                    \Mail::send('emails.link_newuser', ['key' => $dados], function($message) use ($data)
                    {
                        $message->from('contato@sigma3sistemas.com.br', 'Sigma3');
                        $message->subject('Link para validação SIGMA3 - Área do Membro');
                        $message->to($data['email']);
                        $message->bcc('contato@sigma3sistemas.com.br');
                    });

                    $conteudo = ['mensagem' => 'Verifique sua conta de email para validar o acesso ao sistema.'];
              }


          }
          else
          {

                 $credentials = array('email' => $input["email"], 'password' => $input["password"]);

                 if(Auth::attempt($credentials, true))
                 {
                      Auth::login(Auth::user(), true);

                      Auth::guard('web')->login($credentials);

                      //return redirect('login');
                      return \Redirect::intended('login');
                 }

          }


            //return view('tutoriais.minhaigreja', ['conteudo'=>$conteudo]);

     }

    //Exibir listagem
    public function index()
    {

        return view('tutoriais.minhaigreja', ['conteudo'=>'']);

    }

}