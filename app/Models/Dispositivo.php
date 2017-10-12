<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Dispositivo extends Model
{
    use SoftDeletes;

    protected $table = 'dispositivos';

    public function tipo_dispositivo()
    {
        return $this->belongsTo('App\Models\TipoDispositivo','tipo_dispositivo_id');
    }
}
