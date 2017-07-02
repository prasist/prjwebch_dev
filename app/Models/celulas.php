<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class celulas extends Model
{

    public $timestamps = false;
    protected $table = "celulas";
    protected $fillable = array('empresas_id', 'empresas_clientes_cloud_id', 'nome', 'dia_encontro', 'turno', 'regiao', 'segundo_dia_encontro', 'lider_pessoas_id ', 'vicelider_pessoas_id', 'suplente1_pessoas_id', 'suplente2_pessoas_id', 'obs', 'celulas_nivel5_id', 'celulas_nivel4_id', 'celulas_nivel3_id', 'celulas_nivel2_id', 'celulas_nivel1_id', 'email_grupo', 'escaninho', 'celeiro', 'publico_alvo', 'faixa_etaria', 'horario', 'horario2', 'qual_endereco', 'celulas_pai_id', 'origem', 'data_inicio', 'data_multiplicacao', 'data_previsao_multiplicacao', 'cor', 'celulas_id_geracao');

}