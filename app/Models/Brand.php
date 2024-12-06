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
 * Class Brand
 *
 * @version December 24, 2021, 7:27 am UTC
 *
 * @property int $id
 * @property int $is_default
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read string $brand_logo
 * @property-read MediaCollection|Media[] $media
 * @property-read int|null $media_count
 *
 * @method static Builder|Brand newModelQuery()
 * @method static Builder|Brand newQuery()
 * @method static Builder|Brand query()
 * @method static Builder|Brand whereCreatedAt($value)
 * @method static Builder|Brand whereId($value)
 * @method static Builder|Brand whereIsDefault($value)
 * @method static Builder|Brand whereUpdatedAt($value)
 *
 * @mixin Model
 */
class Brand extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    const BRAND_LOGO = 'brand_logo';

    /**
     * @var string[]
     */
    public static $rules = [
        'brand_logo' => 'required|mimes:png,jpg,jpeg',
    ];

    /**
     * @var string
     */
    protected $table = 'brands';

    /**
     * @var string[]
     */
    protected $fillable = ['is_default'];

    /**
     * @var string[]
     */
    protected $appends = ['brand_logo'];

    /**
     * @var string[]
     */
    protected $casts = [
        'is_default' => 'boolean',
    ];

    public function getBrandLogoAttribute(): string
    {
        /** @var Media $media */
        $media = $this->getMedia(self::BRAND_LOGO)->first();
        if (! empty($media)) {
            return $media->getFullUrl();
        }

        return asset('web/media/avatars/male.png');
    }
}
