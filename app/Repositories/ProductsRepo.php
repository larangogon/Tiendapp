<?php

namespace App\Repositories;

use App\Http\Requests\ProductStoreRequest;
use App\Http\Requests\ProductUpdateRequest;
use App\Interfaces\InterfaceProducts;
use App\Models\Imagen;
use App\Models\Product;
use Illuminate\Support\Facades\Storage;

class ProductsRepo implements InterfaceProducts
{
    /**
     * @param ProductStoreRequest $request
     */
    public function store(ProductStoreRequest $request): void
    {
        $product = Product::create($request->all());

        $product->asignarTrademark($request->get('trademark'));
        $product->asignarSize($request->get('size'));

        $files = $request->file('img');
        $product->asignarImagen($files, $product->id);
    }

    /**
     * @param ProductUpdateRequest $request
     * @param Product $product
     */
    public function update(ProductUpdateRequest $request, Product $product): void
    {
        $product->update($request->all());
        $product->trademarks()->sync($request->get('trademark'));
        $product->sizes()->sync($request->get('size'));

        $files = $request->file('img');
        $product->asignarImagen($files, $product->id);
    }

    /**
     * @param Product $product
     */
    public function destroy(Product $product): void
    {
        $product->destroy($product->id);
    }

    /**
     * @param int $id
     * @param Product $product
     */
    public function destroyimagen(int $id, Product $product): void
    {
        $imagen = Imagen::find($id);

        Storage::delete(public_path('uploads/') . $imagen->name);

        $imagen->delete();
    }

    /**
     * @param Product $product
     */
    public function active(Product $product): void
    {;
        $state = $product->active;
        $product->active = !$state;

        $product->update();
    }
}
