<?php declare(strict_types=1);

namespace App\Services\Crypto;

class BuyCryptoServiceRequest
{
    private string $account;
    private string $coinId;
    private float $amount;

    public function __construct(string $account, string $coinId, float $amount)
    {
        $this->account = $account;
        $this->coinId = $coinId;
        $this->amount = $amount;
    }

    public function getAccount(): string
    {
        return $this->account;
    }

    public function getCoinId(): string
    {
        return $this->coinId;
    }

    public function getAmount(): float
    {
        return $this->amount;
    }
}
