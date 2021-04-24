@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <h3>Editar usuario: {{ $user->name }}</h3>
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <form action="{{ route('users.update', $user->id) }}" method="POST" enctype="multipart/form-data">
                    @method('PATCH')
                    @csrf
                    <div class="row">
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="name">
                                    Nombre
                                </label>
                                <input type="text" class="form-control" name="name" value="{{ $user->name}}" placeholder ="escribe tu nombre">
                            </div>
                            <div class="form-group">
                                <label for="email">
                                    Email
                                </label>
                                <input type="email" class="form-control"
                                       name="email" value="{{ $user->email}}"
                                       placeholder ="escribe tu email">
                            </div>
                        </div>

                        <div class="col-sm-4">

                            <div class="form-group">
                              <label for="rol">rol</label>
                                <select name="rol" class="form-control">
                                    <option selected disabled>
                                        elige un rol
                                    </option>
                                    @foreach($roles as $role)
                                        @if($user->tieneRol()->contains($role->name))
                                            <option value="{{ $role->id }}" selected>
                                                {{ $role->name }}
                                            </option>
                                        @else
                                            <option value="{{ $role->id }}">
                                                {{ $role->name }}
                                            </option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>

                            <button type="submit" class="btn btn-primary btn-sm">
                                guardar
                            </button>

                            <button type="reset" class="btn btn-danger btn-sm">
                                cancelar
                            </button>

                            <a href="{{ route('users.index') }}" class="btn btn-dark btn-sm">
                                volver
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

