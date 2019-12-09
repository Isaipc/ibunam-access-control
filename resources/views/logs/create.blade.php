
@extends('layouts.app')
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
              <label for="" class="col-md-2 text-md-right text-lg-right">Empleado</label>
              <select name="empleado" id="empleado" class="form-control selectpicker text-uppercase col-md-6 col-lg-4"
              data-live-search="true"
              title="Seleccione un empleado"
              required>
                    {{-- <option value="">-- Seleccione un empleado --</option> --}}
                    @foreach ($empleados as $empleado)
                        <option value="{{ $empleado->id }}">{{ $empleado->nombre . " " .  $empleado->apellidos }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group row">
                <label for="" class="col-md-2 text-md-right text-lg-right">Fecha</label>
                <input id="fecha" type="datetime" name="fecha" class="fecha form-control col-md-6 col-lg-4" required>
            </div>
            <div class="form-group row">
                <label for="" class="col-md-2 text-md-right text-lg-right">Hora de entrada</label>

                <div class="input-group col-md-6 col-lg-4">
                    <input id="i_entrada" type="time" name="entrada" class="form-control"  placeholder="" aria-describedby="button_entrada" required>
                    {{-- <div class="input-group-append">
                        <button id="button_entrada" type="submit" class="btn btn-outline-primary">Guardar</button>
                    </div> --}}
                </div>
            </div>
            <div class="form-group row">
                <label for="" class="col-md-2 text-md-right text-lg-right">Hora de salida</label>
                <div class="input-group col-md-6 col-lg-4">
                    <input id="i_salida" type="time" name="salida" class="form-control" placeholder="" aria-describedby="button_entrada" required>
                    {{-- <div class="input-group-append">
                        <button id="button_entrada" type="submit" class="btn btn-outline-primary">Guardar</button>
                    </div> --}}
                </div>
            </div>
            <div class="form-inline">
                <button class="btn btn-md btn-primary">Registrar</button>
            </div>
        </form>
    </div>
</div>
@endsection
