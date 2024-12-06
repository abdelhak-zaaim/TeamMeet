<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Notifications\DatabaseNotificationCollection;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Carbon;
use Lab404\Impersonate\Models\Impersonate;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Traits\HasRoles;

/**
 * App\Models\User
 *
 * @property int $id
 * @property string $first_name
 * @property string $last_name
 * @property string $email
 * @property int $gender
 * @property int $status
 * @property string|null $language
 * @property Carbon|null $email_verified_at
 * @property string $password
 * @property string|null $remember_token
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read string $full_name
 * @property-read string $profile_image
 * @property-read MediaCollection|Media[] $media
 * @property-read int|null $media_count
 * @property-read DatabaseNotificationCollection|DatabaseNotification[]
 *     $notifications
 * @property-read int|null $notifications_count
 *
 * @method static UserFactory factory(...$parameters)
 * @method static Builder|User newModelQuery()
 * @method static Builder|User newQuery()
 * @method static Builder|User query()
 * @method static Builder|User whereContact($value)
 * @method static Builder|User whereCreatedAt($value)
 * @method static Builder|User whereDob($value)
 * @method static Builder|User whereEmail($value)
 * @method static Builder|User whereEmailVerifiedAt($value)
 * @method static Builder|User whereFirstName($value)
 * @method static Builder|User whereGender($value)
 * @method static Builder|User whereId($value)
 * @method static Builder|User whereLanguage($value)
 * @method static Builder|User whereLastName($value)
 * @method static Builder|User wherePassword($value)
 * @method static Builder|User whereRememberToken($value)
 * @method static Builder|User whereStatus($value)
 * @method static Builder|User whereUpdatedAt($value)
 *
 * @property-read Collection|Permission[] $permissions
 * @property-read int|null $permissions_count
 * @property-read int|null $qualifications_count
 * @property-read Collection|Role[] $roles
 * @property-read int|null $roles_count
 *
 * @method static Builder|User permission($permissions)
 * @method static Builder|User role($roles, $guard = null)
 *
 * @property string|null $domain_url
 * @property string|null $timezone
 * @property int|null $step
 * @property int|null $personal_experience_id
 * @property-read PersonalExperience $personalExperience
 *
 * @method static Builder|User whereDomainUrl($value)
 * @method static Builder|User wherePersonalExperienceId($value)
 * @method static Builder|User whereStep($value)
 * @method static Builder|User whereTimezone($value)
 *
 * @property string|null $phone_number
 * @property string|null $region_code
 * @property-read GoogleCalendarIntegration|null $gCredentials
 * @property-read Schedule|null $schedule
 *
 * @method static Builder|User wherePhoneNumber($value)
 * @method static Builder|User whereRegionCode($value)
 *
 * @mixin Model
 *
 * @property int $is_super_admin
 *
 * @method static Builder|User whereIsSuperAdmin($value)
 */
