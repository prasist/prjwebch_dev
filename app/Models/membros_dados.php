<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class membros_dados extends Model
{
    public $timestamps = false;
    protected $table = "membros_dados_pessoais";
    protected $fillable = array('pessoas_id', 'empresas_id', 'empresas_clientes_cloud_id', 'status_id', 'sexo', 'doador_sangue', 'doador_orgaos', 'naturalidade', 'uf_naturalidade', 'nacionalidade', 'grupo_sanguinio', 'possui_necessidades_especiais', 'descricao_necessidade_especial', 'idiomas_id', 'igrejas_id', 'link_facebook', 'link_google', 'link_instagram', 'link_linkedin', 'link_outros', 'familias_id', 'graus_id', 'estadoscivis_id', 'disponibilidades_id', 'prefere_trabalhar_com', 'considera_se');
}
