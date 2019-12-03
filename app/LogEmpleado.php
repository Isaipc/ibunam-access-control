<?php

namespace App;

use Carbon\Carbon;
use DateTime;
use Illuminate\Database\Eloquent\Model;

class LogEmpleado extends Model
{
    protected $table = 'logs_empleados';

    public function empleado()
    {
        return $this->belongsTo('App\Empleado');
    }

    public function totalHrs()
    {
        $entrada = new Carbon($this->entrada);
        $salida = new Carbon($this->salida);
        return ($entrada)->diff($salida)->format('%h:%I');
    }

    public function registro()
    {
        $d_entrada = date_create($this->entrada);
        $d_salida = date_create($this->salida);

        $dia = date_format($d_entrada, 'd');
        $entrada = date_format($d_entrada, 'H:i');
        $salida = date_format($d_salida, 'H:i');
        return $dia . ' ( DE ' . $entrada . ' a ' . $salida . ')';
    }
}
