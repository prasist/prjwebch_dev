<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class celulaspessoas extends Model
{

    public $timestamps = false;
    protected $table = "celulas_pessoas";
    protected $fillable = array('empresas_id', 'empresas_clientes_cloud_id', 'celulas_id', 'pessoas_id', 'lider_pessoas_id', 'data_entrada_celula');

}
