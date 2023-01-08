<?php declare(strict_types=1);

namespace App\Services\Account;

use App\Models\Account;
use App\Repositories\Currencies\CurrencyRepository;
use Illuminate\Http\Request;

class TransferService
{
    private CurrencyRepository $currencyRepository;

    public function __construct(CurrencyRepository $currencyRepository)
    {
        $this->currencyRepository = $currencyRepository;
    }

    public function execute(Request $request): void
    {
        //TODO: clean up
        //dd($request->all());
        $userAccount = auth()->user()->accounts()->where('id', $request->input('account'))->first();
        $recipientAccount = Account::query()->where('number', $request->input('recipient'))->first();
        $currencies = $this->currencyRepository->all();

        $senderCurrency = $currencies->where('symbol', $userAccount->currency)->first();
        $senderCurrencyRate = $senderCurrency->rate;

        $recipientCurrency = $currencies->where('symbol', $recipientAccount->currency)->first();
        $recipientCurrencyRate = $recipientCurrency->rate;

        $exchangeRate = $recipientCurrencyRate / $senderCurrencyRate;

        //TODO: database transaction
        $userAccount->withdraw((float) $request->input('amount'));
        $recipientAccount->deposit($request->input('amount') * $exchangeRate);

        //TODO: create transaction
    }
}
