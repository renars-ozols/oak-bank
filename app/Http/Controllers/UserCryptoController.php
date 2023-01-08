<?php

namespace App\Http\Controllers;

use App\Services\Crypto\IndexUserCryptoService;
use Illuminate\Http\Request;
use Inertia\Inertia;

class UserCryptoController extends Controller
{
    private IndexUserCryptoService $indexUserCryptoService;

    public function __construct(IndexUserCryptoService $indexUserCryptoService)
    {
        $this->indexUserCryptoService = $indexUserCryptoService;
    }

    public function index()
    {
        //select only account number
//        $cryptos = auth()->user()->cryptos()
//            ->select('user_cryptos.*', 'accounts.number as account')
//            ->join('accounts', 'accounts.id', '=', 'user_cryptos.account_id')
//            ->get();
        $cryptos = $this->indexUserCryptoService->execute(auth()->id());
        return Inertia::render('CryptoPortfolio', [
            'cryptos' => $cryptos,
        ]);
    }
}
