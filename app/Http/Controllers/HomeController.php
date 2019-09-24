<?php

namespace App\Http\Controllers;

use App\User;
use App\DB;
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
        $user = auth()->user();
		$info = $user->Information(auth()->user()->id);
		return view('home', ['user' => $user, 'info' => $info] );
    }
}
