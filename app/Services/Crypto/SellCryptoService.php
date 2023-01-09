<?php declare(strict_types=1);

namespace App\Services\Crypto;

use App\Models\CryptoTransaction;
use App\Repositories\Crypto\CryptoRepository;
use Illuminate\Http\Request;

class SellCryptoService
{
    private CryptoRepository $repository;

    public function __construct(CryptoRepository $repository)
    {
        $this->repository = $repository;
    }

    public function execute(Request $request, string $id): void
    {
        //TODO: change request to dto
        //dd($request->all(), $id);
        $userAccount = auth()->user()->accounts()->where('number', $request->account)->first();
        // user crypto from this account
        $userCrypto = auth()->user()->cryptos()->where('account_id', $userAccount->id)->where('crypto_id', $id)->first();
        $cryptoPrice = $this->repository->getCurrentPrice($id, $userAccount->currency);
        //dd($userCrypto, $cryptoPrice);
        //TODO: wrap in transaction
        $userAccount->deposit($cryptoPrice * $request->amount);
        $userCrypto->amount -= $request->amount;
        //delete if amount is 0
        //dd($userCrypto);
        if ($userCrypto->amount == 0) {
            $userCrypto->delete();
        } else {
            $userCrypto->save();
        }
        //create transaction
        CryptoTransaction::create([
            'user_id' => auth()->user()->id,
            'account_id' => $userAccount->id,
            'crypto_id' => $id,
            'type' => 'sell',
            'account_number' => $userAccount->number,
            'currency' => $userAccount->currency,
            'crypto_name' => $userCrypto->name,
            'amount' => $request->amount,
            'crypto_price' => $cryptoPrice,
            'total' => $cryptoPrice * $request->amount,
        ]);
    }
}
