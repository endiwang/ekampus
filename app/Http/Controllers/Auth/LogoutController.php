<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Auth;
use Session;

class LogoutController extends Controller
{
    public function logout()
    {
        Session::flush();

        Auth::logout();

        return redirect('login');
    }

    public function logoutPemohon()
    {
        Session::flush();

        Auth::guard('pemohon')->logout();

        return redirect('/');
    }
}
