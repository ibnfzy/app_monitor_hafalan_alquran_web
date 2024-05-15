<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index(): string
    {
        return view('web/new_home');
    }

    public function notonline()
    {
        return view('errors/html/mt');
    }

    public function new_home()
    {
        return view('web/new_home');
    }
}
