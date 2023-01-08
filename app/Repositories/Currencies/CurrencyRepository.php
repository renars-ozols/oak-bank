<?php declare(strict_types=1);

namespace App\Repositories\Currencies;

use Illuminate\Support\Collection;

interface CurrencyRepository
{
    public function all(): Collection;
}
