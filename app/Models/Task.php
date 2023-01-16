<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Facades\DB;

/**
 * @method static orderBy(string $string, string $string1)
 * @method static create(array|string|null $post)
 */
class Task extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'description', 'assigned_by_id','assigned_to_id'];

    public function admin(): BelongsTo
    {
        return $this->belongsTo(
            User::class,'assigned_by_id','id');
//        return $this->belongsToMany(User::class,'tasks','id', 'assigned_by_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(
            User::class,'assigned_to_id','id');
    }

    static function userTasksCount(): \Illuminate\Support\Collection
    {
        return DB::table('users')
            ->join('tasks', 'users.id', '=', 'tasks.assigned_to_id')
            ->select('users.*','tasks.*', DB::raw('count(tasks.id) as count'))
            ->groupBy('users.id')
            ->orderBy('count','DESC')
            ->limit(10)
            ->get()
        ;
    }
}
