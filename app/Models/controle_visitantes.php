<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class controle_visitantes extends Model
{

    public $timestamps = false;
    protected $table = "controle_visitantes";
    protected $fillable = array('nome', 'fone', 'email', 'pessoas_id',  'controle_atividades_id',  'empresas_clientes_cloud_id', 'empresas_id');

}
