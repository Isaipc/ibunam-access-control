
@extends('layouts.app')
@section('content')
<div class="card">
    <div class="card-header">
        <h2>
            Entradas y salidas
        </h2>
    </div>
    <div class="card-body">
        {{-- <h4 class="card-title">Registrar entrada y salida</h4> --}}

        <form action="{{ action('LogEmpleadoController@generarPDF') }}" method="GET">
            @csrf
            <div class="form-group row">
              <label for="" class="col-md-2 text-md-right text-lg-right">Empleado</label>
              <select name="empleados[]" id="" class="form-control selectpicker text-uppercase col-md-6 col-lg-4"
              data-live-search="true"
              data-actions-box="true"
              data-select-all-text="Todos"
              data-deselect-all-text="Ninguno"
              title="Seleccione un empleado"
              multiple required>
                    @foreach ($empleados as $empleado)
                        <option value="{{ $empleado->id }}">{{ $empleado->nombre . " " .  $empleado->apellidos }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group row">
                    <label for="" class="col-md-2 text-md-right text-lg-right">Periodo</label>
                    <input id="daterange" type="text" name="daterange" value="" class="form-control col-md-6 col-lg-4" />
            </div>
            <fieldset class="form-group row">
                <div class="col-lg-4">
                    <div class="custom-control  custom-checkbox float-right">
                        <div class="custom-control custom-radio">
                            <input type="radio" id="radio1" name="radio" class="custom-control-input" value="extras">
                            <label class="custom-control-label" for="radio1">Solo horas extras</label>
                        </div>
                        <div class="custom-control custom-radio">
                            <input type="radio" id="radio2" name="radio" class="custom-control-input" value="domingos">
                            <label class="custom-control-label" for="radio2">Solo domingos</label>
                        </div>
                        <div class="custom-control custom-radio">
                            <input type="radio" id="radio3" name="radio" checked="true" class="custom-control-input" value="ambos">
                            <label class="custom-control-label" for="radio3">Horas extras y domingos</label>
                        </div>
                    </div>
                </div>
            </fieldset>
            <div class="form-inline">
                <button type="submit" class="btn btn-md btn-primary">Generar reporte</button>
            </div>
        </form>
    </div>
</div>
@endsection
