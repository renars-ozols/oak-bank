<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAccountRequest;
use App\Http\Requests\TransactionFilterRequest;
use App\Models\Account;
use App\Models\Transaction;
use App\Repositories\Currencies\CurrencyRepository;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class AccountController extends Controller
{
    private CurrencyRepository $currencyRepository;

    public function __construct(CurrencyRepository $currencyRepository)
    {
        $this->currencyRepository = $currencyRepository;
    }

    public function index(TransactionFilterRequest $request)
    {
        $accounts = auth()->user()->accounts()->get();
        $transactions = Transaction::query()
            ->whereIn('sender_account_id', $accounts->pluck('id'))
            ->orWhereIn('recipient_account_id', $accounts->pluck('id'))
            ->with(['senderAccount:id,user_id,number,name,currency' => [
                'user:id,name',
            ], 'recipientAccount:id,user_id,number,name,currency' => [
                'user:id,name',
            ]])
            ->accountNumber($request->validated('search_account'))
            ->recipientName($request->validated('search_name'));
        if ($request->start_date && $request->end_date) {
            $transactions->dateRange($request->validated('start_date'), $request->validated('end_date'));
        }

        $transactions = $transactions->latest()->paginate(5);
        return Inertia::render('AccountsIndex', ['accounts' => $accounts, 'transactions' => $transactions]);
    }

    public function create(): Response
    {
        $currencies = $this->currencyRepository->all();
        return Inertia::render('CreateAccount', ['currencies' => $currencies]);
    }

    public function store(StoreAccountRequest $request): RedirectResponse
    {
        $request->user()->accounts()->create($request->validated());
        return redirect()->route('accounts.index');
    }

    public function edit(Account $account): Response
    {
        return Inertia::render('EditAccount', ['account' => $account]);
    }

    public function update(Request $request, Account $account): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:15',
        ]);
        $account->update($validated);
        return redirect()->route('accounts.index');
    }
}
