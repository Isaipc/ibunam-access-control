@extends('layouts.app')

@section('content')

<div class="container">
    <div class="card w-75">
        <div class="card-header">
            <h2>
                {{ __('Empleados')}}
            </h2>
        </div>
        <div class="card-body">
            <h4 class="card-title">{{ __('Editar empleado')}} </h4>
            {{-- <p class="card-text">Text</p> --}}
            <form action="{{ route('empleados.update', $empleado) }} " method="POST">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="form-group col-md-6">
                        <label for="">Nombre</label>
                        <input type="text" class="form-control" name="nombre" required value="{{ $empleado->nombre }}">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="">Apellidos</label>
                        <input type="text" class="form-control" name="apellidos" required value="{{ $empleado->apellidos }}">
                    </div>
                </div>

                <div class="row">
                    <div class="form-group col-md-3">
                        <label for="">Telefono</label>
                        <input type="text" class="form-control" name="telefono" required maxlength="12" value="{{ $empleado->telefono }}">
                    </div>
                    <div class="form-group col-md-9">
                        <label for="">Dirección</label>
                        <input  type="text" class="form-control" name="direccion" required value="{{ $empleado->direccion }}">
                    </div>
                </div>

                <div class="row">
                    <div class="form-group col-md-6">
                        <label for="">RFC</label>
                        <input type="text" class="form-control" name="rfc" required maxlength="13" value="{{ $empleado->rfc }}">
                    </div>
                    <div class="form-group col-md-4">
                          <label for="">Categoría</label>
                          <select class="form-control" name="categoria">
                                <option value="">Seleccione una categoría</option>
                              @foreach ($categorias as $categoria)
                                @if ($categoria->id == $empleado->categoria_id)
                                    <option value="{{ $categoria->id }}" selected>{{ $categoria->nombre }}</option>
                                @endif
                                <option value="{{ $categoria->id }}">{{ $categoria->nombre }}</option>
                              @endforeach
                          </select>
                    </div>
                </div>

                <button type="submit" class="btn btn-md btn-primary">Guardar</button>
                <a href="{{ route('empleados.index') }} " class="btn btn-md btn-light">Cancelar</a>
            </form>
        </div>
        {{-- <div class="card-footer text-muted"></div> --}}
    </div>
</div>

@endsection
