<?php

namespace App\Http\Controllers;

use App\Services\Account\CreateAccountService;
use App\Services\Account\TransferService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class AccountController extends Controller
{
    private CreateAccountService $createAccountService;
    private TransferService $transferService;

    public function __construct(CreateAccountService $createAccountService, TransferService $transferService)
    {
        $this->createAccountService = $createAccountService;
        $this->transferService = $transferService;
    }

    public function create()
    {
        $currencies = $this->createAccountService->execute();
        //dd($currencies);
        return Inertia::render('CreateAccount', ['currencies' => $currencies]);
    }

    public function store(Request $request): RedirectResponse
    {
        $request->user()->accounts()->create($request->all());
        return redirect()->route('dashboard');
    }

    public function createTransfer(Request $request): Response
    {
        $accounts = $request->user()->accounts()->get();
        //dd($accounts);
        return Inertia::render('CreateTransfer', ['accounts' => $accounts]);
    }

    public function transfer(Request $request): RedirectResponse
    {
        $this->transferService->execute($request);
        return redirect()->route('dashboard');
    }
}
