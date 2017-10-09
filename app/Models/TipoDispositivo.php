<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TipoDispositivo extends Model
{
    protected $table = 'tipo_dispositivo';

    public function dispositivos()
    {
        return $this->hasMany('App\Models\Dispositivo','tipo_dispositivo_id');
    }

}
