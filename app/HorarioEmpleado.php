<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HorarioEmpleado extends Model
{
    protected $table = 'horarios_empleados';
    protected $fillable = [
        'empleado_id',
        'dia',
        'entrada',
        'salida'
    ];

    public function empleado()
    {
        return $this->belongsTo('App\Empleado');
    }
}
