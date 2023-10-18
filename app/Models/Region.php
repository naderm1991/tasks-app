<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Region
 *
 * @property int $id
 * @property string $name
 * @property string $color
 */
class Region extends Model
{
    use HasFactory;

    public static function booted()
    {
        static::addGlobalScope(function ($query){
            if (is_null($query->getQuery()->columns)) {
                $query->select(['*']);
            }

            $query->selectRaw('ST_AsGeoJSON(geometry) as geometry_as_json');
        });
    }
}
