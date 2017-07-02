<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class membros_familiares extends Model
{

    public $timestamps = false;
    protected $table = "membros_familiares";
    protected $fillable = array('pessoas_id', 'empresas_id', 'empresas_clientes_cloud_id', 'conjuge_id', 'nome_conjuge', 'data_nasc', 'data_falecimento', 'data_casamento', 'status_id', 'profissoes_id', 'igreja_casamento', 'pai_id', 'mae_id', 'nome_pai', 'nome_mae' ,'status_pai_id' ,'status_mae_id' ,'data_falecimento_pai', 'data_falecimento_mae');

}