<?php

namespace App;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use DB;
use Gate;

class ValidacoesAcesso extends Controller
{

    /**//**
     * Verificar se usuário logado tem permissão para a página
     * @return true ou false
     * @param $pagina
     */
     public static function PodeAcessarPagina ($pagina) {

        if (Gate::denies('verifica_permissao', [$pagina,'acessar']))
        {
            \Session::flash('flash_message_erro', 'Sem permissão de acesso a página. Favor contactar o admin.');
            return false;
        }
        else
        {
            return true;
        }

    }

}