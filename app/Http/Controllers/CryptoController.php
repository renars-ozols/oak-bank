<?php

namespace App\Http\Controllers;

use App\Repositories\Crypto\CryptoRepository;
use Inertia\Inertia;

class CryptoController extends Controller
{
    private CryptoRepository $cryptoRepository;

    public function __construct(CryptoRepository $cryptoRepository)
    {
        $this->cryptoRepository = $cryptoRepository;
    }

    public function index()
    {
        $cryptos = $this->cryptoRepository->all();
        return Inertia::render('CryptoIndex', [
            'cryptos' => $cryptos,
        ]);
    }

    public function show($id)
    {
        $currency = request()->query('currency', 'EUR');
        $crypto = $this->cryptoRepository->find($id, $currency);
        $accounts = auth()->user()->accounts()->where('balance', '>', 0)->get();
        $accountsWithCrypto = auth()->user()->accounts()->whereHas('cryptos', function ($query) use ($id) {
            $query->where('crypto_id', $id);
        })->with('cryptos')->get();

        return Inertia::render('ShowCrypto', [
            'crypto' => $crypto,
            'accounts' => $accounts,
            'accountsWithCrypto' => $accountsWithCrypto,
        ]);
    }
}
