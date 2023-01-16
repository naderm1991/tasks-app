<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Support\Facades\View;

/**
 * Tasks statistics
 */
class StatisticsController extends Controller
{
    /**
     * Show the profile for a given user.
     *
     */
    public function userTasksCount(): Factory|\Illuminate\Contracts\View\View|Application
    {
        $tasks_count = Task::userTasksCount();
        return view('statistics.user_tasks_count', compact('tasks_count'));
    }

    /**
     * Show the profile for a given user.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function tasksPerYear(): \Illuminate\Contracts\View\View
    {
        $years = Task::query()
            ->select('id','title','created_at','assigned_by_id','assigned_to_id')
            ->with(['user:id,name'])
            ->latest('created_at')
            ->limit(500)
            ->get()
            ->groupBy(fn ($task) => $task->created_at->year)
        ;
        return View::make(
            'statistics.tasks_years', ['years'=> $years]
        );
    }
}
