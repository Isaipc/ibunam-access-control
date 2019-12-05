@extends('layouts.report')

@section('content')

<h4>Reporte para prima dominical</h4>
<h5>
    periodo: [ {{ $daterange }} ]
</h5>
@if($count > 0)
<table class="table table-striped table-sm">
        <thead>
            <tr>
                <th>#</th>
                <th>RFC</th>
                <th>Nombre</th>
                {{-- <th>Domingos y Fest. Dias laborados</th> --}}
                {{-- <th>Extras</th>
                    <th>Horas</th> --}}
                    <th>Dias laborados</th>
                    <th>Horas:Minutos</th>
                </tr>
        </thead>
        <tbody>
                @foreach ($logs as $key => $item)
                <tr>
                    <td> {{ ++$key }} </td>
                    <td> {{ $item->empleado->rfc}} </td>
                    <td> {{ $item->empleado->nombre }} </td>
                    <td> {{ $item->registro() }} </td>
                    <td> {{ $item->totalHrs() }} </td>
                </tr>
                @endforeach
                <tr class="font-weight-bold">
                    <td colspan="2">Total empleados</td>
                    <td>{{ $count}} </td>
                    <td >Total de horas</td>
                    <td>{{ $total_hrs }} </td>
                </tr>
            </tbody>
        </table>

@else
<div class="alert alert-info">No se encontraron registros</div>
@endif
@endsection
