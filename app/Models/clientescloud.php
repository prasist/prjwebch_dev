<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class clientescloud extends Model
{
    //
    protected $table = "clientes_cloud";
    public $timestamps = false;


    // /*Cria o relacionamento da tabela clientes_cloud e empresas*/
    // public function empresas ()
    // {

    //     //Primeiro parâmetro indica a tabela e segundo parametro o nome da foreignKey
    //     return $this->hasMany('App\Models\empresas', 'clientes_cloud_id');

    // }

}
