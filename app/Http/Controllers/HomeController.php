<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Iluminate\Http\Auth;

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
		//$usuario = auth()->user()->id;

		// $user = \App\User::find(auth()->user()->id);
		$not = [];
		// foreach ($user->unreadNotifications  as $notification) {
		// 	$not[$notification->id]['id'] = $notification->id; 
		// 	$not[$notification->id]['data'] = $notification->data;
    	// 	// $notification->id; // id da notificacao no bd
		// 	//echo $notification->data;
		// }

        return view('home', ['notificacao' => $not]);
    }
}
