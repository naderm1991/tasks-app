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
                <h2>Users</h2>
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
            <th>NAME</th>
            <th>EMAIL</th>
            <th>
                LAST LOGIN
            </th>

            <th>Company</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($users as $user)
            <tr>
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
                <td>
{{--                    {{ $user->last_login_at->diffForHumans() }}--}}

                    @if($user->lastLogin)
                        {{ $user->lastLogin->created_at->diffForHumans() }}
                    @endif
                    <span class="text-sm-center">
                        @if($user->lastLogin)
                            ({{ $user->last_login_ip_address }})
                        @endif
                    </span>
                </td>
                <td>{{ $user->company->name }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
    {{ $users->links('pagination::bootstrap-4') }}
</div>
</body>
</html>
