<?php

namespace App\Http\Controllers;

use App\Http\Requests\CryptoTransactionFilterRequest;
use App\Repositories\Crypto\CryptoRepository;
use Inertia\Inertia;

class UserCryptoController extends Controller
{
    private CryptoRepository $repository;

    public function __construct(CryptoRepository $repository)
    {
        $this->repository = $repository;
    }

    public function index(CryptoTransactionFilterRequest $request)
    {
        $cryptos = auth()->user()->cryptos()->get()->map(function ($crypto) {
            $crypto->account = $crypto->account()->pluck('name')->first();
            $crypto->current_price = $this->repository->getCurrentPrice($crypto->crypto_id, $crypto->currency);
            $crypto->current_value = $crypto->current_price * $crypto->amount;
            $crypto->average_price = $crypto->transactions()->where('type', 'buy')->avg('crypto_price');
            return $crypto;
        });

        $transactions = auth()->user()->cryptoTransactions()->accountNumber($request->validated('search_account'))
            ->cryptoName($request->validated('search_crypto'));
        if ($request->start_date && $request->end_date) {
            $transactions->dateRange($request->validated('start_date'), $request->validated('end_date'));
        }
        $transactions = $transactions->latest()->paginate(5);

        return Inertia::render('CryptoPortfolio', [
            'cryptos' => $cryptos,
            'transactions' => $transactions,
        ]);
    }
}
