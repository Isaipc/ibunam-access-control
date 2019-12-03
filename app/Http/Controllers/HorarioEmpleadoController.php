<?php

namespace App\Http\Controllers;

use App\Empleado;
use App\Horario;
use App\HorarioEmpleado;
use Illuminate\Http\Request;

class HorarioEmpleadoController extends Controller
{

    public $dias_semana = array(
        'Domingo',
        'Lunes',
        'Martes',
        'Miercoles',
        'Jueves',
        'Viernes',
        'Sabado'
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
        $horarios = HorarioEmpleado::orderBy('dia','DESC')->get();
        $empleados = Empleado::orderBy('nombre', 'ASC')->get();
        return view('horarios.index',
        ['empleados' => $empleados, 'horarios' => $horarios, 'dias_semana' => $this->dias_semana]);
    }

    public function getHorarios(Request $request){
        $empleado = Empleado::find($request->empleado);
        $horarios = $empleado->horarios->sortBy('dia')->values()->all();
        return response()->json(['success' => true, 'empleado' => $empleado, 'horarios' => $horarios]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $empleados = Empleado::orderBy('nombre', 'ASC')->get();
        return view('horarios.create', ['empleados' => $empleados, 'dias_semana' => $this->dias_semana]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request->dias);
        foreach ($request->dias as $dia){
            $this->create_horario($request, $dia);
            // var_dump($dia);
        }
        return redirect('/horarios')->with('success', 'Horario guardado correctamente');
    }

    private function create_horario($request, $dia)
    {
         HorarioEmpleado::updateOrCreate(
            ['empleado_id' => $request->empleado,'dia' => $dia],
            ['entrada' => $request->entrada, 'salida' => $request->salida]
        );
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
    public function destroy($id)
    {
        if(HorarioEmpleado::destroy($id))
            return redirect('/horarios')->with('success', 'Horario eliminado correctamente');
        else
            return redirect('/horarios')->with('error', 'No se ha podido eliminar el horario');
    }
}
