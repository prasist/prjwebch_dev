<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class controle_materiais extends Model
{

    public $timestamps = false;
    protected $table = "controle_materiais";
    protected $fillable = array('arquivo', 'controle_atividades_id', 'empresas_clientes_cloud_id', 'empresas_id');

}
