<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ramos extends Model
{

    public $timestamps = false;
    protected $table = "ramos_atividades";

    public function clientes_cloud()
    {

        return $this->belongsTo('App\Models\clientes_cloud');

    }


}
