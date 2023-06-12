<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use PhpParser\Node\Expr\Cast\Object_;

class TaskController extends Controller
{
    private array $validationItems = [
        'title' => 'required',
        'description' => 'required',
        'assigned_by_id'=>'required',
        'assigned_to_id' =>'required'
    ];

    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     */
    public function index(): View|Factory|Application
    {
        if (env('DB_CONNECTION') == "pgsql"){
            // postgres users
            $statuses = Task::query()->toBase()
                ->selectRaw("count(*) filter (where status = 'Requested')". " as requested")
                ->selectRaw("count(*) filter (where status = 'Planned')". " as planned")
                ->selectRaw("count(*) filter (where status = 'Completed')". " as completed")
                ->selectRaw("count(*) filter (where status = 'Pending')". " as pending")
                ->first()
            ;
        }else {
            // MySql
            $statuses = Task::query()->toBase()
                ->selectRaw("sum(status = 'Requested')". " as requested")
                ->selectRaw("sum(status = 'Planned')". " as planned")
                ->selectRaw("sum(status = 'Completed')". " as completed")
                ->selectRaw("sum(status = 'Pending')". " as pending")
                ->first()
            ;
        }
        $tasks = Task::with(['user','admin'])
            ->orderBy('title','desc')
            ->paginate(100)
        ;
        return view('tasks.index', compact('tasks','statuses'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|View
     */
    public function create(): View|Factory|Application
    {
        return view('tasks.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate($this->validationItems);

        Task::create($request->post());

        return redirect()->route('tasks.index')
            ->with('success','Task has been created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param Task $task
     * @return Application|Factory|View
     */
    public function show(Task $task)
    {
        return view('tasks.show',compact('task'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Task  $task
     * @return Application|Factory|View
     */
    public function edit(Task $task): View|Factory|Application
    {
        return view('tasks.edit',compact('task'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param  Task  $task
     * @return RedirectResponse
     */
    public function update(Request $request, Task $task): RedirectResponse
    {
        $request->validate($this->validationItems);
        $task->fill($request->post())->save();
        return redirect()->route('tasks.index')->with('success','Task Has Been updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Task $task
     * @return RedirectResponse
     */
    public function destroy(Task $task): RedirectResponse
    {
        $task->delete();
        return redirect()->route('tasks.index')->with('success','Tasks has been deleted successfully');
    }
}
