<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Notifications\DatabaseNotificationCollection;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Carbon;
use Laravel\Sanctum\HasApiTokens;

/**
 * App\Models\User
 *
 * @property int id
 * @property bool is_owner
 * @method withLastLogin()
 * @property string $name
 * @property string|null $name_normalized
 * @property string $email
 * @property Carbon|null $email_verified_at
 * @property string $password
 * @property int $is_admin
 * @property string|null $remember_token
 * @property string $first_name
 * @property string|null $first_name_normalized
 * @property string $last_name
 * @property string|null $last_name_normalized
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property int $company_id
 * @property-read \Illuminate\Database\Eloquent\Collection<int, Book> $books
 * @property-read int|null $books_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, Comment> $comments
 * @property-read int|null $comments_count
 * @property-read Company $company
 * @property-read Login|null $lastLogin
 * @property-read \Illuminate\Database\Eloquent\Collection<int, Login> $logins
 * @property-read int|null $logins_count
 * @property-read DatabaseNotificationCollection<int, DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Task> $tasks
 * @property-read int|null $tasks_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Laravel\Sanctum\PersonalAccessToken> $tokens
 * @property-read int|null $tokens_count
 * @method static \Database\Factories\UserFactory factory(...$parameters)
 * @method static Builder|User newModelQuery()
 * @method static Builder|User newQuery()
 * @method static Builder|User orderByLastLogin()
 * @method static Builder|User query()
 * @method static Builder|User search($query,?string $term = null)
 * @method static Builder|User whereCompanyId($value)
 * @method static Builder|User whereCreatedAt($value)
 * @method static Builder|User whereEmail($value)
 * @method static Builder|User whereEmailVerifiedAt($value)
 * @method static Builder|User whereFirstName($value)
 * @method static Builder|User whereFirstNameNormalized($value)
 * @method static Builder|User whereId($value)
 * @method static Builder|User whereIsAdmin($value)
 * @method static Builder|User whereIsOwner($value)
 * @method static Builder|User whereLastName($value)
 * @method static Builder|User whereLastNameNormalized($value)
 * @method static Builder|User whereName($value)
 * @method static Builder|User whereNameNormalized($value)
 * @method static Builder|User wherePassword($value)
 * @method static Builder|User whereRememberToken($value)
 * @method static Builder|User whereUpdatedAt($value)
 * @method static Builder|User withLastLoginAt()
 * @method static Builder|User withLastLoginIpAddress()
 * @method static Builder|User orderByBirthDay()
 * @method static Builder|User whereBirthDayThisWeek()
 * @method orderByUpComingBirthDay()
 * @mixin Eloquent
 */
class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'company_id'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'birth_date' => 'date',
        'email_verified_at' => 'datetime',
    ];

    public function scopeOrderByBirthDay($query): void
    {
        $query->orderByRaw("DATE_FORMAT(birth_date,'%m-%d')");
    }

    /**
     * get the users with birthday is this week
     * @param $query
     * @return void
     */
    public function scopeWhereBirthDayThisWeek($query): void
    {
        Carbon::setTestNow(Carbon::parse('January 1, 2023'));

//        $query->whereRaw('date_format(birth_date,"%m-%d") between ? and ?', [
//            Carbon::now()->startOfWeek()->format('m-d'),
//            Carbon::now()->endOfWeek()->format('m-d'),
//        ]);

        // map function returns generator
        $dates = Carbon::now()
            ->startOfWeek()
            ->daysUntil(Carbon::now()->endOfWeek())
            ->map(fn($date) => $date->format('m-d'))
        ;

        $query->whereRaw("DATE_FORMAT(birth_date,'%m-%d') IN (?,?,?,?,?,?,?)",iterator_to_array($dates));
    }

    public function scopeOrderByUpComingBirthDay($query): void
    {
        if (config('database.default') === 'mysql') {
            $query->orderByRaw('
                case
                    when (birth_date + interval (year(?) - year(birth_date)) year) >= ?
                    then (birth_date + interval (year(?) - year(birth_date)) year)
                    else (birth_date + interval (year(?) - year(birth_date)) + 1 year)
                end
            ', [
                array_fill(0, 4, Carbon::now()->startOfWeek()->toDateString()),
            ]);
        }
    }

    public function tasks(): HasMany
    {
        return $this->hasMany(Task::class,'assigned_to_id');
    }
    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }
    public function logins(): HasMany
    {
        return $this->hasMany(Login::class);
    }
    public function scopeWithLastLoginAt($query): void
    {
        $query->addSelect(['last_login_at' => Login::query()
            ->select('created_at')
            ->whereColumn('user_id','users.id')
            ->latest()
            ->take(1)
        ])
        ->withCasts(['last_login_at' => 'datetime']);
    }
    public function scopeWithLastLoginIpAddress($query): void
    {
        $query->addSelect(['last_login_ip_address' => Login::query()
            ->select('ip_address')
            ->whereColumn('user_id','users.id')
            ->latest()
            ->take(1)
        ]);
    }
    /**
     * @return BelongsTo
     */
    public function lastLogin(): BelongsTo
    {
        // wrong way
        //return $this->hasOne(Login::class)->latest()->take(1);
        // right way
        return $this->belongsTo(Login::class);
    }
    public function scopeWithLastLogin($query): void
    {
        $query->addSelect(['last_login_id' => Login::query()
            ->select('id')
            ->whereColumn('user_id','users.id')
            ->latest()
            ->take(1)
        ])->with('lastLogin:id,ip_address,created_at');
    }
    public function scopeOrderByLastLogin($query): void
    {
        $query->orderByDesc(Login::query()->select('created_at')
            ->whereColumn('user_id', 'users.id')
            ->latest()
            ->take(1)
        );
    }
    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }
    public function scopeSearch($query, string $term = null): void
    {
        // when you use a company model, you will create a separated query
        collect(str_getcsv($term,' ','"'))->filter()->each(function (string $term) use ($query) {
            $term = preg_replace('/[^A-Za-z0-9]/', '', $term).'%';
            // where in
            $query->whereIn('id', function ($query) use ($term) {
                // derived table
                $query->select('id')
                    ->from(function ($query) use ($term){
                        $query->select('id')
                            // find users by first nad last name
                            ->from('users')
                            ->where('name_normalized','like',$term)
                            ->orWhere('first_name_normalized','like',$term)
                            ->orWhere('last_name_normalized','like',$term)
                            // union // find users by company name
                            ->union(
                                (
                                    $query->newQuery()
                                    ->select('users.id')
                                    ->from('users')
                                    ->join('companies','companies.id','=','users.company_id')
                                    ->where('companies.name_normalized','like',$term)
                                )
                            )
                        ;
                    }, 'matches')
                ;
            });
        });
    }

    public function books(): BelongsToMany
    {
        return
            $this->belongsToMany(Book::class,'checkouts')
            ->using(Checkout::class)
            ->withPivot(['borrowed_date'])
        ;
    }
}
