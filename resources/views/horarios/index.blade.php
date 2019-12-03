@extends('layouts.app')

@section('content')
    <div class="card">
        <div class="card-header">
            <h2>
                {{ __('Horarios')}}
                <a href="{{ route('horarios.create') }}" class="btn btn-md btn-success float-right">Asignar horarios</a>
            </h2>
        </div>
        <div class="card-body">
            <h4 class="card-title">Lista de horarios</h4>
                <div class="form-inline my-2">
                    <label for="" class="col-md-2 col-form-label text-right">Empleado</label>
                    <select name="empleado" id="s_empleados" class="form-control selectpicker col-lg-4 text-uppercase"
                        data-live-search="true"
                        title="Seleccione un empleado">
                        {{-- <option value="0">-- Seleccione un empleado --</option> --}}
                        @foreach ($empleados as $empleado)
                        <option value="{{ $empleado->id }}">{{ $empleado->nombre . " " .  $empleado->apellidos }}</option>
                        @endforeach
                    </select>
                    {{-- <form class="form-inline" action="{{  }}" method="GET"> --}}
                        {{-- <button type="submit" class="btn btn-md btn-primary ml-2">Ver horarios</button> --}}
                    {{-- </form> --}}
                </div>
            @if (count($horarios) > 0)
                 <table class="table table-striped table-sm">
                     <thead>
                    </thead>
                    <tbody>
                        {{-- @foreach ($horarios as $horario)
                        <tr>
                            <td>{{ $horario->empleado->nombre }}</td>
                            <td>{{ $dias_semana[$horario->dia] }}</td>
                            <td>{{ $horario->entrada }}</td>
                            <td>{{ $horario->salida }}</td>
                            <td>
                                <a href="javascript: document.getElementById('delete-{{ $horario->id }}').submit()" class="btn btn-sm btn-danger">Eliminar</a>
                                <form id="delete-{{ $horario->id }}" action="{{ route('horarios.destroy', $horario->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                </form>
                            </td>
                        </tr>
                        @endforeach --}}
                    </tbody>
                </table>
            @else
                <div class="alert alert-info" role="alert">Todavía no hay horarios registrados.</div>
            @endif
        </div>
        <div class="card-footer text-muted">
            En esta sección puede agregar nuevas horarios.
        </div>
    </div>
@endsection
