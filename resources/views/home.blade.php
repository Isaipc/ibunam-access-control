@extends('layouts.app')

@section('content')
<div class="container">
    @guest
    @else
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

                    Bienvenido <strong> {{ Auth::user()->name }} </strong>
                </div>
            </div>
        </div>
    </div>
    @endguest
</div>
@endsection
