<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;

class UserSubscriptionTransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     */
    public function index(): \Illuminate\View\View
    {
        return view('transactions.index');
    }

    /**
     * @return Application|Factory|View
     */
    public function show(Transaction $transaction)
    {
        if (getLogInUserId() !== $transaction->user_id) {
            return redirect()->back();
        }

        return view('transactions.show', compact('transaction'));
    }
}
