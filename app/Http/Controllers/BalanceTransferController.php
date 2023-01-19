<?php

namespace App\Http\Controllers;

use App\Http\Requests\BalanceTransferRequest;
use App\Services\Account\TransferService;
use App\Services\Account\TransferServiceRequest;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

class BalanceTransferController extends Controller
{
    private TransferService $transferService;

    public function __construct(TransferService $transferService)
    {
        $this->transferService = $transferService;
    }

    public function showForm(): Response
    {
        $accounts = auth()->user()->accounts()->get();
        return Inertia::render('CreateTransfer', ['accounts' => $accounts]);
    }

    public function transfer(BalanceTransferRequest $request): RedirectResponse
    {
        $this->transferService->execute(new TransferServiceRequest(
            $request->validated('account'),
            $request->validated('recipient'),
            $request->validated('amount')
        ));
        return redirect()->route('dashboard');
    }
}
