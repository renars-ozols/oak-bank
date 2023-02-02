<?php declare(strict_types=1);

namespace App\Services\Crypto;

use App\Models\Account;
use App\Models\CryptoTransaction;
use App\Repositories\Crypto\CryptoRepository;
use Illuminate\Support\Facades\DB;

class BuyCryptoService
{
    private CryptoRepository $repository;

    public function __construct(CryptoRepository $repository)
    {
        $this->repository = $repository;
    }

    public function execute(BuyCryptoServiceRequest $request): void
    {
        $userAccount = Account::query()->where('number', $request->getAccount())->first();
        $crypto = $this->repository->find($request->getCoinId(), $userAccount->currency);

        DB::transaction(function () use ($userAccount, $crypto, $request) {
            $userAccount->withdraw($crypto->price * $request->getAmount());

            $userCrypto = $userAccount->cryptos()->firstOrNew([
                'crypto_id' => $crypto->id,
                'name' => $crypto->name,
                'symbol' => $crypto->symbol,
                'logo' => $crypto->logo,
                'currency' => $userAccount->currency,
            ]);
            $userCrypto->user_id = $userAccount->user_id;
            $userCrypto->amount += $request->getAmount();
            $userCrypto->save();

            //create transaction

            $transaction = new CryptoTransaction();
            $transaction->crypto_id = $crypto->id;
            $transaction->type = 'buy';
            $transaction->currency = $userAccount->currency;
            $transaction->crypto_name = $crypto->name;
            $transaction->amount = $request->getAmount();
            $transaction->crypto_price = $crypto->price;
            $transaction->total = $crypto->price * $request->getAmount();
            $transaction->account_number = $userAccount->number;
            $transaction->user()->associate($userAccount->user);
            $transaction->account()->associate($userAccount);
            $transaction->userCrypto()->associate($userCrypto);
            $transaction->save();
        });
    }
}
