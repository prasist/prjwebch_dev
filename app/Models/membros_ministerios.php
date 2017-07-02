<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class membros_ministerios extends Model
{

    public $timestamps = false;
    protected $table = "membros_ministerios";
    protected $fillable = array('pessoas_id', 'empresas_id', 'empresas_clientes_cloud_id', 'ministerios_id');

}
