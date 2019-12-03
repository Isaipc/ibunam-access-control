<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Reporte - Lista de Emplaedos</title>
</head>
<body>

    <h1>Lista de Empleados</h1>
        @if (count($empleados) > 0)
        <table class="">
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
</body>
</html>
