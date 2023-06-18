<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Tasks App</title>
    <style>
        label {
            display: block;
            font: 1rem 'Fira Sans', sans-serif;
        }

        input,
        label {
            margin: 0.4rem 0;
        }
    </style>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" >
</head>
<body>
<div class="container mt-2">
    <label for="site-search">Search the site:</label>
    <input type="text" id="site-search" name="q">
    <button class="searchButton">Search</button>

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
            <th>ID</th>
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
                <td>{{ $user->id }}</td>
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
                <td>
{{--                    {{ $user->last_login_at->diffForHumans() }}--}}

                    @if($user->lastLogin)
                        {{ $user->lastLogin->created_at->diffForHumans() }}
                    @endif
                    <span class="text-sm-center">
                        @if($user->lastLogin)
                            ({{ $user->lastLogin->ip_address }})
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

{{--add jquery cdn--}}
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
{{--add script--}}
{{-- on enter key preessed jquery--}}
<script>
    $(document).ready(function(){
        $("input:text[name=q]").keypress(function(e){
            if(e.keyCode===13)
            {
                let textVal = $("input:text[name=q]").val();
                let value = "?q=" + textVal;
                location.href = "{{url('users')}}" + value;
            }
        });
    });
</script>
<script>
    $(".searchButton").click(function(){
        var textVal = $("input:text[name=q]").val();

        value = "?q=" + textVal;
        location.href = "{{url('users')}}" + value;

    });
</script>
