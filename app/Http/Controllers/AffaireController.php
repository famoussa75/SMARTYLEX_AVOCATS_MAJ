<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Affaires;
use App\Models\Audiences;
use App\Models\clients;
use App\Models\CourierArriver;
use App\Models\CourierDepart;
use App\Models\Fichiers;
use App\Models\Files;
use App\Models\Personnels;
use App\Models\Taches;
use App\Models\User;
use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class AffaireController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function getAllAffaireForSearch($search)
    {
        if (Auth::user()->role == 'Administrateur' || Auth::user()->role == 'Assistant') {
            // récuperation des tâches dans la base de donnees
           $affaire = DB::select("select LOWER(nomAffaire) as nomAffaire,idAffaire,slug from affaires where nomAffaire like '%$search%'");

           
            
        } else {

            $email = Auth::user()->email;
            $personnel = DB::select('select * from personnels where email=? ', [$email]);
            $idPersonnel = $personnel[0]->idPersonnel;

            $affaire = DB::select("select affaires.slug,prenom,nom,typeClient,dateOuverture,affaires.idAffaire,LOWER(nomAffaire) as nomAffaire from clients,affaires,affectation_personnels where affaires.idClient = clients.idClient and affectation_personnels.idClient = affaires.idClient and affectation_personnels.idPersonnel =? and nomAffaire like '%$search%'", [$idPersonnel]);
        }
        return response()->json([
            'affaire' => $affaire,
        ]);
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */


    public function index()
    {

        if (Auth::user()->role == 'Administrateur' || Auth::user()->role == 'Assistant') {
            // récuperation des tâches dans la base de donnees
            $affaire = DB::select('select prenom, nom,denomination,typeClient, nomAffaire , affaires.slug , affaires.idAffaire , clients.idClient from clients,affaires where clients.idClient =affaires.idClient');

           
            
        } else {

            $email = Auth::user()->email;
            $personnel = DB::select('select * from personnels where email=? ', [$email]);
            $idPersonnel = $personnel[0]->idPersonnel;

            $affaire = DB::select("select affaires.slug,prenom,nom,typeClient,dateOuverture,affaires.idAffaire,LOWER(nomAffaire) as nomAffaire from clients,affaires,affectation_personnels where affaires.idClient = clients.idClient and affectation_personnels.idClient = affaires.idClient and affectation_personnels.idPersonnel =? ", [$idPersonnel]);
        }

        return view('affaires.allAffaires', compact('affaire'));
    }

    public function affaireListe()
    {
        if (Auth::user()->role == 'Administrateur' || Auth::user()->role == 'Assistant') {
            // récuperation des tâches dans la base de donnees
            $affaire = DB::select('select prenom, nom,denomination,typeClient, nomAffaire , affaires.slug , affaires.idAffaire , clients.idClient,affaires.created_at,affaires.type from clients,affaires where clients.idClient =affaires.idClient');

           
            
        } else {

            $email = Auth::user()->email;
            $personnel = DB::select('select * from personnels where email=? ', [$email]);
            $idPersonnel = $personnel[0]->idPersonnel;

            $affaire = DB::select("select affaires.created_at,affaires.slug,prenom,nom,typeClient,dateOuverture,affaires.idAffaire,LOWER(nomAffaire) as nomAffaire,affaires.type from clients,affaires,affectation_personnels where affaires.idClient = clients.idClient and affectation_personnels.idClient = affaires.idClient and affectation_personnels.idPersonnel =? ", [$idPersonnel]);
        }

        return view('affaires.AffaireListe', compact('affaire'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  int  $id
     * @param  string  $typeContent
     * @return \Illuminate\Http\Response
     */
    public function fetchAffaire($id)
    {
        // Verication du typeContent pour retourner une bonne reponse
        $affaireClientFetch = Affaires::all()->where('idClient', $id);
        //pour la page de creation de courier depart.
        $client = DB::select("select * from clients where idClient=?",[$id]);
        return response()->json([
            'affaire' => $affaireClientFetch,
            'client' => $client,
        ]);
    }



    /**
     * Afficher the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // Récuperation de l'ensemble des clients dans la base de donnees'
        if (Auth::user()->role=='Collaborateur') {
            $client = DB::table('clients')
            ->join('affectation_personnels', 'clients.idClient', '=', 'affectation_personnels.idClient')
            ->join('personnels', 'affectation_personnels.idPersonnel', '=', 'personnels.idPersonnel')
            ->where('personnels.email', Auth::user()->email)
            ->select('clients.*')
            ->get();        
        }else {
            $client = DB::select('select * from clients');
        }
       
        return view('affaires.createAffaire', compact('client'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
        $validate = $request->validate([
            'nom' => 'required',
            'dateOuverture' => 'required',
            'idClient' => 'required',
            'type' => 'required',
        ]);
        $affaire = new Affaires();
        if ($validate) {
            if ($request->typePost == "modalAffaire") {

                $affaire->nomAffaire = $request->nom;
                $affaire->idClient = $request->idClient;
                $affaire->type = $request->type;
                $affaire->slug = $request->_token . rand(5665, 9876);
                $affaire->dateOuverture = $request->dateOuverture;
                $affaire->etat = 'En cours';
                

                // Creation des fichiers
                // dossiers : affaires,taches,audiences,courier-departs,courier-arrivers
                if ($request->file('fichiers') != null) {

                    $fichiers = request()->file('fichiers');


                    foreach ($fichiers as $fichier){

                        $affaireFile = new Fichiers();

                        $filename = strtoupper(substr(str_shuffle(md5($request->_token . "" . rand(124, 345))), 0, 4)) . date('YmdHi') . '.' . $fichier->extension();
                        $affaireFile->nomOriginal = $fichier->getClientOriginalName();
                        $affaireFile->slugSource = $affaire->slug;
                        $affaireFile->filename =$filename;
                        $affaireFile->slug = $request->_token . "" . rand(1234, 3458);
                        $affaireFile->path = 'assets/upload/fichiers/affaires/' . $filename;
                        $fichier->move(public_path('assets/upload/fichiers/affaires'), $filename);
                        $affaireFile->save();
                    }
                }
                // Enregistrement
                $affaire->save();
                return back()->with('success', 'L\'affaire de ce client a été créée avec succès !');

            } else {
                $affaire->nomAffaire = $request->nom;
                $affaire->idClient = $request->idClient;
                $affaire->type = $request->type;
                $affaire->slug = $request->_token . rand(5665, 9876);
                $affaire->dateOuverture = $request->dateOuverture;
                $affaire->etat = 'En cours';
               
                
                // Creation des fichiers
                // dossiers : affaires,taches,audiences,courier-departs,courier-arrivers
                if ($request->file('fichiers') != null) {

                    $fichiers = request()->file('fichiers');


                    foreach ($fichiers as $fichier){

                        $affaireFile = new Fichiers();

                        $filename = strtoupper(substr(str_shuffle(md5($request->_token . "" . rand(124, 345))), 0, 4)) . date('YmdHi') . '.' . $fichier->extension();
                        $affaireFile->nomOriginal = $fichier->getClientOriginalName();
                        $affaireFile->slugSource = $affaire->slug;
                        $affaireFile->filename =$filename;
                        $affaireFile->slug = $request->_token . "" . rand(1234, 3458);
                        $affaireFile->path = 'assets/upload/fichiers/affaires/' . $filename;
                        $fichier->move(public_path('assets/upload/fichiers/affaires'), $filename);
                        $affaireFile->save();
                    }
                }
                
                
                

                // Enregistrement
                $affaire->save();

                $slug=$affaire->slug;
                $dernierAffaire = DB::select('select idAffaire from affaires where slug=?',[$slug]);
                $idAffaire=$dernierAffaire[0]->idAffaire;
                return redirect()->route('showAffaire',['id'=>$idAffaire,'slug'=>$slug])->with('success','Affaire enregistrée avec succès !');
            }
        }
    }

    private function getAudienceData($audiences, $cabinet, $personne_adverses, $entreprise_adverses, $autreRoles) {
        $formattedAudiences = [];
    
        foreach ($audiences as $row) {
            $ministerePublic = '';
            $autreRole = '';
            $demandeurs = [];
            $defendeurs = [];
            $partieCivile = [];
            $intervenant = [];
    
            foreach ($autreRoles as $r) {
                if ($r->idAudience === $row->idAudience) {
                    if ($r->autreRole === 'mp') {
                        $ministerePublic = 'Ministère public';
                    } else {
                        $autreRole = $r->autreRole;
                    }
                }
            }
    
            foreach ($cabinet as $c) {
                if ($c->idAudience === $row->idAudience) {
                    $partieCabinet = $c->prenom . ' ' . $c->nom . ' ' . $c->denomination;
                    if (in_array($c->role, ['Demandeur', 'Appelant(e)', 'Demandeur au pourvoi', 'Partie civile'])) {
                        $demandeurs[] = $partieCabinet;
                    }
                    if (in_array($c->role, ['Defendeur', 'Intimé(e)', 'Defendeur au pourvoi', 'Prevenu / Accusé'])) {
                        $defendeurs[] = $partieCabinet;
                    }
                }
            }
    
            foreach ($entreprise_adverses as $e) {
                if ($e->idAudience === $row->idAudience) {
                    if (in_array($e->role, ['Demandeur', 'Appelant(e)', 'Demandeur au pourvoi', 'Partie civile'])) {
                        $demandeurs[] = $e->denomination;
                    }
                    if (in_array($e->role, ['Defendeur', 'Intimé(e)', 'Defendeur au pourvoi', 'Prevenu / Accusé'])) {
                        $defendeurs[] = $e->denomination;
                    }
                    if ($e->autreRole === 'pc') $partieCivile[] = $e->denomination;
                    if ($e->autreRole === 'in') $intervenant[] = $e->denomination;
                }
            }
    
            foreach ($personne_adverses as $p) {
                if ($p->idAudience === $row->idAudience) {
                    $personneNom = $p->prenom . ' ' . $p->nom;
                    if (in_array($p->role, ['Demandeur', 'Appelant(e)', 'Demandeur au pourvoi', 'Partie civile'])) {
                        $demandeurs[] = $personneNom;
                    }
                    if (in_array($p->role, ['Defendeur', 'Intimé(e)', 'Defendeur au pourvoi', 'Prevenu / Accusé'])) {
                        $defendeurs[] = $personneNom;
                    }
                    if ($p->autreRole === 'pc') $partieCivile[] = $personneNom;
                    if ($p->autreRole === 'in') $intervenant[] = $personneNom;
                }
            }
    
            // Limiter à 3 parties et ajouter "et X autres" si nécessaire
            $demandeursDisplay = array_slice($demandeurs, 0, 3);
            if (count($demandeurs) > 3) {
                $demandeursDisplay[] = 'et ' . (count($demandeurs) - 3) . ' autres';
            }
    
            $defendeursDisplay = array_slice($defendeurs, 0, 3);
            if (count($defendeurs) > 3) {
                $defendeursDisplay[] = 'et ' . (count($defendeurs) - 3) . ' autres';
            }
    
            $formattedAudiences[] = [
                'idAudience' => $row->idAudience,
                'slugAud' => $row->slugAud,
                'objet' => $row->objet,
                'dateAudience' => $row->dateAudience,
                'statutAud' => $row->statutAud,
                'numRg' => $row->numRg,
                'niveauProcedural' => $row->niveauProcedural,
                'ministerePublic' => $ministerePublic,
                'parties' => implode(', ', $demandeursDisplay) . ' c/ ' . implode(', ', $defendeursDisplay),
                'partieCivile' => empty($partieCivile) ? '' : 'Partie civile : ' . implode(', ', $partieCivile),
                'intervenant' => empty($intervenant) ? '' : 'Intervenant : ' . implode(', ', $intervenant),
                'autreRole' => $autreRole,
            ];
        }
    
        return $formattedAudiences;
    } 
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @param  string  $slug
     * @return \Illuminate\Http\Response
     */
    public function show($id, $slug)
    {
        $affaire = DB::select('select * from clients,affaires where affaires.idClient=clients.idClient and affaires.slug = ?', [$slug]);

        // Information du client lié a l'affaire

        $infoClient = DB::select("select * from clients where idClient=?",[$affaire[0]->idClient]);

        //dd($infoClient);
        // Tâche lié a l'affaire
        $taches = Taches::all()->where('idAffaire', $id);

        // Courier lié a l'affaire (Départ)
        $courierDepart = CourierDepart::all()->where('idAffaire', $id);

        // Courier lié a l'affaire (Arriver)

        $courierArriver = CourierArriver::all()->where('idAffaire', $id);

        // Audiences lié a l'affaire
        $audiences1 = DB::select("select audiences.slug,audiences.idAudience,numRg,objet,niveauProcedural from audiences,parties where audiences.idAudience=parties.idAudience and parties.idAffaire=? ",[$id]);

        $audiences = DB::select("SELECT idAudience,subquery.numRg, subquery.objet, subquery.niveauProcedural, subquery.slugAud, subquery.statutAud, isChild, prochaineAudience as dateAudience
        FROM (
            SELECT MAX(idAudience) as idAudience, MAX(numRg) as numRg, MAX(objet) as objet, MAX(niveauProcedural) as niveauProcedural, slugAud, statutAud, MAX(isChild) as isChild, MAX(prochaineAudience) as prochaineAudience
            FROM (
                SELECT parties.idClient,parties.idAffaire,audiences.idAudience, audiences.slug as slugAud, numRg, objet, niveauProcedural, prenom, nom, denomination, NULL as numRccm, NULL as formeLegal, audiences.statut as statutAud, audiences.isChild, audiences.prochaineAudience
                FROM audiences
                JOIN parties ON audiences.idAudience = parties.idAudience
                LEFT JOIN clients ON parties.idClient = clients.idClient

                UNION

                SELECT parties.idClient,parties.idAffaire,audiences.idAudience, audiences.slug as slugAud, numRg, objet, niveauProcedural, prenom, nom, NULL as denomination, NULL as numRccm, NULL as formeLegal, audiences.statut as statutAud, audiences.isChild, audiences.prochaineAudience
                FROM audiences
                JOIN parties ON audiences.idAudience = parties.idAudience
                JOIN personne_adverses ON parties.idPartie = personne_adverses.idPartie

                UNION

                SELECT parties.idClient,parties.idAffaire,audiences.idAudience, audiences.slug as slugAud, numRg, objet, niveauProcedural, NULL as prenom, NULL as nom, denomination, numRccm, formeLegal, audiences.statut as statutAud, audiences.isChild, audiences.prochaineAudience
                FROM audiences
                JOIN parties ON audiences.idAudience = parties.idAudience
                JOIN entreprise_adverses ON parties.idPartie = entreprise_adverses.idPartie
            ) AS subquery_internal WHERE subquery_internal.idAffaire = $id
            GROUP BY subquery_internal.slugAud,subquery_internal.statutAud
        ) AS subquery
        WHERE isChild is null or isChild!='oui'
        ORDER BY idAudience ASC");



        if (empty($audiences)) {
            $cabinet=[];
            $personne_adverses=[];
            $entreprise_adverses=[];
            $autreRoles=[];
        } else {
            $cabinet =  DB::select("select parties.idPartie,nom,prenom,email,emailEntreprise,affaires.slug as affaireslug,nomAffaire,affaires.idAffaire,denomination,clients.slug as clientslug,clients.idClient,role,autreRole,idAudience from parties,clients,affaires where parties.idClient=clients.idClient and parties.idAffaire=affaires.idAffaire");

            $personne_adverses = DB::select("select * from personne_adverses,parties where parties.idPartie=personne_adverses.idPartie");

            $entreprise_adverses = DB::select("select * from entreprise_adverses,parties where parties.idPartie=entreprise_adverses.idPartie");

            $autreRoles = DB::select("select * from parties,audiences where audiences.idAudience=parties.idAudience");

        }

        // Pièces lié a l'affaire
        $pieceAffaires = DB::select('select * from fichiers where slugSource=?',[$slug]);

        // Pièces lié a la tâche de l'affaire
        $tache = DB::select('select taches.slug from taches,affaires where taches.idAffaire=affaires.idAffaire and affaires.slug=?',[$slug]);
        if (!empty($tache)) {
            
           /// $pieceTaches = DB::select("select * from fichiers where slugSource=?", [$tache[0]->slug]);

           $pieceTaches = DB::select("select fichiers.*,fichiers.slug as slug_fichiers, taches.* from fichiers,taches,affaires where fichiers.slugSource = taches.slug and taches.idAffaire=affaires.idAffaire and affaires.slug=?",[$affaire[0]->slug]);
           //dd($pieceTaches);
        }else {
            $pieceTaches=[];
        }

         // Pièces lié a l'audience de l'affaire
         $audience = DB::select('select audiences.slug from audiences,affaires where audiences.idAffaire=affaires.idAffaire and affaires.slug=?',[$slug]);
         if (!empty($audience)) {
             $pieceAudiences = DB::select("select * from fichiers where slugSource=?", [$audience[0]->$slug]);
         }else {
            $pieceAudiences=[];
         }
        

        // recuperation de l'information des personnels
        $personnels = Personnels::all();

        $factures = DB::select("select * from factures where idAffaire=?",[$id]);

        $formattedAudiences = $this->getAudienceData($audiences, $cabinet, $personne_adverses, $entreprise_adverses, $autreRoles);


        // procedure requete

          // procedure requete

          $requetes1 = DB::select("SELECT procedure_requetes.slug, procedure_requetes.* FROM procedure_requetes JOIN parties_requetes ON procedure_requetes.idProcedure = parties_requetes.idRequete
          JOIN affaires ON parties_requetes.idAffaire = affaires.idAffaire
          WHERE affaires.slug = ?
         ", [$slug]);
 
         //dd( $requetes1);
 
         
         //$requetes1 = DB::select("select * from procedure_requetes");
        
         $personne_adverses1 = DB::select("select * from personne_adverses_requetes,parties_requetes where parties_requetes.idPartie=personne_adverses_requetes.idPartie");
         $entreprise_adverses1 = DB::select("select * from entreprise_adverses_requetes,parties_requetes where parties_requetes.idPartie=entreprise_adverses_requetes.idPartie");
         $autreRoles1 = DB::select("select * from parties_requetes,procedure_requetes where procedure_requetes.idProcedure=parties_requetes.idRequete");
         $cabinet1 =  DB::select("select parties_requetes.idRequete,parties_requetes.idPartie,nom,prenom,email,emailEntreprise,affaires.slug as affaireslug,nomAffaire,affaires.idAffaire,denomination,clients.slug as clientslug,clients.idClient,role from parties_requetes,clients,affaires where parties_requetes.idClient=clients.idClient and parties_requetes.idAffaire=affaires.idAffaire");
         if (empty($audienceClient)) {
             $cabinet1=[];
             $personne_adverses=[];
             $autreRoles1=[];
             $autreRoles=[];
         } else {
             $personne_adverses1 = DB::select("select * from personne_adverses_requetes,parties_requetes where parties_requetes.idPartie=personne_adverses_requetes.idPartie");
             $entreprise_adverses1 = DB::select("select * from entreprise_adverses_requetes,parties_requetes where parties_requetes.idPartie=entreprise_adverses_requetes.idPartie");
             $autreRoles1 = DB::select("select * from parties_requetes,procedure_requetes where procedure_requetes.idProcedure=parties_requetes.idRequete");
             $cabinet1 =  DB::select("select parties_requetes.idRequete,parties_requetes.idPartie,nom,prenom,email,emailEntreprise,affaires.slug as affaireslug,nomAffaire,affaires.idAffaire,denomination,clients.slug as clientslug,clients.idClient,role from parties_requetes,clients,affaires where parties_requetes.idClient=clients.idClient and parties_requetes.idAffaire=affaires.idAffaire");
        
         }


        //dd($infoClient);
        return view(
            'affaires.affaireInfo',
            compact(
                'cabinet',
                'personne_adverses',
                'entreprise_adverses',
                'autreRoles',
                'personnels',
                'affaire',
                'formattedAudiences',
                'pieceAffaires',
                'pieceTaches',
                'pieceAudiences',
                'courierDepart',
                'courierArriver',
                'infoClient',
                'factures',
                'taches',


                'requetes1',
                'personne_adverses1',
                'entreprise_adverses1',
                'autreRoles1',
                'cabinet1'
            )
        );
    }

    /**
     * Afficher the form for editing the specified resource.
     *
     * @param  string  $slug
     * @return \Illuminate\Http\Response
     */
    public function affaireClient($id, $slug)
    {
        //
    }

    public function allAffaireClient()
    {
        $idClient = Auth::user()->idClient;
        $affaire = DB::select('select prenom, nom,denomination,typeClient, nomAffaire , affaires.slug , affaires.idAffaire , clients.idClient from clients,affaires where clients.idClient =affaires.idClient and clients.idClient=?',[$idClient]);

        return view('affaires.allAffaires', compact('affaire'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @param  string  $slug
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $slug)
    {
    

        $affaire = Affaires::where('slug', $slug)->firstOrFail();
        $affaire->nomAffaire =$request->nomAffaire;
        $affaire->idClient =  $request->idClient;
        $affaire->type =  $request->type;
        $affaire->dateOuverture =  $request->dateOuverture;
        $affaire->etat =  'En cours';           
        $affaire->save();

        return back()->with('success', 'modification effectuée avec succès');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function deleteAffaire($slug)
    {
        $affaire =  DB::select("select * from affaires where slug=?", [$slug]);
        $affaire = Affaires::find($affaire[0]->idAffaire);
        $affaire->delete();

        // $affaire =  DB::select("select * from affaires where slug=?", [$slug]);
        // $idAffaireInt = $affaire[0]->id;
        // $idAffaireString = trim($affaire[0]->id);




        // $audience =  DB::select("select * from audiences where idAffaire=?", [$idAffaireString]);
        // if (empty($audience)) {
        //     # code...
        // } else {
        //     DB::delete('delete from assignation_audiences where idAudience=?', [$audience[0]->id]);
        //     DB::delete('delete from file_audiences  where idAssignation=?', [$audience[0]->id]);
        //     DB::delete('delete from suivit_audiences  where idAudience=?', [$audience[0]->id]);
        //     DB::delete('delete from audiences where idAffaire=?', [$idAffaireString]);
        // }


        // $idCourierD =  DB::select("select * from courier_departs where idAffaire=?", [$idAffaireString]);
        // $idCourierA =  DB::select("select * from courier_arrivers where idAffaire=?", [$idAffaireString]);

        // if (empty($idCourierD)) {
        //     # code...
        // } else {
        //     DB::delete('delete from courier_files where idCourier=?', [$idCourierD[0]->id]);
        //     DB::delete('delete from courier_departs where idAffaire=?', [$idAffaireString]);
        // }
        // if (empty($idCourierA)) {
        //     # code...
        // } else {
        //     DB::delete('delete from courier_files where idCourier=?', [$idCourierA[0]->id]);
        //     DB::delete('delete from courier_arrivers where idAffaire=?', [$idAffaireString]);
        // }



        // $tache =  DB::select("select * from taches where idAffaire=?", [$idAffaireString]);

        // if (empty($tache)) {
        //     # code...
        // } else {


        //     DB::delete("delete from tache_files where idTache=?", [$tache[0]->id]);
        //     DB::delete("delete from traitement_taches where idTache=?", [$tache[0]->id]);
        //     DB::delete("delete from tache_personnels where idTache=?", [$tache[0]->id]);
        //     DB::delete('delete from taches where idAffaire=?', [$idAffaireString]);
        // }



        // DB::delete('delete from files where idAffaire=?', [$idAffaireString]);
        // DB::delete('delete from affaires where id=?', [$idAffaireInt]);

        return redirect()->route('allAfaires')->with('success', 'Affaire supprimée avec succès !');
    }
}
