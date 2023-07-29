<?php

namespace App\Http\Controllers;

use App\Models\Customer;
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
        Auth::login(User::query()->where('name', 'Bailey Bode')->first());
        $customers = Customer::query()
            ->with('salesRep')
            ->visibleTo(Auth::user())
            ->orderBy('name')
            ->paginate()
        ;
        return view('customers.index', [
            'customers' => $customers
        ]);
    }
}
