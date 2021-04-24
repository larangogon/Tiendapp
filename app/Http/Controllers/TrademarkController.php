<?php

namespace App\Http\Controllers;

use App\Http\Requests\TrademarkStoreRequest;
use App\Http\Requests\TrademarkUpdateRequest;
use App\Interfaces\InterfaceTrademarks;
use App\Models\Trademark;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class TrademarkController extends Controller
{
    protected $trademarks;


    /**
     * TrademarkController constructor.
     * @param InterfaceTrademarks $trademarks
     */
    public function __construct(InterfaceTrademarks $trademarks)
    {
        $this->trademarks = $trademarks;
        $this->middleware('auth');
        $this->middleware('verified');
        $this->middleware('Status');
    }

    /**
     * @return View
     */
    public function index(): View
    {
        $this->authorize('trademark.index');

        $trademarks = Trademark::all(['id','name', 'code']);

        return view('trademarks.index', [
            'trademarks' => $trademarks
        ]);
    }

    /**
     * @param TrademarkStoreRequest $request
     * @return RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store(TrademarkStoreRequest $request): RedirectResponse
    {
        $this->authorize('trademark.store');
        $this->trademarks->store($request);
        return redirect('trademarks');
    }

    /**
     * @param Trademark $trademark
     * @return RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy(Trademark $trademark): RedirectResponse
    {
        $trademark->destroy($trademark->id);
        return redirect('trademarks');
    }

    /**
     * @param TrademarkUpdateRequest $request
     * @param Trademark $trademark
     * @return RedirectResponse
     */
    public function update(TrademarkUpdateRequest $request, Trademark $trademark): RedirectResponse
    {
        $this->trademarks->update($request, $trademark);

        return redirect('/trademarks')
            ->with('success', 'Editado Satisfactoriamente');
    }

    /**
     * @param Trademark $trademark
     * @return View
     */
    public function edit(Trademark $trademark): View
    {
        return view('trademarks.edit', [
            'trademark' => $trademark,
        ]);
    }

    /**
     * @return View
     */
    public function create(): view
    {
        return view('trademarks.create');
    }
}
