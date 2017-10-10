<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Dispositivo extends Model
{
    protected $table = 'dispositivos';

    public function tipo_dispositivo()
    {
        return $this->belongsTo('App\Models\TipoDispositivo','tipo_dispositivo_id');
    }
}
