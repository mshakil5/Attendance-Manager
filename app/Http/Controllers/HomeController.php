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

        // return view('home');
        if (auth()->user()->is_admin == '1') {
            return redirect()->route('admin.home');
        }elseif (auth()->user()->is_admin == '0') {
            return redirect()->route('employee.home');
        }else {
            return view('auth.login');
        }

    }

    public function dashboard()
    {
        return view('admin.dashboard');
    }

    public function employeeDashboard()
    {
        return view('employee.dashboard');
    }
}
