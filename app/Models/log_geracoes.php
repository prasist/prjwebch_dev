<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class log_geracoes extends Model
{

    public $timestamps = false;
    protected $table = "log_geracoes";
    protected $fillable = array('empresas_id', 'empresas_clientes_cloud_id', 'celulas_id', 'lider_pessoas_id', 'lider_pessoas_id_pai', 'data_inicio', 'qtd_filhas', 'qtd_geracao ', 'alterado_lider');

}