<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    {{-- <meta http-equiv="X-UA-Compatible" content="ie=edge"> --}}
    <title>Entradas y salidas</title>

    <style>
        *{
            font-family:Arial, Helvetica, sans-serif;
        }

        .table
        {
            /* background-color: aqua; */
        }

    </style>
</head>
<body>


    <h1>Entradas y Salidas</h1>
    <table class="table">
        <thead>
            <tr>
                <th>#</th>
                <th>RFC</th>
                <th>Nombre</th>
                {{-- <th>Domingos y Fest. Dias laborados</th> --}}
                {{-- <th>Extras</th>
                <th>Horas</th> --}}
                <th>(dias laborados)</th>
                <th>Horas:Minutos</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($logs as $key => $item)
            <tr>
                <td> {{ ++$key }} </td>
                <td> {{ $item->empleado->rfc}} </td>
                <td> {{ $item->empleado->nombre }} </td>
                {{-- <td> {{ $item->extra() }} </td>
                <td> {{ $item->totalHrsExtras() }} </td> --}}
                <td> {{ $item->registro() }} </td>
                <td> {{ $item->totalHrs() }} </td>
            </tr>
            @endforeach
            <tr>
                <td colspan="2">
                    <h4>Total empleados</h4>
                </td>
                <td>{{ $total_empleados}} </td>
                <td colspan="2">
                    <h4>Total de horas</h4>
                </td>
                {{-- <td>{{ $count_horas }} </td> --}}
            </tr>
        </tbody>
    </table>

</body>
</html>
