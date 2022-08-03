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
            <th>Title</th>
            <th>Description</th>
            <th>Assigned Name</th>
            <th>Admin Name</th>
            <th>Action</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($tasks as $task)
            <tr>
                <td>{{ $task->id }}</td>
                <td>{{ $task->name }}</td>
                <td>{{ $task->email }}</td>
                <td>{{ $task->address }}</td>
                <td>
                    <form action="{{ route('tasks.destroy',$task->id) }}" method="Post">
                        <a class="btn btn-primary" href="{{ route('tasks.edit',$task->id) }}">Edit</a>
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </form>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
    {!! $tasks->links() !!}
</div>
</body>
</html>
