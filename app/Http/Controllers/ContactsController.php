<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ContactsController extends BaseController
{
    public function __invoke(): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Contracts\Foundation\Application
    {
        return view('contacts');
    }
}
