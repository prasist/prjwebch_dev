<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class grupos extends Model
{
    //
    public $timestamps = false;
    protected $fillable = array('nome','empresas_id','empresas_clientes_cloud_id','default');

}
