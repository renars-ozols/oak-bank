<?php

namespace App\Providers;

use App\Repositories\Crypto\CoinMarketCapApiCryptoRepository;
use App\Repositories\Crypto\CryptoRepository;
use App\Repositories\Currencies\CurrencyRepository;
use App\Repositories\Currencies\LatvianBankCurrencyRepository;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(CurrencyRepository::class, LatvianBankCurrencyRepository::class);
        $this->app->bind(CryptoRepository::class, CoinMarketCapApiCryptoRepository::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Http::macro('crypto', function () {
            return Http::acceptJson()->withHeaders([
                'X-CMC_PRO_API_KEY' => env('COINMARKETCAP_API_KEY'),
            ])->baseUrl('https://pro-api.coinmarketcap.com/');
        });
    }
}
