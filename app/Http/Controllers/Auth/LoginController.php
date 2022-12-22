<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\LoginPemohonRequest;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{

    public function __construct()
    {
        // $this->middleware('guest:pemohon')->except('logout');
    }

    public function show()
    {
        return view('auth.login');
    }

    public function login(LoginRequest $request)
    {
        $credentials = $request->getCredentials();

        if(!Auth::validate($credentials)):
            return redirect()->to('login')
                ->withErrors(trans('auth.failed'));
        endif;

        $user = Auth::getProvider()->retrieveByCredentials($credentials);

        Auth::login($user);

        return $this->authenticated($request, $user);

    }

    protected function authenticated(Request $request, $user)
    {
        return redirect()->route('login');
    }

    public function showPemohonLoginForm()
    {
        return view('auth.pemohon.login');
    }

    // Login Pemohon

    public function loginPemohon(LoginPemohonRequest $request)
    {
        $credentials = $request->getCredentials();

        // dd($credentials);
        if(!Auth::guard('pemohon')->validate($credentials)):
            return redirect()->to('login_pemohon')
                ->withErrors(trans('auth.failed'));
        endif;

        $user = Auth::guard('pemohon')->getProvider()->retrieveByCredentials($credentials);

        Auth::guard('pemohon')->login($user);

        return $this->authenticatedPemohon($request, $user);

    }

    protected function authenticatedPemohon(Request $request, $user)
    {
        dd(Auth::guard('pemohon')->user());
        return redirect()->route('login');
    }

}
