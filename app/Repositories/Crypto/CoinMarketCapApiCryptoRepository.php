<?php declare(strict_types=1);

namespace App\Repositories\Crypto;

use App\Models\Crypto;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;

class CoinMarketCapApiCryptoRepository implements CryptoRepository
{
    public function all(): Collection
    {
        // TODO: Implement all() method.
        // TODO: return types
        $currency = 'EUR';
        $response = Http::crypto()->get('v1/cryptocurrency/listings/latest', [
            'limit' => '10',
            'convert' => $currency,
        ])->json();
        //dd($response);
        $logos = $this->getLogos($response['data']);
        //dd($logos);
        //dd($response['data']);
        return collect($response['data'])->map(function ($crypto) use ($currency, $logos) {
            $crypto['logo'] = $logos[$crypto['id']]['logo'];
            return $this->buildModel($crypto, $currency);
        });
    }

    public function find(string $id, string $currency): Crypto
    {
        // TODO: Implement find() method.
        $response = Http::crypto()->get('v2/cryptocurrency/quotes/latest', [
            'id' => $id,
            'convert' => $currency,
        ])->json();

        $coin = $response['data'][$id];

        $logo = Http::crypto()->get('v2/cryptocurrency/info', [
            'id' => $id,
        ])->json();

        $coin['logo'] = $logo['data'][$id]['logo'];

        return $this->buildModel($coin, $currency);
    }

    public function getCurrentPrice(string $id, string $currency): float
    {
        // TODO: Implement getCurrentPrice() method.
        $response = Http::crypto()->get('v2/cryptocurrency/quotes/latest', [
            'id' => $id,
            'convert' => $currency,
        ])->json();
        // return current price
        return $response['data'][$id]['quote'][$currency]['price'];
    }

    private function buildModel(array $data, string $currency): Crypto
    {
        return new Crypto([
            'id' => $data['id'],
            'name' => $data['name'],
            'symbol' => $data['symbol'],
            'currency' => $currency,
            'price' => $data['quote'][$currency]['price'],
            'logo' => $data['logo'],
            'percentChange1h' => $data['quote'][$currency]['percent_change_1h'],
            'percentChange24h' => $data['quote'][$currency]['percent_change_24h'],
            'percentChange7d' => $data['quote'][$currency]['percent_change_7d'],
        ]);
    }

    private function getLogos(mixed $data)
    {
        $ids = [];
        foreach ($data as $coin) {
            $ids[] = $coin['id'];
        }
        $logos = Http::crypto()->get('v2/cryptocurrency/info', [
            'id' => implode(',', $ids),
        ])->json();
        return $logos['data'];
    }
}
