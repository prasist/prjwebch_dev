<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class controle_presencas extends Model
{

    public $timestamps = false;
    protected $table = "controle_presencas";
    protected $fillable = array('pessoas_id', 'controle_atividades_id', 'presenca_simples', 'observacao', 'check_in' , 'hora_check_in', 'tipos_presencas_id',  'empresas_clientes_cloud_id', 'empresas_id');

}
