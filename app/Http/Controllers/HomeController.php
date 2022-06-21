<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Auth;

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
        $this->middleware(function ($request, $next) {
            $user = Auth::user();
            if ($user->user_type == 4) {
                return $next($request);
            }
            else{
                return redirect(route('login'));
            }
        });
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

    public function getDrivers(){
        $drivers = User::where('user_type',3)->get();

        return view('drivers')
            ->with('drivers',$drivers);
    }

    public function getUsers(){
        $users = User::where('user_type','<>',3)->where('user_type','<>',4)->get();

        return view('users')
            ->with('users',$users);
    }

    public function approveDriver($id)
    {
        $user = User::find($id);
        $user->user_status = 1;
        $user->save();

        return redirect()->back();
    }

    public function blockDriver($id)
    {
        $user = User::find($id);
        $user->user_status = 0;
        $user->save();

        return redirect()->back();
    }
}
