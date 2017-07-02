<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class membros_hist_eclesiasticos extends Model
{

    public $timestamps = false;
    protected $table = "membros_historicos";
    protected $fillable = array('pessoas_id', 'empresas_id', 'empresas_clientes_cloud_id', 'igreja_anterior', 'fone_igreja_anterior', 'religioes_id', 'cep_igreja_anterior', 'endereco_igreja_anterior', 'numero_igreja_anterior', 'bairro_igreja_anterior', 'complemento_igreja_anterior', 'cidade_igreja_anterior', 'estado_igreja_anterior', 'data_batismo', 'igreja_batismo', 'celebrador', 'data_entrada' ,'data_saida' , 'ata_entrada','ata_saida' , 'motivos_saida_id', 'motivos_entrada_id', 'observacoes_hist');

}
