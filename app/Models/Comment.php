<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property mixed $task
 */
class Comment extends Model
{
    use HasFactory;

    protected $with = ['user'];
    public function task(): BelongsTo
    {
        return $this->belongsTo(Task::class);
    }

    /**
     * Every comment belongs to a user
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function isAuthor(): bool
    {
        // q: this->task->comments->first()->user_id what this means?
        // a: this means the first comment of the task
        return $this->task->comments->first()->user_id === $this->user_id;
    }
}
