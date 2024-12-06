<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

/**
 * App\Models\Setting
 *
 * @property int $id
 * @property string $key
 * @property string $value
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @method static Builder|Setting newModelQuery()
 * @method static Builder|Setting newQuery()
 * @method static Builder|Setting query()
 * @method static Builder|Setting whereCreatedAt($value)
 * @method static Builder|Setting whereId($value)
 * @method static Builder|Setting whereKey($value)
 * @method static Builder|Setting whereUpdatedAt($value)
 * @method static Builder|Setting whereValue($value)
 *
 * @mixin Model
 */
class Setting extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    const LOGO = 'logo';

    const FAVICON = 'favicon';

    protected $table = 'settings';

    /**
     * @var string[]
     */
    protected $fillable = [
        'key',
        'value',
    ];

    /**
     * @var string[]
     */
    protected $casts = [
        'key' => 'string',
        'value' => 'string',
    ];
}
