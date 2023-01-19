<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAccountRequest;
use App\Repositories\Currencies\CurrencyRepository;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

class AccountController extends Controller
{
    private CurrencyRepository $currencyRepository;

    public function __construct(CurrencyRepository $currencyRepository)
    {
        $this->currencyRepository = $currencyRepository;
    }

    public function create(): Response
    {
        $currencies = $this->currencyRepository->all();
        return Inertia::render('CreateAccount', ['currencies' => $currencies]);
    }

    public function store(StoreAccountRequest $request): RedirectResponse
    {
        $request->user()->accounts()->create($request->validated());
        return redirect()->route('dashboard');
    }
}
