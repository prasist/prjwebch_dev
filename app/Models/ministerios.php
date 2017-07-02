<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ministerios extends Model
{

    public $timestamps = false;
    protected $table = "ministerios";

    public function clientes_cloud()
    {

        return $this->belongsTo('App\Models\clientes_cloud');

    }


}
