<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function index()
    {
        $accounts = auth()->user()->accounts()->get();
        // all transactions for user each account
        $ids = $accounts->pluck('id');
        //dd($ids);
        $transactions = Transaction::query()
            //TODO: test this
            ->whereIn('sender_account_id', $accounts->pluck('id'))
            ->orWhereIn('recipient_account_id', $accounts->pluck('id'))
            ->with(['senderAccount:id,user_id,number,name,currency' => [
                'user:id,name',
            ], 'recipientAccount:id,user_id,number,name,currency' => [
                'user:id,name',
            ]])
            ->latest()
            ->get();
        //dd($transactions);
        return Inertia::render('Dashboard', ['accounts' => $accounts, 'transactions' => $transactions]);
    }
}
