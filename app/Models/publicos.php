<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class publicos extends Model
{

    public $timestamps = false;
    protected $table = "publicos_alvos";

    public function clientes_cloud()
    {
        return $this->belongsTo('App\Models\clientes_cloud');
    }

}
