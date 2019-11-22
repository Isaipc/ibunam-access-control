@extends('layouts.app')

@section('content')
    <div class="card">
        <div class="card-header">
            <h2>
                {{ __('Empleados')}}
                <a href="{{ route('empleados.create') }}" class="btn btn-sm btn-success float-right">Nuevo empleado</a>
            </h2>
        </div>
        <div class="card-body">
            {{-- <h4 class="card-title">Title</h4>
            <p class="card-text">Text</p> --}}
            <table class="table table-striped table-sm">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Apellidos</th>
                        <th>Telefono</th>
                        {{-- <th>Dirección</th> --}}
                        <th>RFC</th>
                        <th>Categoría</th>
                        {{-- <th>Fecha de creación</th> --}}
                        {{-- <th>Última actualización</th> --}}
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($empleados as $item)
                        <tr>
                            <td scope="row">{{ $item->nombre }} </td>
                            <td>{{ $item->apellidos}} </td>
                            <td>{{ $item->telefono}} </td>
                            {{-- <td>{{ $item->direccion}} </td> --}}
                            <td>{{ $item->rfc}} </td>
                            <td>{{ $item->categoria->nombre}} </td>
                            {{-- <td>{{ $item->created_at}} </td> --}}
                            {{-- <td>{{ $item->updated_at}} </td> --}}
                            <td>
                                <a href="{{ route('empleados.edit', $item->id) }} " class="btn btn-sm btn-primary">Editar</a>
                                <a href="javascript: document.getElementById('delete-{{ $item->id }}').submit()" class="btn btn-sm btn-danger">Eliminar</a>
                                <form id="delete-{{ $item->id }}" action="{{ route('empleados.destroy', $item->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

        </div>
        <div class="card-footer text-muted">
            En esta sección puede agregar nuevos empleados.
        </div>
    </div>
@endsection
