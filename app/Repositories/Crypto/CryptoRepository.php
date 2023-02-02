<?php declare(strict_types=1);

namespace App\Repositories\Crypto;

use App\Models\Crypto;
use Illuminate\Support\Collection;

interface CryptoRepository
{
    public function all(): Collection;

    public function find(string $id, string $currency): Crypto;

    public function findIdBySymbol(string $symbol): int;

    public function getCurrentPrice(string $id, string $currency): float;
}
