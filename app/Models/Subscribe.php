<?php

namespace App\Models;

use Barryvdh\LaravelIdeHelper\Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * App\Models\Subscribe
 *
 * @mixin Eloquent
 *
 * @property int $id
 * @property string $email
 * @property int $subscribe
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @method static Builder|Subscribe whereCreatedAt($value)
 * @method static Builder|Subscribe whereEmail($value)
 * @method static Builder|Subscribe whereId($value)
 * @method static Builder|Subscribe whereSubscribe($value)
 * @method static Builder|Subscribe whereUpdatedAt($value)
 * @method static Builder|Subscribe newModelQuery()
 * @method static Builder|Subscribe newQuery()
 * @method static Builder|Subscribe query()
 */
class Subscribe extends Model
{
    use HasFactory;

    protected $table = 'subscribes';

    const SUBSCRIBE = 1;

    const SUBSCRIBER = [
        self::SUBSCRIBE => 'Subscribe',
    ];

    /**
     * @var string[]
     */
    public static $rules = [
        'email' => 'required|email|max:255|regex:/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix|unique:subscribes,email',
    ];

    /**
     * @var string[]
     */
    protected $fillable = [
        'email',
        'subscribe',
    ];

    /**
     * @var string[]
     */
    protected $casts = [
        'email' => 'string',
        'subscribe' => 'boolean',
    ];
}
