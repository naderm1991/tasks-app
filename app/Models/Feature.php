<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\DB;

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

    public function scopeOrderByStatus($query, $direction)
    {
        return $query->orderBy(DB::raw('
            CASE
                WHEN status = "Requested" THEN 1
                WHEN status = "Approved" THEN 2
                WHEN status = "Completed" THEN 3
            END
        '), $direction);
    }

    public function scopeOrderByActivity($query, $direction)
    {
        // sort by votes_count + (comments_count * 2)
        // it's easier than you think
        return $query->orderBy(DB::raw('-(votes_count + (comments_count * 2))'), $direction);
    }
}
