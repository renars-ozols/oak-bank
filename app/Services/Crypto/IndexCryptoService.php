<?php declare(strict_types=1);

namespace App\Services\Crypto;

use App\Repositories\Crypto\CryptoRepository;

class IndexCryptoService
{
    private CryptoRepository $cryptoRepository;

    public function __construct(CryptoRepository $cryptoRepository)
    {
        $this->cryptoRepository = $cryptoRepository;
    }

    public function execute()
    {
        //TODO: return types
        //TODO: remove this
        return $this->cryptoRepository->all();
        //return $this->cryptoRepository->find('1');
    }
}
