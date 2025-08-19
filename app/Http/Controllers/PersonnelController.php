<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Personnels;
use App\Models\User;
use App\Models\AffectationPersonnels;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

/**
 * Controller de la class Personnels
 */
class PersonnelController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Récuperation de l'ensemble des personnels dans la base de donnees
        $personnel = DB::select("select * from personnels");

        return view('Personnels.allPersonnel', compact('personnel'));
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function initial($id)
    {

        // Recuperation de l'inital d'un personnel
        $init =  DB::select('select * from personnels where idPersonnel=?', [$id]);
        return response()->json([
            'initial' => $init,
        ]);
    }

    public function initialAdmin($id)
    {

        // Recuperation de l'inital d'un personnel
        $init =  DB::select('select * from users where id=?', [$id]);
        return response()->json([
            'initialAdmin' => $init,
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getMatriculePersonnel()
    {

        // Récuperation du matricule des personnels déja enregistrer sur la plate-forme
        $matricules = DB::select('select matricules FROM personnels');
        return response()->json([
            'matricule' => $matricules,
        ]);
    }

    /**
     * Afficher the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        return view('Personnels.addPersonnel');
    }

    public function clientPersonnel(Request $request)
    {
        $client = DB::select('select * from clients');
        $personnel = DB::select('select * from personnels');
        $personnelAffec = DB::select('select clients.nom as nomClient,clients.prenom as prenomClient,denomination, personnels.prenom,personnels.nom,clients.idClient,personnels.idPersonnel,affectation_personnels.slug from clients,personnels,affectation_personnels where personnels.idPersonnel=affectation_personnels.idPersonnel and affectation_personnels.idClient= clients.idClient');
        return view('Personnels.clientPersonnel', compact('client', 'personnel', 'personnelAffec'));
    }

    public function addAffectation(Request $request)
    {
        $request->validate(
            [

                'idClient' => 'required',
                'idPersonnel' => 'required',
                'slug' => ''
            ]
        );
        $personnelAffec = new AffectationPersonnels();
        if ($request) {


            $personnelAffec->idClient = $request->idClient;
            $personnelAffec->idPersonnel = $request->idPersonnel;
            $personnelAffec->slug = rand(4827, 9432) . $request->_token . rand(34827, 98432);
            $personnelAffec->save();
            $request = null;
        }
        return redirect()->route('clientPersonnel')->with('success', 'Le personnel a bien été affecté avec succès !');
    }


    /**
     * Fonction permettante d'annuler l'affectation d'un personnel sur les dossiers 
     * d'un client
     * @param  \Illuminate\Http\Request  $request
     * @param  String $slug
     * @return \Illuminate\Http\Response
     */
    public function destroyAffectation($slug){
        
        AffectationPersonnels::where('slug', $slug)->delete();
        return back()->with('success', 'affectation annuler avec succès');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

         // mise a jour 
        // Vérifie si l'email existe déjà
        //$emailExist = Personnels::where('email', $request->email)->exists();
        $emailExist = DB::table('personnels')->where('email', $request->email)->first();
        //dd($emailExist);

        if ($emailExist) {
            //return back()->withErrors(['email' => 'Cet email est déjà utilisé.'])->withInput();
            return back()->with(['error' => 'Cet email est déjà utilisé.']);
        }

        // Récupérer l'email depuis l'entrée utilisateur
        $email = $request->input('email');

        $emailExiste = User::where('email', $email)->exists() || Personnels::where('email', $email)->exists();

        if ($emailExiste) {
            return back()->with(['error' => 'Cet email est déjà utilisé.']);
        } else {
            // Pass
        }
      

        $personnel = new Personnels();
        if ($request) {

            $matricule = 'SML-' . strtoupper(substr(str_shuffle(md5($request->dateNaissance . '' . $request->email)), 0, 4));

            $personnel->matricules = $matricule;
            $personnel->prenom = $request->prenom;
            $personnel->nom = $request->nom;
            $personnel->sexe = $request->sexe;
            $personnel->dateNaissance = $request->dateNaissance;
            $personnel->adresse = $request->adresse;
            $personnel->fonction = $request->fonction;
            $personnel->telephone = $request->telephone;
            $personnel->numeroUrgence = $request->numeroUrgence;
            $personnel->salaire = $request->salaire;
            $personnel->ssn = $request->ssn;
            $personnel->nomPersonneUrgence = $request->nomPersonneUrgence;
            $personnel->telPersonneUrgence = $request->telPersonneUrgence;
            $personnel->initialPersonnel = $request->initialPersonnel;
            $personnel->email = $request->email;
            if ($request->file('photo')) {
                $file = $request->file('photo');
                $filename = strtoupper(substr(str_shuffle(md5($request->_token . "" . rand(124, 345))), 0, 4)) . date('YmdHi') . '.' . $request->file('photo')->extension();
                $personnel->photo = 'assets/upload/photos/'.$filename;
                $file->move(public_path('assets/upload/photos'), $filename);
            } else {
                $personnel->photo ='assets/upload/photo.jpg';
            }
            $personnel->slug = rand(4827, 9432) . $request->_token . rand(34827, 98432);
            $personnel->save();
            $request = null;
        }
        $personnel = Personnels::all();
        return view('Personnels.allPersonnelCard', compact('personnel'))->with('success', 'L\'enregistrement du personnel effectué avec succès !');
    }


    /**
     * Store a newly created resource in storage.
     *@param strin $slug
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function updatePersonnel(Request $request, $slug)
    {
        if ($request) {

            $emailPrecedent = DB::select('select email from personnels where slug=?',[$slug]);

            // modification de la personnel
            DB::select(
                'update personnels set
                prenom = ?,
                nom = ?,
                sexe = ?,
                fonction = ?,
                adresse = ?,
                dateNaissance = ?,
                telephone = ?,
                salaire = ?,
                ssn = ?,
                nomPersonneUrgence = ?,
                telPersonneUrgence = ?,
                numeroUrgence = ?,
                email = ? WHERE slug = ?',
                [
                    $request->prenom,
                    $request->nom,
                    $request->sexe,
                    $request->fonction,
                    $request->adresse,
                    $request->dateNaissance,
                    $request->telephone,
                    $request->salaire,
                    $request->ssn,
                    $request->nomPersonneUrgence,
                    $request->telPersonneUrgence,
                    $request->numeroUrgence,
                    $request->email,
                    $slug
                ]
            );

           
            DB::select("update users set email=? where email=?",[$request->email,$emailPrecedent[0]->email]);

            if ($request->file('photo')) {
                $file = $request->file('photo');
                $filename = strtoupper(substr(str_shuffle(md5($request->_token . "" . rand(124, 345))), 0, 4)) . date('YmdHi') . '.' . $request->file('photo')->extension();
                $NewPhoto = 'assets/upload/photos/'.$filename;
                DB::select('update personnels set photo = ? WHERE slug = ? ', [$NewPhoto, $slug]);
                DB::select('update users set photo = ? WHERE email = ? ', [$NewPhoto, $request->email]);
                $file->move(public_path('assets/upload/photos'), $filename);
            }
        }
        return redirect()->route('home')->with('success', 'Votre modification à été apporter avec succès sur votre profil .');

    }


    /**
     * Store a newly created resource in storage.
     *@param strin $slug
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function editPassword(Request $request, $email)
    {

        $user = DB::select("select * from users where email=?", [$email]);

        return view('Personnels.editPersonnel', compact('user'));
    }

    public function updatePassword(Request $request)
    {

       
        $newPassword = Hash::make($request->newPass);
        //     modification du mot de passe du personnel
        DB::select('update users set password = ?  where email = ? ', [$newPassword, Auth::user()->email]);

        return back()->with('success', 'Votre modification à été apporter avec succès sur votre profil, votre nouveau mot de passe est : ' . $request->newPass);
    }


    /**
     * Display the specified resource.
     *
     * @param  string  $slug
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {
        $personnel = DB::select('select * from personnels where slug=? ', [$slug]);
        $idPersonnel = $personnel[0]->idPersonnel;

        $taches = DB::select("

        select titre,dateDebut,dateFin,taches.statut,taches.slug,nom,prenom,denomination,nomAffaire,taches.idTache,taches.idClient,taches.idAffaire,clients.idClient as idClient,taches.created_at,tache_personnels.fonction,tache_personnels.idPersonnel from taches,clients,affaires,tache_personnels where taches.idClient=clients.idClient AND taches.idAffaire=affaires.idAffaire and tache_personnels.idTache=taches.idTache and tache_personnels.idPersonnel=$idPersonnel
            
            UNION
            
            SELECT 
            t.titre,
            t.dateDebut,
            t.dateFin,
            t.statut,
            t.slug,
            c.nom,
            c.prenom,
            c.denomination,
            a.nomAffaire,
            t.idTache,
            t.idClient,
            t.idAffaire,
            c.idClient AS client_id,
            t.created_at,
            p.fonction,
            p.idPersonnel
        FROM 
            taches AS t
        LEFT JOIN 
            clients AS c ON t.idClient = c.idClient
        LEFT JOIN 
            affaires AS a ON t.idAffaire = a.idAffaire
        LEFT JOIN 
            tache_personnels AS p ON p.idTache = t.idTache
        WHERE 
            t.idClient IS NULL 
            AND t.idAffaire IS NULL
            AND  p.idPersonnel=$idPersonnel

        ");


        $tachesValide = DB::select("select titre,dateDebut,dateFin,statut,taches.slug from taches,tache_personnels where taches.idTache = tache_personnels.idTache and tache_personnels.idPersonnel=? and taches.statut='validée'", [$idPersonnel]);
        $totalTV = count($tachesValide);
        $tachesEncour = DB::select("select titre,dateDebut,dateFin,statut,taches.slug from taches,tache_personnels where taches.idTache = tache_personnels.idTache and tache_personnels.idPersonnel=? and taches.statut='En cours'", [$idPersonnel]);
        $totalE = count($tachesEncour);

        return view('Personnels.infoPersonnel', compact('personnel', 'taches', 'totalTV', 'totalE'));
    }

    public function blockPersonnel($email)
    {

        DB::update("update users set statut='bloquer' where email=?",[$email]);

        return redirect()->back()->with('success','Utilisateur bloqué. Ce compte pourra plus se connecter.');
    }

    public function deblockPersonnel($email)
    {

        DB::update("update users set statut='inactif' where email=?",[$email]);

        return redirect()->back()->with('success','Utilisateur debloqué. Ce compte peut se connecter.');
    }

    //public function show2($email)
    // Il ne faut pas utiliser l'adresse mail d'un personnel pour le retrouver, utilise plutot son slug
    // cela est plus securisé
    public function show2($slug)
    {
        $personnel = DB::select('select * from personnels where email=? ', [$slug]);
        $idPersonnel = $personnel[0]->idPersonnel;

        $taches = DB::select("

        select titre,dateDebut,dateFin,taches.statut,taches.slug,nom,prenom,denomination,nomAffaire,taches.idTache,taches.idClient,taches.idAffaire,clients.idClient as idClient,taches.created_at,tache_personnels.idPersonnel,tache_personnels.fonction from taches,clients,affaires,tache_personnels where taches.idClient=clients.idClient AND taches.idAffaire=affaires.idAffaire and tache_personnels.idTache=taches.idTache and tache_personnels.idPersonnel=$idPersonnel
            
            UNION
            
            SELECT 
            t.titre,
            t.dateDebut,
            t.dateFin,
            t.statut,
            t.slug,
            c.nom,
            c.prenom,
            c.denomination,
            a.nomAffaire,
            t.idTache,
            t.idClient,
            t.idAffaire,
            c.idClient AS client_id,
            t.created_at,
            p.idPersonnel,
            p.fonction
        FROM 
            taches AS t
        LEFT JOIN 
            clients AS c ON t.idClient = c.idClient
        LEFT JOIN 
            affaires AS a ON t.idAffaire = a.idAffaire
        LEFT JOIN 
            tache_personnels AS p ON p.idTache = t.idTache
        WHERE 
            t.idClient IS NULL 
            AND t.idAffaire IS NULL
            AND  p.idPersonnel=$idPersonnel

        ");



        $tachesValide = DB::select("select titre,dateDebut,dateFin,statut,taches.slug from taches,tache_personnels where taches.idTache = tache_personnels.idTache and tache_personnels.idPersonnel=? and taches.statut='validée'", [$idPersonnel]);
        $totalTV = count($tachesValide);
        $tachesEncour = DB::select("select titre,dateDebut,dateFin,statut,taches.slug from taches,tache_personnels where taches.idTache = tache_personnels.idTache and tache_personnels.idPersonnel=? and taches.statut='En cours'", [$idPersonnel]);
        $totalE = count($tachesEncour);

       

        return view('Personnels.infoPersonnel', compact('personnel', 'taches', 'totalTV', 'totalE'));
    }

    /**
     * Afficher the form for editing the specified resource.
     *
     * @param  string  $slug
     * @return \Illuminate\Http\Response
     */
    public function edit($slug)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $slug
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $slug)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  string  $slug
     * @return \Illuminate\Http\Response
     */
    public function destroy($slug)
    {
        // SUppression du personnel dont le slug est passé en parametre
        $personne = DB::select('select * from personnels where slug = ?', [$slug]);
        unlink(public_path('assets/upload/photos/' . $personne[0]->photo));
        $personne = DB::select('delete from personnels where slug = ?', [$slug]);
        return redirect()->route('allPersonnel');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function personnelCard()
    {
        // Récuperation de l'ensemble des personnels dans la base de donnees
        $personnel = DB::select("select * from personnels,users where personnels.email=users.email");
        //DB::table('posts')->paginate(5);
        return view('Personnels.allPersonnelCard', compact('personnel'));
    }

    public function CollabClient(Request $request)
    {
        if (Session::has('idPersonnel')) {
            foreach (Session::get('idPersonnel') as $Personnel) {
                $id = $Personnel->idPersonnel;
            }
        }
        $client = DB::select('select clients.idClient , clients.slug, prenom,adresse,typeClient,email, nom,telephone,emailEntreprise,denomination,telephoneEntreprise,adresseEntreprise from clients,affectation_personnels where affectation_personnels.idClient = clients.idClient and affectation_personnels.idPersonnel =?', [$id]);

        return view('Personnels.collaborateurClient', compact('client'));
    }

    public function CollabAffaires(Request $request)
    {
        if (Session::has('idPersonnel')) {
            foreach (Session::get('idPersonnel') as $Personnel) {
                $id = $Personnel->idPersonnel;
            }
        }

        $affaire = DB::select('select affaires.slug,prenom,nom,typeClient,dateOuverture,affaires.idAffaire,clients.idClient,nomAffaire,denomination from clients,affaires,affectation_personnels where affaires.idClient = clients.idClient and affectation_personnels.idClient = affaires.idClient and affectation_personnels.idPersonnel =?', [$id]);

        return view('Personnels.collaborateurAffaires', compact('affaire'));
    }

    public function affaireListeCollab(Request $request)
    {
        if (Session::has('idPersonnel')) {
            foreach (Session::get('idPersonnel') as $Personnel) {
                $id = $Personnel->idPersonnel;
            }
        }

        $affaire = DB::select('select clients.idClient as clientid,affaires.created_at,affaires.slug,prenom,nom,denomination,typeClient,dateOuverture,affaires.idAffaire,nomAffaire  from clients,affaires,affectation_personnels where affaires.idClient = clients.idClient and affectation_personnels.idClient = affaires.idClient and affectation_personnels.idPersonnel =?', [$id]);

        return view('Personnels.affaireListe', compact('affaire'));
    }

    public function CollabAudiences(Request $request)
    {
        if (Session::has('idPersonnel')) {
            foreach (Session::get('idPersonnel') as $Personnel) {
                $id = $Personnel->idPersonnel;
            }
        }
        $audience = DB::select('select audiences.slug,audiences.idAudience,objet,roleASK,roleAdverse,statut from audiences,affectation_personnels where audiences.idClient = affectation_personnels.idClient and affectation_personnels.idPersonnel =?', [$id]);

        return view('Personnels.collaborateurAudiences', compact('audience'));
    }
}