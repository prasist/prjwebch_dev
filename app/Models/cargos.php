<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class cargos extends Model
{

    public $timestamps = false;
    protected $table = "cargos";

    public function clientes_cloud()
    {

        return $this->belongsTo('App\Models\clientes_cloud');

    }


}
