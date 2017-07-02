<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class empresas extends Model
{
    //
    public $timestamps = false;


 // /*  /*Cria o relacionamento da tabela clientes_cloud e empresas*/
 //    public function clientescloud ()
 //    {

 //        //Primeiro parâmetro indica a tabela e segundo parametro o nome da foreignKey
 //        return $this->hasOne('App\Models\clientescloud','clientes_cloud_id');

 //    }*/

}
