<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\Personnels;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {

        $user = User::all()->count();
        return view('auth.login', compact('user'));
    }

    /**
     * Handle an incoming authentication request.
     *
     * @param  \App\Http\Requests\Auth\LoginRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(LoginRequest $request)
    {

        $request->authenticate();

        $request->session()->regenerate();

        $cabinetSession = DB::select("select * from cabinets");
      
        $request->session()->put('cabinetSession', $cabinetSession);
       

        // Recuperation de la photo du personnel
        $photo = DB::select('select photo from personnels where email = ?', [$request->email]);
        $idPersonnel = DB::select('select * from personnels where email = ?', [$request->email]);

       
        $request->session()->put('photo', $photo);
        if (empty($idPersonnel)) {
            # code...
        } else {
            $request->session()->put('idPersonnel', $idPersonnel);
        }

        DB::delete("delete from notifications where etat='vue'");

        $user = DB::select("select * from users where email=?",[$request->email]);

        if (!empty($user)) {

            if ($user[0]->statut=='bloquer') {
                return redirect()->back()->with('error','Votre compte a été bloqué , veuillez contacter l\'Administrateur.');
            } else {

                 // Notification de l'utilisateur en tant que connecter
                 DB::update('update users set statut = ?  where email = ?', ['actif', $request->email]);
                return redirect()->intended(RouteServiceProvider::HOME);
            }
            
        }else {
            return redirect()->back()->with('error','Ce compte n\'existe pas , veuillez renseigner de bonnes informations.');

        }
        

       
    }

    /**
     * Destroy an authenticated session.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request)
    {

        // Notification de l'utilisateur en tant que connecter
        DB::update('update users set statut = ?  where email = ?', ['inactif', Auth::user()->email]);

        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
