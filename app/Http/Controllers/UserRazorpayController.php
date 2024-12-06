<?php

namespace App\Http\Controllers;

use App\Models\EventSchedule;
use App\Models\Transaction;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Laracasts\Flash\Flash;
use Razorpay\Api\Api;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;
use App\Repositories\ScheduleEventRepository;
use Illuminate\Support\Facades\Session;

class UserRazorpayController extends AppBaseController
{
    public function razorpayonBoard(Request $request)
    {
        try {
            if (!in_array(strtoupper(getCurrencyCode()), getRazorPaySupportedCurrencies())) {
                Flash::error(__('messages.error.razorpay_currency_not_supported'));
                $scheduleEvent = EventSchedule::findOrFail($request->get('scheduleEventId'));
                $scheduleEvent->delete();
                return response()->json(['url' => route('events.index')]);
            }

            $scheduleEventId = $request->get('scheduleEventId');
            $scheduleEvent = EventSchedule::findOrFail($scheduleEventId);

            $api = new Api(getAdminRazorpayKey($scheduleEvent->user_id), getAdminRazorpaySecretKey($scheduleEvent->user_id));

            $orderData = [
                'receipt' => $scheduleEventId,
                'amount' => $scheduleEvent->event->payable_amount * 100, // 100 = 1 rupees
                'currency' => strtoupper(getCurrencyCode()),
                'notes' => [
                    'email' => $scheduleEvent->email,
                    'name' => $scheduleEvent->name,
                    'scheduleEvent_id' => $scheduleEventId,
                    'amount' => $scheduleEvent->event->payable_amount,
                ],
            ];

            $razorpayOrder = $api->order->create($orderData);
            $data['id'] = $razorpayOrder->id;
            $data['amount'] = $scheduleEvent->event->payable_amount * 100;
            $data['name'] = $scheduleEvent->name;
            $data['email'] = $scheduleEvent->email;
            $data['scheduleEventId'] = $scheduleEventId;

            session(['scheduleEventId' => $scheduleEventId]);
            session(['user_id' => $scheduleEvent->user_id]);

            return $this->sendResponse($data, __('messages.flash.order_created'));
        } catch (Exception $e) {
            if ($request->get('scheduleEventId')) {
                $scheduleEvent = EventSchedule::findOrFail($request->get('scheduleEventId'));
                $scheduleEvent->delete();
            }
            throw new UnprocessableEntityHttpException($e->getMessage());
        }
    }

    public function eventScheduleRazorpaySuceess(Request $request)
    {
        $input =  $request->all();

        try {
            DB::beginTransaction();
            $api = new Api(getAdminRazorpayKey(session('user_id')), getAdminRazorpaySecretKey(session('user_id')));

            if (count($input) && !empty($input['razorpay_payment_id'])) {
                $data = $api->payment->fetch($input['razorpay_payment_id']);
                $generatedSignature = hash_hmac(
                    'sha256',
                    $data['order_id'] . '|' . $input['razorpay_payment_id'],
                    getAdminRazorpaySecretKey(session('user_id'))
                );

                if ($generatedSignature != $input['razorpay_signature']) {
                    return redirect()->back();
                }

                $scheduleEventId = $data['notes']['scheduleEvent_id'];
                $transactionId = $data['id'];

                $scheduleEvent = EventSchedule::find($scheduleEventId);
                $user = User::find($scheduleEvent->user_id);

                $transaction = [
                    'user_id' => $user->id,
                    'transaction_id' => $transactionId,
                    'schedule_event_id' => $scheduleEvent->id,
                    'amount' => $scheduleEvent->event->payable_amount,
                    'type' => $scheduleEvent->payment_type,
                    'meta' => json_encode($data),
                ];

                Transaction::create($transaction);

                $scheduleEvent->update(['status' => EventSchedule::BOOKED]);
                $redirectUrl = getSlotConfirmPageUrl($scheduleEvent);

                $scheduleEventRepo = App::make(ScheduleEventRepository::class);
                $scheduleEventRepo->scheduleEventMails($scheduleEvent, $scheduleEvent->email, true);

                DB::commit();
                Flash::success(__('messages.success_message.payment_completed'));
                session()->forget('scheduleEventId');
                session()->forget('user_id');
                return redirect(url($redirectUrl));
            }
        } catch (Exception $e) {
            DB::rollBack();
            session()->forget('scheduleEventId');
            session()->forget('user_id');
            Log::info('RazorPay Payment Failed Error:' . $e->getMessage());
            throw new UnprocessableEntityHttpException($e->getMessage());
        }
    }

    public function eventScheduleRazorpayFailed(Request $request)
    {
        $scheduleEventId = Session::get('scheduleEventId');
        $scheduleEvent = EventSchedule::findOrFail($scheduleEventId);
        $scheduleEvent->delete();
        session()->forget('scheduleEventId');

        Flash::error(__('messages.success_message.payment_not_completed'));

        return response()->json(['url' => route('events.index')]);
    }
}
