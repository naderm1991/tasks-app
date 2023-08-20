<?php

use App\Http\Controllers\BooksController;
use App\Http\Controllers\ContactsController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\FeaturesController;
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
Route::resource('customers', CustomerController::class);
Route::resource('books', BooksController::class);
Route::get('contacts', ContactsController::class);
Route::get('features', [FeaturesController::class, 'index'])->name('features.index');
Route::get('devices', [\App\Http\Controllers\DevicesController::class, 'index'])->name('devices.index');
Route::get('posts', [\App\Http\Controllers\PostController::class, 'index'])->name('posts.index');
Route::get('posts', [\App\Http\Controllers\PostController::class, 'index'])->name('posts.index');
Route::get('stores', [\App\Http\Controllers\StoreController::class, 'index'])->name('stores.index');
