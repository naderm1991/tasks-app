<?php

namespace App\Models;

use Database\Factories\CheckoutFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * App\Models\Checkout
 *
 * @property int $id
 * @property int $book_id
 * @property int $user_id
 * @property Carbon|null $borrowed_date
 * @property-read User $user
 * @method static CheckoutFactory factory(...$parameters)
 * @method static Builder|Checkout newModelQuery()
 * @method static Builder|Checkout newQuery()
 * @method static Builder|Checkout query()
 * @method static Builder|Checkout whereBookId($value)
 * @method static Builder|Checkout whereBorrowedDate($value)
 * @method static Builder|Checkout whereId($value)
 * @method static Builder|Checkout whereUserId($value)
 * @mixin \Eloquent
 */
class Checkout extends Model
{
    use HasFactory;

    protected $table = 'checkouts';

    public $timestamps = false;

    protected $casts = [
        'borrowed_date' => 'date',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class,'user_id','id');
    }
}
