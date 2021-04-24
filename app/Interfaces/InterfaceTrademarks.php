<?php

namespace App\Interfaces;

use App\Http\Requests\TrademarkStoreRequest;
use App\Http\Requests\TrademarkUpdateRequest;
use App\Models\Trademark;

interface InterfaceTrademarks
{
    /**
     * @param TrademarkStoreRequest $request
     * @return mixed
     */
    public function store(TrademarkStoreRequest $request);

    /**
     * @param TrademarkUpdateRequest $request
     * @param Trademark $trademark
     * @return mixed
     */
    public function update(TrademarkUpdateRequest $request, Trademark $trademark);
}
