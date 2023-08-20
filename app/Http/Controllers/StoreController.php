<?php

namespace App\Http\Controllers;

use App\Models\Store;
use App\Models\User;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class StoreController extends Controller
{
    public function index(): Factory|View|Application
    {
        $myLocation = [-79.47, 43.14];

        $stores = Store::query()
            ->selectDistanceTo($myLocation)
            ->paginate()
        ;

        return view('stores',['stores' => $stores]);
    }
}
