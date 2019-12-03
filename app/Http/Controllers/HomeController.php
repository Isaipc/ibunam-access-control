<?php

namespace App\Http\Controllers;

use App\Empleado;
use App\Categoria;
use App\HorarioEmpleado;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $empleados = (Empleado::all())->count();
        $categorias = Categoria::all()->count();
        $horarios = HorarioEmpleado::all()->count();
        // dd($empleados);
        // $empleados = Horarios::all();
        return view('home', ['empleados' => $empleados, 'categorias' => $categorias, 'horarios' => $horarios]);
    }
}
