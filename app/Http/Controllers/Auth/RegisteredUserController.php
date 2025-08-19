<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
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
     

        if ($request->file('photo') != null) {

            $fichier = request()->file('photo');
            $filename = strtoupper(substr(str_shuffle(md5($request->_token . "" . rand(124, 345))), 0, 4)) . date('YmdHi') . '.' . $fichier->extension();
            $path = 'assets/upload/photos/'.$filename;
            $fichier->move(public_path('assets/upload/photos'), $filename);
        }else {
            $path ='assets/upload/photos/photo.jpg';
        }


       $request->validate([
           'name' => ['required', 'string', 'max:255'],
           'statut' => ['required', 'string', 'max:255'],
           'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
           'password' => ['required', 'confirmed', Rules\Password::defaults()],
       ]);

     

       $user = User::create([
           'name' => $request->name,
           'email' => $request->email,
           'password' => Hash::make($request->password),
           'statut' => $request->statut,
           'photo' => $path,
           'initial' => $request->initial,
           'role' => 'Administrateur',
       ]);

       event(new Registered($user));

       Auth::login($user);
        return redirect(RouteServiceProvider::HOME);
    }
}
