<?php

namespace App\Models;

use Barryvdh\LaravelIdeHelper\Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * App\Models\PersonalExperience
 *
 * @property int $id
 * @property string|null $name
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @method static Builder|PersonalExperience newModelQuery()
 * @method static Builder|PersonalExperience newQuery()
 * @method static Builder|PersonalExperience query()
 * @method static Builder|PersonalExperience whereCreatedAt($value)
 * @method static Builder|PersonalExperience whereId($value)
 * @method static Builder|PersonalExperience whereName($value)
 * @method static Builder|PersonalExperience whereUpdatedAt($value)
 *
 * @mixin Eloquent
 */
class PersonalExperience extends Model
{
    use HasFactory;

    /**
     * @var string
     */
    protected $table = 'personal_experiences';

    /**
     * @var string[]
     */
    protected $fillable = [
        'name',
    ];

    /**
     * @var string[]
     */
    protected $casts = [
        'name' => 'string',
    ];

    /**
     * @var string[]
     */
    public static $rules = [
        'name' => 'required|unique:personal_experiences,name',
    ];
}
