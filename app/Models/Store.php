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
 * @method withinDistanceTo($myLocation,int $int)
 */
class Store extends Model
{
    use HasFactory;

    public function scopeSelectDistanceTo(Builder $query, array $coordinates): void
    {
        if (is_null($query->getQuery()->columns)) {
            $query->select( '*');
        }

        $query->selectRaw(
            'ST_Distance(
                ST_SRID(Point(longitude, latitude),4326),
                ST_SRID(Point(?, ?),4326)
            )  as distance',$coordinates
        );
    }

    public function scopeWithinDistanceTo(Builder $query, $coordinates,int $distance): void
    {
        $query->whereRaw(
            'ST_Distance(
                ST_SRID(Point(longitude, latitude),4326),
                ST_SRID(Point(?, ?),4326)
            ) <= ?',[...$coordinates,$distance]
        );
    }
    public function scopeOrderByBirthDay($query): void
    {
        $query->orderByRaw("DATE_FORMAT(birth_date,'%m-%d')");
    }

}
