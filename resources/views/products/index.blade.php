@extends('layouts.app')

@section('content')
    <div class="panel-body">
        <script type="text/javascript">
            function confirmarEliminar() {
                var x = confirm("Estas seguro de Eliminar?");
                if (x==true)
                {
                    return true;
                }
                else {
                    return false;
                }
            }
        </script>
        <div class="container">
            @if (session('success'))
                <div class="alert-default-success" role="alert">
                    <p>{{session('success')}}</p>
                </div>
            @endif
                <div class="row">
                    <div class="col-md-8">
                        <h2>
                            Productos Creados
                        </h2>
                    </div>
                    <a href="products/create">
                        <button type="button" class="btn btn-success btn-sm btn-block float-right">
                           Crear Producto
                        </button>
                    </a>
                </div>
                <h6>
                    @if($search)
                        <div class="alert-default-primary" role="alert">
                            Los resultados para tu busqueda '{{$search}}' son:
                        </div>
                    @endif
                </h6>
                <table class="table table-sm table-hover table-bordered">
                    <thead>
                    <tr class="table-primary">
                        <th scope="col">#</th>
                        <th>Nombre</th>
                        <th>Observaciones</th>
                        <th>Precio</th>
                        <th>Cantidad en inventario</th>
                        <th>Img</th>
                        <th>Opciones</th>
                        <th>X</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($products as $product)
                        <tr>
                            <td class="v-align-middle">{{$product->id}}</td>
                            <td class="v-align-middle">{{$product->name}}</td>
                            <td class="v-align-middle text-truncate" style="max-width: 200px">{{$product->description}}</td>
                            <td class="v-align-middle">$.{{number_format($product->price)}}</td>
                            <td class="v-align-middle">{{$product->stock}}</td>
                            <td class="v-align-middle">
                                <img class="img img:hover"
                                     src="../uploads/{{$product->imagenes()->first()['name']}}"
                                     width="30" class="img-responsive">
                            </td>
                            <td class="v-align-middle">
                                <form action= "{{ route('products.active',  $product->id)}}" method = "POST">
                                    <a href="{{route('products.show', $product->id) }}">
                                        <button type="button" class="btn btn-dark btn-sm">
                                            Ver
                                        </button>
                                    </a>
                                    @can('products.edit')
                                        <a href="{{ route('products.edit', $product->id) }}">
                                            <button type="button" class="btn btn-primary btn-sm">
                                                Editar
                                            </button>
                                        </a>
                                    @endcan
                                    @can('products.active')
                                        @csrf
                                        @method('GET')
                                        <button type="submit" class=" btn-sm btn {{$product->active ?  'btn-success' : 'btn-danger'}}" role="button" >
                                            {{$product->active ?  'activo' : 'inactivo'}}
                                        </button>
                                    @endcan
                                </form>
                            <td class="v-align-middle">
                                <form action= "{{ route('products.destroy',  $product->id)}}" method = "POST">
                                    @csrf
                                    @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm"  role="button" onclick="return confirmarEliminar()">
                                            Eliminar
                                        </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
        </div>
        <div class="row">
            <div class="mx-auto">
                {{ $products->links()}}
            </div>
        </div>
    </div>
@endsection
