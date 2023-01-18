<?php

namespace App\Http\Controllers;

use App\Http\Requests\TransactionFilterRequest;
use App\Models\Transaction;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function index(TransactionFilterRequest $request)
    {
        //dd($request->all());
        $accounts = auth()->user()->accounts()->get();
        $transactions = Transaction::query()
            ->whereIn('sender_account_id', $accounts->pluck('id'))
            ->orWhereIn('recipient_account_id', $accounts->pluck('id'))
            ->with(['senderAccount:id,user_id,number,name,currency' => [
                'user:id,name',
            ], 'recipientAccount:id,user_id,number,name,currency' => [
                'user:id,name',
            ]])
            ->accountNumber($request->search_account)
            ->recipientName($request->search_name);
        if ($request->start_date && $request->end_date) {
            $transactions->dateRange($request->start_date, $request->end_date);
        }
        $transactions = $transactions->latest()->paginate(5);
        return Inertia::render('Dashboard', ['accounts' => $accounts, 'transactions' => $transactions]);
    }
}
