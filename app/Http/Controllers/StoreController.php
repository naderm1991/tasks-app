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
        //Call to undefined method Illuminate\Database\Eloquent\Builder::toRawSql()
         $stores = Store::query()
             ->selectDistanceTo([-79.47, 43.14])
             ->withinDistanceTo([-79.47, 43.14],1000 * 15000)
             ->orderbyDistance([-79.47, 43.14])
             ->toRawSql()
            ;

         var_dump($stores);
        $myLocation = [-79.47, 43.14];

        $myLocation = [-79.47, 43.14. '& select * from users where id = 1'];
        $stores = Store::query()
            ->selectDistanceTo($myLocation)
            ->withinDistanceTo($myLocation,1000 * 15000)
            ->orderbyDistance($myLocation)
            ->toRawSql()
        ;

        dd($stores);

        return view('stores',['stores' => $stores]);
    }
}
