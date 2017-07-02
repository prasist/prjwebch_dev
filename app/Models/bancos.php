<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class bancos extends Model
{
    //testes
    public $timestamps = false;
    protected $table = "bancos";

    public function clientes_cloud()
    {

        return $this->belongsTo('App\Models\clientes_cloud');

    }

}