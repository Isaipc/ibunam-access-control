@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header">
            <h2>
                {{ __('Horarios')}}
            </h2>
        </div>
        <div class="card-body">
            <h4 class="card-title">{{ __('Asignar horarios')}} </h4>
            {{-- <p class="card-text">Text</p> --}}

            <form action="{{ route('horarios.store') }} " method="POST">
                @csrf
                <div class="form-group row">
                    <label for="" class="col-md-2 text-md-right text-lg-right">Empleado</label>
                    <select name="empleado" id="" class="form-control selectpicker col-lg-4 text-uppercase"
                    data-live-search="true"
                    title="Seleccione un empleado"
                     required>
                        @foreach ($empleados as $empleado)
                        <option value="{{ $empleado->id }}">{{ $empleado->nombre . " " .  $empleado->apellidos }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group row">
                    <label for="" class="col-md-2 text-md-right text-lg-right">Dia de la semana</label>
                    <select name="dias[]" id="s_dia" class="selectpicker multiple-select"
                        data-actions-box="true"
                        data-select-all-text="Todos los días"
                        data-deselect-all-text="Ninguno"
                        multiple required title="Seleccione los días">
                        @for ($i = 0; $i < count($dias_semana); $i++)
                            <option value="{{ $i }}">{{ $dias_semana[$i] }}</option>
                        @endfor
                    </select>
                </div>
                <div class="form-group row">
                    <label for="" class="col-md-2 text-md-right text-lg-right">Hora de entrada</label>

                    <div class="input-group col-md-6 col-lg-4">
                        <input id="i_entrada" type="time" name="entrada" class="form-control" placeholder=""  required>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="" class="col-md-2 text-md-right text-lg-right">Hora de salida</label>
                    <div class="input-group col-md-6 col-lg-4">
                        <input id="i_salida" type="time" name="salida" class="form-control" placeholder="" required>
                    </div>
                </div>
                {{-- <div class="form-row align-items-center">
                    <div class="col"> --}}
                        <button type="submit" class="btn btn-md btn-primary">Guardar</button>
                    {{-- </div> --}}
                    {{-- <div class="col"> --}}
                        <a href="{{ route('horarios.index') }} " class="btn btn-md btn-secondary">Cancelar</a>
                    {{-- </div> --}}
                {{-- </div> --}}
            </form>
        </div>
        {{-- <div class="card-footer text-muted"></div> --}}
    </div>
</div>
@endsection
