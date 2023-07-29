<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Checkout;
use App\Models\User;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class BooksController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     */
    public function index(): View|Factory|Application
    {
        $books = Book::query()
            ->with('user')
            ->orderByRaw('user_id is null desc')
            ->orderBy('name')
            ->get();
        return view('books.index', ['books' => $books]);
    }
}
