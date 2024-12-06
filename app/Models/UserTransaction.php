<?php

namespace App\Models;

use Barryvdh\LaravelIdeHelper\Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Carbon;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

/**
 * App\Models\UserTransaction
 *
 * @property int $id
 * @property int $user_id
 * @property string $transaction_id
 * @property float $amount
 * @property int|null $type
 * @property array $meta
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Subscription $subscription
 * @property-read Subscription|null $transactionSubscription
 *
 * @method static Builder|UserTransaction newModelQuery()
 * @method static Builder|UserTransaction newQuery()
 * @method static Builder|UserTransaction query()
 * @method static Builder|UserTransaction whereAmount($value)
 * @method static Builder|UserTransaction whereCreatedAt($value)
 * @method static Builder|UserTransaction whereId($value)
 * @method static Builder|UserTransaction whereMeta($value)
 * @method static Builder|UserTransaction whereScheduleEventId($value)
 * @method static Builder|UserTransaction whereTransactionId($value)
 * @method static Builder|UserTransaction whereType($value)
 * @method static Builder|UserTransaction whereUpdatedAt($value)
 * @method static Builder|UserTransaction whereUserId($value)
 *
 * @mixin Eloquent
 *
 * @property int $payment_type 1 = Stripe, 2 = Paypal
 * @property string $status
 * @property int $subscription_status
 * @property string|null $note
 * @property-read User $user
 *
 * @method static Builder|UserTransaction whereNote($value)
 * @method static Builder|UserTransaction wherePaymentType($value)
 * @method static Builder|UserTransaction whereStatus($value)
 * @method static Builder|UserTransaction whereSubscriptionStatus($value)
 */
class UserTransaction extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    const PAYMENT_ATTACHMENT = 'payment_attachment';

    protected $table = 'user_transactions';

    const PAID = 'Paid';

    const UNPAID = 'Unpaid';

    const TYPE_STRIPE = 1;

    const TYPE_PAYPAL = 2;

    const TYPE_PAYSTACK = 4;

    const MANUALLY = 3;

    const TYPE_RAZORPAY = 5;

    const PAYMENT_TYPES = [
        self::TYPE_STRIPE => 'Stripe',
        self::TYPE_PAYPAL => 'PayPal',
        self::MANUALLY => 'Manually',
        self::TYPE_PAYSTACK => 'Paystack',
        self::TYPE_RAZORPAY => 'RazorPay'

    ];

    const PENDING = 1;

    const APPROVED = 2;

    const REJECTED = 3;

    const SUBSCRIPTION_STATUS_ARR = [
        self::PENDING => 'Pending',
        self::APPROVED => 'Approved',
        self::REJECTED => 'Rejected',
    ];

    /**
     * @var string[]
     */
    protected $fillable = [
        'transaction_id',
        'payment_type',
        'amount',
        'user_id',
        'status',
        'meta',
        'subscription_status',
        'note',
    ];

    protected $appends = ['payment_attachment'];

    /**
     * @var string[]
     */
    protected $casts = [
        'transaction_id' => 'string',
        'payment_type' => 'integer',
        'amount' => 'double',
        'user_id' => 'integer',
        'status' => 'string',
        'meta' => 'string',
        'subscription_status' => 'integer',
    ];

    public function getPaymentAttachmentAttribute(): bool
    {
        /** @var Media $media */
        $media = $this->getMedia(self::PAYMENT_ATTACHMENT)->first();

        if (! empty($media)) {
            return $media->getFullUrl();
        }

        return false;
    }

    public function subscription(): BelongsTo
    {
        return $this->belongsTo(Subscription::class, 'transaction_id');
    }

    public function transactionSubscription(): HasOne
    {
        return $this->hasOne(Subscription::class, 'transaction_id', 'id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
