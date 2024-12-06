<?php

namespace App\Repositories;

use App\Events\CreateGoogleEvent;
use App\Events\DeleteEventFromGoogleCalendar;
use App\Mail\EventScheduleMail;
use App\Mail\UserEventScheduleMail;
use App\Models\Event;
use App\Models\EventSchedule;
use App\Models\UserGoogleEventSchedule;
use Carbon\Carbon;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Stripe\Checkout\Session;
use Stripe\Exception\ApiErrorException;
use Stripe\Stripe;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;

/**
 * Class ScheduleEventRepository
 *
 * @version December 07, 2021, 10:43 am UTC
 */
class ScheduleEventRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name',
    ];

    /**
     * Return searchable fields
     */
    public function getFieldsSearchable(): array
    {
        return $this->fieldSearchable;
    }

    /**
     * Configure the Model
     **/
    public function model(): string
    {
        return EventSchedule::class;
    }

    public function store($input): mixed
    {
        try {
            DB::beginTransaction();
            $eventSchedule = EventSchedule::create($input);

            if (! empty($input['location_meta'])) {
                $eventSchedule->event->update(['location_meta' => $input['location_meta']]);
            }

            $this->scheduleEventMails($eventSchedule, $input['email'], false);

            DB::commit();

            return $eventSchedule;
        } catch (Exception $exception) {
            DB::rollback();
            throw new UnprocessableEntityHttpException($exception->getMessage());
        }
    }

    /**
     * @param  false  $paidEventMail
     */
    public function scheduleEventMails($eventSchedule, $email, bool $paidEventMail = false): bool
    {
        $data = [];
        $data['eventSchedule'] = $eventSchedule;
        $data['event'] = $eventSchedule->event->name;
        $data['eventType'] = $eventSchedule->event->event_type;
        $data['name'] = $eventSchedule->name;
        $data['email'] = $eventSchedule->email;
        $data['schedule_date'] = $eventSchedule->schedule_date;
        $data['scheduleTime'] = $eventSchedule->slot_time;
        $data['user'] = $eventSchedule->user;
        $data['confirmScheduleEventUrl'] = getSlotConfirmPageUrl($eventSchedule);
        $data['cancelScheduleEventUrl'] = getSlotConfirmPageUrl($eventSchedule).'?cancel=true';
        if ($eventSchedule->event->event_type == Event::FREE) {
            $eventSchedule->update(['status' => EventSchedule::BOOKED]);
        }
        $data['loginUserName'] = $eventSchedule->user->full_name;
        $loginUserEmail = $eventSchedule->user->email;
        CreateGoogleEvent::dispatch($eventSchedule->id);

        $googleUserEventSchedule = UserGoogleEventSchedule::whereUserId($eventSchedule->user_id)->whereEventScheduleId($eventSchedule->id)->first();
        if (($eventSchedule->event->event_location == Event::GOOGLE_MEET) && ! empty($googleUserEventSchedule->google_meet_link)) {
            $data['googleMeetLink'] = $googleUserEventSchedule->google_meet_link;
        } else {
            $data['googleMeetLink'] = '';
        }

        if ($eventSchedule->event->event_type == Event::FREE) {
            Mail::to($email)->send(new EventScheduleMail($data));
            Mail::to($loginUserEmail)->send(new UserEventScheduleMail($data));
        } elseif ($paidEventMail) {
            Mail::to($email)->send(new EventScheduleMail($data));
            Mail::to($loginUserEmail)->send(new UserEventScheduleMail($data));
        }

        return true;
    }

    /**
     * @throws ApiErrorException
     */
    public function createSession($eventSchedule): array
    {

        try{
            if (getCurrencyCode() != 'jpy') {
                $amount = $eventSchedule->event->payable_amount * 100;
            } else {
                $amount = $eventSchedule->event->payable_amount;
            }

            Stripe::setApiKey(getStripeSecretKey($eventSchedule->user_id));

            $successUrl = '/payment-success';
            $cancelUrl = '/payment-failed';
            $eventScheduleUserID = $eventSchedule->user_id;
            $session = Session::create([
                'payment_method_types' => ['card'],
                'customer_email' => $eventSchedule->email,
                'line_items' => [
                    [
                        'price_data' => [
                            'product_data' => [
                                'name' => 'Payment for schedule event booking',
                                'description' => 'Payment for user schedule event :
                         '.$eventSchedule->name.' at '.Carbon::parse($eventSchedule->schedule_date)->format('d/m/Y').' '.$eventSchedule->slot_time,
                            ],
                            'unit_amount' => $amount,
                            'currency' => getCurrencyCode(),
                        ],
                        'quantity' => 1,
                    ],
                ],
                'client_reference_id' => $eventSchedule->id,
                'mode' => 'payment',
                'success_url' => url($successUrl).'?session_id={CHECKOUT_SESSION_ID} & eventScheduleUserID='.$eventScheduleUserID,
                'cancel_url' => url($cancelUrl.'?error=payment_cancelled & eventScheduleUserID='.$eventScheduleUserID),
            ]);

            $result = [
                'sessionId' => $session['id'],
            ];

            return $result;
        }catch(Exception $e){
            $scheduleEvent = EventSchedule::findOrFail($eventSchedule->id);
            $scheduleEvent->delete();
            throw new UnprocessableEntityHttpException($e->getMessage());
        }
    }

    /**
     * @return Builder|Builder[]|Collection|Model|null
     */
    public function cancelScheduleEvent($cancelReason, $id)
    {
        try {
            DB::beginTransaction();
            $scheduledEvent = EventSchedule::with('user')->findOrFail($id);
            $scheduledEvent->update(['status' => EventSchedule::CANCELLED, 'cancel_reason' => $cancelReason]);

            $userEventSchedules = UserGoogleEventSchedule::with('user')
                ->where('event_schedule_id', $scheduledEvent->id)
                ->get()
                ->groupBy('user_id');

            foreach ($userEventSchedules as $userEventSchedule) {
                $user = $userEventSchedule[0]->user;
                DeleteEventFromGoogleCalendar::dispatch($userEventSchedule, $user);
            }

            DB::commit();

            return $scheduledEvent;
        } catch (Exception $e) {
            DB::rollBack();
            throw new UnprocessableEntityHttpException($e->getMessage());
        }
    }

    public function changeStatus(): bool
    {
        $scheduledEvents = EventSchedule::whereStatus(EventSchedule::HOLD)->get();

        foreach ($scheduledEvents as $scheduledEvent) {
            $userEventSchedules = UserGoogleEventSchedule::with('user')
                ->where('event_schedule_id', $scheduledEvent->id)
                ->get()
                ->groupBy('user_id');
            $createdTime = Carbon::parse($scheduledEvent->created_at);
            $diff = $createdTime->diffInMinutes(Carbon::now());
            if ($diff > 30) {
                $scheduledEvent->update(['status' => EventSchedule::CANCELLED]);

                foreach ($userEventSchedules as $userEventSchedule) {
                    $user = $userEventSchedule[0]->user;
                    DeleteEventFromGoogleCalendar::dispatch($userEventSchedule, $user);
                }
            }
        }

        return true;
    }
}
