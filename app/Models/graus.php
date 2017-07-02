<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class graus extends Model
{

    public $timestamps = false;
    protected $table = "graus_instrucao";

    public function clientes_cloud()
    {

        return $this->belongsTo('App\Models\clientes_cloud');

    }


}
