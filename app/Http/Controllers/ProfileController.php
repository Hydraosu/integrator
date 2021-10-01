<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{

    public $user;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware(function ($request, $next) {

            $this->user = Auth::user();

            return $next($request);

        });
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('/settings/profile/index', ['user' => $this->user]);
    }

    public function update(Request $request)
    {
        $name = $request->input('name');

        DB::table('users')
            ->where('id', $this->user->id)
            ->update(['name' => $name]);

        return redirect()->action([ProfileController::class, 'index']);
    }
}
