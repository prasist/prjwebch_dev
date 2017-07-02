<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class idiomas extends Model
{

    public $timestamps = false;
    protected $table = "idiomas";

    public function clientes_cloud()
    {

        return $this->belongsTo('App\Models\clientes_cloud');

    }


}
