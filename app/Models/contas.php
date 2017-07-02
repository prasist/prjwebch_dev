<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class contas extends Model
{

    public $timestamps = false;
    protected $table = "contas";

    public function clientes_cloud()
    {

        return $this->belongsTo('App\Models\clientes_cloud');

    }


}
