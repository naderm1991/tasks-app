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
 * @property int|mixed $isAdmin
 * @method static orderBy(string $string, string $string1)
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
}
