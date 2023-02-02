<?php

namespace App\Http\Controllers;

use App\Repositories\Crypto\CryptoRepository;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class SearchCryptoController extends Controller
{
    private CryptoRepository $repository;

    public function __construct(CryptoRepository $repository)
    {
        $this->repository = $repository;
    }

    public function search(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'search' => 'required|string',
        ]);

        try {
            $id = $this->repository->findIdBySymbol($validated['search']);
            return redirect()->route('crypto.show', ['id' => $id]);
        } catch (\Exception $e) {
            abort(404);
        }
    }
}
