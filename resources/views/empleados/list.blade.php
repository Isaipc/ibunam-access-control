@extends('layouts.report')

@section('content')
    <h2>Lista de Empleados</h2>
    @if (count($empleados) > 0)
    <table class="table table-striped table-sm">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nombre</th>
                    <th>Apellidos</th>
                    {{-- <th>Telefono</th> --}}
                    <th>RFC</th>
                    <th>Categoría</th>
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
                </tr>
                @endforeach
            </tbody>
        </table>
        @else
        <div class="alert alert-info" role="alert">Todavía no hay empleados registradas.</div>
        @endif

@endsection
