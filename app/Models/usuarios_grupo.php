<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class usuarios_grupo extends Model
{

    protected $table = "usuarios_grupo";
    public $timestamps = false;
    protected $fillable = array('usuarios_id', 'usuarios_empresas_id', 'usuarios_empresas_clientes_cloud_id', 'grupos_id');

    /*  Exemplo da query
    *   $dados = usuarios_grupo::find(1)->grupos;
    */
  /*  public function grupos() {

        return $this->hasOne('App\Models\grupos', 'id');

    }

    public function permissoes_grupo () {

        return $this->hasMany('App\Models\permissoes_grupo', 'grupos_id');

    }*/

}