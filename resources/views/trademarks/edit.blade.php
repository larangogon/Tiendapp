@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="card">

            <div class="card-body">
                <h5>
                    Editar una nueva marca
                    <a href="{{ route('trademarks.index')}}">
                        <button type="button" class="btn btn-primary btn-sm float-right">
                            Volver
                        </button>
                    </a>
                </h5>
                <form action="{{ route('trademarks.update', $trademark->id) }}" method="POST" enctype="multipart/form-data">
                    @method('PATCH')
                    @csrf
                    <div class="row">
                        <div class="col-sm-5">
                            <div class="form-group">
                                <label for="name">
                                    Nombre
                                </label>
                                <input type="text" class="form-control" name="name" placeholder="{{$trademark->name}}" value="{{ $trademark->name }}">
                            </div>
                        </div>
                        <div class="col-sm-5">
                            <div class="form-group">
                                <label for="codigo">
                                    Codigo
                                </label>
                                <input type="text" class="form-control" name="code" placeholder="{{$trademark->code}}" value="{{ $trademark->code }}">
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary btn-block">
                        Guardar
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
