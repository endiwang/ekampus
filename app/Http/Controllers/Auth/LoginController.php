<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginPemohonRequest;
use App\Http\Requests\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

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

        if (! Auth::validate($credentials)) {
            return redirect()->to('login')
                ->withErrors(trans('auth.failed'));
        }

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
        if (! Auth::guard('pemohon')->validate($credentials)) {
            Alert::error('Ralat', 'Sila pastikan no kad pengenalan dan katalauan anda betul');

            return redirect()->to('login_pemohon')
                ->withErrors(trans('auth.failed'));
        }

        $user = Auth::guard('pemohon')->getProvider()->retrieveByCredentials($credentials);
        // dd($user);
        if ($user->email_verified_at == null) {
            Auth::guard('pemohon')->logout();
            Alert::error('Emel Belum Disahkan', 'Sila sahkan email untuk log masuk dan memohon');

            return redirect()->route('login_pemohon');
        }

        Auth::guard('pemohon')->login($user);

        return $this->authenticatedPemohon($request, $user);

    }

    protected function authenticatedPemohon(Request $request, $user)
    {
        return redirect()->route('pemohon.utama.index');
    }
}
