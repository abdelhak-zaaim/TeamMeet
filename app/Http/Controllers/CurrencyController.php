<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateCurrencyRequest;
use App\Http\Requests\UpdateCurrencyRequest;
use App\Models\Currency;
use App\Models\Setting;
use App\Models\SubscriptionPlan;
use App\Repositories\CurrencyRepository;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;

class CurrencyController extends AppBaseController
{
    /** @var CurrencyRepository */
    private $currencyRepository;

    public function __construct(CurrencyRepository $currencyRepo)
    {
        $this->currencyRepository = $currencyRepo;
    }

    /**
     * Display a listing of the Currency.
     *
     * @return Application|Factory|View
     */
    public function index(): \Illuminate\View\View
    {
        return view('currencies.index');
    }

    /**
     * Store a newly created Currency in storage.
     */
    public function store(CreateCurrencyRequest $request): JsonResponse
    {
        $input = $request->all();
        $this->currencyRepository->store($input);

        return $this->sendSuccess(__('messages.currency.currency_created_successfully'));
    }

    public function edit(Currency $currency): JsonResponse
    {
        return $this->sendResponse($currency, __('messages.currency.currency_retrieved_successfully'));
    }

    /**
     * Update the specified Currency in storage.
     */
    public function update(UpdateCurrencyRequest $request, Currency $currency): JsonResponse
    {
        $input = $request->all();
        $this->currencyRepository->update($input, $currency->id);

        return $this->sendSuccess(__('messages.currency.currency_updated_successfully'));
    }

    /**
     * Remove the specified Currency from storage.
     */
    public function destroy(Currency $currency): JsonResponse
    {
        $checkRecord = Setting::where('key', 'currency')->first()->value;
        $currencyExist = SubscriptionPlan::whereCurrency($currency->currency_code)->exists();

        if (($checkRecord == $currency->id) || $currencyExist) {
            return $this->sendError(__('messages.currency.currency_used_somewhere_else'));
        }

        if ($currency->is_default) {
            return $this->sendError(__('messages.currency.default_currency_can_not_be_deleted'));
        }

        $currency->delete();

        return $this->sendSuccess(__('messages.currency.currency_deleted_successfully'));
    }
}
