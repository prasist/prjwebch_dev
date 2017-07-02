<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class membros_dons extends Model
{

    public $timestamps = false;
    protected $table = "membros_dons";
    protected $fillable = array('pessoas_id', 'empresas_id', 'empresas_clientes_cloud_id', 'dons_id');

}
