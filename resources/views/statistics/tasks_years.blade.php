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
                <h2>Tasks Statistics</h2>
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
        @foreach ($years as $year => $tasks)
            <main>
                <div>
                    <h2>
                        {{$year}}
                    </h2>
                    <div>
                        @foreach($tasks as $task)
                            <div>
                                <span>{{ $task->title }}</span>
                                <h3>date: {{ $task->created_at->toFormattedDateString() }} </h3>
                                <h6> Assigned to: {{$task->user->name}}</h6>
                            </div>
                        @endforeach
                    </div>
                </div>
            </main>
        @endforeach
</div>
</body>
</html>
