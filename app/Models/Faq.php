<?php

namespace App\Models;

use Barryvdh\LaravelIdeHelper\Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * App\Models\Faq
 *
 * @property int $id
 * @property string $question
 * @property string $answer
 * @property int $is_default
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @method static Builder|Faq newModelQuery()
 * @method static Builder|Faq newQuery()
 * @method static Builder|Faq query()
 * @method static Builder|Faq whereAnswer($value)
 * @method static Builder|Faq whereCreatedAt($value)
 * @method static Builder|Faq whereId($value)
 * @method static Builder|Faq whereIsDefault($value)
 * @method static Builder|Faq whereQuestion($value)
 * @method static Builder|Faq whereUpdatedAt($value)
 *
 * @mixin Eloquent
 */
class Faq extends Model
{
    use HasFactory;

    /**
     * @var string
     */
    protected $table = 'faqs';

    /**
     * @var string[]
     */
    protected $fillable = [
        'question',
        'answer',
        'is_default',
    ];

    /**
     * @var string[]
     */
    protected $casts = [
        'question' => 'string',
        'answer' => 'string',
        'is_default' => 'boolean',
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'question' => 'required|max:300',
        'answer' => 'required|max:500',
    ];
}
