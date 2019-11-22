<?php

namespace App\Http\Controllers;

use App\Empleado;
use App\HorarioEmpleado;
use Illuminate\Http\Request;

class HorarioEmpleadoController extends Controller
{

    public $dias_semana = array(
        'Lunes',
        'Martes',
        'Miercoles',
        'Jueves',
        'Viernes',
        'Sabado',
        'Domingo'
    );

    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $empleados = Empleado::orderBy('nombre', 'ASC')->get();
        return view('horarios.index', ['empleados' => $empleados, 'dias_semana' => $this->dias_semana]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->create_horario($request->entradaLunes, $request->salidaLunes, 0, $request->empleado);
        $this->create_horario($request->entradaMartes, $request->salidaMartes, 1, $request->empleado);
        $this->create_horario($request->entradaMiercoles, $request->salidaMiercoles, 2, $request->empleado);
        $this->create_horario($request->entradaJueves, $request->salidaJueves, 3, $request->empleado);
        $this->create_horario($request->entradaViernes, $request->salidaViernes, 4, $request->empleado);
        $this->create_horario($request->entradaSabado, $request->salidaSabado, 5, $request->empleado);
        $this->create_horario($request->entradaDomingo, $request->salidaDomingo, 6, $request->empleado);
    }

    private function create_horario($entrada, $salida, $dia, $empleado)
    {
        if ($entrada != null && $salida != null) {
            $horario = new HorarioEmpleado;
            $horario->entrada = $entrada;
            $horario->salida = $salida;
            $horario->dia = $dia;
            $horario->empleado_id = $empleado;

            if ($empleado->save())
                return redirect('/horarios')->with('success', 'Horarios guardados correctamente');
            else
                return $horario;
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\HorarioEmpleado  $horarioEmpleado
     * @return \Illuminate\Http\Response
     */
    public function show(HorarioEmpleado $horarioEmpleado)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\HorarioEmpleado  $horarioEmpleado
     * @return \Illuminate\Http\Response
     */
    public function edit(HorarioEmpleado $horarioEmpleado)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\HorarioEmpleado  $horarioEmpleado
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, HorarioEmpleado $horarioEmpleado)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\HorarioEmpleado  $horarioEmpleado
     * @return \Illuminate\Http\Response
     */
    public function destroy(HorarioEmpleado $horarioEmpleado)
    {
        //
    }
}
