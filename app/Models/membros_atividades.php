<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class membros_atividades extends Model
{

    public $timestamps = false;
    protected $table = "membros_atividades";
    protected $fillable = array('pessoas_id', 'empresas_id', 'empresas_clientes_cloud_id', 'atividades_id');

}
