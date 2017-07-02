<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class tipospessoas extends Model
{

    public $timestamps = false;
    protected $table = "tipos_pessoas";

    public function clientes_cloud()
    {

        return $this->belongsTo('App\Models\clientes_cloud');

    }

}
