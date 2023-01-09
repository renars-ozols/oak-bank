<?php declare(strict_types=1);

namespace App\Services\Crypto;

use App\Models\CryptoTransaction;
use App\Models\UserCrypto;
use App\Repositories\Crypto\CryptoRepository;
use Illuminate\Http\Request;

class BuyCryptoService
{
    private CryptoRepository $repository;

    public function __construct(CryptoRepository $repository)
    {
        $this->repository = $repository;
    }

    public function execute(Request $request, string $id)
    {
        //TODO: change request to dto
        $userAccount = auth()->user()->accounts()->where('number', $request->account)->first();
        $crypto = $this->repository->find($id, $userAccount->currency);

        //TODO: wrap in transaction
        $userAccount->withdraw($crypto->price * $request->amount);

        $userCrypto = UserCrypto::firstOrNew([
            'user_id' => auth()->user()->id,
            'crypto_id' => $crypto->id,
            'account_id' => $userAccount->id,
            'name' => $crypto->name,
            'symbol' => $crypto->symbol,
            'logo' => $crypto->logo,
            'currency' => $userAccount->currency,
        ]);
        $userCrypto->amount += $request->amount;
        $userCrypto->save();

        CryptoTransaction::create([
            'user_id' => auth()->user()->id,
            'account_id' => $userAccount->id,
            'crypto_id' => $crypto->id,
            'type' => 'buy',
            'account_number' => $userAccount->number,
            'currency' => $userAccount->currency,
            'crypto_name' => $crypto->name,
            'amount' => $request->amount,
            'crypto_price' => $crypto->price,
            'total' => $crypto->price * $request->amount,
        ]);
    }
}
