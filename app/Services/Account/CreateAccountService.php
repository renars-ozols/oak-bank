<?php declare(strict_types=1);

namespace App\Services\Account;

use App\Repositories\Currencies\CurrencyRepository;
use Illuminate\Support\Collection;

class CreateAccountService
{
    private CurrencyRepository $repository;

    public function __construct(CurrencyRepository $repository)
    {
        $this->repository = $repository;
    }

    public function execute(): Collection
    {
        //TODO: remove this service
        return $this->repository->all();
    }
}
