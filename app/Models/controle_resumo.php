<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class controle_resumo extends Model
{

    public $timestamps = false;
    protected $table = "controle_resumo";
    protected $fillable = array('controle_atividades_id', 'empresas_clientes_cloud_id', 'empresas_id', 'total_membros', 'total_visitantes', 'total_geral');

}
