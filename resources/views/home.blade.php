@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">

        <div class="col-md-3">
            <ul class="list-group">
                <li class="list-group-item d-flex justify-content-between align-items-center bg-light">
                    <h4>Registros</h4>
                </li>
                <li class="list-group-item align-items-center">
                    <h5 class="d-flex justify-content-between">
                    Empleados<span class="badge badge-success badge-pill">{{ $empleados }}</span>
                    </h5>
                </li>
                <li class="list-group-item align-items-center">
                    <h5 class="d-flex justify-content-between">
                    Categorias<span class="badge badge-success badge-pill">{{ $categorias }}</span>
                    </h5>
                </li>
                <li class="list-group-item align-items-center">
                    <h5 class="d-flex justify-content-between">
                        Horarios<span class="badge badge-success badge-pill">{{ $horarios }}</span>
                    </h5>
                </li>
            </ul>
        </div>
        <div class="col-md-8">
            <div class="card">
                <h4 class="card-header">Panel de control</h4>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    @guest
                    @else
                    <h2 class="mx-auto text-center">
                        Bienvenido
                        <strong class="text-uppercase">
                            {{ Auth::user()->name }}
                        </strong>
                    </h2>
                    <div class="row my-5">
                        <a href="{{ route('logs.create') }}" class="btn btn-md btn-outline-primary mx-auto">Capturar entrada y salida</a>
                    </div>
                    @endguest
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
