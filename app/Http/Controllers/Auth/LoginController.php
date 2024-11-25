<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Events\Login;

class LoginController extends Controller
{
    use \Illuminate\Foundation\Auth\AuthenticatesUsers;

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('auth')->only('logout');
    }

    protected function authenticated(Request $request, $user)
    {
        // Check user type and redirect accordingly
        if ($user->user_type === 'admin') {
            return redirect()->route('dashboard.admin');
        }

        if ($user->user_type === 'reviewer') {
            return redirect()->route('dashboard.reviewer');
        }

        return redirect()->route('dashboard.applicant');
    }
}
