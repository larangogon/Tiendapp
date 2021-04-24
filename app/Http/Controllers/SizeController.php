<?php

namespace App\Http\Controllers;

use App\Models\Size;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SizeController extends Controller
{
    /**
     * SizeController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('verified');
        $this->middleware('Status');
    }

    /**
     * @return View
     */
    public function index(): View
    {
        $this->authorize('size.index');

        $sizes = Size::all(['id','name']);

        return view('sizes.index', [
            'sizes' => $sizes
        ]);
    }

    /**
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        $this->authorize('size.store');

        $size = Size::create($request->all());

        return redirect('sizes');
    }
}
