<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class tipostelefones extends Model
{

    public $timestamps = false;
    protected $table = "tipos_telefones";

    public function clientes_cloud()
    {

        return $this->belongsTo('App\Models\clientes_cloud');

    }


}
