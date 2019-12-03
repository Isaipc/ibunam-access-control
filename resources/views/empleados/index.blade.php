@extends('layouts.app')

@section('content')
    <div class="card">
        <div class="card-header">
            <h2>
                {{ __('Empleados')}}
                <span class="badge badge-success">{{ $count_empleados }}</span>
                <span class="float-right">
                    <a href="{{ action('EmpleadoController@generarPDF') }}" class="btn btn-md btn-primary">Generar reporte</a>
                    <a href="{{ route('empleados.create') }}" class="btn btn-md btn-success">Nuevo empleado</a>
                </span>
            </h2>
        </div>
        <div class="card-body">
             <h4 class="card-title">Lista de empleados</h4>
            {{-- <p class="card-text">Text</p> --}}
            <table class="table table-striped table-sm">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nombre</th>
                        <th>Apellidos</th>
                        {{-- <th>Telefono</th> --}}
                        <th>RFC</th>
                        <th>Categoría</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($empleados as $key=> $item)
                        <tr>
                            <td>{{ ++$key }}</td>
                            <td scope="row">
                                <form action=""></form>
                            <span id="{{ $item->id }}" data-toggle="modal" data-target="#empleado-data"
                                class="btn-link text-dark show-empleado">
                                    {{ $item->nombre }}
                            </span>
                            </td>
                            <td>{{ $item->apellidos}} </td>
                            {{-- <td>{{ $item->telefono ?: 'No registrado'}}</td> --}}
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

    <!-- Button trigger modal -->
    {{-- <button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#empleado-data"> --}}
      {{-- Launch --}}
    {{-- </button> --}}

    <!-- Modal -->
    <div class="modal fade" id="empleado-data" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                    <div class="modal-header">
                            <h5 class="modal-title">Datos del empleado</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                        </div>
                <div class="modal-body">
                    <div class="container-fluid">
                        <div class="row mb-2">
                            <h5 class="mr-2">Nombre:</h5>
                            <h5 id="empleado_nombre"></h5>
                        </div>
                        <div class="row mb-2">
                            <h5 class="mr-2">RFC:</h5>
                            <h5 id="empleado_rfc"></h5>
                        </div>
                        <div class="row mb-2">
                            <h5 class="mr-2">Telefono:</h5>
                            <h5 id="empleado_telefono"></h5>
                        </div>
                        <div class="row mb-2">
                            <h5 class="mr-2">Dirección:</h5>
                            <h5 id="empleado_direccion"></h5>
                        </div>
                        <div class="row mb-2">
                            <h5 class="mr-2">Categoría:</h5>
                            <h5 id="empleado_categoria"></h5>
                        </div>
                        <div class="row mb-2">
                            <h5 class="mr-2">Creación:</h5>
                            <h5 id="empleado_creacion"></h5>
                        </div>
                        <div class="row mb-2">
                            <h5 class="mr-2">Ultima actualización:</h5>
                            <h5 id="empleado_actualizacion"></h5>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Aceptar</button>
                    {{-- <button type="button" class="btn btn-primary">Save</button> --}}
                </div>
            </div>
        </div>
    </div>
@endsection
