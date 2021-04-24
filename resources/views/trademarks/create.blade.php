@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="card">

            <div class="card-body">
                <h5>
                    Crear una nueva marca
                    <a href="{{ route('trademarks.index')}}">
                        <button type="button" class="btn btn-primary btn-sm float-right">
                            Volver
                        </button>
                    </a>
                </h5>
                <form action="{{route('trademarks.store')}}" method="post">
                    @csrf
                    <div class="row">
                        <div class="col-sm-5">
                            <div class="form-group">
                                <label for="name">
                                    Nombre
                                </label>
                                <input type="text" class="form-control" name="name" placeholder="Nombre">
                            </div>
                        </div>
                        <div class="col-sm-5">
                            <div class="form-group">
                                <label for="codigo">
                                    Codigo
                                </label>
                                <input type="text" class="form-control" name="code" placeholder="codigo">
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-dark btn-block">
                        Crear
                    </button>
                </form>
            </div>
        </div>
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>
                            {{ $error }}
                        </li>
                    @endforeach
                </ul>
            </div>
        @endif
        </div>
@endsection
