<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class centros_custos extends Model
{

    public $timestamps = false;
    protected $table = "centros_custos";

    public function clientes_cloud()
    {

        return $this->belongsTo('App\Models\clientes_cloud');

    }


}
