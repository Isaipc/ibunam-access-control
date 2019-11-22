
@extends('layouts.app');

@section('content')
<div class="card">
    <div class="card-header">
        <h2>
            Entrada y salida
        </h2>
    </div>
    <div class="card-body">
        <h4 class="card-title">Registrar entrada y salida</h4>

        <form action="{{ route('logs.store') }}" method="POST">
            @csrf
            <div class="form-group row">
              <label for="" class="col-md-2 text-right">Empleado</label>
              <select name="empleado" id="" class="form-control col-md-3" required>
                    <option value="">-- Seleccione un empleado --</option>
                    @foreach ($empleados as $empleado)
                        <option value="{{ $empleado->id }}">{{ $empleado->nombre . " " .  $empleado->apellidos }}</option>
                    @endforeach
                </select>
              {{-- <small id="helpId" class="text-muted">Help text</small> --}}
            </div>

            <div class="form-group row">
                <label for="" class="col-md-2 text-right">Hora de entrada</label>
                <input type="time" name="entrada" class="form-control col-md-3" placeholder="" aria-describedby="helpId" required>
                {{-- <small id="helpId" class="text-muted">Help text</small> --}}
            </div>
            <div class="form-group row">
                <label for="" class="col-md-2 text-right">Hora de salida</label>
                <input type="time" name="salida" class="form-control col-md-3" placeholder="" aria-describedby="helpId" required>
                    {{-- <small id="helpId" class="text-muted">Help text</small> --}}
            </div>
            <button type="submit" class="btn btn-md btn-primary mx-5">Guardar</button>
        </form>
    </div>
</div>
@endsection
