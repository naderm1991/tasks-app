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
                <h2>Laravel 9 CRUD Example Tutorial</h2>
            </div>
            <div class="pull-right mb-2">
                <a class="btn btn-success" href="{{ route('tasks.create') }}"> Create tasks</a>
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
            <th>Name</th>
            <th>Tasks Number</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($tasks_count as $task)
            <tr>
                <td>{{ $task->name }}</td>
                <td>{{ $task->count }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
</body>
</html>
