<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Laravel\Sanctum\HasApiTokens;

/**
 * @property int id
 * @property bool is_owner
 * @method withLastLogin()
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
        'email_verified_at' => 'datetime',
    ];

//    protected $with = [];


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
}
