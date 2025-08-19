<?php
  
namespace App\Http\Controllers;
  
use Illuminate\Http\Request;
use App\Models\UserEmailCode;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Session;
use Illuminate\Support\Facades\Auth;


  
class TwoFAController extends Controller
{
    /**
     * Write code on Method
     *
     * @return response()
     */

    public function doubleFacteur()
    {

        $user = User::all()->count();
        $cabinet = DB::select("select * from cabinets");

        auth()->user()->generateCode();

        return view('2fa', compact('user', 'cabinet'));
        
    
    }

    public function index()
    {

         // Vérifie si la période de 6 mois est écoulée
         if ($this->isPastSixMonths()) {
            // Redirection ou réponse d'erreur 403
            return response()->view('errors.403');
        }else {
            $user = User::all()->count();
            $cabinet = DB::select("select * from cabinets");

            return view('auth.login', compact('user', 'cabinet'));
        }
       
    }

    protected function isPastSixMonths()
    {
        $cabinet = DB::select("select * from cabinets");

        if ($cabinet) {
            // Vérifie la date de dernière utilisation du site
            $lastUsedDate =  date(("Y-m-d"), strtotime( $cabinet[0]->created_at));// Récupérer la date de dernière utilisation depuis la base de données ou un autre stockage
                // Vérifie si 6 mois se sont écoulés depuis la dernière utilisation
            if ($cabinet[0]->plan=='gratuit') {
                return Carbon::parse($lastUsedDate)->addMonths(1)->isPast();
            } elseif ($cabinet[0]->plan=='standard') {
                return Carbon::parse($lastUsedDate)->addMonths(12)->isPast();
            } elseif ($cabinet[0]->plan=='premium') {
                return Carbon::parse($lastUsedDate)->addMonths(24)->isPast();
            }else{}

        }else{}
       
        
    
    }
  
    /**
     * Write code on Method
     *
     * @return response()
     */
    public function store(Request $request)
    {
        $request->validate([
            'code'=>'required',
        ]);
  
        $find = UserEmailCode::where('user_id', auth()->user()->id)
                        ->where('code', $request->code)
                        ->where('updated_at', '>=', now()->subMinutes(2))
                        ->first();
  
        if (!is_null($find)) {

            Session::put('user_2fa', auth()->user()->id);
            $user_2fa = session('user_2fa');
           
         
            $cabinetSession = DB::select("select * from cabinets");
            Session::put('cabinetSession',$cabinetSession);
           
    
            // Recuperation de la photo du personnel
            $photo = DB::select('select photo from personnels where email = ?', [Auth::user()->email]);
            Session::put('photo',$photo);

            $cabinetLogo = DB::select("select logo from cabinets");
            Session::put('cabinetLogo',$cabinetLogo);

           
            $idPersonnel = DB::select('select * from personnels where email = ?', [Auth::user()->email]);

            if (empty($idPersonnel)) {
                # code...
            } else {
                Session::put('idPersonnel',$idPersonnel);
            }
    
            DB::delete("delete from notifications where etat='vue'");
    
            $user = DB::select("select * from users where email=?",[Auth::user()->email]);
    
            if (!empty($user)) {
    
                if ($user[0]->statut=='bloquer') {
                    return redirect()->back()->with('error','Votre compte a été bloqué , veuillez contacter l\'Administrateur.');
                } else {
    
                     // Notification de l'utilisateur en tant que connecter
                     DB::update('update users set statut = ?  where email = ?', ['actif', Auth::user()->email]);
                    return redirect()->route('home');
                }
                
            }else {
                return redirect()->back()->with('error','Ce compte n\'existe pas , veuillez renseigner de bonnes informations.');
    
            }
            
    
            
        }
  
        return back()->with('error', 'Vous avez entré un mauvais code.');
    }
    /**
     * Write code on Method
     *
     * @return response()
     */
    public function resend()
    {
        auth()->user()->generateCode();
  
        return back()->with('success', 'Nous avons renvoyé le code sur votre e-mail.');
    }
}