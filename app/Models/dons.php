<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class dons extends Model
{

    public $timestamps = false;
    protected $table = "dons";

    public function clientes_cloud()
    {

        return $this->belongsTo('App\Models\clientes_cloud');

    }

}
