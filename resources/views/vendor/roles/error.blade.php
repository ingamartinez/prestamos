@extends('layouts.dashboard')

@section('content')

    <div class="container">
        <div class="row">
            <div class="col-sm-12 text-center">
                <h2>{{ $exception->getMessage() }}</h2>
                <a href="{{ url('/') }}" class="btn btn-primary">Inicio</a>
            </div>
        </div>
    </div>

@endsection