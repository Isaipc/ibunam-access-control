<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HorarioEmpleado extends Model
{
    protected $fillable = [
        'empleado_id',
        'entrada',
        'salida'
    ];

    public function empleado()
    {
        return $this->belongsTo('App\Empleado');
    }
}
