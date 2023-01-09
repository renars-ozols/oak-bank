<?php declare(strict_types=1);

namespace App\Services\Crypto;

use App\Models\CryptoTransaction;
use App\Models\UserCrypto;
use App\Repositories\Crypto\CryptoRepository;
use Illuminate\Support\Collection;

class IndexUserCryptoService
{
    public function __construct(CryptoRepository $repository)
    {
        $this->repository = $repository;
    }

    public function execute(string $userId): Collection
    {
        //TODO: types
        //dd($userId);
        //select only account number
        $cryptos = UserCrypto::where('user_cryptos.user_id', $userId)
            ->select('user_cryptos.*', 'accounts.number as account')
            ->join('accounts', 'accounts.id', '=', 'user_cryptos.account_id')
            ->get();

        //dd($cryptos);
        //dd($ids, $currencies);
        // get the current price for each crypto
        $cryptos->map(function ($crypto) {
            $crypto->current_price = $this->repository->getCurrentPrice($crypto->crypto_id, $crypto->currency);
            return $crypto;
        });

        $transactions = CryptoTransaction::where('user_id', $userId)->get();
        //dd($transactions);

        return collect([
            'cryptos' => $cryptos,
            'transactions' => $transactions,
        ]);
    }
}
