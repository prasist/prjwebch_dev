<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class rateio_titulos extends Model
{

    public $timestamps = false;
    protected $table = "rateio_titulo";
    protected $fillable = array('empresas_id', 'empresas_clientes_cloud_id', 'titulos_id', 'planos_contas_id', 'centros_custos_id', 'valor', 'percentual');

}
