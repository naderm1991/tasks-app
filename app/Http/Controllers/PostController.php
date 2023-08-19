<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     */
    public function index()
    {
        $posts = Post::with('author')
            ->select('*')
            ->when(request('search'), function ($query, $search) {
                $query
                    ->selectRaw('match(title, body) against (? in boolean mode) as score', [$search])
                    ->whereRaw('match(title, body) AGAINST (? IN boolean mode)', [$search])
                ;
            }, function ($query) {
                $query->latest('published_at');
            })
//            ->when(request('search'), function ($query, $search) {
//                $query->where('title', 'like', '%' . $search . '%')
//                    ->orWhere('body', 'like', '%' . $search . '%');
//            })
            ->paginate()
        ;
        return view('posts.index', compact('posts'));
    }
}
