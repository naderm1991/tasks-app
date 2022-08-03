<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @method static orderBy(string $string, string $string1)
 * @method static create(array|string|null $post)
 */
class Task extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description', 'assigned_by_id','assigned_to_id'];
}
