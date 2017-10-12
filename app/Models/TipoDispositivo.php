<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TipoDispositivo extends Model
{

    use SoftDeletes;

    protected $table = 'tipo_dispositivo';

    public function dispositivos()
    {
        return $this->hasMany('App\Models\Dispositivo','tipo_dispositivo_id');
    }

}
