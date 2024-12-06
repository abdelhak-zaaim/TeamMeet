<?php

namespace App\Models;

use Barryvdh\LaravelIdeHelper\Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

/**
 * App\Models\MainReason
 *
 * @property int $id
 * @property string $key
 * @property string $value
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read MediaCollection|Media[] $media
 * @property-read int|null $media_count
 *
 * @method static Builder|MainReason newModelQuery()
 * @method static Builder|MainReason newQuery()
 * @method static Builder|MainReason query()
 * @method static Builder|MainReason whereCreatedAt($value)
 * @method static Builder|MainReason whereId($value)
 * @method static Builder|MainReason whereKey($value)
 * @method static Builder|MainReason whereUpdatedAt($value)
 * @method static Builder|MainReason whereValue($value)
 *
 * @mixin Eloquent
 */
class MainReason extends Model implements hasMedia
{
    use HasFactory, InteractsWithMedia;

    protected $table = 'main_reasons';

    const MAIN_REASON_IMAGE = 'image';

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'main_title' => 'required|max:27',
        'image' => 'mimes:jpeg,png,jpg|max:2000',
        'title_1' => 'required|max:45',
        'title_2' => 'required|max:28',
        'title_3' => 'required|max:20',
        'description_1' => 'required|max:122',
        'description_2' => 'required|max:122',
        'description_3' => 'required|max:122',
    ];

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
