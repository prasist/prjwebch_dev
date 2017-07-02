<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class areas extends Model
{

    public $timestamps = false;
    protected $table = "areas_formacao";

    public function clientes_cloud()
    {

        return $this->belongsTo('App\Models\clientes_cloud');

    }


}
