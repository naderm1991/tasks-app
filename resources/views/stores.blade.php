<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Books</title>
    <style>
        label {
            display: block;
            font: 1rem 'Fira Sans', sans-serif;
        }
        input
    </style>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" >
</head>
<body>
<div class="container mt-2">
    <label for="site-search">Search the site:</label>
    <input type="text" id="site-search" name="q" value="{{request('search')}}">
    <button class="searchButton">Search</button>

    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Locations</h2>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <a class="btn btn-success" href="{{ route('stores.create') }}"> Create New Store</a>
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
            <th>Address</th>
            <th>City</th>
            <th>Distance</th>
        </tr>
        </thead>
        <tbody>
        {{-- // create foreach books--}}
        @foreach ($stores as $store)
            <tr>
                <td>{{ $store->address }}</td>
                <td>
                    {{$store->city}} {{$store->state}}
                </td>
                <td>
                    {{$store->distance}}
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
    {{--    {{$customers->total()}}--}}
    {{ $stores->links() }}
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
                let value = "?search=" + textVal;
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