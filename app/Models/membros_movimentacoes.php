<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class membros_movimentacoes extends Model
{

    public $timestamps = false;
    protected $table = "membros_movimentacoes";
    protected $fillable = array('data_movimentacao', 'pessoas_id', 'empresas_id', 'empresas_clientes_cloud_id', 'motivos_id', 'observacao', 'celulas_id_atual', 'celulas_id_nova');

}