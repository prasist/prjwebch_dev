<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class faixas extends Model
{

    public $timestamps = false;
    protected $table = "faixas_etarias";

    public function clientes_cloud()
    {

        return $this->belongsTo('App\Models\clientes_cloud');

    }


}
