<?php

namespace App\Models;

use Barryvdh\LaravelIdeHelper\Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * App\Models\Enquiry
 *
 * @property int $id
 * @property string $first_name
 * @property string $last_name
 * @property string $email
 * @property string $message
 * @property int $view
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read string $view_name
 *
 * @method static Builder|Enquiry newModelQuery()
 * @method static Builder|Enquiry newQuery()
 * @method static Builder|Enquiry query()
 * @method static Builder|Enquiry whereCreatedAt($value)
 * @method static Builder|Enquiry whereEmail($value)
 * @method static Builder|Enquiry whereFirstName($value)
 * @method static Builder|Enquiry whereId($value)
 * @method static Builder|Enquiry whereLastName($value)
 * @method static Builder|Enquiry whereMessage($value)
 * @method static Builder|Enquiry whereUpdatedAt($value)
 * @method static Builder|Enquiry whereView($value)
 *
 * @mixin Eloquent
 */
class Enquiry extends Model
{
    use HasFactory;

    protected $table = 'enquiries';

    protected $appends = ['view_name', 'full_name'];

    const ALL = 2;

    const READ = 1;

    const UNREAD = 0;

    const VIEW_NAME = [
        self::ALL => 'All',
        self::READ => 'Read',
        self::UNREAD => 'Unread',
    ];

    /**
     * @var string[]
     */
    public static $rules = [
        'first_name' => 'required',
        'last_name' => 'required',
        'email' => 'required|email|max:255|regex:/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix',
        'message' => 'required',
    ];

    /**
     * @var string[]
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'message',
        'view',
    ];

    /**
     * @var string[]
     */
    protected $casts = [
        'first_name' => 'string',
        'last_name' => 'string',
        'email' => 'string',
        'message' => 'string',
        'view' => 'boolean',
    ];

    public function getFullNameAttribute(): string
    {
        return $this->first_name.' '.$this->last_name;
    }

    public function getViewNameAttribute(): string
    {
        return self::VIEW_NAME[$this->view];
    }
}
