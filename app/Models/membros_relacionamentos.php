<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class membros_relacionamentos extends Model
{

    public $timestamps = false;
    protected $table = "membros_relacionamentos";
    protected $fillable = array('pessoas_id', 'pessoas2_id', 'empresas_id', 'empresas_clientes_cloud_id', 'tipos_relacionamentos_id');

}
