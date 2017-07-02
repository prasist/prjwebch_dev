<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class membros_cursos extends Model
{

    public $timestamps = false;
    protected $table = "membros_cursos";
    protected $fillable = array('pessoas_id', 'empresas_id', 'empresas_clientes_cloud_id', 'cursos_id', 'data_inicio', 'data_fim', 'ministrante_id', 'observacao');

}
