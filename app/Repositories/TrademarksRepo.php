<?php

namespace App\Repositories;

use App\Http\Requests\TrademarkStoreRequest;
use App\Http\Requests\TrademarkUpdateRequest;
use App\Interfaces\InterfaceTrademarks;
use App\Models\Trademark;


class TrademarksRepo implements InterfaceTrademarks
{
    /**
     * @param TrademarkStoreRequest $request
     */
    public function store(TrademarkStoreRequest $request): void
    {
        Trademark::create($request->all());
    }

    /**
     * @param TrademarkUpdateRequest $request
     * @param Trademark $trademark
     */
    public function update(TrademarkUpdateRequest $request, Trademark $trademark): void
    {
        $trademark->update($request->all());
    }
}
