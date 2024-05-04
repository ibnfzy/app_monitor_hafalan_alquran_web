<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index(): string
    {
        return view('web/index');
    }

    public function notonline()
    {
        return view('errors/html/mt');
    }
}
