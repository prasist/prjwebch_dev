<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class membros_idiomas extends Model
{

    public $timestamps = false;
    protected $table = "membros_idiomas";
    protected $fillable = array('pessoas_id', 'empresas_id', 'empresas_clientes_cloud_id', 'idiomas_id');

}
