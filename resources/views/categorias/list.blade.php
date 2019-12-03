<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Reporte - Lista de Categorias</title>
</head>
<body>

    <h1>Lista de Categorias</h1>
        @if (count($categorias) > 0)
        <table class="">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nombre</th>
                    <th>Fecha de creación</th>
                    <th>Última actualización</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($categorias as $key=> $item)
                <tr>
                    <td scope="row">{{ ++$key}} </td>
                    <td>{{ $item->nombre }} </td>
                    <td>{{ $item->created_at}} </td>
                    <td>{{ $item->updated_at}} </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <div class="alert alert-info" role="alert">Todavía no hay categorias registradas.</div>
        @endif
</body>
</html>
