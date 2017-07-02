<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class users extends Model
{
    //

    public $timestamps = false;
    protected $fillable = array('name', 'email', 'password', 'confirmed', 'membro');

    public function usuarios() {

         return $this->hasOne('App\Models\usuarios');

    }

}
