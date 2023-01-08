<?php declare(strict_types=1);

namespace App\Repositories\Currencies;

use App\Models\Currency;
use Illuminate\Support\Collection;

class LatvianBankCurrencyRepository implements CurrencyRepository
{
    public function all(): Collection
    {
        $url = 'https://www.bank.lv/vk/ecb.xml';
        $xml = simplexml_load_file($url);
        $json = json_encode($xml);
        $array = json_decode($json, true);
        $currencies = $array['Currencies']['Currency'];

        $currenciesCollection = collect($currencies)->map(function ($attributes) {
            return new Currency([
                'symbol' => $attributes['ID'],
                'rate' => $attributes['Rate'],
            ]);
        })->push(new Currency([
            'symbol' => 'EUR',
            'rate' => 1,
        ]))->sortBy('symbol');;

        return $currenciesCollection->values();
    }
}
