<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Dispositivo extends Model
{
    protected $table = 'dispositivo';

    public function dispositivos()
    {
        return $this->hasOne('App\Models\TipoPrestamo','tipo_dispositivo_id');
    }
}
