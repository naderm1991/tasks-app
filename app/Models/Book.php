<?php

namespace App\Models;

use Database\Factories\BookFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * App\Models\Book
 *
 * @bublic method withLastCheckout()
 * @property int $id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $name
 * @property string|null $author
 * @property-read Checkout|null $lastCheckout
 * @property-read Collection<int, User> $user
 * @property-read int|null $user_count
 * @method static BookFactory factory(...$parameters)
 * @method static Builder|Book newModelQuery()
 * @method static Builder|Book newQuery()
 * @method static Builder|Book query()
 * @method static Builder|Book whereAuthor($value)
 * @method static Builder|Book whereCreatedAt($value)
 * @method static Builder|Book whereId($value)
 * @method static Builder|Book whereName($value)
 * @method static Builder|Book whereUpdatedAt($value)
 * @method static Builder|Book withLastCheckout()
 * @mixin \Eloquent
 */
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
