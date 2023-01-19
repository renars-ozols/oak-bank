<?php declare(strict_types=1);

namespace App\Services\Account;

class TransferServiceRequest
{
    private string $account;
    private string $recipientAccount;
    private float $amount;

    public function __construct(string $account, string $recipientAccount, float $amount)
    {
        $this->account = $account;
        $this->recipientAccount = $recipientAccount;
        $this->amount = $amount;
    }

    public function getAccount(): string
    {
        return $this->account;
    }

    public function getRecipient(): string
    {
        return $this->recipientAccount;
    }

    public function getAmount(): float
    {
        return $this->amount;
    }
}
