@extends('layouts.app')

@section('content')

<div class="container">
    .<div class="card">
        <div class="card-header">
            <h2>
                {{ __('Categorías')}}
            </h2>
        </div>
        <div class="card-body">
            <h4 class="card-title">{{ __('Nueva categoría')}} </h4>
            {{-- <p class="card-text">Text</p> --}}

            <form action="{{ route('categorias.store') }} " method="POST">
                @csrf
                <div class="form-group row">
                    <label for="i_nombre" class="col-lg-2">Nombre</label>
                    <input id="i_nombre" type="text" class="form-control text-uppercase col-lg-4" name="categoria" required>
                </div>
                <button type="submit" class="btn btn-md btn-primary">Guardar</button>
                <a href="{{ route('categorias.index') }} " class="btn btn-md btn-secondary">cancelar</a>
            </form>
        </div>
        {{-- <div class="card-footer text-muted"></div> --}}
    </div>
</div>

@endsection
