<?php

namespace App\Http\Controllers;

use PDF;
use App\Categoria;
use Illuminate\Http\Request;

class CategoriaController extends Controller
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
        $categorias = Categoria::orderBy('created_at', 'DESC')->get();
        $count_categorias = $categorias->count();
        return view('categorias.index', ["categorias" => $categorias, 'count_categorias' => $count_categorias]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('categorias.create');
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
        //     'nombre' => 'required'
        // ]);
        $categoria = new Categoria;
        $categoria->nombre = mb_strtoupper($request->categoria, 'UTF-8');
        $categoria->save();
        return redirect('/categorias')->with('success', 'Categoría creada correctamente.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Categoria  $categoria
     * @return \Illuminate\Http\Response
     */
    public function show(Categoria $categoria)
    { }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Categoria  $categoria
     * @return \Illuminate\Http\Response
     */
    public function edit(Categoria $categoria)
    {
        return view('categorias.edit', compact('categoria'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Categoria  $categoria
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Categoria $categoria)
    {
        $categoria->nombre = mb_strtoupper($request->categoria, 'UTF-8');
        $categoria->save();
        return redirect('/categorias')->with('success', 'Categoría actualizada correctamente.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Categoria  $categoria
     * @return \Illuminate\Http\Response
     */
    public function destroy(Categoria $categoria)
    {
        $categoria->delete();
        return redirect('/categorias')->with('success', 'Categoría eliminada correctamente.');
    }

    public function generarPDF()
    {
        $categorias = Categoria::all();
        $count_categorias = $categorias->count();
        $pdf = PDF::loadView('categorias.list', compact([ 'categorias', 'count_categorias' ]))
        ->setPaper('letter','landscape');
        return $pdf->stream();
    }
}
