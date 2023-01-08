<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function index()
    {
        $accounts = auth()->user()->accounts()->get();
        //dd($accounts);
        return Inertia::render('Dashboard', ['accounts' => $accounts]);
    }
}
