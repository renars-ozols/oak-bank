<?php declare(strict_types=1);

namespace App\Services\Account;

use App\Models\Account;
use App\Models\Transaction;
use App\Repositories\Currencies\CurrencyRepository;
use Illuminate\Support\Facades\DB;

class TransferService
{
    private CurrencyRepository $currencyRepository;

    public function __construct(CurrencyRepository $currencyRepository)
    {
        $this->currencyRepository = $currencyRepository;
    }

    public function execute(TransferServiceRequest $request): void
    {
        $userAccount = Account::query()->where('number', $request->getAccount())->first();
        $recipientAccount = Account::query()->where('number', $request->getRecipient())->first();
        $currencies = $this->currencyRepository->all();

        $senderCurrency = $currencies->where('symbol', $userAccount->currency)->first();
        $senderCurrencyRate = $senderCurrency->rate;

        $recipientCurrency = $currencies->where('symbol', $recipientAccount->currency)->first();
        $recipientCurrencyRate = $recipientCurrency->rate;

        $exchangeRate = $recipientCurrencyRate / $senderCurrencyRate;

        DB::transaction(function () use ($userAccount, $recipientAccount, $request, $exchangeRate) {
            $userAccount->withdraw($request->getAmount());
            $recipientAccount->deposit($request->getAmount() * $exchangeRate);

            Transaction::query()->create([
                'sender_account_id' => $userAccount->id,
                'recipient_account_id' => $recipientAccount->id,
                'amount' => $request->getAmount() * $exchangeRate,
            ]);
        });
    }
}
