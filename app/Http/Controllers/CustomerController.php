<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Region;
use App\Models\User;
use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     */
    public function index(): View|Factory|Application
    {
        $regions = Region::all();

        $customers = Customer::query()
            ->inRegion(Region::query()->where('name', 'The Prairies')->first())
            ->get()
        ;

//        dd($regions->where('name', 'British Columbia')->first());
//        dd($customers);
        return view('customers.map', [
            'customers' => $customers,
            'regions' => $regions,
        ]);
    }
}
