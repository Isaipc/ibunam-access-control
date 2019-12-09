@extends('layouts.report')

@section('content')

<h4 class="row">Reporte de horas extras</h4>
<div class="row">
    <h5 class="text-uppercase">
        {{-- periodo: [ {{ $daterange }} ] --}}
        Semana:
        <span class="text-danger">{{ $semana }}</span>
    </h5>
</div>
<p class="row"> {{ $periodo }} </p>
@if($count> 0)
<table class="table table-striped table-sm">
    <thead>
        <tr>
            <th>#</th>
            <th>RFC</th>
            <th>Nombre</th>
            <th>Domingos y Fest. Dias laborados</th>
            <th>Horas</th>
            <th>Prima dominical. Dias laborados</th>
            <th>Horas</th>
        </tr>
    </thead>
    <tbody>



    @foreach ($logs as $key => $item)
    @if ($item->dia == 0)
        <tr>
            <td> {{ ++$key }} </td>
            <td> {{ $item->rfc }} </td>
            <td> {{ $item->empleado }} </td>
            <td class="text-center">  --- </td>
            <td class="text-center">  --- </td>
            <td class="text-center"> DIA {{ $item->dia_mes }} ( DE {{$item->entrada}} A {{ $item->salida }} HRS) </td>
            <td class="text-center"> {{ $item->hrs }} </td>
        </tr>
    @else
        <tr>
            <td> {{ ++$key }} </td>
            <td> {{ $item->rfc }} </td>
            <td> {{ $item->empleado }} </td>
            <td class="text-center"> DIA {{ $item->dia_mes }} ( DE {{$item->entrada}} A {{ $item->salida }} HRS) </td>
            <td class="text-center"> {{ $item->hrs }} </td>
            <td class="text-center"> --- </td>
            <td class="text-center"> --- </td>
        </tr>
    @endif
    @endforeach
    <tr class="font-weight-bold">
        <td colspan="2">Total empleados</td>
        <td>{{ $count }} </td>
        <td >Total de horas</td>
        <td>{{ $total_hrs }} </td>
        <td >Total de horas</td>
        <td>{{ $total_hrs_d }} </td>
    </tr>

    </tbody>
</table>
@else
<div class="alert alert-info">No se encontraron registros</div>

@endif
@endsection
