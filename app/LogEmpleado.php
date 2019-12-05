<?php

namespace App;

use Carbon\Carbon;
use DateTime;
use Illuminate\Database\Eloquent\Model;

class LogEmpleado extends Model
{
    protected $table = 'logs_empleados';
    protected $fillable = ['empleado_id', 'fecha', 'entrada', 'salida'];

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
        $fecha = new Carbon($this->fecha);
        return
        // $fecha->day
        $fecha->format('d/m/Y')
        . ' ( DE ' . $this->entrada . ' a ' . $this->salida . ')';
    }
}
