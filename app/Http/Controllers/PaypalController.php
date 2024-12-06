<?php

namespace App\Http\Controllers;

use App\Models\EventSchedule;
use App\Models\Transaction;
use App\Models\User;
use App\Repositories\ScheduleEventRepository;
use Exception;
use Flash;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use Srmklive\PayPal\Services\PayPal as PayPalClient;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;
use Throwable;

class PaypalController extends Controller
{
    /**
     * @throws Throwable
     */
    public function onBoard(Request $request): JsonResponse
    {
        if (! in_array(strtoupper(getCurrencyCode()), getPayPalSupportedCurrencies())) {
            Flash::error(__('messages.success_message.currency_not_supported'));
            $scheduleEvent = EventSchedule::findOrFail($request->get('scheduleEventId'));
            $scheduleEvent->delete();
            return response()->json(['url' => route('events.index')]);
        }

        $scheduleEventId = $request->get('scheduleEventId');
        $scheduleEvent = EventSchedule::findOrFail($scheduleEventId);
        $userId = $scheduleEvent->user_id;
        Session::put('user_id', $userId);

        if (empty(paypalClientID($userId)) || empty(paypalClientID($userId)) || empty(paypalClientSecret($userId))) {
            Flash::error(__('messages.error.set_paypal_credentials'));
            $scheduleEvent = EventSchedule::findOrFail($request->get('scheduleEventId'));
            $scheduleEvent->delete();
            return response()->json(['url' => route('events.index')]);
        }

        config([
            'paypal.mode' => ! empty(paypalMode($userId)) ? paypalMode($userId) : 'sandbox',
            'paypal.sandbox.client_id' => paypalClientID($userId),
            'paypal.sandbox.client_secret' => paypalClientSecret($userId),
            'paypal.live.client_id' => paypalClientID($userId),
            'paypal.live.client_secret' => paypalClientSecret($userId),
        ]);

        try {
            $provider = new PayPalClient();
            $provider->getAccessToken();

            $data = [
                'intent' => 'CAPTURE',
                'purchase_units' => [
                    [
                        'reference_id' => $scheduleEvent->id,
                        'amount' => [
                            'value' => $scheduleEvent->event->payable_amount,
                            'currency_code' => getCurrencyCode(),
                        ],
                    ],
                ],
                'application_context' => [
                    'cancel_url' => route('paypal.failed'),
                    'return_url' => route('paypal.success'),
                ],
            ];

            $order = $provider->createOrder($data);

            return response()->json($order);
        } catch (Exception $e) {
            throw new UnprocessableEntityHttpException($e->getMessage());
        }
    }

    /**
     * @return Application|RedirectResponse|Redirector
     */
    public function failed(): RedirectResponse
    {
        Flash::error(__('messages.success_message.payment_not_completed'));

        return redirect(route('events.index'));
    }

    /**
     * @return Application|Redirector|RedirectResponse
     *
     * @throws Throwable
     */
    public function success(Request $request): RedirectResponse
    {
        $userId = Session::get('user_id');

        config([
            'paypal.mode' => ! empty(paypalMode($userId)) ? paypalMode($userId) : 'sandbox',
            'paypal.sandbox.client_id' => paypalClientID($userId),
            'paypal.sandbox.client_secret' => paypalClientSecret($userId),
            'paypal.live.client_id' => paypalClientID($userId),
            'paypal.live.client_secret' => paypalClientSecret($userId),
        ]);

        $provider = new PayPalClient();
        $provider->getAccessToken();
        $token = $request->get('token');
        $orderInfo = $provider->showOrderDetails($token);

        try {
            // Call API with your client and get a response for your call
            $response = $provider->capturePaymentOrder($token);
            // If call returns body in response, you can get the deserialized version from the result attribute of the response
            $scheduleEventId = $response['purchase_units'][0]['reference_id'];
            $transactionID = $response['id'];
            $scheduleEvent = EventSchedule::find($scheduleEventId);
            $user = User::find($scheduleEvent->user_id);

            $transaction = [
                'user_id' => $user->id,
                'transaction_id' => $transactionID,
                'schedule_event_id' => $scheduleEvent->id,
                'amount' => $scheduleEvent->event->payable_amount,
                'type' => $scheduleEvent->payment_type,
                'meta' => json_encode($response),
            ];

            Transaction::create($transaction);
            $scheduleEvent->update(['status' => EventSchedule::BOOKED]);
            $redirectUrl = getSlotConfirmPageUrl($scheduleEvent);

            $scheduleEventRepo = App::make(ScheduleEventRepository::class);
            $scheduleEventRepo->scheduleEventMails($scheduleEvent, $scheduleEvent->email, true);

            Flash::success(__('messages.success_message.payment_completed'));

            return redirect(url($redirectUrl));
        } catch (Exception $e) {
            throw new UnprocessableEntityHttpException($e->getMessage());
        }
    }
}
