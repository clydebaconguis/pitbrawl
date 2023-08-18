<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        // return auth()->user()->usertype;
        

        if(auth()->user()->usertype == 'superadmin')
        {
            return view('pit/dashboard');
        }
        elseif(auth()->user()->usertype == 'declarator')
        {
            return view('pit/dash_declarator');
        }
        // return view('home');
    }
}
