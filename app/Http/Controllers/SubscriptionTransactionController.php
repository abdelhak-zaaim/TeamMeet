<?php

namespace App\Http\Controllers;

use App\Models\UserTransaction;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class SubscriptionTransactionController extends Controller
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
        return view('subscription_transactions.index');
    }

    /**
     * @return Application|Factory|View|RedirectResponse
     */
    public function show(UserTransaction $userTransaction)
    {
        if (getLogInUser()->hasRole('user') && getLogInUserId() !== $userTransaction->user_id) {
            return redirect()->back();
        }

        return view('subscription_transactions.show', compact('userTransaction'));
    }
}
