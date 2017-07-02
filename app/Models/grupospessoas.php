<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class grupospessoas extends Model
{

    public $timestamps = false;
    protected $table = "grupos_pessoas";

    public function clientes_cloud()
    {

        return $this->belongsTo('App\Models\clientes_cloud');

    }


}
