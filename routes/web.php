<?php

use App\Http\Controllers\StatisticsController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect()->route('tasks.index');
});

Route::resource('tasks', TaskController::class);
Route::resource('users', UserController::class);
Route::get('user/search', [UserController::class, 'search'])->name('users.search');
Route::get('statistics/user_tasks_count', [StatisticsController::class, 'userTasksCount'])->name('statistics.tasks');
Route::get('statistics/tasks_years', [StatisticsController::class, 'tasksPerYear'])->name('statistics.tasks');
