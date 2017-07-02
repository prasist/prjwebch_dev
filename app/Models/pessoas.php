<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class pessoas extends Model
{

    public $timestamps = false;
    protected $table = "pessoas";

    public function clientes_cloud()
    {
        return $this->belongsTo('App\Models\clientes_cloud');
    }

    /*Cria where condicional*/
    /*Se houver dados para consultar cria a clausula where*/
    public function scopeStatus($query, $status)
    {

        if ($status)
        {

            if ($status=="A")  //Ambos
            {
                return $query->where('ativo', '<>', $status);
            }

           return $query->where('ativo', '=', $status);

        }

        return $query;
    }


    public function scopePessoa($query, $pessoa)
    {

        if ($pessoa)
        {
           return $query->where('tipopessoa', '=', $pessoa);
        }

        return $query;
    }

public function scopeRazaosocial($query, $nome)
    {

        /*Instancia a classe de funcoes (Data, valor, etc)*/
        $this->formatador = new  \App\Functions\FuncoesGerais();

        /*busca por razaosocial, nomefantasia ou cnpj/cpf*/
        if ($nome)
        {
           return $query
           ->where('razaosocial', 'ilike', '%' . $this->formatador->tirarAcentos($nome) . '%')
           ->orWhere('razaosocial', 'ilike', '%' . $nome . '%')
           ->orWhere('nomefantasia', 'ilike', '%' . $this->formatador->tirarAcentos($nome) . '%')
           ->orWhere('nomefantasia', 'ilike', '%' . $nome . '%')
           ->orWhere('cnpj_cpf', '=', $this->formatador->tirarAcentos($nome));
        }

        return $query;
    }


public function scopePorletra($query, $letra)
    {

        if ($letra)
        {
           return $query->where('razaosocial', 'ilike', $letra . '%');
        }

        return $query;
    }


    public function scopeGrupo($query, $grupo)
    {

        if ($grupo)
        {
           return $query->where('grupos_pessoas_id', '=', $grupo);
        }

        return $query;
    }


    public function scopeTipopessoa($query, $tipopessoa)
    {

        if ($tipopessoa)
        {
           return $query->where('tipos_pessoas_id', '=', $tipopessoa);
        }

        return $query;
    }

    public function scopeDatanasc($query, $datanasc)
    {

        if ($datanasc)
        {
           return $query->where('datanasc', '>=', $datanasc);
        }

        return $query;
    }


    public function scopeDatanascfim($query, $datanasc_ate)
    {

        if ($datanasc_ate)
        {
           return $query->where('datanasc', '<=', $datanasc_ate);
        }

        return $query;
    }


    public function scopeMes($query, $mes)
    {

        if ($mes)
        {
           return $query->whereMonth('datanasc', '=', $mes);
        }

        return $query;
    }

}