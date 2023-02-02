<?php declare(strict_types=1);

namespace App\Services\Crypto;

use App\Models\Account;
use App\Models\CryptoTransaction;
use App\Repositories\Crypto\CryptoRepository;
use Illuminate\Support\Facades\DB;

class SellCryptoService
{
    private CryptoRepository $repository;

    public function __construct(CryptoRepository $repository)
    {
        $this->repository = $repository;
    }

    public function execute(SellCryptoServiceRequest $request): void
    {
        $userAccount = Account::query()->where('number', $request->getAccount())->first();
        $userCrypto = $userAccount->cryptos()->where('account_id', $userAccount->id)->where('crypto_id', $request->getCoinId())->first();
        $cryptoPrice = $this->repository->getCurrentPrice($request->getCoinId(), $userAccount->currency);

        DB::transaction(function () use ($userAccount, $userCrypto, $cryptoPrice, $request) {
            $userAccount->deposit($cryptoPrice * $request->getAmount());
            $userCrypto->amount -= $request->getAmount();

            if ($userCrypto->amount == 0) {
                $userCrypto->delete();
            } else {
                $userCrypto->save();
            }

            $transaction = new CryptoTransaction();
            $transaction->crypto_id = $userCrypto->crypto_id;
            $transaction->type = 'sell';
            $transaction->currency = $userAccount->currency;
            $transaction->crypto_name = $userCrypto->name;
            $transaction->amount = $request->getAmount();
            $transaction->crypto_price = $cryptoPrice;
            $transaction->total = $cryptoPrice * $request->getAmount();
            $transaction->account_number = $userAccount->number;
            $transaction->user()->associate($userAccount->user);
            $transaction->account()->associate($userAccount);
            $transaction->userCrypto()->associate($userCrypto);
            $transaction->save();
        });
    }
}
