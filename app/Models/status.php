<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class status extends Model
{

    public $timestamps = false;
    protected $table = "status";

    public function clientes_cloud()
    {

        return $this->belongsTo('App\Models\clientes_cloud');

    }


}
