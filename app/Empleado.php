<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Empleado extends Model
{
    protected $fillable = [
        'rfc',
        'nombre',
        'apellidos',
        'telefono',
        'direccion',
        'horario_id',
        'categoria_id'
    ];

    public function categoria()
    {
        return $this->belongsTo('App\Categoria');
    }

    public function horarios()
    {
        return $this->hasMany('App\HorarioEmpleado');
    }
}
