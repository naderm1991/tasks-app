<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UserController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     */
    public function index(): View|Factory|Application
    {
        $users = User::with('company')
            ->select(['id','name','company_id','email'])
//            ->withLastLogin()
            ->addSelect(['last_login_id' => \App\Models\Login::query()->select('created_at')
                ->whereColumn('user_id','users.id')->latest()->take(1)
            ])
            ->orderBy('name')
            ->paginate(15)
        ;
        return view('users.index', compact('users'));
    }

    /**
     * Show the profile for a given user.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function search(Request $request): JsonResponse
    {
        $term = "";
        $requests = $request->all();
        if (isset($requests['term'])){$term =$requests['term'];}
        $user= User::search($term,$requests["is_admin"]??0);
        return $this->sendResponse($user, 'Users retrieved successfully.');
    }
}

