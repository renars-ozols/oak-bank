<?php

namespace App\Http\Controllers;

use App\Repositories\Crypto\CryptoRepository;
use App\Services\Crypto\IndexCryptoService;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CryptoController extends Controller
{
    private IndexCryptoService $indexCryptoService;
    private CryptoRepository $cryptoRepository;

    public function __construct(IndexCryptoService $indexCryptoService, CryptoRepository $cryptoRepository)
    {
        $this->indexCryptoService = $indexCryptoService;
        $this->cryptoRepository = $cryptoRepository;
    }

    public function index()
    {
        $cryptos = $this->indexCryptoService->execute();
        //dd($cryptos);
        return Inertia::render('CryptoIndex', [
            'cryptos' => $cryptos,
        ]);
    }

    public function show($id)
    {
        $currency = request()->query('currency', 'EUR');
        //dd($currency);
        $crypto = $this->cryptoRepository->find($id, $currency);
        //dd($crypto);
        //auth user accounts with balance > 0
        $accounts = auth()->user()->accounts()->where('balance', '>', 0)->get();
        return Inertia::render('ShowCrypto', [
            'crypto' => $crypto,
            'accounts' => $accounts,
        ]);
    }
}
