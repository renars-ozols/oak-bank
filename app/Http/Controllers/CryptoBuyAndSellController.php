<?php

namespace App\Http\Controllers;

use App\Http\Requests\BuyCryptoRequest;
use App\Http\Requests\SellCryptoRequest;
use App\Services\Crypto\BuyCryptoService;
use App\Services\Crypto\BuyCryptoServiceRequest;
use App\Services\Crypto\SellCryptoService;
use App\Services\Crypto\SellCryptoServiceRequest;
use Illuminate\Http\RedirectResponse;

class CryptoBuyAndSellController extends Controller
{
    private BuyCryptoService $buyCryptoService;
    private SellCryptoService $sellCryptoService;

    public function __construct(BuyCryptoService $buyCryptoService, SellCryptoService $sellCryptoService)
    {
        $this->buyCryptoService = $buyCryptoService;
        $this->sellCryptoService = $sellCryptoService;
    }

    public function buy(BuyCryptoRequest $request, string $id): RedirectResponse
    {
        $this->buyCryptoService->execute(new BuyCryptoServiceRequest(
            $request->validated('account'),
            $id,
            $request->validated('amount'),
        ));
        return redirect()->route('user-cryptos.index');
    }

    public function sell(SellCryptoRequest $request, string $id): RedirectResponse
    {
        $this->sellCryptoService->execute(new SellCryptoServiceRequest(
            $request->validated('account'),
            $id,
            $request->validated('amount'),
        ));
        return redirect()->route('user-cryptos.index');
    }
}
