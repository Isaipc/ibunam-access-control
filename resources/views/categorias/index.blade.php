@extends('layouts.app')

@section('content')
    <div class="card">
        <div class="card-header">
            <h2>
                {{ __('Categorías')}}
                <span class="badge badge-success">{{ $count_categorias }}</span>
                <span class="float-right">
                    <a href="{{ action('CategoriaController@generarPDF') }}" class="btn btn-md btn-primary">Generar reporte</a>
                    <a href="{{ route('categorias.create') }}" class="btn btn-md btn-success">Nueva cateogoría</a>
                </span>
            </h2>
        </div>
        <div class="card-body">
            <h4 class="card-title">Lista de categorías</h4>
            {{-- <p class="card-text">Text</p>  --}}

            @if (count($categorias) > 0)
            <table class="table table-striped table-sm">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nombre</th>
                        <th>Fecha de creación</th>
                        <th>Última actualización</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($categorias as $key=> $item)
                    <tr>
                        <td scope="row">{{ ++$key}} </td>
                        <td>{{ $item->nombre }} </td>
                        <td>{{ $item->created_at}} </td>
                        <td>{{ $item->updated_at}} </td>
                        <td>
                            <a href="{{ route('categorias.edit', $item->id) }} " class="btn btn-sm btn-primary">Editar</a>
                            <a href="javascript: document.getElementById('delete-{{ $item->id }}').submit()" class="btn btn-sm btn-danger">Eliminar</a>
                            <form id="delete-{{ $item->id }}" action="{{ route('categorias.destroy', $item->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <div class="alert alert-info" role="alert">Todavía no hay categorias registradas.</div>
            @endif
            </div>
            <div class="card-footer text-muted">
                En esta sección puede agregar nuevas categorías.
        </div>
    </div>
@endsection
