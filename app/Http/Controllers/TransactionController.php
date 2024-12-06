<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     *
     * @throws Exception
     */
    public function index(): \Illuminate\View\View
    {
        return view('transactions.index');
    }

    /**
     * @return Application|Factory|View|RedirectResponse
     */
    public function show(Transaction $transaction)
    {
        if (getLogInUser()->hasRole('user') && getLogInUserId() !== $transaction->user_id) {
            return redirect()->back();
        }

        return view('transactions.show', compact('transaction'));
    }
}
