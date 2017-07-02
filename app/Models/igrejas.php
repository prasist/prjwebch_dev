<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class igrejas extends Model
{

    public $timestamps = false;

    public function clientes_cloud()
    {

        return $this->belongsTo('App\Models\clientes_cloud');

    }


}
