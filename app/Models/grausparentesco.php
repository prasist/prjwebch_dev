<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class grausparentesco extends Model
{

    public $timestamps = false;
    protected $table = "parentescos";

    public function clientes_cloud()
    {

        return $this->belongsTo('App\Models\clientes_cloud');

    }


}
