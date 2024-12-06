<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * App\Models\Currency
 *
 * @property int $id
 * @property string $currency_name
 * @property string $currency_icon
 * @property string $currency_code
 * @property int $is_default
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @method static Builder|Currency newModelQuery()
 * @method static Builder|Currency newQuery()
 * @method static Builder|Currency query()
 * @method static Builder|Currency whereCreatedAt($value)
 * @method static Builder|Currency whereCurrencyCode($value)
 * @method static Builder|Currency whereCurrencyIcon($value)
 * @method static Builder|Currency whereCurrencyName($value)
 * @method static Builder|Currency whereId($value)
 * @method static Builder|Currency whereIsDefault($value)
 * @method static Builder|Currency whereUpdatedAt($value)
 *
 * @mixin Model
 */
class Currency extends Model
{
    use HasFactory;

    /**
     * @var string
     */
    protected $table = 'currencies';

    /**
     * @var string[]
     */
    protected $fillable = [
        'currency_name',
        'currency_icon',
        'currency_code',
        'is_default',
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'currency_name' => 'required|unique:currencies',
        'currency_icon' => 'required',
        'currency_code' => 'required|min:3|max:3',
    ];

    /**
     * @var string[]
     */
    protected $casts = [
        'currency_name' => 'string',
        'currency_icon' => 'string',
        'currency_code' => 'string',
        'is_default' => 'boolean',
    ];
}
