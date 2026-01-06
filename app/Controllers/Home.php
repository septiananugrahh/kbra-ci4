<?php

namespace App\Controllers;

class Home extends CustomController
{
    public function index(): string
    {
        return view('welcome_message');
    }
}
