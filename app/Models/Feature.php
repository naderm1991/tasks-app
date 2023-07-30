<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Feature extends Model
{
    use HasFactory;

    public static function search($query)
    {
        //create features factory command: php artisan make:factory FeatureFactory --model=Feature
        return empty($query) ?
            static::query() :
            static::query()->where('name', 'like', '%'.$query.'%')->orWhere('email', 'like', '%'.$query.'%')
        ;
    }

    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }

    public function votes(): HasMany
    {
        return $this->hasMany(Vote::class);
    }
}
