<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Customers</title>
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
                <h2>Customers</h2>
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
            <th>COMPANY</th>
            <th>CITY</th>
            <th>SALES REPRESENTATIVE</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($customers as $customer)
            {{--  can the current view this customer --}}
            @can('view', $customer)
            <tr>
                <td>{{ $customer->name }}</td>
                <td>{{ $customer->city }}, {{ $customer->state }}</td>
                <td>{{ $customer->salesRep->name }}
                    @if($customer->salesRep->is_owner ) (Owner) @endif
                </td>
            </tr>
            @endcan
        @endforeach
        </tbody>
    </table>
    {{ $customers->links('pagination::bootstrap-4') }}
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
