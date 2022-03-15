<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    
    use AuthenticatesUsers;
    protected $redirectTo = RouteServiceProvider::HOME;
    protected $redirectRecruiter = RouteServiceProvider::DASHBOARD;
    protected $isWorker = "isWorker";

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
}