class User extends Authenticatable implements HasMedia, MustVerifyEmail
{
    use HasFactory, Notifiable, InteractsWithMedia,Impersonate, HasRoles;

    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'email_verified_at',
        'status',
        'password',
        'phone_number',
        'language',
        'gender',
        'domain_url',
        'step',
        'timezone',
        'personal_experience_id',
        'region_code',
        'is_super_admin',
    ];

    const LANGUAGES = [
        'ar' => 'Arabic',
        'zh' => 'Chinese',
        'en' => 'English',
        'fr' => 'French',
        'de' => 'German',
        'pt' => 'Portuguese',
        'ru' => 'Russian',
        'es' => 'Spanish',
        'tr' => 'Turkish',
    ];

    const PROFILE = 'profile';

    const STEP_1 = 1;

    const STEP_2 = 2;

    const STEP_3 = 3;

    const MALE = 1;

    const FEMALE = 2;

    const GENDER = [
        self::MALE => 'Male',
        self::FEMALE => 'Female',
    ];

    protected $appends = ['full_name', 'profile_image'];

    public static $rules = [
        'first_name' => 'required|string|regex:/(^([a-zA-z]+)(\d+)?$)/u',
        'last_name' => 'required|string|regex:/(^([a-zA-z]+)(\d+)?$)/u',
        'email' => 'required|email:filter|unique:users,email',
        'password' => 'required|same:password_confirmation|min:6',
        'phone_number' => 'required|unique:users,phone_number',
        'profile' => 'nullable|mimes:jpeg,png,jpg|max:2000',
        'personal_experience_id' => 'required',
        'subscription_plans_id' => 'required',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'first_name' => 'string',
        'last_name' => 'string',
        'email' => 'string',
        'status' => 'boolean',
        'password' => 'string',
        'phone_number' => 'string',
        'language' => 'string',
        'gender' => 'integer',
        'domain_url' => 'string',
        'step' => 'integer',
        'timezone' => 'string',
        'personal_experience_id' => 'integer',
        'region_code' => 'string',
        'is_super_admin' => 'boolean',
        'email_verified_at' => 'datetime',
    ];

    const TIME_ZONE_ARRAY = [
        'Europe/Andorra',
        'Asia/Dubai',
        'Asia/Kabul',
        'Europe/Tirane',
        'Asia/Yerevan',
        'Antarctica/Casey',
        'Antarctica/Davis',
        'Antarctica/DumontDUrville', // https://bugs.chromium.org/p/chromium/issues/detail?id=928068
        'Antarctica/Mawson',
        'Antarctica/Palmer',
        'Antarctica/Rothera',
        'Antarctica/Syowa',
        'Antarctica/Troll',
        'Antarctica/Vostok',
        'America/Argentina/Buenos_Aires',
        'America/Argentina/Cordoba',
        'America/Argentina/Salta',
        'America/Argentina/Jujuy',
        'America/Argentina/Tucuman',
        'America/Argentina/Catamarca',
        'America/Argentina/La_Rioja',
        'America/Argentina/San_Juan',
        'America/Argentina/Mendoza',
        'America/Argentina/San_Luis',
        'America/Argentina/Rio_Gallegos',
        'America/Argentina/Ushuaia',
        'Pacific/Pago_Pago',
        'Europe/Vienna',
        'Australia/Lord_Howe',
        'Antarctica/Macquarie',
        'Australia/Hobart',
        'Australia/Currie',
        'Australia/Melbourne',
        'Australia/Sydney',
        'Australia/Broken_Hill',
        'Australia/Brisbane',
        'Australia/Lindeman',
        'Australia/Adelaide',
        'Australia/Darwin',
        'Australia/Perth',
        'Australia/Eucla',
        'Asia/Baku',
        'America/Barbados',
        'Asia/Dhaka',
        'Europe/Brussels',
        'Europe/Sofia',
        'Atlantic/Bermuda',
        'Asia/Brunei',
        'America/La_Paz',
        'America/Noronha',
        'America/Belem',
        'America/Fortaleza',
        'America/Recife',
        'America/Araguaina',
        'America/Maceio',
        'America/Bahia',
        'America/Sao_Paulo',
        'America/Campo_Grande',
        'America/Cuiaba',
        'America/Santarem',
        'America/Porto_Velho',
        'America/Boa_Vista',
        'America/Manaus',
        'America/Eirunepe',
        'America/Rio_Branco',
        'America/Nassau',
        'Asia/Thimphu',
        'Europe/Minsk',
        'America/Belize',
        'America/St_Johns',
        'America/Halifax',
        'America/Glace_Bay',
        'America/Moncton',
        'America/Goose_Bay',
        'America/Blanc-Sablon',
        'America/Toronto',
        'America/Nipigon',
        'America/Thunder_Bay',
        'America/Iqaluit',
        'America/Pangnirtung',
        'America/Atikokan',
        'America/Winnipeg',
        'America/Rainy_River',
        'America/Resolute',
        'America/Rankin_Inlet',
        'America/Regina',
        'America/Swift_Current',
        'America/Edmonton',
        'America/Cambridge_Bay',
        'America/Yellowknife',
        'America/Inuvik',
        'America/Creston',
        'America/Dawson_Creek',
        'America/Fort_Nelson',
        'America/Vancouver',
        'America/Whitehorse',
        'America/Dawson',
        'Indian/Cocos',
        'Europe/Zurich',
        'Africa/Abidjan',
        'Pacific/Rarotonga',
        'America/Santiago',
        'America/Punta_Arenas',
        'Pacific/Easter',
        'Asia/Shanghai',
        'Asia/Urumqi',
        'America/Bogota',
        'America/Costa_Rica',
        'America/Havana',
        'Atlantic/Cape_Verde',
        'America/Curacao',
        'Indian/Christmas',
        'Asia/Nicosia',
        'Asia/Famagusta',
        'Europe/Prague',
        'Europe/Berlin',
        'Europe/Copenhagen',
        'America/Santo_Domingo',
        'Africa/Algiers',
        'America/Guayaquil',
        'Pacific/Galapagos',
        'Europe/Tallinn',
        'Africa/Cairo',
        'Africa/El_Aaiun',
        'Europe/Madrid',
        'Africa/Ceuta',
        'Atlantic/Canary',
        'Europe/Helsinki',
        'Pacific/Fiji',
        'Atlantic/Stanley',
        'Pacific/Chuuk',
        'Pacific/Pohnpei',
        'Pacific/Kosrae',
        'Atlantic/Faroe',
        'Europe/Paris',
        'Europe/London',
        'Asia/Tbilisi',
        'America/Cayenne',
        'Africa/Accra',
        'Europe/Gibraltar',
        'America/Godthab',
        'America/Danmarkshavn',
        'America/Scoresbysund',
        'America/Thule',
        'Europe/Athens',
        'Atlantic/South_Georgia',
        'America/Guatemala',
        'Pacific/Guam',
        'Africa/Bissau',
        'America/Guyana',
        'Asia/Hong_Kong',
        'America/Tegucigalpa',
        'America/Port-au-Prince',
        'Europe/Budapest',
        'Asia/Jakarta',
        'Asia/Pontianak',
        'Asia/Makassar',
        'Asia/Jayapura',
        'Europe/Dublin',
        'Asia/Jerusalem',
        'Asia/Kolkata',
        'Indian/Chagos',
        'Asia/Baghdad',
        'Asia/Tehran',
        'Atlantic/Reykjavik',
        'Europe/Rome',
        'America/Jamaica',
        'Asia/Amman',
        'Asia/Tokyo',
        'Africa/Nairobi',
        'Asia/Bishkek',
        'Pacific/Tarawa',
        'Pacific/Enderbury',
        'Pacific/Kiritimati',
        'Asia/Pyongyang',
        'Asia/Seoul',
        'Asia/Almaty',
        'Asia/Qyzylorda',
        'Asia/Qostanay', // https://bugs.chromium.org/p/chromium/issues/detail?id=928068
        'Asia/Aqtobe',
        'Asia/Aqtau',
        'Asia/Atyrau',
        'Asia/Oral',
        'Asia/Beirut',
        'Asia/Colombo',
        'Africa/Monrovia',
        'Europe/Vilnius',
        'Europe/Luxembourg',
        'Europe/Riga',
        'Africa/Tripoli',
        'Africa/Casablanca',
        'Europe/Monaco',
        'Europe/Chisinau',
        'Pacific/Majuro',
        'Pacific/Kwajalein',
        'Asia/Yangon',
        'Asia/Ulaanbaatar',
        'Asia/Hovd',
        'Asia/Choibalsan',
        'Asia/Macau',
        'America/Martinique',
        'Europe/Malta',
        'Indian/Mauritius',
        'Indian/Maldives',
        'America/Mexico_City',
        'America/Cancun',
        'America/Merida',
        'America/Monterrey',
        'America/Matamoros',
        'America/Mazatlan',
        'America/Chihuahua',
        'America/Ojinaga',
        'America/Hermosillo',
        'America/Tijuana',
        'America/Bahia_Banderas',
        'Asia/Kuala_Lumpur',
        'Asia/Kuching',
        'Africa/Maputo',
        'Africa/Windhoek',
        'Pacific/Noumea',
        'Pacific/Norfolk',
        'Africa/Lagos',
        'America/Managua',
        'Europe/Amsterdam',
        'Europe/Oslo',
        'Asia/Kathmandu',
        'Pacific/Nauru',
        'Pacific/Niue',
        'Pacific/Auckland',
        'Pacific/Chatham',
        'America/Panama',
        'America/Lima',
        'Pacific/Tahiti',
        'Pacific/Marquesas',
        'Pacific/Gambier',
        'Pacific/Port_Moresby',
        'Pacific/Bougainville',
        'Asia/Manila',
        'Asia/Karachi',
        'Europe/Warsaw',
        'America/Miquelon',
        'Pacific/Pitcairn',
        'America/Puerto_Rico',
        'Asia/Gaza',
        'Asia/Hebron',
        'Europe/Lisbon',
        'Atlantic/Madeira',
        'Atlantic/Azores',
        'Pacific/Palau',
        'America/Asuncion',
        'Asia/Qatar',
        'Indian/Reunion',
        'Europe/Bucharest',
        'Europe/Belgrade',
        'Europe/Kaliningrad',
        'Europe/Moscow',
        'Europe/Simferopol',
        'Europe/Kirov',
        'Europe/Astrakhan',
        'Europe/Volgograd',
        'Europe/Saratov',
        'Europe/Ulyanovsk',
        'Europe/Samara',
        'Asia/Yekaterinburg',
        'Asia/Omsk',
        'Asia/Novosibirsk',
        'Asia/Barnaul',
        'Asia/Tomsk',
        'Asia/Novokuznetsk',
        'Asia/Krasnoyarsk',
        'Asia/Irkutsk',
        'Asia/Chita',
        'Asia/Yakutsk',
        'Asia/Khandyga',
        'Asia/Vladivostok',
        'Asia/Ust-Nera',
        'Asia/Magadan',
        'Asia/Sakhalin',
        'Asia/Srednekolymsk',
        'Asia/Kamchatka',
        'Asia/Anadyr',
        'Asia/Riyadh',
        'Pacific/Guadalcanal',
        'Indian/Mahe',
        'Africa/Khartoum',
        'Europe/Stockholm',
        'Asia/Singapore',
        'America/Paramaribo',
        'Africa/Juba',
        'Africa/Sao_Tome',
        'America/El_Salvador',
        'Asia/Damascus',
        'America/Grand_Turk',
        'Africa/Ndjamena',
        'Indian/Kerguelen',
        'Asia/Bangkok',
        'Asia/Dushanbe',
        'Pacific/Fakaofo',
        'Asia/Dili',
        'Asia/Ashgabat',
        'Africa/Tunis',
        'Pacific/Tongatapu',
        'Europe/Istanbul',
        'America/Port_of_Spain',
        'Pacific/Funafuti',
        'Asia/Taipei',
        'Europe/Kiev',
        'Europe/Uzhgorod',
        'Europe/Zaporozhye',
        'Pacific/Wake',
        'America/New_York',
        'America/Detroit',
        'America/Kentucky/Louisville',
        'America/Kentucky/Monticello',
        'America/Indiana/Indianapolis',
        'America/Indiana/Vincennes',
        'America/Indiana/Winamac',
        'America/Indiana/Marengo',
        'America/Indiana/Petersburg',
        'America/Indiana/Vevay',
        'America/Chicago',
        'America/Indiana/Tell_City',
        'America/Indiana/Knox',
        'America/Menominee',
        'America/North_Dakota/Center',
        'America/North_Dakota/New_Salem',
        'America/North_Dakota/Beulah',
        'America/Denver',
        'America/Boise',
        'America/Phoenix',
        'America/Los_Angeles',
        'America/Anchorage',
        'America/Juneau',
        'America/Sitka',
        'America/Metlakatla',
        'America/Yakutat',
        'America/Nome',
        'America/Adak',
        'Pacific/Honolulu',
        'America/Montevideo',
        'Asia/Samarkand',
        'Asia/Tashkent',
        'America/Caracas',
        'Asia/Ho_Chi_Minh',
        'Pacific/Efate',
        'Pacific/Wallis',
        'Pacific/Apia',
        'Africa/Johannesburg',
    ];

    public function getProfileImageAttribute(): string
    {
        /** @var Media $media */
        $media = $this->getMedia(self::PROFILE)->first();
        if (! empty($media)) {
            return $media->getFullUrl();
        }

        $gender = $this->gender;

        if ($gender == self::FEMALE) {
            return asset('web/media/avatars/female.png');
        }

        return asset('web/media/avatars/male.png');
    }

    public function getFullNameAttribute(): string
    {
        return $this->first_name.' '.$this->last_name;
    }

    public function personalExperience(): BelongsTo
    {
        return $this->belongsTo(PersonalExperience::class, 'personal_experience_id');
    }

    public function schedule(): HasOne
    {
        return $this->hasOne(Schedule::class);
    }

    public function gCredentials(): HasOne
    {
        return $this->hasOne(GoogleCalendarIntegration::class, 'user_id');
    }
}
