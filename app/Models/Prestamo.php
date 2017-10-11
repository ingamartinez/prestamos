<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Prestamo extends Model
{
    use SoftDeletes;

    protected $table = 'prestamos';
    protected $dates = ['deleted_at'];

    public function user()
    {
        return $this->belongsTo('App\Models\User','users_id');
    }


    public function tipo_prestamo()
    {
        return $this->belongsTo('App\Models\TipoPrestamo','tipo_prestamo_id');
    }

    public function dispositivos()
    {
        return $this->belongsToMany('App\Models\Dispositivo', 'dispositivos_prestados', 'prestamos_id', 'dispositivos_id')->withPivot('cantidad');
    }
}
