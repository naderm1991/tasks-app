<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;

class ContactsController extends BaseController
{
    public function __invoke(): Factory|View|Application
    {
        return view('contacts');
    }
}
