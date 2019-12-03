<?php

namespace App\Http\Controllers;

use App\LogEmpleado;
use App\Empleado;
use Illuminate\Support\Facades\DB;
use DateTime;
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
        // $date_e = date_create_from_format('d/m/Y:H:i:s', $request->entrada);
        // $date_s = date_create_from_format('d/m/Y:H:i:s', $request->salida);
        // dd($request->entrada);

        $input_time_format = 'H:i';
        $date_e = DateTime::createFromFormat($input_time_format, $request->entrada);
        $date_s = DateTime::createFromFormat($input_time_format, $request->salida);

        $log = new LogEmpleado;
        $log->empleado_id = $request->empleado;
        $log->entrada = $date_e;
        $log->salida = $date_s;
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

    public function generarPDF(Request $request)
    {
        $domingo = 1;
        $daterange = explode('-', $request->daterange);
        $entrada = new Carbon($daterange[0]);
        $salida = new Carbon($daterange[1]);
        $radio = $request->radio;

        // dd($entrada->dayOfWeek);
        // if($request->radio == 'extras'){
            // $logs = DB::table('logs_empleados')->
            // $logs = LogEmpleado::select('')
            // ->join('empleados', 'logs_empleados.empleado_id', '=', 'empleados.id')
            // ->whereIn('empleado_id', $request->empleados)
            // ->whereRaw('DAYOFWEEK(created_at) = ?', $domingo)
            // ->whereNotBetween('created_at', [$entrada->toDateTimeString(), $salida->toDateTimeString()] )
            // ->get();
        // }
        if($request->radio == 'domingos'){
            $logs = LogEmpleado::whereIn('empleado_id', $request->empleados)
            ->whereBetween('created_at', [$entrada->toDateTimeString(), $salida->toDateTimeString()] )
            ->whereRaw('DAYOFWEEK(created_at) = ?', $domingo)
            ->get();
        }else{
            $logs = LogEmpleado::whereIn('empleado_id', $request->empleados)
            ->whereBetween('created_at', [$entrada->toDateTimeString(), $salida->toDateTimeString()] )
            ->get();
        }

        $total_empleados = count($request->empleados);
        // $total_empleados = count($logs->empleados);
        // dd($logs);

        PDF::setOptions(['dpi' => 150, 'defaultFont' => 'calibri']);
        $pdf = PDF::loadView('logs.report', compact('logs', 'total_empleados'))
                ->setPaper('letter','landscape');
        return $pdf->stream();
    }
}
