<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Login;
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
        //todo check the load time without the queries
        $users = User::query()
            //->whereBirthDayThisWeek()
            ->orderByUpComingBirthDay()
            //->toSql()
            ->orderBy('name')
            ->paginate()
        ;
        return view('users.index', ['users' => $users]);
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

