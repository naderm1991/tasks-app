<?php

namespace App\Models;

use App\Model;
use Database\Factories\CustomerFactory;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Notifications\DatabaseNotificationCollection;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Carbon;
use Laravel\Sanctum\HasApiTokens;
use Laravel\Sanctum\PersonalAccessToken;

/**
 * App\Models\Customer
 *
 * @property int id
 * @property int sales_rep_id
 * @property string $name
 * @property string $city
 * @property int $state
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read DatabaseNotificationCollection<int, DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @property-read User|null $salesRep
 * @property-read Collection<int, PersonalAccessToken> $tokens
 * @property-read int|null $tokens_count
 * @property mixed $location
 * @method static CustomerFactory factory(...$parameters)
 * @method static Builder|Customer newModelQuery()
 * @method static Builder|Customer newQuery()
 * @method static Builder|Customer query()
 * @method static Builder|Customer whereCity($value)
 * @method static Builder|Customer whereCreatedAt($value)
 * @method static Builder|Customer whereId($value)
 * @method static Builder|Customer whereName($value)
 * @method static Builder|Customer whereSalesRepId($value)
 * @method static Builder|Customer whereState($value)
 * @method static Builder|Customer whereUpdatedAt($value)
 *
 * @method static Builder|Customer visibleTo(User $user)
 * @method static Builder|Customer inRegion(null|Model $region)
 * @mixin Eloquent
 */
class Customer extends Model
{
    // q: create customer controller
    // a: php artisan make:controller CustomerController --resource --model=Customer
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

    public function salesRep(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public static function booted(): void
    {
        static::addGlobalScope(function ($query){
            if (is_null(static::getQuery()->columns)) {
                $query->select(['*']);
            }
            $query->selectRaw('ST_X(location) as latitude, ST_Y(location) as longitude');

        });
    }

    public function scopeVisibleTo($query, User $user)
    {
        if ($user->is_owner) {
            return $query;
        }
        return $query->where('sales_rep_id', $user->id);
    }

    public function scopeInRegion($query, Region $region): void
    {
        $query->whereRaw("ST_Contains(?, customers.location)", [$region->geometry]);
    }
}
