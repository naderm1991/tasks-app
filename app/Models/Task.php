<?php

namespace App\Models;

use Database\Factories\TaskFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

/**
 * App\Models\Task
 *
 * @method static orderBy(string $string, string $string1)
 * @method static create(array|string|null $post)
 * @property int $id
 * @property string $title
 * @property string $description
 * @property int $assigned_by_id
 * @property int $assigned_to_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string $status
 * @property-read User|null $admin
 * @property-read User|null $user
 * @property HasMany $comments
 * @method static TaskFactory factory(...$parameters)
 * @method static Builder|Task newModelQuery()
 * @method static Builder|Task newQuery()
 * @method static Builder|Task query()
 * @method static Builder|Task whereAssignedById($value)
 * @method static Builder|Task whereAssignedToId($value)
 * @method static Builder|Task whereCreatedAt($value)
 * @method static Builder|Task whereDescription($value)
 * @method static Builder|Task whereId($value)
 * @method static Builder|Task whereStatus($value)
 * @method static Builder|Task whereTitle($value)
 * @method static Builder|Task whereUpdatedAt($value)
 * @property-read \App\Models\User|null $assignedTo
 * @property-read int|null $comments_count
 * @mixin \Eloquent
 */
class Task extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'description','assigned_to_id'];

    // todo remove this for testing
//    protected $with = ['user','comments'];

    public function assignedTo(): BelongsTo
    {
        return $this->belongsTo(User::class,'assigned_to_id','id');
//        return $this->belongsToMany(User::class,'tasks','id', 'assigned_by_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
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

    public function comments(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Comment::class)->orderBy('created_at');
    }
}
