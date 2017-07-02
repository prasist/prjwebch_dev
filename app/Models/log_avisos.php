<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class log_avisos extends Model
{

    public $timestamps = false;
    protected $table = "log_avisos";
    protected $fillable = array('users_id', 'avisos_id', 'data_leitura');

}
