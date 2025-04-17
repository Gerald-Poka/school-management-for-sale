<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;

class LandingController extends Controller
{
    public function index()
    {
        return view('website.landing');
    }
}
