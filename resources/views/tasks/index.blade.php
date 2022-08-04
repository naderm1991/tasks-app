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
    <table class="table table-bordered">
        <thead>
        <tr>
            <th>Title</th>
            <th>Description</th>
            <th>Assigned Name</th>
            <th>Admin Name</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($tasks as $task)
            <tr>
                <td>{{ $task->title }}</td>
                <td>{{ $task->description }}</td>
                @if(isset($task->users->first()->name))
                <td>
                    {{$task->users->first()->name }}
                </td>
                @endif
                @if(isset($task->admins->first()->name))
                    <td>{{$task->admins->first()->name}}</td>
                @endif
            </tr>
        @endforeach
        </tbody>
    </table>
    {!! $tasks->links() !!}
</div>
</body>
</html>
