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
 * App\Models\FrontTestimonial
 *
 * @property int $id
 * @property string $name
 * @property string $designation
 * @property string $short_description
 * @property int $is_default
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read string $front_profile
 * @property-read MediaCollection|Media[] $media
 * @property-read int|null $media_count
 *
 * @method static Builder|FrontTestimonial newModelQuery()
 * @method static Builder|FrontTestimonial newQuery()
 * @method static Builder|FrontTestimonial query()
 * @method static Builder|FrontTestimonial whereCreatedAt($value)
 * @method static Builder|FrontTestimonial whereDesignation($value)
 * @method static Builder|FrontTestimonial whereId($value)
 * @method static Builder|FrontTestimonial whereIsDefault($value)
 * @method static Builder|FrontTestimonial whereName($value)
 * @method static Builder|FrontTestimonial whereShortDescription($value)
 * @method static Builder|FrontTestimonial whereUpdatedAt($value)
 *
 * @mixin Model
 */
class FrontTestimonial extends Model implements hasMedia
{
    use HasFactory, InteractsWithMedia;

    const FRONT_PROFILE = 'profile';

    protected $table = 'front_testimonials';

    /**
     * @var string[]
     */
    protected $fillable = [
        'name',
        'designation',
        'short_description',
        'is_default',
    ];

    /**
     * @var string[]
     */
    protected $casts = [
        'name' => 'string',
        'designation' => 'string',
        'short_description' => 'string',
        'is_default' => 'boolean',
    ];

    protected $appends = ['front_profile'];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'name' => 'required',
        'designation' => 'required',
        'short_description' => 'required|max:230',
        'profile' => 'required|mimes:jpeg,jpg,png|max:2000',
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $editRules = [
        'name' => 'required',
        'designation' => 'required',
        'short_description' => 'required|max:230',
        'profile' => 'nullable|mimes:jpeg,jpg,png|max:2000',
    ];

    public function getFrontProfileAttribute(): string
    {
        /** @var Media $media */
        $media = $this->getMedia(self::FRONT_PROFILE)->first();
        if (! empty($media)) {
            return $media->getFullUrl();
        }

        return asset('web/media/avatars/male.png');
    }
}
