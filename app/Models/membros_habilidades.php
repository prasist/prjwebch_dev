<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class membros_habilidades extends Model
{

    public $timestamps = false;
    protected $table = "membros_habilidades";
    protected $fillable = array('pessoas_id', 'empresas_id', 'empresas_clientes_cloud_id', 'habilidades_id');

}
