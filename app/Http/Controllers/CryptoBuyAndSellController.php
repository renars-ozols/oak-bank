<?php

namespace App\Http\Controllers;

use App\Services\Crypto\BuyCryptoService;
use App\Services\Crypto\SellCryptoService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class CryptoBuyAndSellController extends Controller
{
    private BuyCryptoService $buyCryptoService;
    private SellCryptoService $sellCryptoService;

    public function __construct(BuyCryptoService $buyCryptoService, SellCryptoService $sellCryptoService)
    {
        $this->buyCryptoService = $buyCryptoService;
        $this->sellCryptoService = $sellCryptoService;
    }

    public function buy(Request $request, string $id): RedirectResponse
    {
        //TODO: implement buy crypto
        //TODO: change request to dto
        //TODO: add validation
        //TODO: return type, redirect after execute
        $this->buyCryptoService->execute($request, $id);
        return redirect()->route('user-cryptos.index');
    }

    public function sell(Request $request, string $id): RedirectResponse
    {
        //TODO: implement sell crypto
        //TODO: change request to dto
        //TODO: add validation
        //TODO: return type, redirect after execute
        $this->sellCryptoService->execute($request, $id);
        return redirect()->route('user-cryptos.index');
    }
}
