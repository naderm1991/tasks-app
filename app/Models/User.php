<?php

namespace App\Models;

use App\Builders\UserBuilder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Laravel\Sanctum\HasApiTokens;

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

    //protected $with = ['company'];

    public static function search($term,$is_admin=0): Collection
    {
        return DB::table('users')
            ->where('name', 'like',"%".$term."%")
            ->where('is_admin',$is_admin)
            ->get(['id','name','is_admin'])
        ;
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

    /**
     * @return BelongsTo
     */
    public function lastLogin(): BelongsTo
    {
        // this refers to the current model
        // bad approach because: will load all the models
        return $this->belongsTo(Login::class);
    }

    public function scopeWithLastLogin($query): void
    {
        $query->addSelect(['last_login_id' => Login::query()
            ->select('created_at')
            ->whereColumn('user_id','users.id')
            ->latest()
            ->take(1)
        ])
        ->withCasts(['last_login_id' => 'datetime']);
    }


//    /**
//     * @param $query
//     * @return UserBuilder
//     */
//    public function newEloquentBuilder($query): UserBuilder
//    {
//        return new UserBuilder($query);
//    }
//
//    public static function query() : UserBuilder
//    {
//        return UserBuilder::query();
//    }
}
