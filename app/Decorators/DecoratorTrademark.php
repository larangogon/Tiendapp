<?php

namespace App\Decorators;

use App\Http\Requests\TrademarkStoreRequest;
use App\Http\Requests\TrademarkUpdateRequest;
use App\Models\Trademark;
use App\Repositories\TrademarksRepo;
use App\Interfaces\InterfaceTrademarks;
use Illuminate\Support\Facades\Cache;

class DecoratorTrademark implements InterfaceTrademarks
{
    private $trademarksRepo;

    /**
     * DecoratorTrademark constructor.
     * @param TrademarksRepo $trademarksRepo
     */
    public function __construct(TrademarksRepo $trademarksRepo)
    {
        $this->trademarksRepo = $trademarksRepo;
    }

    /**
     * @param TrademarkStoreRequest $request
     */
    public function store(TrademarkStoreRequest $request): void
    {
        $this->trademarksRepo->store($request);

        Cache::tags('trademarks')->flush();
    }

    /**
     * @param TrademarkUpdateRequest $request
     * @param Trademark $trademark
     */
    public function update(TrademarkUpdateRequest $request, Trademark $trademark): void
    {
        $this->trademarksRepo->update($request, $trademark);

        Cache::tags('trademark')->flush();
    }
}
