@extends('layouts.app')

@section('content')
    <div class="card">
        <div class="card-header">
            <h2>
                {{ __('Horarios')}}
            </h2>
        </div>
        <div class="card-body">
            {{-- <h4 class="card-title">Title</h4>
            <p class="card-text">Text</p> --}}
            <form action="{{ route('horarios.store') }} " method="POST">
                @csrf

            <div class="form-group row">
                <label for="" class="col-md-2 col-form-label text-right">Empleado</label>
                <select name="empleado" id="" class="form-control col-md-6" required>
                    <option value="">-- Seleccione un empleado --</option>
                    @foreach ($empleados as $empleado)
                        <option value="{{ $empleado->id }}">{{ $empleado->nombre . " " .  $empleado->apellidos }}</option>
                    @endforeach
                </select>
            </div>

            <table class="table table-striped table-sm">
                <thead>
                    <tr>
                        <th>Día</th>
                        <th>Entrada</th>
                        <th>Salida</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($dias_semana as $dia)
                        <tr>
                            <td>{{ $dia }}</td>
                            <td>
                                <input name="entrada-{{ $dia }}" type="time" class="form-control form-control-sm">
                            </td>
                            <td>
                                <input name="salida-{{ $dia }}" type="time" class="form-control form-control-sm">
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                    <button type="submit" class="btn btn-md btn-primary">Guardar</button>
            </form>

        </div>
        <div class="card-footer text-muted">
            En esta sección puede agregar nuevas horarios.
        </div>
    </div>
@endsection
