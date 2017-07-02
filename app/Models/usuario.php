<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class usuario extends Model
{
    //
    protected $table = "usuarios";
    public $timestamps = false;
    protected $fillable = array('id', 'empresas_id', 'empresas_clientes_cloud_id', 'master', 'admin', 'membro');

    public function usuarios_grupo() {

         return $this->hasMany('App\Models\usuarios_grupo');
    }

}
