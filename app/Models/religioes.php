<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class religioes extends Model
{

    public $timestamps = false;
    protected $table = "religioes";

    public function clientes_cloud()
    {

        return $this->belongsTo('App\Models\clientes_cloud');

    }


}
