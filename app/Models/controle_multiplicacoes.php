<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class controle_multiplicacoes extends Model
{

    public $timestamps = false;
    protected $table = "controle_multiplicacoes";
    protected $fillable = array('empresas_id', 'empresas_clientes_cloud_id', 'pessoas_id', 'pessoas_id_origem', 'pessoas_id_pai', 'data_inicio', 'qtd_filhas', 'qtd_geracao ');

}