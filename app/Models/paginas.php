<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class paginas extends Model
{
    //
    public function permissoes_grupo() {

        return $this->belongTo('\App\Models\permissoes_grupo');

    }
}
