<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

/**
 * App\Models\Service
 *
 * @property int $id
 * @property string $main_title
 * @property string $service_image_1
 * @property string $service_image_2
 * @property string $service_image_3
 * @property string $service_title_1
 * @property string $service_title_2
 * @property string $service_title_3
 * @property string $service_description_1
 * @property string $service_description_2
 * @property string $service_description_3
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read MediaCollection|Media[] $media
 * @property-read int|null $media_count
 *
 * @method static Builder|Service newModelQuery()
 * @method static Builder|Service newQuery()
 * @method static Builder|Service query()
 * @method static Builder|Service whereCreatedAt($value)
 * @method static Builder|Service whereId($value)
 * @method static Builder|Service whereMainTitle($value)
 * @method static Builder|Service whereServiceDescription1($value)
 * @method static Builder|Service whereServiceDescription2($value)
 * @method static Builder|Service whereServiceDescription3($value)
 * @method static Builder|Service whereServiceImage1($value)
 * @method static Builder|Service whereServiceImage2($value)
 * @method static Builder|Service whereServiceImage3($value)
 * @method static Builder|Service whereServiceTitle1($value)
 * @method static Builder|Service whereServiceTitle2($value)
 * @method static Builder|Service whereServiceTitle3($value)
 * @method static Builder|Service whereUpdatedAt($value)
 *
 * @mixin Model
 */
class Service extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    protected $table = 'services';

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

    const SERVICE_ICON = 'service_icon';

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'main_title' => 'required|max:45',
        'service_image_1' => 'mimes:svg,jpeg,png,jpg|max:2000',
        'service_image_2' => 'mimes:svg,jpeg,png,jpg|max:2000',
        'service_image_3' => 'mimes:svg,jpeg,png,jpg|max:2000',
        'service_title_1' => 'required|max:20',
        'service_title_2' => 'required|max:20',
        'service_title_3' => 'required|max:20',
        'service_description_1' => 'required|max:90',
        'service_description_2' => 'required|max:90',
        'service_description_3' => 'required|max:90',
    ];
}
