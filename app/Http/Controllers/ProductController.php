<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductStoreRequest;
use App\Http\Requests\ProductUpdateRequest;
use App\Interfaces\InterfaceProducts;
use App\Models\Imagen;
use App\Models\Product;
use App\Models\Size;
use App\Models\Trademark;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\Session;

class ProductController extends Controller
{
    protected $products;

    /**
     * ProductsController constructor.
     * @param InterfaceProducts $products
     */
    public function __construct(InterfaceProducts $products)
    {
        $this->products = $products;
        $this->middleware('auth');
        $this->middleware('Status');
        $this->middleware('verified');
    }

    /**
     * @param Request $request
     * @return View
     */
    public function index(Request $request): View
    {
        $this->authorize('product.index');

        $query = trim($request->get('search'));

        $products = Product::where('name', 'LIKE', '%' . $query . '%')
            ->orwhere('stock', 'LIKE', '%' . $query . '%')
            ->orwhere('id', 'LIKE', '%' . $query . '%')
            ->orderBy('id', 'asc')
            ->paginate(15);

        return view('products.index', [
            'products' => $products,
            'search'   => $query
        ]);
    }

    /**
     * @return View
     */
    public function create(): View
    {
        $this->authorize('product.create');

        $trademarks = Trademark::all(['id','name']);
        $sizes      = Size::all(['id','name']);
        $imagens   = Imagen::all(['id','name']);

        return view('products.create', [
            'trademarks' => $trademarks,
            'sizes'      => $sizes,
            'imagens'   => $imagens,
        ]);
    }

    /**
     * @param ProductStoreRequest $request
     * @return RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store(ProductStoreRequest $request): RedirectResponse
    {
        $this->authorize('product.store');

        $this->products->store($request);

        return redirect('/products')
            ->with('success', 'producto Creado Satisfactoriamente');
    }

    /**
     * @param Product $product
     * @return View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function show(Product $product): View
    {
        $this->authorize('product.show');

        return view('products.show', compact('product'));
    }

    /**
     * @param Product $product
     * @return View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function edit(Product $product): View
    {
        $this->authorize('product.edit');
        $trademarks = Trademark::all(['id','name']);
        $sizes      = Size::all(['id','name']);

        return view('products.edit', [
            'product'    => $product,
            'trademarks' => $trademarks,
            'sizes'      => $sizes,
        ]);
    }

    /**
     * @param ProductUpdateRequest $request
     * @param Product $product
     * @return RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(ProductUpdateRequest $request, Product $product): RedirectResponse
    {
        $this->authorize('product.update');

        $this->products->update($request, $product);

        return redirect('/products')
            ->with('success', 'Producto Editado Satisfactoriamente');
    }

    /**
     * @param Product $product
     * @return RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy(Product $product): RedirectResponse
    {
        $this->authorize('product.destroy');
        $this->products->destroy($product);

        return Redirect('/products')
            ->with('success', 'Eliminado Satisfactoriamente !');
    }

    /**
     * @param int $id
     * @param Product $product
     * @return RedirectResponse
     */
    public function destroyimagen(int $id, Product $product): RedirectResponse
    {
        $this->authorize('product.destroy');

        $this->products->destroyimagen($id, $product);

        return redirect()->back()
            ->with('success', 'Imagen Eliminada Satisfactoriamente !');
    }

    /**
     * @param Product $product
     * @return RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function active(Product $product): RedirectResponse
    {
        $this->authorize('product.status');

        $this->products->active($product);

        Session::flash('message', 'Estatus del producto Editado Satisfactoriamente !');

        return redirect('/products');
    }
}
