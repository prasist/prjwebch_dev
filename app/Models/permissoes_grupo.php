<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class permissoes_grupo extends Model
{
    //
    public $timestamps = false;
    protected $fillable = array('grupos_id', 'paginas_id', 'incluir', 'alterar', 'excluir', 'visualizar', 'exportar', 'imprimir', 'acessar');

}
