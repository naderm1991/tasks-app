<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Book extends Model
{
    use HasFactory;

    public function user()
    {
        // inverse of belongsToMany
        return $this->belongsToMany(User::class,'checkouts')
            ->using(Checkout::class)
            ->withPivot('borrowed_date')
        ;
    }

    public function lastCheckout(): BelongsTo
    {
        return $this->belongsTo(Checkout::class);
    }
    public function scopeWithLastCheckout($query): void
    {
        $query->addSelect(['last_checkout_id' =>
            (Checkout::query()
                ->select('id')
                ->whereColumn('book_id','books.id')
                ->orderByDesc('borrowed_date')
                ->latest()
                ->take(1)
            )
        ])
        //todo add needed columns only
        ->with('lastCheckout');
    }
}
