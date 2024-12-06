<?php

namespace App\Models;

use Barryvdh\LaravelIdeHelper\Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * App\Models\UserSetting
 *
 * @property int $id
 * @property int $user_id
 * @property string $key
 * @property string $value
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @method static Builder|UserSetting newModelQuery()
 * @method static Builder|UserSetting newQuery()
 * @method static Builder|UserSetting query()
 * @method static Builder|UserSetting whereCreatedAt($value)
 * @method static Builder|UserSetting whereId($value)
 * @method static Builder|UserSetting whereKey($value)
 * @method static Builder|UserSetting whereUpdatedAt($value)
 * @method static Builder|UserSetting whereUserId($value)
 * @method static Builder|UserSetting whereValue($value)
 *
 * @mixin Eloquent
 */
class UserSetting extends Model
{
    use HasFactory;

    protected $table = 'user_settings';

    public static $rules = [
        'key' => 'required',
        'value' => 'required',
    ];

    /**
     * @var string[]
     */
    protected $fillable = [
        'user_id',
        'key',
        'value',
    ];

    /**
     * @var string[]
     */
    protected $casts = [
        'user_id' => 'integer',
        'key' => 'string',
        'value' => 'string',
    ];
}
