<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\Mail\PasswordPemohon;
use App\Mail\VerifyEmailPemohon as EmailVerifyEmailPemohon;
use App\Models\Pemohon;
use App\Models\User;
use App\Models\VerifyEmailPemohon as ModelVerifyEmailPemohon;
use App\Providers\RouteServiceProvider;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use RealRashid\SweetAlert\Facades\Alert;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    // use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    // protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    // public function __construct()
    // {
    //     $this->middleware('guest');
    // }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    // protected function validator(array $data)
    // {
    //     return Validator::make($data, [
    //         'name' => ['required', 'string', 'max:255'],
    //         'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
    //         'password' => ['required', 'string', 'min:8', 'confirmed'],
    //     ]);
    // }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    public function show()
    {
        return view('auth.register');
    }

    protected function registerPemohon(Request $request)
    {

        $validation = $request->validate([
            'email' => 'required|unique:pemohon,email',
            'no_ic' => 'required|unique:pemohon,username',
        ], [
            'no_ic.required' => 'Sila masukkan No Kad Pengenalan / Mykad anda.',
            'email.required' => 'Sila masukkan email anda yang sah.',
            'no_ic.unique' => 'No Kad Pengenalan / Mykad anda telah didaftarkan.',
            'email.unique' => 'Email anda telah didaftarkan.',
        ]);

        $password = 'DarulQuranJakim';
        $pemohon = Pemohon::create([
            'username' => $request->no_ic,
            'email' => $request->email,
            'password' => bcrypt($password),
        ]);

        ModelVerifyEmailPemohon::create([
            'pemohon_id' => $pemohon->id,
            'token' => Str::random(60),
        ]);

        Mail::to($request->email)->send(new EmailVerifyEmailPemohon($pemohon));

        // auth()->login($user);
        Alert::success('Emel Telah Dihantar', 'Sila semak email anda untuk melakukan pengesahan.');

        return redirect()->route('login_pemohon');

        // return User::create([
        //     'name' => $data['name'],
        //     'email' => $data['email'],
        //     'password' => Hash::make($data['password']),
        // ]);
    }

    protected function verifyEmailPemohon($token)
    {
        $verifyPemohon = ModelVerifyEmailPemohon::where('token', $token)->first();
        if (isset($verifyPemohon)) {
            $pemohon = $verifyPemohon->pemohon;

            if (! $pemohon->email_verified_at) {
                $password = Str::random(10);
                $pemohon->email_verified_at = Carbon::now();
                $pemohon->password = bcrypt($password);
                $pemohon->save();
                Mail::to($pemohon->email)->send(new PasswordPemohon($password));
                Alert::success('Emel Berjaya Disahkan', 'Katalaluan telah dihantar ke email anda, sila semak.');

                return redirect()->route('login_pemohon');
            } else {
                Alert::info('Emel Telah Disahkan', 'Emel yang anda gunakan telah disahkan sebelum ini, sila log masuk meggunakan katalaluan anda');

                return redirect()->route('login_pemohon');
            }
        } else {
            Alert::error('Ralat', 'Something went wrong!');

            return redirect()->route('login_pemohon');
        }
    }

    protected function register(RegisterRequest $request)
    {
        // dd($request);
        $user = User::create($request->validated());
        auth()->login($user);

        return redirect('/')->with('success', 'Account successfully registered.');

        // return User::create([
        //     'name' => $data['name'],
        //     'email' => $data['email'],
        //     'password' => Hash::make($data['password']),
        // ]);
    }
}
