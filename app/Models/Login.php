<?php

namespace App\Models;

use Database\Factories\LoginFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * App\Models\Login
 *
 * @property int $id
 * @property int $user_id
 * @property string $ip_address
 * @property Carbon $created_at
 * @method static LoginFactory factory(...$parameters)
 * @method static Builder|Login newModelQuery()
 * @method static Builder|Login newQuery()
 * @method static Builder|Login query()
 * @method static Builder|Login whereCreatedAt($value)
 * @method static Builder|Login whereId($value)
 * @method static Builder|Login whereIpAddress($value)
 * @method static Builder|Login whereUserId($value)
 * @mixin \Eloquent
 */
class Login extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $dates = [
        'created_at'
    ];

}
