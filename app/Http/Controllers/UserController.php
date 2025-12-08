<?php

namespace App\Http\Controllers;

use App\Models\Personnels;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Laravel\Fortify\Contracts\UpdatesUserPasswords;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function setTheme($theme)
    {
       DB::update('update users set theme=? where email=?',[$theme,Auth::user()->email]);
       return back()->with('success', 'Thème modifié avec succès !');

    }

    /**
     * Afficher the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $nbreCompte = DB::select("select totalComptes from cabinets");
        $users = DB::select("select * from users,personnels where users.email=personnels.email");
        $adminUsers = DB::select("select * from users where role='Administrateur'");
        $firstAdmin = DB::select("select * from users where role='Administrateur' order by created_at asc limit 1");
        $client = DB::select('select * from clients');
        $cabinetForPlan = DB::select("select * from cabinets");
        $plan = $cabinetForPlan[0]->plan;
        return view('users.createUser',compact('users','nbreCompte','client','plan','adminUsers','firstAdmin'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // L'instance du model utilisateur

        if ($request->role=='Client') {

            $user = new User();            
    
            $userExist = DB::select("select * from users where email=?",[$request->email]);
            if (!empty($userExist) ) {
                return back()->with('error', 'Cet email a déjà été utilisé !');
            }
    
            if ($request->file('photo') != null) {
    
                $fichier = request()->file('photo');
                $filename = strtoupper(substr(str_shuffle(md5($request->_token . "" . rand(124, 345))), 0, 4)) . date('YmdHi') . '.' . $fichier->extension();
                $path = 'assets/upload/photos/'.$filename;
                $fichier->move(public_path('assets/upload/photos'), $filename);
            }else {
                $path ='assets/upload/photo.jpg';
            }
            $user->name = $request->username;
            $user->email = $request->email;
            $user->password = Hash::make($request->password);
            $user->statut = 'Off Line';
            $user->role = $request->role;
            $user->photo = $path;
            $user->initial = 'CLT';
            $user->idClient = $request->idClient ;
            $user->save();
            return back()->with('success', 'Utilisateur créer avec succès !');

        } elseif($request->role=='Administrateur') {

            $user = new User();


            $userExist = DB::select("select * from users where email=?",[$request->email]);
            $userExistPersonnel = DB::select("select * from personnels where email=?",[$request->email]);

            if (!empty($userExist) ) {
                return back()->with('error', 'Cet administrateur a déjà un compte !');
            }

            if (!empty($userExistPersonnel) ) {
                return back()->with('error', 'Cet email a déjà été utilisé !');
            }

            if ($request->file('photo') != null) {

                $fichier = request()->file('photo');
                $filename = strtoupper(substr(str_shuffle(md5($request->_token . "" . rand(124, 345))), 0, 4)) . date('YmdHi') . '.' . $fichier->extension();
                $path = 'assets/upload/photos/'.$filename;
                $fichier->move(public_path('assets/upload/photos'), $filename);
            }else {
                $path ='assets/upload/photo.jpg';
            }
            $user->name = $request->username;
            $user->email = $request->email;
            $user->password = Hash::make($request->password);
            $user->statut = 'Off Line';
            $user->role = $request->role;
            $user->photo = $path;
            $user->initial = $request->initial;
            $user->save();
            return back()->with('success', 'Utilisateur créer avec succès !');

        }else {

                $user = new User();

                
    
                $personnel = DB::table('personnels')->where('matricules', $request->matricules)->get();

                if ($personnel->isEmpty()) {
                    return back()->with('error', 'Oops, ce matricule n\'existe pas !');

                }

                $userExist = DB::select("select * from users where email=?",[$personnel[0]->email]);
                if (!empty($userExist) ) {
                    return back()->with('error', 'Ce utilisateur a déjà un compte !');
                }
    
                if ($request->file('photo') != null) {
    
                    $fichier = request()->file('photo');
                    $filename = strtoupper(substr(str_shuffle(md5($request->_token . "" . rand(124, 345))), 0, 4)) . date('YmdHi') . '.' . $fichier->extension();
                    $path = 'assets/upload/photos/'.$filename;
                    $fichier->move(public_path('assets/upload/photos'), $filename);
                }else {
                    $path ='assets/upload/photo.jpg';
                }
                $user->name = ''.$personnel[0]->prenom.' '.$personnel[0]->nom.'';
                $user->email = $personnel[0]->email;
                $user->password = Hash::make($request->password);
                $user->statut = 'Off Line';
                $user->role = $request->role;
                $user->photo = $path;
                $user->initial = $request->initial;
                $user->save();
                return back()->with('success', 'Utilisateur créer avec succès !');
    
        
        }
        
       
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Afficher the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  int  $id
     * @param  string  $email
     * @return \Illuminate\Http\Response
     */
    public function checkUser($userMail)
    {

        // Verication du typeContent pour retourner une bonne reponse
        // $user = User::all()->where('email', $userMail);
        $user = DB::select('SELECT * FROM users WHERE email = ?', [$userMail]);
        return response()->json([
            'users' => $user,
        ]);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  int  $id
     * @param  string  $email
     * @param  string  $date
     * @return \Illuminate\Http\Response
     */
    public function updateUser($userMail, $date)
    {

        
        // Verication du typeContent pour retourner une bonne reponse
        $user = User::all()->where('email', $userMail);
        return response()->json([
            'users' => $user,
        ]);
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, UpdatesUserPasswords $passwordUpdater)
    {

       
        $user = Auth::user();
        $lastConnexion = 1;
        if (Hash::check($request->current_password, $user->password)) {
           $user->update([
                'password' => Hash::make($request->password),
                'lastConnexion' => $lastConnexion,
           ]);

           return redirect()->back()->with('success', 'Mot de passe modifié avec succès !');
        }

        return redirect()->back()->with('error', 'Mot de passe incorrecte !');
    }

    public function update2(Request $request, UpdatesUserPasswords $passwordUpdater)
    {
        dd("ici modif");

       
        $user = Auth::user();
        $lastConnexion = 1;
        if (Hash::check($request->current_password, $user->password)) {
           $user->update([
                'password' => Hash::make($request->password),
                'lastConnexion' => $lastConnexion,
           ]);

           return redirect()->back()->with('success', 'Mot de passe modifié avec succès !');
        }

        return redirect()->back()->with('error', 'Mot de passe incorrecte !');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}