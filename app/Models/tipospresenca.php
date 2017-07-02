<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class tipospresenca extends Model
{

    public $timestamps = false;
    protected $table = "tipos_presenca";

    public function clientes_cloud()
    {

        return $this->belongsTo('App\Models\clientes_cloud');

    }


}
