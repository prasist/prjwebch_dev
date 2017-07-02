<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class controle_questions extends Model
{

    public $timestamps = false;
    protected $table = "controle_questions";
    protected $fillable = array('questionarios_id', 'controle_atividades_id', 'resposta', 'empresas_clientes_cloud_id', 'empresas_id');

}
