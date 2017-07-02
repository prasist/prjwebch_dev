<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class civis extends Model
{

    public $timestamps = false;
    protected $table = "estados_civis";

    public function clientes_cloud()
    {

        return $this->belongsTo('App\Models\clientes_cloud');

    }


}
