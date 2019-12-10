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

    public function getHorario(Request $request){
        $fecha = Carbon::createFromFormat('d/m/Y', $request->fecha);
        $empleado = Empleado::find($request->empleado_id);
        $horarios = $empleado->horarios->where('dia', $fecha->dayOfWeek)->first();
        return response()->json(['success' => true, 'empleado' => $empleado, 'horarios' => $horarios]);
    }


    public function generarPDF(Request $request)
    {
        $daterange = explode('-', str_replace(' ', '', $request->semana));
        $entrada = Carbon::createFromFormat('d/m/Y', $daterange[0]);
        $salida = Carbon::createFromFormat('d/m/Y', $daterange[1]);

        // ->whereRaw('DAYOFWEEK(fecha) != ?', $domingo);
        $logs = DB::table('logs_empleados')
        ->select('logs_empleados.*',
            'empleados.rfc as rfc',
            'empleados.nombre as nombre',
            'empleados.apellidos as apellidos',
            DB::raw('TIMEDIFF(logs_empleados.salida, logs_empleados.entrada) as hrs'),
            DB::raw('DAYOFWEEK(logs_empleados.fecha)-1 as dia'),
            DB::raw('DAYOFMONTH(logs_empleados.fecha) as dia_mes')
            )
            ->whereIn('logs_empleados.empleado_id', $request->empleados)
            ->whereBetween('logs_empleados.fecha', [$entrada->toDateString(), $salida->toDateString()] )
            ->orderBy('logs_empleados.fecha', 'ASC')
        ->leftJoin('empleados','empleados.id', '=', 'logs_empleados.empleado_id')
        ->leftJoin('horarios_empleados', 'horarios_empleados.empleado_id', '=', 'empleados.id')
        ->distinct()
        ->get();
        // ->where('logs_empleados.entrada', '<', 'horarios_empleados.entrada')
        // ->orWhere('logs_empleados.salida', '>', 'horarios_empleados.salida')

        $t_hrs = 0;
        $t_hrs_d = 0;
        $t_min = 0;
        $t_min_d = 0;

        foreach ($logs as $key => $l) {
            if($l->dia != 0){
                $time = explode(':', str_replace(' ', '', $l->hrs));
                $t_hrs = $t_hrs + (int)$time[0];
                $t_min = $t_min + (int)$time[1];
            }else{
                $time = explode(':', str_replace(' ', '', $l->hrs));
                $t_hrs_d = $t_hrs_d + (int)$time[0];
                $t_min_d = $t_min_d + (int)$time[1];
            }
        }
        $total_hrs = $t_hrs.':'.$t_min;
        $total_hrs_d = $t_hrs_d.':'.$t_min_d;
        $periodo =mb_strtoupper('DEL '.$entrada->format('d').' AL '.$salida->format('d \\DE F \\DE Y'));

        $pdf = PDF::loadView('logs.extras',
        ['logs' => $logs,
        'count' => 1,
        'total_hrs' => $total_hrs,
        'total_hrs_d' => $total_hrs_d,
        'semana' => $entrada->week(),
        'periodo' => $periodo])
        ->setPaper('letter','landscape');
        return $pdf->stream();
    }
}
