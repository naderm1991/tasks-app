<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Feature extends Model
{
    use HasFactory;

    public static function search($query)
    {
        return empty($query) ?
            static::query() :
            static::query()->where('name', 'like', '%'.$query.'%')->orWhere('email', 'like', '%'.$query.'%')
            ;
    }
}
