@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Panel de control</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    @guest
                    @else
                    <h2>
                        Bienvenido
                        <strong class="text-uppercase">
                            {{ Auth::user()->name }}
                        </strong>
                    </h2>
                    @endguest
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
