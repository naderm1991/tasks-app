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
    <input type="text" id="site-search" name="q" value="{{request('search')}}">
    <button class="searchButton">Search</button>

    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Posts</h2>
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
            <th>TITLE</th>
            <th>AUTHOR</th>
            <th>
                PUBLISHED
            </th>
        </tr>
        </thead>
        <tbody>
        @foreach ($posts as $post)
            <tr>
                <td>{{ $post->title }}
                    <span class="ml-1 px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                        ({{number_format($post->score,2)}})
                    </span>
                </td>
                <td>{{ $post->author?$post->author->name:"" }}</td>
                <td>
                    {{ $post->published_at->diffForHumans() }}
                </td>

            </tr>
        @endforeach
        </tbody>
    </table>
    {{$posts->total()}}
    {{ $posts->links('pagination::bootstrap-4') }}
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
                location.href = "{{url('posts')}}" + value;
            }
        });
    });
</script>
<script>
    $(".searchButton").click(function(){
        var textVal = $("input:text[name=q]").val();

        value = "?search=" + textVal;
        location.href = "{{url('users')}}" + value;
    });
</script>
