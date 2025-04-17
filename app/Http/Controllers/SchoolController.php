<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SchoolController extends Controller
{
    //controller for login
    public function loginpage(){
       return view('website.login');
    }
}
