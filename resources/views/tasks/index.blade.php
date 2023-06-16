<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Tasks App</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" >
</head>
<body>
<div class="container mt-2">
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Tasks</h2>
            </div>
            <div class="pull-right mb-2">
                <a class="btn btn-success" href="{{ route('tasks.create') }}">Create tasks</a>
                <a class="btn btn-success" href="{{ route('statistics.tasks') }}">Show Statistics</a>
            </div>
        </div>
    </div>
    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>
                    Requested {{ $statuses->requested }}
                </h2>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>
                    Planned {{ $statuses->planned }}
                </h2>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>
                    Completed {{ $statuses->completed }}
                </h2>
            </div>
        </div>
    </div>
    <table class="table table-bordered">
        <thead>
        <tr>
            <th>ID</th>
            <th>Title</th>
            <th>Description</th>
            <th>User Name</th>
            <th>Assigned To</th>
            <th>Comments</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($tasks as $task)
            <tr>
                <td>{{ $task->id }}</td>
                <td>{{ $task->title }}</td>
                <td>{{ $task->description }}</td>
                @if(isset($task->user->name))
                    <td>{{$task->user->name }}</td>
                @endif
                @if(isset($task->assignedTo->name))
                    <td>{{$task->assignedTo->name}}</td>
                @endif
                <td>
                    @foreach($task->comments as $comment)
                         <div>
{{--                            @if($comment->isAuthor())--}}
                                <hgroup>Admin:</hgroup>
{{--                            @endif--}}
                                {{ $comment->user->name }}:

                            {{ $comment->content }} ({{ $comment->created_at->diffForHumans() }})<br>
                             ------------------------------
                        </div>
                    @endforeach
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
    {{ $tasks->links('pagination::bootstrap-4') }}
</div>
</body>
</html>
