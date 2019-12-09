<?php

namespace App\Http\Controllers;

use App\LogEmpleado;
use App\Empleado;
use Illuminate\Support\Facades\DB;
use DateTime;
// use Barryvdh\DomPDF\Facade as PDF
use PDF;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Date;

class LogEmpleadoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $empleados = Empleado::orderBy('nombre', 'ASC')->get();
        return view('logs.index', ['empleados' => $empleados]);
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
        $fecha =  Carbon::createFromFormat('d/m/Y', $request->fecha);

        // dd($fecha->toDateString());
        LogEmpleado::updateOrCreate(
            ['empleado_id' => $request->empleado,'fecha' => $fecha->toDateString()],
            ['entrada' => $request->entrada, 'salida' => $request->salida]
        );
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

    public function esHoraExtra(Request $request){
        $empleado = Empleado::find($request->empleado_id);
        $horarios = $empleado->horarios->whereIn('dia', );

        dd($horarios);

        // response()->json(['success' => true, 'esHoraExtra' => true]);
        return response()->json(['success' => true, 'empleado' => $empleado]);
    }


    public function generarPDF(Request $request)
    {
        $domingo = 1;
        $daterange = explode('-', str_replace(' ', '', $request->daterange));
        $entrada = Carbon::createFromFormat('d/m/Y', $daterange[0]);
        $salida = Carbon::createFromFormat('d/m/Y', $daterange[1]);
        $radio = $request->radio;

        dd(date('W'));


        // dd($request);


        if($radio == 'extras'){
            // $logs = LogEmpleado::select('')
            $logs = LogEmpleado::
            // ::table('logs_empleados')
            select('logs_empleados.*')
            ->join('empleados','logs_empleados.empleado_id', '=', 'empleados.id')
            ->join('horarios_empleados','logs_empleados.empleado_id', '=', 'horarios_empleados.empleado_id')
            ->whereIn('logs_empleados.empleado_id', $request->empleados)
            ->whereBetween('logs_empleados.fecha', [$entrada->toDateString(), $salida->toDateString()] )
            // ->whereRaw('DAYOFWEEK(fecha) != ?', $domingo)
            ->where('logs_empleados.entrada', '<', 'horarios_empleados.entrada')
            ->orWhere('logs_empleados.salida', '>', 'horarios_empleados.salida')
            ->distinct()
            ->get();
            // $total_empleados;
            $count = $logs->count();
            $view = 'logs.extras';

        }else if($radio == 'domingos'){
            $logs = LogEmpleado::whereIn('empleado_id', $request->empleados)
            ->whereBetween('fecha', [$entrada->toDateString(), $salida->toDateString()] )
            ->whereRaw('DAYOFWEEK(fecha) = ?', $domingo)
            ->get();
            $count = $logs->count();
            $view = 'logs.domingo';
        }

        $t_hrs = 0;
        $t_min = 0;
        foreach ($logs as $key => $l) {
            $hrs = explode(':', str_replace(' ', '', $l->totalHrs()));
            $t_hrs = $t_hrs + (int)$hrs[0];
            $t_min = $t_min + (int)$hrs[1];
        }

        $total_hrs = $t_hrs.':'.$t_min;

        $pdf = PDF::loadView($view, ['logs' => $logs,
        'daterange' => $request->daterange, 'count' => $count, 'total_hrs' => $total_hrs])
        ->setPaper('letter','landscape');
        return $pdf->stream();
    }
}
