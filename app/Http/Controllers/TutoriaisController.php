<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use URL;
use Auth;
use Input;
use Gate;

class TutoriaisController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
        $this->dados_login = \Session::get('dados_login');
    }


    /**
     * Abre tela para informação de conclusão do TOUR
     * @param type $id  - Número do Tour Rápido     *
     */
    public function index($id)
    {
        return view('tutoriais.conclusao', ['id'=> $id]);     //ok, direciona para dashboard
    }


    /**//**
     * Description - Grava como concluido o Tour na tabela do usuário
     * @param type $id - Numero do tour (1 = Cadastro Usuario, 2 = Visão Geral)
     *
     */
    public function  concluir($id)
    {

         //------------------Atualizar tabela USUARIOS com termino do TOUR RAPIDO
        $where = ['empresas_id' => $this->dados_login->empresas_id, 'empresas_clientes_cloud_id' => $this->dados_login->empresas_clientes_cloud_id, 'id' => $this->dados_login->id];

        if ($id==1)
        {
            \Session::put('tour_rapido', 'S'); //Atualiza session
            $update = \DB::table('usuarios')->where($where)->update(array('tutorial'    => 'S'));
        }
        else if ($id==2)
        {
            \Session::put('tour_visaogeral', 'S'); //Atualiza session
            $update = \DB::table('usuarios')->where($where)->update(array('tutorial_visaogeral'    => 'S'));
        }

        return redirect('home');

    }

    /**//**
     * Description - Reinicia o Tour rápido limpando a variavel de sessao e gravando na tabela usuarios como nao assistido
     * @param type $id - Numero do tour (1 = Cadastro Usuario, 2 = Visão Geral)
     *
     */
    public function  iniciar($id)
    {

        //------------------Atualizar tabela USUARIOS com termino do TOUR RAPIDO
        $where = ['empresas_id' => $this->dados_login->empresas_id, 'empresas_clientes_cloud_id' => $this->dados_login->empresas_clientes_cloud_id, 'id' => $this->dados_login->id];

       if ($id==1)
       {
            \Session::put('tour_rapido', 'N'); //Atualiza session
            $update = \DB::table('usuarios')->where($where)->update(array('tutorial'    => 'N'));
       }
       else  if ($id==2)
       {
            \Session::put('tour_visaogeral', 'N'); //Atualiza session
            $update = \DB::table('usuarios')->where($where)->update(array('tutorial_visaogeral'    => 'N'));
       }

        return redirect('home');

    }

    public function  tutorial ($id)
    {

            if ($id==1)
            {
                    return view('tutoriais.users');
            }
            else if ($id==2)
            {
                    return view('tutoriais.users_admin');
            }
            else if ($id==3)
            {
                    return view('tutoriais.tutorial_login');
            }
            else if ($id==4)
            {
                    return view('tutoriais.celulas');
            }
            else if ($id==5)
            {
                    return view('tutoriais.encontros');
            }

    }


}