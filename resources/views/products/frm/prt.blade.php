@if ( !empty ( $product->id) )
    <div class="card">
        <div class="card-header">
            Editar {{ $product->name }}
        </div>
        <div class="container">
            <input type="hidden" value="{{auth()->user()->id}}" name="updated_by">
            <div class="row">
                <div class="col-sm-5">
                    <div class="form-group">
                        <label for="name" class="negrita">
                            Nombre del producto
                        </label>
                        <div>
                            <input class="form-control" placeholder="product" required="required"
                                   name="name" type="text" id="name" value="{{ $product->name }}">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="description" class="negrita">
                            Observaciones
                        </label>
                        <textarea name="description" rows="4" cols="50"
                                  class="form-control" required="required"  id="description">
                            Observaciones o descripcion
                        </textarea>
                    </div>

                    <div class="form-group">
                        <label for="price" class="negrita">
                            Precio
                        </label>
                        <div>
                            <input class="form-control" placeholder="4.500" required="required"
                                   name="price" type="text" id="price" value="{{ $product->price }}">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="marca" class="negrita">
                            Seleccione Una marca
                        </label>
                        <select name="trademark" class="form-control">
                            <option selected disabled>
                                Seleccione marca
                            </option>
                            @foreach ($trademarks as $trademark)
                                @if($product->tieneTrademark()->contains($trademark->name))
                                    <option value="{{$trademark->id}}"selected>{{$trademark->name}}</option>
                                @else
                                    <option value="{{$trademark->id}}">{{$trademark->name}}</option>
                                @endif
                            @endforeach
                        </select>
                        @error('trademark')
                        {{$message}}
                        @enderror
                    </div>
                </div>
                <div class="col-sm-5">
                   <div class="form-group">
                       <label for="stock" class="negrita">
                           Cantidad en inventario:
                       </label>
                       <div>
                           <input class="form-control" placeholder="40" required="required"
                                  name="stock" type="text" id="stock" value="{{ $product->stock }}">
                       </div>
                   </div>
                    <div class="form-group">
                        <label for="stock" class="negrita">
                            Talla
                        </label>
                        <div>
                        @foreach  ($sizes as $key => $size)
                            <input type="checkbox"
                                   @if($product->tieneSize()->contains($size->name))
                                   checked @endif
                                   name="size[]" value="{{$size->id}}"/>
                            {{$size->name}}
                        @endforeach
                        </div>
                    </div>
                    @error('size')
                    {{$message}}
                    @enderror

                    <div class="form-group">
                        <label for="img" class="negrita">
                            Seleccione una imagen
                        </label>
                        <div>
                            <input name="img[]" type="file" id="img" multiple="multiple">
                        </div>
                    </div>
                </div>

                <button type="submit" class="btn btn-sm btn-primary btn-block">
                    Guardar
                </button>
                <a href="{{ route('products.index') }}" class="btn btn-sm btn-dark btn-block">
                    Cancelar
                </a>
            </div>
        </div>
    </div>
@else
    <div class="card">
        <div class="card-header">
            Crear producto
            <a href="{{ route('products.index') }}" class="btn btn-success btn-sm float-right">
                Cancelar
            </a>
        </div>
        <div class="container">
            <input type="hidden" value="{{auth()->user()->id}}" name="created_by">
            <div class="row">
                <div class="col-sm-5">
                    <div class="form-group">
                        <label for="name" class="negrita">
                            Nombre
                        </label>
                        <div>
                            <input class="form-control" placeholder="producto" required="required"
                                   name="name" type="text" id="name">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="description" class="negrita">
                            Observaciones
                        </label>
                        <div>
                            <textarea name="description" placeholder="description"  class="form-control"
                                      required="required"  id="description">
                            </textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="price" class="negrita">
                            Precio
                        </label>
                        <div>
                            <input class="form-control" placeholder="price" required="required"
                                   name="price" type="text" id="price">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="stock" class="negrita">
                            Cantidad en inventario
                        </label>
                        <div>
                            <input class="form-control" placeholder="stock" required="required"
                                   name="stock" type="text" id="stock">
                        </div>
                    </div>
                </div>
                <div class="col-sm-5">
                    <div class="form-group">
                        Seleccione una talla
                    <div>
                        @foreach  ($sizes as $key => $size)
                            <input type="checkbox"
                                   name="size[]" value="{{$size->id}}"/>
                            {{$size->name}}
                        @endforeach
                    </div>
                </div>
                @error('size')
                {{$message}}
                @enderror
                <div class="form-group">
                    <label for="stock" class="negrita">
                        Seleccione una marca
                    </label>
                    <select name="trademark[]" class="form-control">
                        <option selected disabled>
                            seleccione una marka
                        </option>
                        @foreach ($trademarks as $trademark )
                            <option value="{{ $trademark->id}}">
                                {{$trademark->name}}
                            </option>
                        @endforeach
                    </select>
                    @error('trademark')
                    {{$message}}
                    @enderror
                </div>

                <div class="form-group">
                    <label for="img" class="negrita">
                        seleccione una imagen
                    </label>
                    <div>
                        <input name="img[]" type="file" id="img" multiple="multiple">
                    </div>
                </div>
                @error('img')
                {{$message}}
                @enderror
            </div>
            <button type="submit" class="btn btn-block btn-primary btn-sm">
                Guardar
            </button>
        </div>
    </div>
@endif

