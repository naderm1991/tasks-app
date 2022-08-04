<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;

class StatisticsController extends Controller
{

    /**
     * Show the profile for a given user.
     *
     * @return Application|Factory|View
     */
    public function tasks()
    {
        $tasks_count = Task::userTasksCount();
        return view('statistics.tasks', compact('tasks_count'));
    }
}
