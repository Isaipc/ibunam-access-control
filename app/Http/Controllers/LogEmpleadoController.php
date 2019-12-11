<?php

namespace App\Http\Controllers;

use App\LogEmpleado;
use App\Empleado;
use Illuminate\Support\Facades\DB;
use DateTime;
// use Barryvdh\DomPDF\Facade as PDF
use PDF;
use Carbon\Carbon;
use Carbon\CarbonInterval;
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
        // $request->validate([
        //     'empleado_id' => 'required',
        //     'fecha' => 'required',
        //     'entrada' => 'max:12',
        //     'salida' => 'required'
        // ]);

        $fecha =  Carbon::createFromFormat('d/m/Y', $request->fecha);
        $empleado = Empleado::find($request->empleado);
        $horario = $empleado->horarios->where('dia', $fecha->dayOfWeek)->first();

        // dd($horario->salida);
        if($horario == null)
            LogEmpleado::updateOrCreate(
                ['empleado_id' => $request->empleado,'fecha' => $fecha->toDateString()],
                ['entrada' => $request->entrada, 'salida' => $request->salida]
            );
        else
            LogEmpleado::updateOrCreate(
                ['empleado_id' => $request->empleado,'fecha' => $fecha->toDateString()],
                ['entrada' => $horario->salida, 'salida' => $request->salida]
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


        $hrs = 0;
        $mins = 0;
        $hrs_d = 0;
        $mins_d = 0;

        foreach ($logs as $key => $l) {
            $time = explode(':', str_replace(' ', '', $l->hrs));
            if($l->dia != 0){
                $hrs = $hrs + (int) $time[0];
                $mins = $mins + (int) $time[1];
            }else{
                $hrs_d = $hrs_d + (int) $time[0];
                $mins_d = $mins_d + (int) $time[1];
            }
        }

        $total_hrs = ($hrs +(int) ($mins/60)) . ':' . ($mins%60);
        $total_hrs_d = ($hrs_d + (int)($mins_d/60)) . ':' . ($mins_d%60);

        // dd(compact('total_hrs', 'total_hrs_d'));

        $periodo = mb_strtoupper('DEL '.$entrada->format('d').' AL '.$salida->format('d \\DE F \\DE Y'));

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
