<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class membros_profissionais extends Model
{

    public $timestamps = false;
    protected $table = "membros_profissionais";
    protected $fillable = array('pessoas_id', 'empresas_id', 'empresas_clientes_cloud_id', 'nome_empresa', 'endereco', 'numero', 'bairro',  'cep', 'complemento', 'cidade', 'estado', 'cargos_id', 'ramos_id', 'profissoes_id', 'emailprofissional');

}
