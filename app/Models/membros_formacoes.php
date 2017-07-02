<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class membros_formacoes extends Model
{

    public $timestamps = false;
    protected $table = "membros_formacoes";
    protected $fillable = array('pessoas_id', 'empresas_id', 'empresas_clientes_cloud_id', 'formacoes_id');

}
