<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class membros_filhos extends Model
{

    public $timestamps = false;
    protected $table = "membros_filhos";
    protected $fillable = array('pessoas_id', 'empresas_id', 'empresas_clientes_cloud_id', 'filhos_id', 'nome_filho', 'sexo', 'data_nasc', 'data_falecimento', 'status_id', 'estadocivil_id');

}