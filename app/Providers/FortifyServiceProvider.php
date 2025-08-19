<?php

namespace App\Providers;

use App\Actions\Fortify\CreateNewUser;
use App\Actions\Fortify\ResetUserPassword;
use App\Actions\Fortify\UpdateUserPassword;
use App\Actions\Fortify\UpdateUserProfileInformation;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
use Laravel\Fortify\Fortify;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;


class FortifyServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Fortify::createUsersUsing(CreateNewUser::class);
        Fortify::updateUserProfileInformationUsing(UpdateUserProfileInformation::class);
        Fortify::updateUserPasswordsUsing(UpdateUserPassword::class);
        Fortify::resetUserPasswordsUsing(ResetUserPassword::class);

        Fortify::loginView(function () {
            $user = User::all()->count();
            $cabinet = DB::select("select * from cabinets");
            return view('auth.login',compact('user','cabinet'));
        });

        Fortify::authenticateUsing(function (Request $request) {
            
            $user = User::where('email', $request->email)->first();
    
            if ($user &&
                Hash::check($request->password, $user->password)) {

           

                        if ($user->statut=='bloquer') {
                  
                        } else {
            
                            $cabinetSession = DB::select("select * from cabinets");
                            $cabinetLogo = DB::select("select logo from cabinets");
              
                            $request->session()->put('cabinetSession', $cabinetSession);
                            $request->session()->put('cabinetLogo', $cabinetLogo);
                            
                           
                    
                            // Recuperation de la photo du personnel
                            $photo = DB::select('select photo from personnels where email = ?', [$request->email]);
                            $idPersonnel = DB::select('select * from personnels where email = ?', [$request->email]);
                    
                            // Notification de l'utilisateur en tant que connecter
                            DB::update('update users set statut = ?  where email = ?', ['actif', $request->email]);
                            $request->session()->put('photo', $photo);
                            if (empty($idPersonnel)) {
                                # code...
                            } else {
                                $request->session()->put('idPersonnel', $idPersonnel);
                            }
                    
                            DB::delete("delete from notifications where etat='vue'");
                            return $user; 
                        }
                        
                   
                    
                   
            }
        });
    
        Fortify::registerView(function () {
            return view('auth.register');
        });
    
        Fortify::requestPasswordResetLinkView(function () {
            return view('auth.forgot-password');
        });
    
        Fortify::resetPasswordView(function ($request) {
            return view('auth.reset-password', ['request' => $request]);
        });
    
        Fortify::verifyEmailView(function () {
            return view('auth.verify-email');
        });

        RateLimiter::for('login', function (Request $request) {
            $throttleKey = Str::transliterate(Str::lower($request->input(Fortify::username())).'|'.$request->ip());

            return Limit::perMinute(5)->by($throttleKey);
        });

        RateLimiter::for('two-factor', function (Request $request) {
            return Limit::perMinute(5)->by($request->session()->get('login.id'));
        });
    }
}
