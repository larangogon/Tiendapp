@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <h2>
                    Usuarios registrados
                </h2>
            </div>
            <a href="users/create">
                <button type="button" class="btn btn-success btn-sm btn-block float-right">
                    Crear usuarios
                </button>
            </a>
        <h6>
            @if($search)
                <div class="alert-default-primary" role="alert">
                    Los resultados para tu busqueda '{{$search}}' son:
                </div>
            @endif
        </h6>
        <table class="table table-hover table-bordered table-sm">
            <thead>
            <tr class="table-primary">
                <th scope="col">#</th>
                <th scope="col">Nombre </th>
                <th scope="col">Email</th>
                <th scope="col">Rol</th>
                <th scope="col">Opciones</th>
            </tr>
            </thead>
            <tbody>
            @foreach($users as $user)
                <tr>
                    <th scope="row">{{$user->id}}</th>
                    <td>{{$user->name}}</td>
                    <td>{{$user->document}}</td>
                    <td>{{$user->email}}</td>
                    <td>{{trans($user->roles->implode('name',', '))}}</td>
                    <td>
                        <form action= "{{ route('users.active',  $user->id)}}" method = "POST">
                            <a href="{{route('users.show', $user->id) }}">
                                <button type="button" class="btn btn-dark btn-sm">
                                    {!! trans('messages.Show') !!}
                                </button>
                            </a>
                            <a href="{{ route('users.edit', $user->id) }}">
                                <button type="button" class="btn btn-primary btn-sm">
                                    {!! trans('messages.Edit') !!}
                                </button>
                            </a>
                            @csrf
                            @method('GET')
                            <button type="submit" class=" btn-sm btn {{$user->active ?  'btn-success' : 'btn-danger'}}" role="button" >{{$user->active ?  'activo' : 'inactivo'}}</button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        <div class="row">
            <div class="mx-auto">
                {{ $users->links()}}
            </div>
        </div>
    </div>
@endsection
