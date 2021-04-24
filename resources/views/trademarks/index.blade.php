@extends('layouts.app')

@section('content')

    @can('Administrator')
        <div class="container">
            <div class="row">
                <div class="col-md-4 mx-auto">
                    <h2>Marcas
                        <a href="{{ route('trademarks.create') }}">
                            <button type="button" class="btn btn-secondary btn-sm float-right">
                                Crear
                            </button>
                        </a>
                    </h2>
                    <table class="table-sm table table-hover">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Nombre</th>
                                <th scope="col">Codigo</th>
                                <th scope="col"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($trademarks as $trademark)
                                <tr>
                                    <th scope="row">{{$trademark->id}}</th>
                                    <td>{{$trademark->name}}</td>
                                    <td>{{$trademark->code}}</td>
                                    <td>
                                        <form action= "{{ route('trademarks.destroy',  $trademark->id)}}" method = "POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm"  role="button">
                                                Eliminar
                                            </button>
                                        </form>
                                    </td>
                                    <td>
                                        <a href="{{ route('trademarks.edit', $trademark->id) }}">
                                            <button type="button" class="btn btn-primary btn-sm">
                                                Editar
                                            </button>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @endcan
@endsection
