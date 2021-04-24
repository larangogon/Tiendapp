<?php

namespace App\Interfaces;


use App\Http\Requests\ProductStoreRequest;
use App\Http\Requests\ProductUpdateRequest;
use App\Models\Product;

interface InterfaceProducts
{
    /**
     * @param ProductStoreRequest $request
     * @return mixed
     */
    public function store(ProductStoreRequest $request);

    /**
     * @param ProductUpdateRequest $request
     * @param Product $product
     * @return mixed
     */
    public function update(ProductUpdateRequest $request, Product $product);

    /**
     * @param Product $product
     * @return mixed
     */
    public function destroy(Product $product);

    /**
     * @param int $id
     * @param Product $product
     * @return mixed
     */
    public function destroyimagen(int $id, Product $product);

    /**
     * @param Product $product
     * @return mixed
     */
    public function active(Product $product);
}
