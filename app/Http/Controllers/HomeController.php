<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
        return view('home');
    }

    public function getMenu(){
        $dbSystem = DB::table('m_public_system')
            ->where('status','1')
            ->orderBy('idm_system','asc')
            ->get();
        return view ('homeDiv', compact('dbSystem'));
    }
}
