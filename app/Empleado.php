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

    public function logs()
    {
        return $this->hasMany('App\LogEmpleado');
    }

    public function totalHrs()
    {
        return $this->horarios()->totalHrs()->sum();
    }
}
