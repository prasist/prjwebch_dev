<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class log_users extends Model
{

    public $timestamps = false;
    protected $table = "log_users";
    protected $fillable = array('users_id', 'empresas_id', 'empresas_clientes_cloud_id', 'data_acesso', 'token', 'ip', 'data_aviso');

}
