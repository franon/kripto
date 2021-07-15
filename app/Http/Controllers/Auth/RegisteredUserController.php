<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Pengguna;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $request->validate([
            'p_namapengguna' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:pengguna',
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);
        // dd('wow');
        $user = User::create([
            'p_id' => sha1(md5(microtime(true))),
            'p_namapengguna' => $request->p_namapengguna, 
            'p_namalengkap' => $request->p_namapengguna,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        event(new Registered($user));

        // Auth::login($user);
        
        return \redirect('/login');
        // return \redirect('/employee/dashboard');
        // return redirect(RouteServiceProvider::HOME);
    }
}
