<?php

namespace App\Http\Controllers;

use App\Categoria;
use App\Empleado;
use Illuminate\Http\Request;

use PDF;

class EmpleadoController extends Controller
{

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
        $empleados = Empleado::orderBy('created_at', 'DESC')->get();
        $count_empleados = $empleados->count();
        return view('empleados.index', ['empleados' => $empleados, 'count_empleados' => $count_empleados]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categorias = Categoria::orderBy('nombre', 'ASC')->get();
        return view('empleados.create', ['categorias' => $categorias]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'rfc' => 'required|max:13',
            'nombre' => 'required',
            'apellidos' => 'required',
            'telefono' => 'max:12',
            'categoria' => 'required'
        ]);

        $empleado = new Empleado;
        $empleado->nombre = mb_strtoupper($request->nombre, 'UTF-8');
        $empleado->apellidos = mb_strtoupper($request->apellidos, 'UTF-8');
        $empleado->telefono = $request->telefono;
        $empleado->direccion = mb_strtoupper($request->direccion, 'UTF-8');
        $empleado->rfc = mb_strtoupper($request->rfc, 'UTF-8');
        $empleado->categoria_id = $request->categoria;

        if($empleado->save())
            return redirect('/empleados')->with('success', 'Empleado creado correctamente');
        else
            dd($empleado);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Empleado  $empleado
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        return response()->json(['success' => true, 'empleado' => Empleado::find($request->id) ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Empleado  $empleado
     * @return \Illuminate\Http\Response
     */
    public function edit(Empleado $empleado)
    {
        $categorias = Categoria::orderBy('nombre', 'ASC')->get();
        return view('empleados.edit', ['empleado' => $empleado, 'categorias' => $categorias]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Empleado  $empleado
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Empleado $empleado)
    {
        $request->validate([
            'rfc' => 'required|max:13',
            'nombre' => 'required',
            'apellidos' => 'required',
            'telefono' => 'required|max:12',
            'direccion' => 'required',
            'categoria' => 'required'
        ]);

        $empleado->nombre = mb_strtoupper($request->nombre, 'UTF-8');
        $empleado->apellidos = mb_strtoupper($request->apellidos, 'UTF-8');
        $empleado->telefono = $request->telefono;
        $empleado->direccion = mb_strtoupper($request->direccion, 'UTF-8');
        $empleado->rfc = mb_strtoupper($request->rfc, 'UTF-8');
        $empleado->categoria_id = $request->categoria;

        if($empleado->save())
            return redirect('/empleados')->with('success', 'Empleado actualizado correctamente');
            else
            return view('empleados.edit', ['empleado' => $empleado]);
        }

        /**
         * Remove the specified resource from storage.
     *
     * @param  \App\Empleado  $empleado
     * @return \Illuminate\Http\Response
     */
    public function destroy(Empleado $empleado)
    {
        $empleado->delete();
        return redirect('/empleados')->with('success', 'Empleado eliminado correctamente');
    }

    public function generarPDF()
    {
        $empleados = Empleado::orderBy('nombre', 'ASC')->get();
        $pdf = PDF::loadView('empleados.list', compact('empleados'))
        ->setPaper('letter','landscape');
        return $pdf->stream();
    }
}
