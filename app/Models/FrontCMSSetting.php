<?php

namespace App\Models;

use Barryvdh\LaravelIdeHelper\Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

/**
 * App\Models\FrontSetting
 *
 * @property-read MediaCollection|Media[] $media
 * @property-read int|null $media_count
 *
 * @method static Builder|FrontCMSSetting newModelQuery()
 * @method static Builder|FrontCMSSetting newQuery()
 * @method static Builder|FrontCMSSetting query()
 *
 * @mixin Eloquent
 */
class FrontCMSSetting extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    const FRONT_IMAGE = 'front_image';

    protected $table = 'front_cms_settings';

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

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'title' => 'required|max:41',
        'front_image' => 'mimes:jpeg,png,jpg|max:2000',
        'email' => 'required|email:filter',
        'description' => 'required|max:74',
        'phone' => 'required',
        'address' => 'required',
        'facebook_url' => 'required',
        'twitter_url' => 'required',
        'instagram_url' => 'required',
    ];
}
