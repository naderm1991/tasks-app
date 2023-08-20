<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Notifications\DatabaseNotificationCollection;
use Illuminate\Support\Carbon;


/**
 * App\Models\Store
 *
 * @method static Builder|Store query()
 * @method static Builder|Store selectDistanceTo($myLocation)
 */
class Store extends Model
{
    use HasFactory;

    public function scopeOrderByBirthDay($query): void
    {
        $query->orderByRaw("DATE_FORMAT(birth_date,'%m-%d')");
    }

}
