<?php

namespace App\Http\Controllers;

use App\LogEmpleado;
use App\Empleado;
use DateTime;
use Illuminate\Http\Request;

class LogEmpleadoController extends Controller
{

    public function index()
    {
        return view('logs.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $empleados = Empleado::orderBy('nombre', 'ASC')->get();
        return view('logs.create', ['empleados' => $empleados]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // $date_e = date_create_from_format('d/m/Y:H:i:s', $request->entrada);
        // $date_s = date_create_from_format('d/m/Y:H:i:s', $request->salida);

        $date_e = new DateTime($request->entrada);
        $date_s = new DateTime($request->salida);
        $log = new LogEmpleado;
        $log->empleado_id = $request->empleado;
        // $log->entrada = $date_e->getTimestamp();
        $log->entrada = $date_e;
        $log->salida = $date_s;
        // $log->salida = $date_s->getTimestamp();
        $log->save();
        return redirect('/logs/create')->with('success', 'Registro hecho correctamente.');;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\LogEmpleado  $logEmpleado
     * @return \Illuminate\Http\Response
     */
    public function show(LogEmpleado $logEmpleado)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\LogEmpleado  $logEmpleado
     * @return \Illuminate\Http\Response
     */
    public function edit(LogEmpleado $logEmpleado)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\LogEmpleado  $logEmpleado
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, LogEmpleado $logEmpleado)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\LogEmpleado  $logEmpleado
     * @return \Illuminate\Http\Response
     */
    public function destroy(LogEmpleado $logEmpleado)
    {
        //
    }
}
