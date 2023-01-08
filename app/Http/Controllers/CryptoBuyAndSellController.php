<?php

namespace App\Http\Controllers;

use App\Services\Crypto\BuyCryptoService;
use Illuminate\Http\Request;

class CryptoBuyAndSellController extends Controller
{
    public function __construct(BuyCryptoService $buyCryptoService)
    {
        $this->buyCryptoService = $buyCryptoService;
    }

    public function buy(Request $request, string $id)
    {
        //TODO: implement buy crypto
        //TODO: change request to dto
        //TODO: add validation
        //TODO: return type, redirect after execute
        $this->buyCryptoService->execute($request, $id);
    }
}
