<?php

namespace App\Http\Controllers;

use App\Http\Controllers\BaseController;
use App\Http\Resources\UserResource;
use App\Models\Task;
use App\Models\User;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class UserController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|\Illuminate\Contracts\View\View
     */
    public function index(): \Illuminate\Contracts\View\View|Factory|Application
    {
        $users = User::query()
            ->select(['name'])->orderBy('id','desc')->paginate(10)
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
