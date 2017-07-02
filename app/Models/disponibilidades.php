<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class disponibilidades extends Model
{

    public $timestamps = false;
    protected $table = "disponibilidades";

    public function clientes_cloud()
    {

        return $this->belongsTo('App\Models\clientes_cloud');

    }


}
