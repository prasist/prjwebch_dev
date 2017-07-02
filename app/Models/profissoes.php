<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class profissoes extends Model
{

    public $timestamps = false;
    protected $table = "profissoes";

    public function clientes_cloud()
    {

        return $this->belongsTo('App\Models\clientes_cloud');

    }


}
