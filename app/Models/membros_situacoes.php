<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class membros_situacoes extends Model
{

    public $timestamps = false;
    protected $table = "membros_situacoes";
    protected $fillable = array('pessoas_id', 'empresas_id', 'empresas_clientes_cloud_id', 'situacoes_id');

}
