@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="panel-title">
            <h2>Nombre: {{ $product->name }}
                <a href="{{ route('products.index') }}" class="btn btn-outline-success  btn-sm">
                    Volver
                </a>
            </h2>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="container">
                        <table class="table table-sm">
                            <tr>
                                <th>Observaciones</th>
                                <td>{{ $product->description }}</td>
                            </tr>
                            <tr>
                                <th>Precio</th>
                                <td>{{ $product->price }}</td>
                            </tr>
                            <tr>
                                <th> Cantidad en inventario</th>
                                <td>{{ $product->stock }}</td>
                            </tr>
                            <tr>
                                <th>Marca</th>
                                <td>{{$product->trademarks->implode('name',', ')}}</td>
                            </tr>
                            <tr>
                                <th>Codigo</th>
                                <td>{{$product->trademarks->implode('code',', ')}}</td>
                            </tr>
                            <tr>
                                <th>Talla</th>
                                <td>{{$product->sizes->implode('name',', ')}}</strong></td>
                            </tr>
                            <tr>
                                <th>Fecha de embarque</th>
                                <td>{{ $product->created_at }}</strong></td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card-body">
                    @foreach($product->imagenes as $img)
                        <a data-fancybox="gallery" href="../../../uploads/{{ $img->name }}">
                            <img class="img img:hover" src="../../../uploads/{{ $img->name }}" width="200" class="img-fluid">
                        </a>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection
