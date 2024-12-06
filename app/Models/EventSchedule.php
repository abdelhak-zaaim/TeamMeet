<?php

namespace App\Models;

use Barryvdh\LaravelIdeHelper\Eloquent;
use Dyrynda\Database\Support\GeneratesUuid;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Carbon;

/**
 * App\Models\EventSchedule
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string $schedule_date
 * @property string|null $description
 * @property int $user_id
 * @property int|null $event_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @method static Builder|EventSchedule newModelQuery()
 * @method static Builder|EventSchedule newQuery()
 * @method static Builder|EventSchedule query()
 * @method static Builder|EventSchedule whereCreatedAt($value)
 * @method static Builder|EventSchedule whereDescription($value)
 * @method static Builder|EventSchedule whereEmail($value)
 * @method static Builder|EventSchedule whereEventId($value)
 * @method static Builder|EventSchedule whereId($value)
 * @method static Builder|EventSchedule whereName($value)
 * @method static Builder|EventSchedule whereScheduleDate($value)
 * @method static Builder|EventSchedule whereUpdatedAt($value)
 * @method static Builder|EventSchedule whereUserId($value)
 *
 * @mixin Eloquent
 *
 * @property int|null $user_schedule_id
 * @property-read Event|null $event
 * @property-read UserSchedule|null $userSchedule
 *
 * @method static Builder|EventSchedule whereUserScheduleId($value)
 *
 * @property int|null $status
 * @property string|null $slot_time
 *
 * @method static Builder|EventSchedule whereSlotTime($value)
 * @method static Builder|EventSchedule whereStatus($value)
 *
 * @property string|null $cancel_reason
 * @property string|null $uuid
 *
 * @method static Builder|EventSchedule whereCancelReason($value)
 * @method static Builder|EventSchedule whereUuid($value)
 *
 * @property string|null $otp
 *
 * @method static Builder|EventSchedule whereOtp($value)
 *
 * @property int|null $payment_type
 * @property-read User $user
 *
 * @method static Builder|EventSchedule wherePaymentType($value)
 */
class EventSchedule extends Model
{
    use HasFactory, GeneratesUuid;

    /**
     * @var string[]
     */
    public static $rules = [
        'name' => 'required',
        'email' => 'required|email:filter',
    ];

    /**
     * @var string
     */
    protected $table = 'event_schedules';

    /**
     * @var string[]
     */
    protected $fillable = [
        'name',
        'email',
        'schedule_date',
        'description',
        'user_id',
        'event_id',
        'user_schedule_id',
        'status',
        'slot_time',
        'cancel_reason',
        'uuid',
        'otp',
        'payment_type',
        'reminder_sent',
    ];

    /**
     * @var string[]
     */
    protected $casts = [
        'name' => 'string',
        'email' => 'string',
        'schedule_date' => 'string',
        'description' => 'string',
        'user_id' => 'integer',
        'event_id' => 'integer',
        'user_schedule_id' => 'integer',
        'status' => 'integer',
        'slot_time' => 'string',
        'cancel_reason' => 'string',
        'uuid' => 'string',
        'otp' => 'string',
        'payment_type' => 'integer',
    ];

    const BOOKED = 1;

    const HOLD = 2;

    const CANCELLED = 3;

    const STATUS = [
        self::BOOKED => 'Booked',
        self::HOLD => 'Hold',
        self::CANCELLED => 'Cancelled',
    ];

    const UNLIMITED_SCHEDULES = -1;

    const STRIPE = 1;

    const PAYPAL = 2;

    const PAYSTACK = 3;

    const RAZORPAY = 4;

    const PAYMENT_METHOD = [
        self::STRIPE => 'Stripe',
        self::PAYPAL => 'Paypal',
        self::PAYSTACK => 'PayStack',
        self::RAZORPAY => 'RazorPay',
    ];

    /**
     * @throws Exception
     */
    public static function generateOTP(): int
    {
        $cancelScheduleOTP = random_int(100000, 999999);
        while (true) {
            $isExist = self::whereOtp($cancelScheduleOTP)->exists();
            if ($isExist) {
                self::generateOTP();
            }
            break;
        }

        return $cancelScheduleOTP;
    }

    public function userSchedule(): BelongsTo
    {
        return $this->belongsTo(UserSchedule::class, 'user_schedule_id');
    }

    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class, 'event_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function userGoogleEventSchedule(): HasOne
    {
        return $this->hasOne(UserGoogleEventSchedule::class);
    }

    public function scopeUser($query)
    {
        $query->where('user_id', getLogInUserId());
    }

    public function transaction(): HasOne
    {
        return $this->hasOne(Transaction::class, 'schedule_event_id');
    }
}
