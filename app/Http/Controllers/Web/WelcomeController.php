<?php

namespace App\Http\Controllers\Web;

class WelcomeController extends \App\Http\Controllers\Controller
{
    public function __invoke()
    {
        return view('welcome');
    }
}
