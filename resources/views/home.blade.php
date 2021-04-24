@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    {{ __('You are logged in!') }}
                </div>
                <a href="{{url('users')}}" class="nav-link"
                   class="{{ Request::path() === '/' ? 'nav-link active' : 'nav-link' }}">
                    <i class="far fa-check-circle"></i>
                    <button type="button" class="btn btn-success btn-sm btn-block float-right">
                        Usuarios
                    </button>
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
