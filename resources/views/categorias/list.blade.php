@extends('layouts.report')

@section('content')

    <h3>Lista de Categorias</h3>
    @if (count($categorias) > 0)
    <table class="table table-striped table-sm">
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


@endsection
