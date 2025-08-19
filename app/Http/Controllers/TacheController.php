<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\clients;
use App\Models\Fichiers;
use App\Models\TachePersonne;
use App\Models\Personnels;
use App\Models\Notifications;
use App\Models\TraitementTaches;
use App\Models\Taches;
use App\Models\TacheFilles;
use App\Models\TypeTaches;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

use function PHPUnit\Framework\isNull;

class TacheController extends Controller
{


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */


    public function index()
    {
        // récuperation des tâches dans la base de donnees
        $taches = DB::select("
        
                    SELECT 
                titre,
                dateDebut,
                dateFin,
                statut,
                t.created_at AS tache_created_at,
                t.slug,
                nom,
                prenom,
                denomination,
                nomAffaire,
                idTache,
                t.idClient AS idClient,
                t.idAffaire
            FROM 
                taches AS t
            LEFT JOIN 
                clients AS c ON t.idClient = c.idClient
            LEFT JOIN 
                affaires AS a ON t.idAffaire = a.idAffaire

            UNION

            SELECT 
                titre,
                dateDebut,
                dateFin,
                statut,
                t.created_at AS tache_created_at,
                t.slug,
                nom,
                prenom,
                denomination,
                nomAffaire,
                idTache,
                t.idClient AS idClient,
                t.idAffaire
            FROM 
                taches AS t
            LEFT JOIN 
                clients AS c ON t.idClient = c.idClient
            LEFT JOIN 
                affaires AS a ON t.idAffaire = a.idAffaire
            WHERE 
                t.idClient IS NULL 
                AND t.idAffaire IS NULL
            ORDER BY 
                tache_created_at Desc
                   
        " );

        return view('taches.showTask', compact('taches'));
    }


    public function last()
    {
        // récuperation des tâches dans la base de donnees
        $taches = DB::select("select * from taches");

        for ($i = 0; $i < count($taches); $i++) {

            DB::update("update taches set slugTache=? where id=?", [$taches[$i]->id, $taches[$i]->id]);
        }
    }


    public function getAllTache()
    {

        /*   $taches = DB::select("select idTache,titre,slug from taches where statut='En cours'
                               UNION
                              select idTache,titre,slug from tache_filles where statut='En cours' ");
        */
        $taches = DB::select("select idTache,idTypeTache,titre,slug from taches where statut='En cours' and idTypeTache !='2'");



        return response()->json([
            'taches' => $taches,
        ]);
    }

    public function getOneTache($slugTache, $titre)
    {

        $tache = DB::select("select idTache,titre,idClient,idAffaire,slug from taches where slug=? and titre=?", [$slugTache, $titre]);

        if (empty($tache)) {
            $tache = DB::select("select idTache,titre,idClient,idAffaire,slug from tache_filles where slug=? and titre=?", [$slugTache, $titre]);
        }

        $idClient = $tache[0]->idClient;
        $idAffaire = $tache[0]->idAffaire;

        $client = DB::select("select * from clients where idClient=?", [$idClient]);
        $affaire = DB::select("select * from affaires where idAffaire=?", [$idAffaire]);


        return response()->json([
            'client' => $client,
            'affaire' => $affaire,
        ]);
    }


    /**
     * Fonction permettant de selectionner toutes les tâches pour une recherche future
     *
     * @return \Illuminate\Http\Response
     */
    public function getAllTacheForSearch($search)
    {
        if (Auth::user()->role == 'Administrateur' || Auth::user()->role == 'Assistant') {
            // récuperation des tâches dans la base de donnees
            $tache = DB::select("select LOWER(titre) as titre,slug from taches where titre like '%$search%'");
        } else {

            $email = Auth::user()->email;
            $personnel = DB::select('select * from personnels where email=? ', [$email]);
            $idPersonnel = $personnel[0]->idPersonnel;

            $tache = DB::select("
            
            select LOWER(titre) as titre,dateDebut,dateFin,taches.statut,taches.slug,nom,prenom,nom,taches.idTache,taches.idClient,taches.idAffaire from taches,clients,affaires,tache_personnels where taches.idTache = tache_personnels.idTache and tache_personnels.idPersonnel=$idPersonnel AND taches.idClient=clients.idClient AND taches.idAffaire=affaires.idAffaire and titre like '%$search%'
                UNION
            select LOWER(titre) as titre,dateDebut,dateFin,taches.statut,taches.slug,taches.idTache ,nom is NULL,prenom is NULL,nom is NULL,taches.idClient is NULL,taches.idAffaire is NULL  from taches,clients,affaires,tache_personnels where taches.idTache = tache_personnels.idTache and tache_personnels.idPersonnel=$idPersonnel AND taches.idClient=0 AND taches.idAffaire=0 and titre like '%$search%'
      
            ");
        }

        return response()->json([
            'tache' => $tache,
        ]);


        //return view('taches.showTask', compact('taches'));
    }

    public function employeeTask()
    {
        // récuperation des tâches dans la base de donnees
        $email = Auth::user()->email;
        $personnel = DB::select('select * from personnels where email=? ', [$email]);
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


        return view('taches.employeeTask', compact('taches'));
    }

    /**
     * Afficher the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request, $idModule, $typeModule)
    {
        if ($idModule == 'x' && $typeModule == 'all') {

            // L'instance du model client
            $clients = DB::select("select * from clients");

            $affaire = '';

            $idCourier = 0;

            $idAudience = 0;
            $idSuivitRequete=0;

            $idSuivit = 0;

            $tacheAff = false;

        } elseif ($idModule != 'x' && $typeModule == 'affaire') {

            $affaire = DB::select("select * from affaires where idAffaire=?", [$idModule]);

            $clients = DB::select("select * from clients where idClient=?", [$affaire[0]->idClient]);

            $tacheAff = true;

            $idCourier = 0;

            $idAudience = 0;
            $idSuivitRequete=0;

            $idSuivit = 0;

        } elseif ($idModule != 'x' && $typeModule == 'client') {

            $affaire = DB::select("select * from affaires where idClient=?", [$idModule]);

            $clients = DB::select("select * from clients where idClient=?", [$idModule]);

            $tacheAff = true;

            $idCourier = 0;

            $idAudience = 0;
            $idSuivitRequete=0;

            $idSuivit = 0;
        }

        if ($idModule != 'x' && $typeModule == 'courier') {

            $courrier = DB::select("select * from courier_arrivers where idCourierArr=?", [$idModule]);

            $clientCourrier = DB::select("select * from clients where idClient=?", [$courrier[0]->idClient]);


            if (empty($clientCourrier)) {

                $idClient = 0;

                $affaire = [];

                $clients = [];

                $tacheAff = true;

                $idCourier = $idModule;

                $idAudience = 0;
                $idSuivitRequete=0;

                $idSuivit = 0;
                
                
            } else {
                

                $idClient = $clientCourrier[0]->idClient;

                $affaire = DB::select("select * from affaires where idAffaire=?", [$courrier[0]->idAffaire]);

                $clients = DB::select("select * from clients where idClient=?", [$idClient]);

                $tacheAff = true;

                $idCourier = $courrier[0]->idCourierArr;

                $idAudience = 0;
                $idSuivitRequete=0;

                $idSuivit = 0;
            }
        }
        
        if ($idModule != 'x' && $typeModule == 'audienceAppel') {

            $suivitAudienceAppel = DB::select("select * from suivit_audience_appels where idSuivitAppel=?",[$idModule]);
            $audience = DB::select("select * from parties where typeAvocat=1 and idAudience=?", [$suivitAudienceAppel[0]->idAudience]);
            $clientAud = DB::select("select * from clients where idClient=?", [$audience[0]->idClient]);
           

            if (empty($clientAud)) {

                $idClient = 0;

                $affaire = [];

                $clients = [];

                $tacheAff = true;

                $idCourier = 0;

                $idAudience = 0;
                $idSuivitRequete=0;

                $idSuivit = 0;

            }else {

                $idClient = $clientAud[0]->idClient;

                $affaire = DB::select("select * from affaires where idAffaire=?", [$audience[0]->idAffaire]);

                $clients = DB::select("select * from clients where idClient=?", [$idClient]);

                $tacheAff = true;

                $idCourier = 0;

                $idSuivitRequete=0;
                $idSuivit = $idModule;

                $idAudience = $audience[0]->idAudience;
                
            }
        }

        if ($idModule != 'x' && $typeModule == 'audience') {

            $suivitAudience = DB::select("select * from suivit_audiences where idSuivit=?",[$idModule]);
            $audience = DB::select("select * from parties where typeAvocat=1 and idAudience=?", [$suivitAudience[0]->idAudience]);
            $clientAud = DB::select("select * from clients where idClient=?", [$audience[0]->idClient]);
          
            if (empty($clientAud)) {

                $idClient = 0;

                $affaire = [];

                $clients = [];

                $tacheAff = true;

                $idCourier = 0;

                $idAudience = 0;
                $idSuivitRequete=0;

                $idSuivit = 0;

            } else {

                $idClient = $clientAud[0]->idClient;

                $affaire = DB::select("select * from affaires where idAffaire=?", [$audience[0]->idAffaire]);

                $clients = DB::select("select * from clients where idClient=?", [$idClient]);

                $tacheAff = true;

                $idCourier = 0;
                $idSuivitRequete=0;

                $idAudience = $audience[0]->idAudience;

                $idSuivit = $idModule;

            }
        }
        
        if ($idModule != 'x' && $typeModule == 'requetes') {

            $suivitRequete = DB::select("select * from suivit_requetes where idSuivit=?",[$idModule]);
            $audience = DB::select("select * from parties_requetes where typeAvocat=1 and idRequete=?", [$suivitRequete[0]->idRequete]);
            $clientRequete = DB::select("select * from clients where idClient=?", [$audience[0]->idClient]);

            // mise a jour 
            if (empty($clientRequete)) {

                $idClient = 0;

                $affaire = [];

                $clients = [];

                $tacheAff = true;

                $idCourier = 0;

                $idRequete = 0;

                $idSuivit = 0;

                $idSuivit = 0;

            } else {

                $idClient = $clientRequete[0]->idClient;

                $affaire = DB::select("select * from affaires where idAffaire=?", [$audience[0]->idAffaire]);

                $clients = DB::select("select * from clients where idClient=?", [$idClient]);

                $tacheAff = true;

                $idCourier = 0;

               // $idRequete = $audience[0]->idRequete;
                $idAudience = $audience[0]->idRequete;
                
                $idSuivit = 0;

                $idSuivitRequete = $idModule;

            }
            
        }

        // L'instance du model personnel
        $personnels = Personnels::all();

        $typeTaches = DB::select("select * from type_taches");

        if (empty($typeTaches)) {

            TypeTaches::create([
                'descriptionType' => 'Tâche ordinaire',
            ]);

            TypeTaches::create([
                'descriptionType' => 'Création d\'entreprise',
            ]);

            $typeTaches = DB::select("select * from type_taches");
        } else {
            $typeTaches = DB::select("select * from type_taches");
        }



        // Affichage du formulaire permettant de créer une tâche
        return view('taches.createTask', compact('personnels', 'clients', 'tacheAff', 'affaire', 'idCourier', 'typeTaches','idAudience','idSuivit','idSuivitRequete'));
    }

    public function createFromCourrier($idCourrier)
    {
        // L'instance du model personnel
        $personnels = Personnels::all();

        // L'instance du model client
        $clients = DB::select("select * from clients");
        $courrier = DB::select("select * from courier_arrivers where id=?", [$idCourrier]);
        $clientCourrier = DB::select("select * from clients where id=?", [$courrier[0]->idClient]);
        $clientAffaire = DB::select("select * from affaires where id=?", [$courrier[0]->idAffaire]);

        if (empty($clientCourrier)) {
            $idClient = 'x';
        } else {
            $idClient = $clientCourrier[0]->idClient;
        }



        // Affichage du formulaire permettant de créer une tâche
        return redirect()->route('taskForm', [$idClient, 'courier']);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        return DB::transaction(function () use ($request) {
        // Liaison de la tâche avec la personne ou les personnes assignées
        $arr = $request->idPersonnel;
        $arrResponsable = $request->idPersonnelResponsable;

       

        // L'instance du model Fichiers'
        // $fichiers = new Fichiers();

        // L'instance du model tache'
        $tache = new Taches();


        if ($request) {


            if ($request->idClient) {

                $idClient = $request->idClient;
                $idAffaire = $request->idAffaire;
            } else {

                $idClient = $request->idClient2;
                $idAffaire = $request->idAffaire2;
            }

            if ($request->dateDebut) {
                $dateDebut = $request->dateDebut;
                $dateFin = $request->dateFin;
            } else {
                $dateDebut = '';
                $dateFin = $request->dateFin2;
            }

            if ($request->categorie == 'Simple') {
        

                // L'instance du model tache'
                $tache = new Taches();

                // L'instance du model Fichiers'
                $fichiers = new Fichiers();

                if ($request->idTypeTache == 1) {

                    // Creation de la tâche
                    $tache->titre = $request->titre;
                    $tache->point = $request->point;
                    $tache->idClient = $idClient;
                    $tache->idAffaire = $idAffaire;
                    $tache->courrierTache =  $request->idCourier;
                    $tache->audTache =  $request->idAudience;
                    $tache->idSuivitRequete =  $request->idSuivitRequete;
                    $tache->idSuivit =  $request->idSuivit;
                    $tache->idTypeTache = $request->idTypeTache;
                    $tache->priorite = $request->priorite;
                    $tache->dateDebut = $dateDebut;
                    $tache->dateFin = $request->dateFin;
                    $tache->description = $request->description;
                    $tache->statut = 'En cours';
                    $tache->created_by = Auth::user()->name;
                    $tache->categorie = $request->categorie;
                    $tache->slug = $request->_token . '' . rand(1234, 3458);
                    $tache->slugFille = $tache->slug;
                    // Enregistrement
                    $tache->save();

                    $admins = DB::select("select * from users where role='Administrateur'");

                    foreach ($admins as $a) {
                        DB::select(
                            'INSERT INTO notifications(categorie, messages, etat, idRecepteur,slug,a_biper,urlName,urlParam,idAdmin) VALUES(?,?,?,?,?,?,?,?,?)',
                            [
                                'Tâche',
                                'Vous avez une nouvelle tâche en attente.',
                                'masquer',
                                'admin',
                                $request->_token . "" . rand(1234, 3458),
                                "non",
                                "infosTask",
                                $tache->slug,
                                $a->id
                            ]
                        );
                    }

                    
                    $idTache = DB::select("select idTache from taches where slug=?", [$tache->slug]);
                    for ($j = 0; $j < count($arrResponsable); $j++) {
                        DB::select(
                            'INSERT INTO tache_personnels(idTache, idPersonnel,fonction, slug) VALUES(?,?,?,?)',
                            [
                                $idTache[0]->idTache,
                                 $arrResponsable[$j],
                                'Responsable',
                                $request->_token . "" . rand(1234, 3458)
                            ]
                        );
                        DB::select(
                            'INSERT INTO notifications(categorie, messages, etat, idRecepteur,slug,a_biper,urlName,urlParam) VALUES(?,?,?,?,?,?,?,?)',
                            [
                                'Tâche',
                                'Vous avez une nouvelle tâche en attente.',
                                'masquer',
                                 $arrResponsable[$j],
                                $request->_token . "" . rand(1234, 3458),
                                "non",
                                "infosTask",

                                $tache->slug
                            ]
                        );
                    }

                    $arr = $arr ?? [];

                    for ($i = 0; $i < count($arr); $i++) {
                        DB::select(
                            'INSERT INTO tache_personnels(idTache, idPersonnel,fonction, slug) VALUES(?,?,?,?)',
                            [
                                $idTache[0]->idTache,
                                $arr[$i],
                                'Participant',
                                $request->_token . "" . rand(1234, 3458)
                            ]
                        );
                        DB::select(
                            'INSERT INTO notifications(categorie, messages, etat, idRecepteur,slug,a_biper,urlName,urlParam) VALUES(?,?,?,?,?,?,?,?)',
                            [
                                'Tâche',
                                'Vous avez une nouvelle tâche en attente.',
                                'masquer',
                                $arr[$i],
                                $request->_token . "" . rand(1234, 3458),
                                "non",
                                "infosTask",

                                $tache->slug
                            ]
                        );
                    }

                    // Creation des fichiers
                    // dossiers : affaires,taches,audiences,courier-departs,courier-arrivers
                    if ($request->file('fichiers') != null) {

                        $fichiers = request()->file('fichiers');


                        foreach ($fichiers as $fichier) {

                            $tacheFile = new Fichiers();

                            $filename = strtoupper(substr(str_shuffle(md5($request->_token . "" . rand(124, 345))), 0, 4)) . date('YmdHi') . '.' . $fichier->extension();
                            $tacheFile->nomOriginal = $fichier->getClientOriginalName();
                            $tacheFile->filename = $filename;
                            $tacheFile->slugSource = $tache->slug;
                            $tacheFile->slug = $request->_token . "" . rand(1234, 3458);
                            $tacheFile->path = 'assets/upload/fichiers/taches/' . $filename;
                            $fichier->move(public_path('assets/upload/fichiers/taches'), $filename);
                            $tacheFile->save();
                        }
                    }

                    // mettre le statut du courrier arrivee en traitement si c'est courier de la tâche
                    $courrierTache = $request->idCourier;
                    if ($courrierTache == 0) {
                    } else {
                        DB::update("update courier_arrivers set statut='En Traitement' where idCourierArr=?", [$courrierTache]);
                    }
                    $request = null;

                    return redirect()->route('infosTask', $tache->slug)->with('success', 'Tâche créer avec success, les personnes assignées seront notifier pour cette tâche');
               
                } elseif ($request->idTypeTache == 2) {
                    
                    

                    $todays = date('Y-m-d');
                    $dateFin = date('Y-m-d', strtotime($todays . ' + ' . $request->delais1 . ' days'));

                    // A- Creation de la tâche
                    // L'instance du model tache'
                    $tache1 = new Taches();


                    // Creation de la tâche
                    $tache1->titre = $request->titre1;
                    $tache1->point = $request->point1;
                    $tache1->idClient = $idClient;
                    $tache1->idAffaire = $idAffaire;
                    $tache1->courrierTache =  $request->idCourier;
                    $tache1->audTache =  $request->idAudience;
                    $tache1->idTypeTache = $request->idTypeTache;
                    $tache1->priorite = $request->priorite;
                    $tache1->dateDebut = $todays;
                    $tache1->dateFin = $dateFin;
                    $tache1->description = $request->desc1;
                    $tache1->statut = 'En cours';
                    $tache1->created_by = Auth::user()->name;
                    $tache1->categorie = $request->categorie;
                    $tache1->slug = $request->_token . '' . rand(1234, 3458);
                    $tache1->slugFille = $tache1->slug;
                    // Enregistrement
                    $tache1->save();


                    // mettre le statut du courrier arrivee en traitement si c'est courier de la tâche
                    $courrierTache = $request->courrier;
                    if ($courrierTache == '') {
                    } else {
                        DB::update("update courier_arrivers set statut='En Traitement' where idCourrierArr=?", [$courrierTache]);
                    }
                    $idTache = DB::select("select idTache from taches where slug=?", [$tache1->slug]);

                    for ($j = 0; $j < count($arrResponsable); $j++) {
                        DB::select(
                            'INSERT INTO tache_personnels(idTache, idPersonnel,fonction, slug) VALUES(?,?,?,?)',
                            [
                                $idTache[0]->idTache,
                                 $arrResponsable[$j],
                                'Responsable',
                                $request->_token . "" . rand(1234, 3458)
                            ]
                        );
                        DB::select(
                            'INSERT INTO notifications(categorie, messages, etat, idRecepteur,slug,a_biper,urlName,urlParam) VALUES(?,?,?,?,?,?,?,?)',
                            [
                                'Tâche',
                                'Vous avez une nouvelle tâche en attente.',
                                'masquer',
                                 $arrResponsable[$j],
                                $request->_token . "" . rand(1234, 3458),
                                "non",
                                "infosTask",

                                $tache1->slug
                            ]
                        );
                    }

                   

                    $arr = $arr ?? [];

                    for ($i = 0; $i < count($arr); $i++) {
                        DB::select(
                            'INSERT INTO tache_personnels(idTache, idPersonnel,fonction, slug) VALUES(?,?,?,?)',
                            [
                                $idTache[0]->idTache,
                                $arr[$i],
                                'Participant',
                                $request->_token . "" . rand(1234, 3458)
                            ]
                        );
                        DB::select(
                            'INSERT INTO notifications(categorie, messages, etat, idRecepteur,slug,a_biper,urlName,urlParam) VALUES(?,?,?,?,?,?,?,?)',
                            [
                                'Tâche',
                                'Vous avez une nouvelle tâche en attente.',
                                'masquer',
                                $arr[$i],
                                $request->_token . "" . rand(1234, 3458),
                                "non",
                                "infosTask",

                                $tache1->slug
                            ]
                        );
                    }

                    // Creation des fichiers
                    // dossiers : affaires,taches,audiences,courier-departs,courier-arrivers
                    if ($request->file('fichiers') != null) {

                        $fichiers = request()->file('fichiers');


                        foreach ($fichiers as $fichier) {

                            $tacheFile = new Fichiers();

                            $filename = strtoupper(substr(str_shuffle(md5($request->_token . "" . rand(124, 345))), 0, 4)) . date('YmdHi') . '.' . $fichier->extension();
                            $tacheFile->nomOriginal = $fichier->getClientOriginalName();
                            $tacheFile->filename = $filename;
                            $tacheFile->slugSource = $tache1->slug;
                            $tacheFile->slug = $request->_token . "" . rand(1234, 3458);
                            $tacheFile->path = 'assets/upload/fichiers/taches/' . $filename;
                            $fichier->move(public_path('assets/upload/fichiers/taches'), $filename);
                            $tacheFile->save();
                        }
                    }

                    // mettre le statut du courrier arrivee en traitement si c'est courier de la tâche
                    $courrierTache = $request->idCourier;
                    if ($courrierTache == 0) {
                    } else {
                        DB::update("update courier_arrivers set statut='En Traitement' where idCourierArr=?", [$courrierTache]);
                    }


                    // 2---------------------------------------------------------------------------------

                    // selection de la 1ere tache
                    $t1 = DB::select("select * from taches where slug=?", [$tache1->slug]);
                    //B- Creation de la 2eme taches liee a la tâche principale.

                    $tacheFille2 = new TacheFilles();
                    // Creation de la tâche fille
                    $tacheFille2->idTache = $t1[0]->idTache;
                    $tacheFille2->titre = $request->titre2;
                    $tacheFille2->point = $request->point2;
                    $tacheFille2->idClient = $idClient;
                    $tacheFille2->idTypeTache = $request->idTypeTache;
                    $tacheFille2->idAffaire = $idAffaire;
                    $tacheFille2->priorite = $request->priorite;
                    $tacheFille2->dateDebut = '';
                    $tacheFille2->dateFin = $request->delais2;
                    $tacheFille2->description = $request->desc2;
                    $tacheFille2->statut = 'En cours';
                    $tacheFille2->categorie = $request->categorie;
                    $tacheFille2->slugTache = $tache1->slug;
                    $tacheFille2->slug = $request->_token . '' . rand(1234, 3458);
                    // Enregistrement
                    $tacheFille2->save();

                    $idTacheFille2 = DB::select("select * from tache_filles where slug=?", [$tacheFille2->slug]);
                    for ($j = 0; $j < count($arrResponsable); $j++) {
                        DB::select(
                            'INSERT INTO tache_personnel_filles(idTacheFille, idPersonnel,fonction,slug) VALUES(?,?,?,?)',
                            [
                                $idTacheFille2[0]->idTacheFille,
                                 $arrResponsable[$j],
                                'Responsable',
                                $request->_token . "" . rand(1234, 3458)
                            ]
                        );
                    }


                    for ($i = 0; $i < count($arr); $i++) {
                        DB::select(
                            'INSERT INTO tache_personnel_filles(idTacheFille, idPersonnel,fonction,slug) VALUES(?,?,?,?)',
                            [
                                $idTacheFille2[0]->idTacheFille,
                                $arr[$i],
                                'Participant',
                                $request->_token . "" . rand(1234, 3458)
                            ]
                        );
                    }

                    //------------------------------------------------------------------------------------

                    // 3---------------------------------------------------------------------------------

                    // selection de la 1ere tache
                    $t2 = DB::select("select * from tache_filles where slug=?", [$tacheFille2->slug]);
                    //B- Creation de la 2eme taches liee a la tâche principale.

                    $tacheFille3 = new TacheFilles();
                    // Creation de la tâche fille
                    $tacheFille3->idTache = $t2[0]->idTache;
                    $tacheFille3->titre = $request->titre3;
                    $tacheFille3->point = $request->point3;
                    $tacheFille3->idClient = $idClient;
                    $tacheFille3->idTypeTache = $request->idTypeTache;
                    $tacheFille3->idAffaire = $idAffaire;
                    $tacheFille3->priorite = $request->priorite;
                    $tacheFille3->dateDebut = '';
                    $tacheFille3->dateFin = $request->delais3;
                    $tacheFille3->description = $request->desc3;
                    $tacheFille3->statut = 'En cours';
                    $tacheFille3->categorie = $request->categorie;
                    $tacheFille3->slugTache = $tacheFille2->slug;
                    $tacheFille3->slug = $request->_token . '' . rand(1234, 3458);
                    // Enregistrement
                    $tacheFille3->save();

                    $idTacheFille3 = DB::select("select * from tache_filles where slug=?", [$tacheFille3->slug]);

                    for ($j = 0; $j < count($arrResponsable); $j++) {
                        DB::select(
                            'INSERT INTO tache_personnel_filles(idTacheFille, idPersonnel,fonction,slug) VALUES(?,?,?,?)',
                            [
                                $idTacheFille3[0]->idTacheFille,
                                 $arrResponsable[$j],
                                'Responsable',
                                $request->_token . "" . rand(1234, 3458)
                            ]
                        );
                    }

                    for ($i = 0; $i < count($arr); $i++) {
                        DB::select(
                            'INSERT INTO tache_personnel_filles(idTacheFille, idPersonnel,fonction,slug) VALUES(?,?,?,?)',
                            [
                                $idTacheFille3[0]->idTacheFille,
                                $arr[$i],
                                'Participant',
                                $request->_token . "" . rand(1234, 3458)
                            ]
                        );
                    }

                    //------------------------------------------------------------------------------------

                    // 4--------------------------------------------------------------------------------

                    // selection de la 1ere tache
                    $t3 = DB::select("select * from tache_filles where slug=?", [$tacheFille3->slug]);
                    //B- Creation de la 2eme taches liee a la tâche principale.

                    $tacheFille4 = new TacheFilles();
                    // Creation de la tâche fille
                    $tacheFille4->idTache = $t3[0]->idTache;
                    $tacheFille4->titre = $request->titre4;
                    $tacheFille4->point = $request->point4;
                    $tacheFille4->idClient = $idClient;
                    $tacheFille4->idTypeTache = $request->idTypeTache;
                    $tacheFille4->idAffaire = $idAffaire;
                    $tacheFille4->priorite = $request->priorite;
                    $tacheFille4->dateDebut = '';
                    $tacheFille4->dateFin = $request->delais4;
                    $tacheFille4->description = $request->desc4;
                    $tacheFille4->statut = 'En cours';
                    $tacheFille4->categorie = $request->categorie;
                    $tacheFille4->slugTache = $tacheFille3->slug;
                    $tacheFille4->slug = $request->_token . '' . rand(1234, 3458);
                    // Enregistrement
                    $tacheFille4->save();

                    $idTacheFille4 = DB::select("select * from tache_filles where slug=?", [$tacheFille4->slug]);
                    for ($j = 0; $j < count($arrResponsable); $j++) {
                        DB::select(
                            'INSERT INTO tache_personnel_filles(idTacheFille, idPersonnel,fonction,slug) VALUES(?,?,?,?)',
                            [
                                $idTacheFille4[0]->idTacheFille,
                                 $arrResponsable[$j],
                                'Responsable',
                                $request->_token . "" . rand(1234, 3458)
                            ]
                        );
                    }


                    for ($i = 0; $i < count($arr); $i++) {
                        DB::select(
                            'INSERT INTO tache_personnel_filles(idTacheFille, idPersonnel,fonction, slug) VALUES(?,?,?,?)',
                            [
                                $idTacheFille4[0]->idTacheFille,
                                $arr[$i],
                                'Participant',
                                $request->_token . "" . rand(1234, 3458)
                            ]
                        );
                    }

                    //------------------------------------------------------------------------------------

                    // 5--------------------------------------------------------------------------------

                    // selection de la 1ere tache
                    $t4 = DB::select("select * from tache_filles where slug=?", [$tacheFille4->slug]);
                    //B- Creation de la 2eme taches liee a la tâche principale.

                    $tacheFille5 = new TacheFilles();
                    // Creation de la tâche fille
                    $tacheFille5->idTache = $t4[0]->idTache;
                    $tacheFille5->titre = $request->titre5;
                    $tacheFille5->point = $request->point5;
                    $tacheFille5->idClient = $idClient;
                    $tacheFille5->idTypeTache = $request->idTypeTache;
                    $tacheFille5->idAffaire = $idAffaire;
                    $tacheFille5->priorite = $request->priorite;
                    $tacheFille5->dateDebut = '';
                    $tacheFille5->dateFin = $request->delais5;
                    $tacheFille5->description = $request->desc5;
                    $tacheFille5->statut = 'En cours';
                    $tacheFille5->categorie = $request->categorie;
                    $tacheFille5->slugTache = $tacheFille4->slug;
                    $tacheFille5->slug = $request->_token . '' . rand(1234, 3458);
                    // Enregistrement
                    $tacheFille5->save();

                    $idTacheFille5 = DB::select("select * from tache_filles where slug=?", [$tacheFille5->slug]);
                    for ($j = 0; $j < count($arrResponsable); $j++) {
                        DB::select(
                            'INSERT INTO tache_personnel_filles(idTacheFille, idPersonnel,fonction,slug) VALUES(?,?,?,?)',
                            [
                                $idTacheFille5[0]->idTacheFille,
                                 $arrResponsable[$j],
                                'Responsable',
                                $request->_token . "" . rand(1234, 3458)
                            ]
                        );
                    }

                    for ($i = 0; $i < count($arr); $i++) {
                        DB::select(
                            'INSERT INTO tache_personnel_filles(idTacheFille, idPersonnel,fonction, slug) VALUES(?,?,?,?)',
                            [
                                $idTacheFille5[0]->idTacheFille,
                                $arr[$i],
                                'Participant',
                                $request->_token . "" . rand(1234, 3458)
                            ]
                        );
                    }

                    //------------------------------------------------------------------------------------

                    // 6--------------------------------------------------------------------------------

                    // selection de la 1ere tache
                    $t5 = DB::select("select * from tache_filles where slug=?", [$tacheFille5->slug]);
                    //B- Creation de la 2eme taches liee a la tâche principale.

                    $tacheFille6 = new TacheFilles();
                    // Creation de la tâche fille
                    $tacheFille6->idTache = $t5[0]->idTache;
                    $tacheFille6->titre = $request->titre6;
                    $tacheFille6->point = $request->point6;
                    $tacheFille6->idClient = $idClient;
                    $tacheFille6->idTypeTache = $request->idTypeTache;
                    $tacheFille6->idAffaire = $idAffaire;
                    $tacheFille6->priorite = $request->priorite;
                    $tacheFille6->dateDebut = '';
                    $tacheFille6->dateFin = $request->delais6;
                    $tacheFille6->description = $request->desc6;
                    $tacheFille6->statut = 'En cours';
                    $tacheFille6->categorie = $request->categorie;
                    $tacheFille6->slugTache = $tacheFille5->slug;
                    $tacheFille6->slug = $request->_token . '' . rand(1234, 3458);
                    // Enregistrement
                    $tacheFille6->save();

                    $idTacheFille6 = DB::select("select * from tache_filles where slug=?", [$tacheFille6->slug]);
                    for ($j = 0; $j < count($arrResponsable); $j++) {
                        DB::select(
                            'INSERT INTO tache_personnel_filles(idTacheFille, idPersonnel,fonction,slug) VALUES(?,?,?,?)',
                            [
                                $idTacheFille6[0]->idTacheFille,
                                 $arrResponsable[$j],
                                'Responsable',
                                $request->_token . "" . rand(1234, 3458)
                            ]
                        );
                    }
                    

                    for ($i = 0; $i < count($arr); $i++) {
                        DB::select(
                            'INSERT INTO tache_personnel_filles(idTacheFille, idPersonnel,fonction,slug) VALUES(?,?,?,?)',
                            [
                                $idTacheFille6[0]->idTacheFille,
                                $arr[$i],
                                'Participant',
                                $request->_token . "" . rand(1234, 3458)
                            ]
                        );
                    }

                    //------------------------------------------------------------------------------------

                    // 7--------------------------------------------------------------------------------

                    // selection de la 1ere tache
                    $t6 = DB::select("select * from tache_filles where slug=?", [$tacheFille6->slug]);
                    //B- Creation de la 2eme taches liee a la tâche principale.

                    $tacheFille7 = new TacheFilles();
                    // Creation de la tâche fille
                    $tacheFille7->idTache = $t6[0]->idTache;
                    $tacheFille7->titre = $request->titre7;
                    $tacheFille7->point = $request->point7;
                    $tacheFille7->idClient = $idClient;
                    $tacheFille7->idTypeTache = $request->idTypeTache;
                    $tacheFille7->idAffaire = $idAffaire;
                    $tacheFille7->priorite = $request->priorite;
                    $tacheFille7->dateDebut = '';
                    $tacheFille7->dateFin = $request->delais7;
                    $tacheFille7->description = $request->desc7;
                    $tacheFille7->statut = 'En cours';
                    $tacheFille7->categorie = $request->categorie;
                    $tacheFille7->slugTache = $tacheFille6->slug;
                    $tacheFille7->slug = $request->_token . '' . rand(1234, 3458);
                    // Enregistrement
                    $tacheFille7->save();

                    $idTacheFille7 = DB::select("select * from tache_filles where slug=?", [$tacheFille7->slug]);
                    for ($j = 0; $j < count($arrResponsable); $j++) {
                        DB::select(
                            'INSERT INTO tache_personnel_filles(idTacheFille, idPersonnel,fonction,slug) VALUES(?,?,?,?)',
                            [
                                $idTacheFille7[0]->idTacheFille,
                                 $arrResponsable[$j],
                                'Responsable',
                                $request->_token . "" . rand(1234, 3458)
                            ]
                        );
                    }

                    for ($i = 0; $i < count($arr); $i++) {
                        DB::select(
                            'INSERT INTO tache_personnel_filles(idTacheFille, idPersonnel,fonction,slug) VALUES(?,?,?,?)',
                            [
                                $idTacheFille7[0]->idTacheFille,
                                $arr[$i],
                                'Participant',
                                $request->_token . "" . rand(1234, 3458)
                            ]
                        );
                    }

                    //------------------------------------------------------------------------------------

                    // 8--------------------------------------------------------------------------------

                    // selection de la 1ere tache
                    $t7 = DB::select("select * from tache_filles where slug=?", [$tacheFille6->slug]);
                    //B- Creation de la 2eme taches liee a la tâche principale.

                    $tacheFille8 = new TacheFilles();
                    // Creation de la tâche fille
                    $tacheFille8->idTache = $t7[0]->idTache;
                    $tacheFille8->titre = $request->titre8;
                    $tacheFille8->point = $request->point8;
                    $tacheFille8->idClient = $idClient;
                    $tacheFille8->idTypeTache = $request->idTypeTache;
                    $tacheFille8->idAffaire = $idAffaire;
                    $tacheFille8->priorite = $request->priorite;
                    $tacheFille8->dateDebut = '';
                    $tacheFille8->dateFin = $request->delais8;
                    $tacheFille8->description = $request->desc8;
                    $tacheFille8->statut = 'En cours';
                    $tacheFille8->categorie = $request->categorie;
                    $tacheFille8->slugTache = $tacheFille7->slug;
                    $tacheFille8->slug = $request->_token . '' . rand(1234, 3458);
                    // Enregistrement
                    $tacheFille8->save();

                    $idTacheFille8 = DB::select("select * from tache_filles where slug=?", [$tacheFille8->slug]);
                    for ($j = 0; $j < count($arrResponsable); $j++) {
                        DB::select(
                            'INSERT INTO tache_personnel_filles(idTacheFille, idPersonnel,fonction,slug) VALUES(?,?,?,?)',
                            [
                                $idTacheFille8[0]->idTacheFille,
                                 $arrResponsable[$j],
                                'Responsable',
                                $request->_token . "" . rand(1234, 3458)
                            ]
                        );
                    }

                    for ($i = 0; $i < count($arr); $i++) {
                        DB::select(
                            'INSERT INTO tache_personnel_filles(idTacheFille, idPersonnel,fonction, slug) VALUES(?,?,?,?)',
                            [
                                $idTacheFille8[0]->idTacheFille,
                                $arr[$i],
                                'Participant',
                                $request->_token . "" . rand(1234, 3458)
                            ]
                        );
                    }

                    //------------------------------------------------------------------------------------


                    return redirect()->route('infosTask', $tache1->slug)->with('success', 'Tâche créer avec success, les personnes assignées seront notifier pour cette tâche');
                }
                
            } elseif ($request->categorie == 'Conditionnelle') {

                $arr = $arr ?? [];

                if ($request->idClient) {

                    $idClient = $request->idClient;
                    $idAffaire = $request->idAffaire;
                } else {

                    $idClient = $request->idClient2;
                    $idAffaire = $request->idAffaire2;
                }

                if ($request->dateDebut) {
                    $dateDebut = $request->dateDebut;
                    $dateFin = $request->dateFin;
                } else {
                    $dateDebut = '';
                    $dateFin = $request->dateFin2;
                }


                // L'instance du model tache'
                $tacheFille = new TacheFilles();
                $TacheParente = DB::select("select idTache,slugFille,slug from taches where slug=?", [$request->slugTache]);
                if (empty($TacheParente)) {

                    $TacheParente = DB::select("select idTacheFille,slug from tache_filles where slug=?", [$request->slugTache]);
                    $idTacheParente =  null;
                } else {
                    $TacheParente = DB::select("select idTache,slugFille,slug from taches where slug=?", [$request->slugTache]);
                    $idTacheParente =  $TacheParente[0]->idTache;
                }

                if (!$request->filled('slugTache')) {
                    return back()->with(['error' => 'Veuillez sélectionner une tâche parente.']);
                }
                
                
                // Creation de la tâche fille
                $tacheFille->idTache = $idTacheParente;
                $tacheFille->titre = $request->titre;
                $tacheFille->point = $request->point;
                $tacheFille->idClient = $idClient;
                $tacheFille->idTypeTache = $request->idTypeTache;
                $tacheFille->idAffaire = $idAffaire;
                $tacheFille->priorite = $request->priorite;
                $tacheFille->dateDebut = $dateDebut;
                $tacheFille->dateFin = $dateFin;
                $tacheFille->description = $request->description;
                $tacheFille->statut = 'En cours';
                $tacheFille->categorie = $request->categorie;
                $tacheFille->slugTache = $TacheParente[0]->slug;
                $tacheFille->slug = $request->_token . '' . rand(1234, 3458);

                // Vérification de la condition
                if ($idClient === 'Cabinet') {
                    // Si c'est "Cabinet", on n'assigne pas idClient ni idAffaire
                    $tacheFille->idClient = null;
                    $tacheFille->idAffaire = null;
                } else {
                    // Sinon on les assigne normalement
                    $tacheFille->idClient = $idClient;
                    $tacheFille->idAffaire = $idAffaire;
                }
                // Enregistrement
                $tacheFille->save();


                // mettre le statut du courrier arrivee en traitement si c'est courier de la tâche
                $courrierTache = $request->courrier;

                if ($courrierTache == 0) {
                } else {
                    DB::update("update courier_arrivers set statut='En Traitement' where idCourierArr=?", [$courrierTache]);
                }

                $idTacheFille = DB::select("select * from tache_filles where slug=?", [$tacheFille->slug]);

                for ($j = 0; $j < count($arrResponsable); $j++) {
                    DB::select(
                        'INSERT INTO tache_personnel_filles(idTacheFille,idPersonnel,fonction,slug) VALUES(?,?,?,?)',
                        [
                            $idTacheFille[0]->idTacheFille,
                            $arrResponsable[$j],
                            'Responsable',
                            $request->_token . "" . rand(1234, 3458)
                        ]
                    );
                }

                $arr = $arr ?? [];
                for ($i = 0; $i < count($arr); $i++) {
                    DB::select(
                        'INSERT INTO tache_personnel_filles(idTacheFille, idPersonnel,fonction, slug) VALUES(?,?,?,?)',
                        [
                            $idTacheFille[0]->idTacheFille,
                            $arr[$i],
                            'Participant',
                            $request->_token . "" . rand(1234, 3458)
                        ]
                    );
                }


                // Creation des fichiers
                // dossiers : affaires,taches,audiences,courier-departs,courier-arrivers
                if ($request->file('fichiers') != null) {

                    $fichiers = request()->file('fichiers');


                    foreach ($fichiers as $fichier) {

                        $tacheFile = new Fichiers();

                        $filename = strtoupper(substr(str_shuffle(md5($request->_token . "" . rand(124, 345))), 0, 4)) . date('YmdHi') . '.' . $fichier->extension();
                        $tacheFile->nomOriginal = $fichier->getClientOriginalName();
                        $tacheFile->filename = $filename;
                        $tacheFile->slugSource = $tacheFille->slug;
                        $tacheFile->slug = $request->_token . "" . rand(1234, 3458);
                        $tacheFile->path = 'assets/upload/fichiers/taches/' . $filename;
                        $fichier->move(public_path('assets/upload/fichiers/taches'), $filename);
                        $tacheFile->save();
                    }
                }

                return redirect()->route('infosTask', $request->slugTache)->with('success', 'Tâche créer avec success, les personnes assignées seront notifier pour cette tâche');

            }
        }

      });
    }



    /**
     * Display the specified resource.
     *
     * @param  string  $slug
     * @return \Illuminate\Http\Response
     */
    public function showFromAud(Request $request, $idSuivit)
    {
        $taches = DB::select('select slug from taches where idSuivit=?',[$idSuivit]);
        return redirect()->route('infosTask', ['slug' => $taches[0]->slug]);

    }

    public function showFromAud2(Request $request, $idSuivit)
    {
        $tachesRequete = DB::select('select slug from taches where idSuivitRequete = ?', [$idSuivit]);
    
        if (!empty($tachesRequete)) {
            return redirect()->route('infosTask', ['slug' => $tachesRequete[0]->slug]);
        } else {
            return back()->with('error', 'Aucune tâche trouvée pour ce suivi.');
        }
    }
    
    

    public function show(Request $request, $slug)
    {
        //personnel connecter
        if (Session::has('idPersonnel')) {
            foreach (Session::get('idPersonnel') as $Personnel) {
                $idPersonConnected = $Personnel->initialPersonnel;
            }
        } else {
            $idPersonConnected = null;
        }

        // Récuperation des informations de la tâche selectionner
        $tache = DB::select('select * from taches,type_taches where taches.idTypeTache=type_taches.idTypeTache and taches.slug=?', [$slug]);
        
        if (empty($tache)) {
            $tache = DB::select('select * from taches,type_taches where taches.idTypeTache=type_taches.idTypeTache and taches.slugFille=?', [$slug]);
        }
        $typeTaches = DB::select("select * from type_taches");

        // Vérification après les deux tentatives
        if (empty($tache)) {
            return redirect()->back()->with('error', "La tâche demandée est introuvable.");
        }

        $idTache = $tache[0]->idTache;
        $slugTache = $tache[0]->slugFille;
        $idCourier = $tache[0]->courrierTache;
        $idAudience = $tache[0]->audTache;
        $idSuivit =  $tache[0]->audTache;
        $idProcedure = $tache[0]->audTache;
        $idClient = $tache[0]->idClient;
        $idAffaire = $tache[0]->idAffaire;


        // Recuperation des fichier lier a la tâche
        $fichiers = DB::select("select * from fichiers where slugSource=? OR slugSource=?", [$tache[0]->slug ,$tache[0]->slugFille] );
        //dd($fichiers);


        if ($idCourier == '') {
            $taskFileCourier = [];
        } else {
            $taskFileCourier = DB::select("select fichiers.slug as fileSlug,idCourierArr,courier_arrivers.slug as courierSlug from fichiers,courier_arrivers where fichiers.slugSource=courier_arrivers.slug and idCourierArr=?", [$idCourier]);
        }

        if ($idAudience == '') {
            $taskFileAud = [];
        } else {
            //$taskFileAud = DB::select("select nomOriginal,fichiers.slug as fileSlug,suivit_audiences.idSuivit,suivit_audiences.slug as suvitSlug, audiences.slug as slugAud,niveauProcedural from fichiers,suivit_audiences,audiences where suivit_audiences.idAudience=audiences.idAudience and fichiers.slugSource=suivit_audiences.slug and suivit_audiences.idSuivit=?", [$idSuivit]);
            $taskFileAud = DB::select("
            SELECT 
                fichiers.nomOriginal,
                fichiers.slug AS fileSlug,
                suivit_audiences.idSuivit,
                suivit_audiences.slug AS suvitSlug,
                audiences.slug AS slugAud,
                audiences.niveauProcedural
            FROM taches
            JOIN suivit_audiences ON taches.idSuivit = suivit_audiences.idSuivit
            JOIN audiences ON suivit_audiences.idAudience = audiences.idAudience
            JOIN fichiers ON fichiers.slugSource = suivit_audiences.slug
            WHERE taches.idTache = ?", 
            [$idTache]); // <-- ID de la tâche 

            //dd($taskFileAud);
        }

        if ($idProcedure == '') {
            $taskFileReq = [];
        } else {
            //$taskFileReq = DB::select("select nomOriginal,fichiers.slug as fileSlugReq,procedure_requetes.idProcedure,suivit_requetes.slug as suvitSlug, procedure_requetes.slug from fichiers,suivit_requetes,procedure_requetes where suivit_requetes.idRequete=procedure_requetes.idProcedure and fichiers.slugSource=suivit_requetes.slug and procedure_requetes.idProcedure=?", [$idProcedure]);
        
            $taskFileReq = DB::select("
                SELECT 
                    fichiers.nomOriginal,
                    fichiers.slug AS fileSlugReq,
                    procedure_requetes.idProcedure,
                    suivit_requetes.slug AS suvitSlug,
                    procedure_requetes.slug AS slugReq
                FROM taches
                JOIN suivit_requetes ON taches.idSuivitRequete = suivit_requetes.idSuivit
                JOIN procedure_requetes ON suivit_requetes.idRequete = procedure_requetes.idProcedure
                JOIN fichiers ON fichiers.slugSource = suivit_requetes.slug
                WHERE taches.idTache = ?", 
            [$idTache]); // <-- ID de la tâche de départ
            //dd($taskFileReq);
        }



        //$tacheAud = DB::select("select audiences.idAudience, audiences.slug as slugAud,niveauProcedural from audiences where  audiences.idAudience=?", [$idAudience]);
        //$tacheAud2 = DB::select("select procedure_requetes.idProcedure, procedure_requetes.slug  from procedure_requetes where  procedure_requetes.idProcedure=?", [$idProcedure]);
       // dd($tacheAud2);

       $tacheAud = [];
       $tacheAud2 = [];
       

        if (!empty($tache)) {
            // On prend la première tâche (car DB::select retourne un tableau)
            $t = $tache[0];
        
            if ($t->idSuivit == 0) {
                // Si idSuivit == 0, on récupère depuis procedure_requetes
                $tacheAud2 = DB::select("select procedure_requetes.idProcedure, procedure_requetes.slug  from procedure_requetes where  procedure_requetes.idProcedure=?", [$idProcedure]);
            } else {
                // Sinon, on récupère depuis audiences
                $tacheAud = DB::select("select audiences.idAudience, audiences.slug as slugAud,niveauProcedural from audiences where  audiences.idAudience=?", [$idAudience]);
            }
        }


        // L'instance du model personnel
        $personnels = DB::select('SELECT * FROM personnels AS P, tache_personnels AS TP WHERE P.idPersonnel = TP.idPersonnel and TP.idTache=? order by TP.fonction desc', [$idTache]);

        $traitements = DB::select("select traitement_taches.idTraitement,timesheet,type,initialPersonnel as initial,traitement_taches.slug, description,traitement_taches.created_at,uniteTime,initialAdmin from personnels,traitement_taches where personnels.idPersonnel = traitement_taches.idPersonnel and traitement_taches.idTache = $idTache
                                    UNION
                                  select traitement_taches.idTraitement,timesheet,type,idPersonnel,slug,description,traitement_taches.created_at,uniteTime,initialAdmin from traitement_taches where traitement_taches.idPersonnel is null and traitement_taches.idTache = $idTache  ORDER BY created_at DESC ");

        //$traitementsadmin = DB::select('select * from traitement_taches where traitement_taches.idTache = ? and traitement_taches.idPersonnel = ? ', [$id, $emailadmin]);
        $initialAdmin = DB::select("select initial from users where role='Administrateur' ");

        $fichiersTraitement = DB::select("select * from fichiers");




        // L'instance du model client
        $clients = DB::select('select * from clients where idClient = ? ', [$idClient]);

        $J = DB::select("select SUM(timesheet) AS timesheet from traitement_taches where  uniteTime='j' and traitement_taches.idTache = $idTache");
        $H = DB::select("select SUM(timesheet) AS timesheet from traitement_taches where  uniteTime='h' and traitement_taches.idTache = $idTache");
        $M = DB::select("select SUM(timesheet) AS timesheet from traitement_taches where  uniteTime='m' and traitement_taches.idTache = $idTache");

        if (is_null($J[0]->timesheet)) {
            $timesheetJ = 0;
        } else {
            $timesheetJ = $J[0]->timesheet;
        }
        if (is_null($H[0]->timesheet)) {
            $timesheetH = 0;
        } else {
            $timesheetH = $H[0]->timesheet;
        }
        if (is_null($M[0]->timesheet)) {
            $timesheetM = 0;
        } else {
            $timesheetM = $M[0]->timesheet;
        }


        // L'instance du model affaires
        $affaires = DB::select('select * from affaires where idAffaire = ? ', [$idAffaire]);

        // Recuperation de tout le personnel du cabinet qui ne sont pas assiginer/ il est possible d'assigner une tache a plusieurs personnes
        $allPersonnels = DB::select('SELECT * FROM personnels AS P WHERE P.idPersonnel NOT IN (SELECT idPersonnel FROM tache_personnels where idTache=?)', [$idTache]);

        //Update de notification
        $email = Auth::user()->email;
        $personnel = DB::select('select * from personnels where email=? ', [$email]);
        if (empty($personnel)) {
            DB::update("update notifications set etat='vue' where idRecepteur='admin' and idAdmin=? and urlParam=?", [Auth::user()->id,$slug]);
        } else {
            $idPersonnel = $personnel[0]->idPersonnel;
            $etat = 'vue';
            $idPerso = strval($idPersonnel);
            DB::select(
                'UPDATE notifications SET etat=? where idRecepteur=? AND urlParam=?',
                [$etat, $idPerso, $slug]
            );
        }

        $tacheFille =  DB::select("select tache_filles.idTacheFille as id,tache_filles.titre as titre,tache_filles.slug as slug from tache_filles where tache_filles.slugTache=?", [$slug]);
        $tacheLiers = DB::select("select tache_filles.titre,tache_filles.slug as slug from taches,tache_filles where taches.slugFille=tache_filles.slugTache and taches.slugFille=? order by tache_filles.idTacheFille desc ",[$slug]);
        if (empty($tacheLiers)) {
            $tacheLiers = DB::select("select tache_filles.titre,tache_filles.slug as slug from taches,tache_filles where taches.slugFille=tache_filles.slugTache and taches.slug=? order by tache_filles.idTacheFille desc ",[$slug]);

        }
       
        
        $tacheCond = DB::select("select * from taches where categorie='Conditionnelle' and idTache=? ", [$idTache]);

        if (empty($tacheFille)) {

            $tacheFille =  DB::select("select * from tache_filles where slugTache=?", [$slugTache]);
        }


        return view('taches.infosTask', compact('fichiersTraitement', 'tache', 'idPersonConnected', 'tacheFille', 'typeTaches', 'fichiers', 'clients', 'personnels', 'affaires', 'traitements', 'allPersonnels', 'taskFileCourier','taskFileAud', 'timesheetJ', 'timesheetH', 'timesheetM', 'tacheCond', 'slug','initialAdmin','tacheAud','tacheAud2','taskFileReq','tacheLiers'));
    }

    public function show2(Request $request, $slug)
    {
        $tache = DB::select('select * from tache_filles,type_taches where tache_filles.idTypeTache=type_taches.idTypeTache and tache_filles.slug=?', [$slug]);
        $typeTaches = DB::select("select * from type_taches");


        $idTacheFille = $tache[0]->idTacheFille;
        $slugTache = $tache[0]->slug;
        $idClient = $tache[0]->idClient;
        $idAffaire = $tache[0]->idAffaire;
        $idParente = $tache[0]->idTache;



        // Recuperation des fichier lier a la tâche
        $fichiers = DB::select("select * from fichiers where slugSource=?", [$slug]);
       // dd($fichiers);

        // L'instance du model personnel
        $personnels = DB::select('SELECT * FROM personnels AS P, tache_personnel_filles AS TP WHERE P.idPersonnel = TP.idPersonnel and TP.idTacheFille=?', [$idTacheFille]);



        // L'instance du model client
        $clients = DB::select('select * from clients where idClient = ? ', [$idClient]);

        // L'instance du model affaires
        $affaires = DB::select('select * from affaires where idAffaire = ? ', [$idAffaire]);

        // Recuperation de tout le personnel du cabinet qui ne sont pas assiginer/ il est possible d'assigner une tache a plusieurs personnes
        $allPersonnels = DB::select('SELECT * FROM personnels AS P WHERE P.idPersonnel NOT IN (SELECT idPersonnel FROM tache_personnel_filles where idTacheFille=?)', [$idTacheFille]);

        //Update de notification
        $email = Auth::user()->email;
        $personnel = DB::select('select * from personnels where email=? ', [$email]);


        // $tache_tmps =  DB::select("select tache_tmps.id as id,tache_tmps.titre as titre,tache_tmps.slug as slug from tache_tmps where idParente=?", [$id]);
        $tacheParente = DB::select("select * from taches where idTache=?", [$idParente]);

        $tacheFille =  DB::select("select tache_filles.idTacheFille as id,tache_filles.titre as titre,tache_filles.slug as slug from tache_filles where tache_filles.slugTache=?", [$slug]);

        return view('taches.infosTask2', compact('tache', 'slug', 'tacheParente', 'fichiers', 'clients', 'personnels', 'affaires', 'allPersonnels', 'tacheFille'));
    }

    public function addTaskTraitement(Request $request)
    {
        return DB::transaction(function () use ($request) {
        //personnel connecter
        if (Session::has('idPersonnel')) {
            foreach (Session::get('idPersonnel') as $Personnel) {
                $idPersonConnected = $Personnel->idPersonnel;
            }
        } else {
            $idPersonConnected = 'admin';
        }


        $timesheet = $request->timesheet;
        $unite = $request->uniteTime;

        // if ($unite == 'm') {
        //     $timesheet = $inputTime * 0.016;
        // } elseif ($unite == 'j') {
        //     $timesheet = $inputTime * 24;
        // } else {
        //     $timesheet = $inputTime;
        // }


        $traitement_taches = new TraitementTaches();
        if ($request) {

            $traitement_taches->idTache =  $request->idTache;
            $traitement_taches->type =  $request->type;
            $traitement_taches->timesheet =  $timesheet;
            $traitement_taches->uniteTime =  $unite;
            if ($idPersonConnected != 'admin') {
                $traitement_taches->idPersonnel =  $idPersonConnected;
            } else {
                $traitement_taches->initialAdmin = Auth::user()->initial;
            }
            $traitement_taches->description =  $request->description;
            $traitement_taches->slug = $request->_token . "" . rand(1234, 3458);
            $traitement_taches->save();

            if ($request->file('fichiers') != null) {

                $fichiers = request()->file('fichiers');


                foreach ($fichiers as $fichier) {

                    $traitementFile = new Fichiers();

                   // $filename = strtoupper(substr(str_shuffle(md5($request->_token . "" . rand(124, 345))), 0, 4)) . date('YmdHi') . '.' . $fichier->extension();
                    if ($fichier && $fichier->isValid()) {
                        // Traitement du fichier
                        $filename = strtoupper(substr(str_shuffle(md5($request->_token . "" . rand(124, 345))), 0, 4)) . date('YmdHi') . '.' . $fichier->extension();
                        // Stockage du fichier dans le dossier approprié
                       // $fichier->move($destinationPath, $filename);
                    } else {
                        // Gérer l'erreur si le fichier n'est pas valide ou n'existe pas
                        return back()->withErrors(['file' => 'Le fichier est invalide ou n\'a pas été téléchargé correctement.']);
                    }
                    $traitementFile->nomOriginal = $fichier->getClientOriginalName();
                    $traitementFile->filename = $filename;
                    $traitementFile->slugSource = $traitement_taches->slug;
                    $traitementFile->slug = $request->_token . "" . rand(1234, 3458);
                    $traitementFile->path = 'assets/upload/fichiers/taches/' . $filename;
                    $fichier->move(public_path('assets/upload/fichiers/taches'), $filename);
                    $traitementFile->save();
                }
            }


            //Mise en place de la notification.
            $id_tache = $request->idTache;
            $personInteresser = DB::select("select * from tache_personnels where idTache=?", [$id_tache]);
            $taskrecent = DB::select("select * from taches where idTache=?", [$id_tache]);
            $slug = $taskrecent[0]->slug;

            foreach ($personInteresser as $p) {

                if ($p->idPersonnel == $idPersonConnected) {
                    # ne pas envoyer a la personne qui ajoute un traitement
                } else {
                    DB::select(
                        'INSERT INTO notifications(categorie, messages, etat, idRecepteur,a_biper,slug,urlName,urlParam) VALUES(?,?,?,?,?,?,?,?)',
                        [
                            'Tâche',
                            'Un collaborateur a ajouté un nouveau traitement.',
                            'masquer',
                            $p->idPersonnel,
                            'non',
                            $request->_token . "" . rand(1234, 3458),
                            "infosTask",
                            $slug
                        ]
                    );
                }
            }
            if ($idPersonConnected == 'admin') {
                # ne pas envoyer a l'admin connecter
            } else {
               $admins = DB::select("select * from users where role='Administrateur'");

                    foreach ($admins as $a) {
                        DB::select(
                            'INSERT INTO notifications(categorie, messages, etat, idRecepteur,slug,a_biper,urlName,urlParam,idAdmin) VALUES(?,?,?,?,?,?,?,?,?)',
                            [
                                'Tâche',
                                'Un collaborateur a ajouté un nouveau traitement.',
                                'masquer',
                                'admin',
                                'non',
                                $request->_token . "" . rand(1234, 3458),
                                "infosTask",
                                $slug,
                                $a->id
                            ]
                        );
                    }
            }

            return back()->with('success', 'Traitement ajouter avec succès');
        }

      });
    }

    public function valideTask(Request $request, $slug,$slugFille)
    {
      return DB::transaction(function () use ($request, $slug,$slugFille) {
        //personnel connecter
        if (Session::has('idPersonnel')) {
            foreach (Session::get('idPersonnel') as $Personnel) {
                $idPersonConnected = $Personnel->idPersonnel;
            }
        } else {
            $idPersonConnected = 'admin';
        }

      

        // L'instance du model tache'
        $tache = new Taches();

        $valide = "validée";

        // Récuperation des informations de la tâche selectionner.
        $Taches = DB::select("select * from taches where slugFille=?", [$slugFille]);

        DB::update("update courier_arrivers set statut='Traité' where idCourierArr=? ",[$Taches[0]->courrierTache]);

        // Recuperation des informations de la tâche fille liee a la tâche.
        $TacheFilles = DB::select("select * from tache_filles where slugTache=?", [$slugFille]);


        // selection des taches filles liées a la tâche principale simple de la table tache
        // $TacheFille = DB::select("select taches.slugTache,tache_filles.idTacheFille,taches.slug,tache_filles.idTache,tache_filles.categorie,tache_filles.description,tache_filles.titre,tache_filles.point,tache_filles.idClient,tache_filles.idAffaire,tache_filles.idTypeTache,tache_filles.dateDebut,tache_filles.dateFin,tache_filles.priorite from tache_filles,taches where taches.slugTache=tache_filles.slugTache and taches.slug=?", [$slug]);

        $idTache =  $Taches[0]->idTache;
        $identitTache =  $Taches[0]->categorie;
        $point =  (int)$Taches[0]->point;
        $todays = date('Y-m-d');


        // Verification de disponibilité de cette tache
        if (sizeof($TacheFilles) > 0) {

            // Mettre le statut de la tâche a 'validee'.
            DB::update("update taches set statut=? where slugFille=?", [$valide, $slugFille]);

            DB::update("update tache_filles set statut=? where slugTache=?", [$valide, $slugFille]);

            // Mise a jour du score.
            $personnels = DB::select('select personnels.idPersonnel,score,tache_personnels.fonction from personnels,tache_personnels where personnels.idPersonnel = tache_personnels.idPersonnel and tache_personnels.idTache=? ', [$idTache]);

            foreach ($personnels as $p) {

                $score = (int)$p->score;
                $id = (int)$p->idPersonnel;

                if ($p->fonction=='Responsable') {
                    $newscore = $score + $point;

                } else {

                    $newscore= $score + intval($point / 2);
                  
                }
                

                $personne = DB::select('select * from personnels where idPersonnel=?', [$id]);

                $personne = DB::update('update personnels set score=? where idPersonnel=?', [$newscore, $id]);
            }

            //Mise en place de la notification.
            $personInteresser = DB::select("select * from tache_personnels where idTache=?", [$idTache]);
            $taskrecent = DB::select("select * from taches where idTache=?", [$idTache]);
            $slugRecent = $taskrecent[0]->slug;

            foreach ($personInteresser as $p) {

                if ($p->idPersonnel == $idPersonConnected) {
                    # ne pas envoyer a la personne qui ajoute un traitement
                } else {
                    DB::select(
                        'INSERT INTO notifications(categorie, messages, etat, idRecepteur,a_biper,slug,urlName,urlParam) VALUES(?,?,?,?,?,?,?,?)',
                        [
                            'Tâche',
                            "Felicitation vous avez une tache validée.",
                            'masquer',
                            $p->idPersonnel,
                            'non',
                            $request->_token . "" . rand(1234, 3458),
                            "infosTask",
                            $slugRecent
                        ]
                    );
                }
            }

            // Création de la nouvelle tache en copiant de la table tache_filles vers taches.
            foreach ($TacheFilles as $i) {

                $dateFin = date('Y-m-d', strtotime($todays . ' + ' . $i->dateFin . ' days'));

                $Tache = new Taches();
                $Tache->titre = $i->titre;
                $Tache->point = $i->point;
                $Tache->idClient = $i->idClient;
                $Tache->idAffaire = $i->idAffaire;
                $Tache->idTypeTache = $i->idTypeTache;
                $Tache->dateDebut = $todays;
                $Tache->dateFin = $dateFin;
                $Tache->priorite = $i->priorite;
                $Tache->description = $i->description;
                $Tache->idTypeTache = $i->idTypeTache;
                $Tache->statut = 'En cours';
                $Tache->created_by = Auth::user()->name;
                $Tache->categorie = $i->categorie;
                $Tache->slugFille = $i->slug;
                $Tache->slug = $request->_token . '' . rand(1234, 3458);
                $Tache->save();

                $lastTache = DB::select("select * from taches order by idTache desc limit 1");
               

                // copie des personnes assigner de la table tache_personnel_filles vers tache_personnels.
                $personne = DB::select('select * from tache_personnel_filles where idTacheFille=?', [$i->idTacheFille]);
              
                foreach ($personne as $j) {
                    DB::select(
                        'INSERT INTO tache_personnels(idTache, idPersonnel,fonction, slug) VALUES(?,?,?,?)',
                        [
                            $lastTache[0]->idTache,
                            $j->idPersonnel,
                            $j->fonction,
                            str_shuffle(sha1('tmp') . '' . rand(1234, 3458))
                        ]
                    );
                    DB::select(
                        'INSERT INTO notifications(categorie, messages, etat, idRecepteur,a_biper,slug,urlName,urlParam) VALUES(?,?,?,?,?,?,?,?)',
                        [
                            'Tâche',
                            'Vous avez une nouvelle tache.',
                            'masquer',
                            $j->idPersonnel,
                            'non',
                            str_shuffle(sha1('tmp') . '' . rand(1234, 3458)),
                            "infosTask",
                            $Tache->slug
                        ]
                    );
                }
               $admins = DB::select("select * from users where role='Administrateur'");

                    foreach ($admins as $a) {
                        DB::select(
                            'INSERT INTO notifications(categorie, messages, etat, idRecepteur,slug,a_biper,urlName,urlParam,idAdmin) VALUES(?,?,?,?,?,?,?,?,?)',
                            [
                                'Tâche',
                                'La tache fille a été lancé automatiquement.',
                                'masquer',
                                'admin',
                                'non',
                                str_shuffle(sha1('tmp') . '' . rand(1234, 3458)),
                                "infosTask",
                                $Tache->slug,
                                $a->id
                            ]
                        );
                    }
            }

            return back()->with('success', 'Taches validée avec succès et une nouvelle a été créer');

        } else {

            DB::update("update taches set statut=? where slugFille=?", [$valide, $slugFille]);

            DB::update("update tache_filles set statut=? where slugTache=?", [$valide, $slugFille]);

            $personnels = DB::select('select personnels.idPersonnel,score from personnels,tache_personnels where personnels.idPersonnel = tache_personnels.idPersonnel and tache_personnels.idTache=? ', [$idTache]);

            foreach ($personnels as $p) {
                $score = (int)$p->score;
                $id = (int)$p->idPersonnel;

                $newscore = $score + $point;
                $personne = DB::select('select * from personnels where idPersonnel=?', [$id]);

                $personne = DB::update('update personnels set score=? where idPersonnel=?', [$newscore, $id]);
            }
            //Mise en place de la notification.

            $personInteresser = DB::select("select * from tache_personnels where idTache=?", [$idTache]);
            $taskrecent = DB::select("select * from taches where idTache=?", [$idTache]);
            $slugRecent = $taskrecent[0]->slug;

            foreach ($personInteresser as $p) {

                if ($p->idPersonnel == $idPersonConnected) {
                    # ne pas envoyer a la personne qui ajoute un traitement
                } else {
                    DB::select(
                        'INSERT INTO notifications(categorie, messages, etat, idRecepteur,a_biper,slug,urlName,urlParam) VALUES(?,?,?,?,?,?,?,?)',
                        [
                            'Tâche',
                            "Felicitation vous avez une tache validée.",
                            'masquer',
                            $p->idPersonnel,
                            'non',
                            $request->_token . "" . rand(1234, 3458),
                            "infosTask",
                            $slugRecent
                        ]
                    );
                }
            }


            return back()->with('success', 'Taches validée avec succès');
        }

      });
    }



    /**
     * Focntion permettant de modifier la tâche selectionner
     *
     * @param  int  $id
     * @param  string  $slug
     * @return \Illuminate\Http\Response
     */
    public function updateTask(Request $request, $slug)
    {
        return DB::transaction(function () use ($request, $slug) {

        //personnel connecter
        if (Session::has('idPersonnel')) {
            foreach (Session::get('idPersonnel') as $Personnel) {
                $idPersonConnected = $Personnel->idPersonnel;
            }
        } else {
            $idPersonConnected = 'admin';
        }

        $taskrecent = DB::select("select * from taches where slug=?", [$slug]);

        $titre = $request->titre;
        $dateDebut = $request->dateDebut;
        $dateFin = $request->dateFin;
        $description = $request->description;
        $point = $request->point;
        $idTypeTache = $request->idTypeTache;
        $statut = 'En cours';

        // Récuperation des informations de la tâche à modifier
        /*  
        if ($taskrecent[0]->dateFin==$request->dateFin) {
            DB::update('update taches set titre=?,dateDebut=?,dateFin=?,description=?,point=?,idTypeTache=? where slug=?', [ $titre, $dateDebut, $dateFin, $description, $point, $idTypeTache, $slug]);

        } else {
            DB::update('update taches set statut=?,titre=?,dateDebut=?,dateFin=?,description=?,point=?,idTypeTache=? where slug=?', [$statut, $titre, $dateDebut, $dateFin, $description, $point, $idTypeTache, $slug]);

        }
        */

        if ($taskrecent[0]->dateFin==$request->dateFin) {   
            DB::update('update taches set titre=?,dateDebut=?,dateFin=?,description=?,point=? where slug=?', [ $titre, $dateDebut, $dateFin, $description, $point,$slug]);

        } else {
            DB::update('update taches set statut=?,titre=?,dateDebut=?,dateFin=?,description=?,point=? where slug=?', [$statut, $titre, $dateDebut, $dateFin, $description, $point,$slug]);

        }
        

        //Mise en place de la notification.
       
        $slug = $taskrecent[0]->slug;
        $id_tache = $taskrecent[0]->idTache;

        $personInteresser = DB::select("select * from tache_personnels where idTache=?", [$id_tache]);

        foreach ($personInteresser as $p) {

            if ($p->idPersonnel == $idPersonConnected) {
                # ne pas envoyer a la personne qui ajoute un traitement
            } else {
                DB::select(
                    'INSERT INTO notifications(categorie, messages, etat, idRecepteur,a_biper,slug,urlName,urlParam) VALUES(?,?,?,?,?,?,?,?)',
                    [
                        'Tâche',
                        "Une modification a été apportée a une tache.",
                        'masquer',
                        $p->idPersonnel,
                        'non',
                        $request->_token . "" . rand(1234, 3458),
                        "infosTask",
                        $slug
                    ]
                );
            }
        }
        return back()->with('success', 'Modification de la tâche effectué avec succès');

      });
    }


    public function updateTask2(Request $request, $slug)
    {
        return DB::transaction(function () use ($request, $slug) {
        //personnel connecter
        if (Session::has('idPersonnel')) {
            foreach (Session::get('idPersonnel') as $Personnel) {
                $idPersonConnected = $Personnel->idPersonnel;
            }
        } else {
            $idPersonConnected = 'admin';
        }

        $titre = $request->titre;
        $dateDebut = $request->dateDebut;
        $dateFin = $request->dateFin;
        $description = $request->description;
        $point = $request->point;
        $idTypeTache = $request->idTypeTache;
        $statut = 'En cours';

        // Modification de la tâche fille

       // DB::update('update tache_filles set statut=?,titre=?,dateDebut=?,dateFin=?,description=?,point=?,idTypeTache=? where slug=?', [$statut, $titre, $dateDebut, $dateFin, $description, $point, $idTypeTache, $slug]);

        DB::update('update tache_filles set statut=?,titre=?,dateDebut=?,dateFin=?,description=?,point=? where slug=?', [$statut, $titre, $dateDebut, $dateFin, $description, $point, $slug]);

        return back()->with('success', 'Modification de la tâche effectué avec succès');
        
        });
    }


    /**
     * Focntion permettant de modifier la tâche selectionner
     *
     * @param  int  $id
     * @param  string  $slug
     * @return \Illuminate\Http\Response
     */
    public function updateAssignation(Request $request, $id, $slug)
    {

        $taskrecent = DB::select("select * from taches where idTache=?", [$id]);
        $slugTache = $taskrecent[0]->slug;


        // Liaison de la tâche avec la personne ou les personnes assignées
        $data = $request->idPersonnel;

        for ($i = 0; $i < count($data); $i++) {
            DB::select(
                'INSERT INTO tache_personnels(idTache, idPersonnel,fonction, slug) VALUES(?,?,?,?)',
                [
                    $id,
                    $data[$i],
                    'Participant',
                    $request->_token . "" . rand(12349, 34589)
                ]
            );

            DB::select(
                'INSERT INTO notifications(categorie, messages, etat, idRecepteur,a_biper,slug,urlName,urlParam) VALUES(?,?,?,?,?,?,?,?)',
                [
                    'Tâche',
                    "Vous avez été assigner a une tache.",
                    'masquer',
                    $data[$i],
                    'non',
                    $request->_token . "" . rand(1234, 3458),
                    "infosTask",
                    $slugTache
                ]
            );
        }


        return back()->with('success', 'Les personnes selectionner ont été assigner a la tâche effectué avec succès');
    }

    public function updateAssignation2(Request $request, $id, $slug)
    {

        $taskrecent = DB::select("select * from tache_filles where idTacheFille=?", [$id]);
        $slugTache = $taskrecent[0]->slug;


        // Liaison de la tâche avec la personne ou les personnes assignées
        $data = $request->idPersonnel;

        for ($i = 0; $i < count($data); $i++) {
            DB::select(
                'INSERT INTO tache_personnel_filles(idTacheFille, idPersonnel,fonction, slug) VALUES(?,?,?,?)',
                [
                    $id,
                    $data[$i],
                     'Participant',
                    $request->_token . "" . rand(12349, 34589)
                ]
            );
        }


        return back()->with('success', 'Les personnes selectionner ont été assigner a la tâche');
    }
    /**
     * Afficher the form for editing the specified resource.
     *
     * @param  string  $slug
     * @return \Illuminate\Http\Response
     */
    public function suspendreTache(Request $request, $slug)
    {
        //personnel connecter
        if (Session::has('idPersonnel')) {
            foreach (Session::get('idPersonnel') as $Personnel) {
                $idPersonConnected = $Personnel->idPersonnel;
            }
        } else {
            $idPersonConnected = '';
        }
        // Récuperation des informations de la tâche selectionner pour la suspenssion
        $tache = Taches::where('slug', $slug);
        $tache->update(
            [
                'statut' => 'suspendu'
            ]
        );

        //Mise en place de la notification.
        $taskrecent = DB::select("select * from taches where slug=?", [$slug]);
        $slug = $taskrecent[0]->slug;
        $id_tache = $taskrecent[0]->idTache;

        $personInteresser = DB::select("select * from tache_personnels where idTache=?", [$id_tache]);

        foreach ($personInteresser as $p) {

            if ($p->idPersonnel == $idPersonConnected) {
                # ne pas envoyer a la personne qui ajoute un traitement
            } else {
                DB::select(
                    'INSERT INTO notifications(categorie, messages, etat, idRecepteur,a_biper,slug,urlName,urlParam) VALUES(?,?,?,?,?,?,?,?)',
                    [
                        'Tâche',
                        "Une tache a ete suspendu.",
                        'masquer',
                        $p->idPersonnel,
                        'non',
                        $request->_token . "" . rand(1234, 3458),
                        "infosTask",
                        $slug
                    ]
                );
            }
        }

        return back()->with('success', 'Cette tâche a été suspendu ');
    }


    /**
     * Afficher the form for editing the specified resource.
     *
     * @param  string  $slug
     * @return \Illuminate\Http\Response
     */
    public function startingTache(Request $request, $slug)
    {
        //personnel connecter
        if (Session::has('idPersonnel')) {
            foreach (Session::get('idPersonnel') as $Personnel) {
                $idPersonConnected = $Personnel->idPersonnel;
            }
        } else {
            $idPersonConnected = '';
        }
        // Récuperation des informations de la tâche selectionner pour la suspenssion

        $tache = Taches::where('slug', $slug);
        $tache->update(
            [
                'statut' => 'En cours'
            ]
        );

        //Mise en place de la notification.
        $taskrecent = DB::select("select * from taches where slug=?", [$slug]);
        $slug = $taskrecent[0]->slug;
        $id_tache = $taskrecent[0]->idTache;

        $personInteresser = DB::select("select * from tache_personnels where idTache=?", [$id_tache]);

        foreach ($personInteresser as $p) {

            if ($p->idPersonnel == $idPersonConnected) {
                # ne pas envoyer a la personne qui ajoute un traitement
            } else {
                DB::select(
                    'INSERT INTO notifications(categorie, messages, etat, idRecepteur,a_biper,slug,urlName,urlParam) VALUES(?,?,?,?,?,?,?,?)',
                    [
                        'Tâche',
                        "une tache a ete retirer de la suspension.",
                        'masquer',
                        $p->idPersonnel,
                        'non',
                        $request->_token . "" . rand(1234, 3458),
                        "infosTask",
                        $slug
                    ]
                );
            }
        }
        return back()->with('success', 'Cette tâche a été rédemarrer, elle est maintenant ouverte a toutes suggestion ');
    }

    //
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function deleteTask($slug)
    {
        $tache = DB::select("select * from taches where slug=?", [$slug]);
        $idTache = $tache[0]->idTache;


        $fichier = DB::select("select * from fichiers where slugSource=?", [$slug]);
        // Suppression des fichiers lié à la tâche principale
        if (!empty($fichier)) {
            foreach ($fichier as $key => $value) {

                if (file_exists($value->path)) {
                    unlink(public_path($value->path));
                } else {
                   
                }
            }
            DB::delete("delete from fichiers where slugSource=? ", [$slug]);
        } else {
        }

        // Selection et suppression des traitement et fichiers.
        $traitement = DB::select("select * from traitement_taches where idTache=?", [$tache[0]->idTache]);
        if (!empty($traitement)) {
            foreach ($traitement as $key => $t) {
                $fichier = DB::select("select * from fichiers where slugSource=?", [$t->slug]);
                if (!empty($fichier)) {
                    foreach ($fichier as $key => $value) {
                        if (file_exists($value->path)) {
                            unlink(public_path($value->path));
                        } else {
                           
                        }
                    }
                    DB::delete("delete from fichiers where slugSource=? ", [$t->slug]);
                } else {
                    # code...
                }
                DB::delete("delete from traitement_taches where idTache=?", [$t->idTache]);
            }
        }

        // Selection , suppression des taches filles et leurs fichiers
        $tacheFille = DB::select("select * from tache_filles where idTache=?", [$idTache]);
        if (!empty($tacheFille)) {

            // selection et suppression des tache filles et leurs fichiers dans la meme table .
            foreach ($tacheFille as $key => $t) {

                DB::delete("delete from tache_personnel_filles where idTacheFille=?", [$t->idTacheFille]);

                $fichier = DB::select("select * from fichiers where slugSource=?", [$t->slug]);
                if (!empty($fichier)) {
                    foreach ($fichier as $key => $value) {
                        if (file_exists($value->path)) {
                            unlink(public_path($value->path));
                        } else {
                           
                        }
                    }
                    DB::delete("delete from fichiers where slugSource=? ", [$t->slug]);
                } else {
                }
                DB::delete("delete from tache_filles where idTacheFille=?", [$t->idTacheFille]);
            }
        }

        DB::delete("delete from tache_personnels where idTache=?", [$idTache]);
        DB::delete("delete from taches where idTache=?", [$idTache]);
        DB::delete("delete from notifications where urlParam=?", [$slug]);

        return redirect()->route('allTasks')->with('success', 'La tâche a été supprimer avec succes !');
    }

    public function deleteTask2($slug)
    {
        $tache = DB::select("select * from tache_filles where slug=?", [$slug]);
        $idTache = $tache[0]->idTacheFille;
        $fichier = DB::select("select * from fichiers where slugSource=?", [$slug]);

        // selection et suppression des tache filles et leurs fichiers dans la meme table .
        foreach ($tache as $key => $t) {

            $fichier = DB::select("select * from fichiers where slugSource=?", [$t->slug]);
            if (!empty($fichier)) {

                foreach ($fichier as $key => $value) {
                    if (file_exists($value->path)) {
                        unlink(public_path($value->path));
                    } else {
                       
                    }
                }
            } else {
                # code...
            }

            DB::delete("delete from fichiers where slugSource=? ", [$t->slug]);
            $tacheFille = DB::select("select * from tache_filles where slugTache=?", [$t->slug]);

            if (!empty($tacheFille)) {

                foreach ($tacheFille as $key => $value) {
                    DB::delete("delete from tache_personnel_filles where idTacheFille=?", [$value->idTacheFille]);
                    DB::select("delete from tache_filles where slugTache=?", [$value->slug]);
                }
            }
            DB::delete("delete from tache_personnel_filles where idTacheFille=?", [$t->idTacheFille]);
            DB::select("delete from tache_filles where slugTache=?", [$t->slug]);
        }


        return redirect()->route('allTasks')->with('success', 'La tâche en attente a été supprimer avec succes !');
    }

    public function deleteTraitement($idTraitement)
    {
        $traitement = DB::select("select * from traitement_taches where idTraitement=?", [$idTraitement]);
        $fichier = DB::select("select * from fichiers where slug=?", [$traitement[0]->slug]);
        if (!empty($fichier)) {
            foreach ($fichier as $key => $value) {
                if (file_exists($value->path)) {
                    unlink(public_path($value->path));
                } else {
                   
                }
            }
        } else {
            # code...
        }


        DB::delete("delete from fichiers where slugSource=? ", [$traitement[0]->slug]);

        DB::delete("delete from traitement_taches where idTraitement=?", [$idTraitement]);

        return back()->with('success', 'Le traitement a été retirer avec succès !');
    }

    public function deletePersonnelTask($idTache, $idPersonnel)
    {
        DB::delete("delete from tache_personnels where idPersonnel=? and idTache=?",[$idPersonnel,$idTache]);

        return back()->with('success', 'Le personnel a été retirer avec succès !');
    }

    public function responsablePersonnelTask($idTache, $idPersonnel)
    {
        DB::update("update tache_personnels set fonction='Responsable' where idPersonnel=? and idTache=?",[$idPersonnel,$idTache]);

        return back()->with('success', 'Fonction modifiée avec succès !');
    }

    public function participantPersonnelTask($idTache, $idPersonnel)
    {
        DB::update("update tache_personnels set fonction='Participant' where idPersonnel=? and idTache=?",[$idPersonnel,$idTache]);

        return back()->with('success', 'Fonction modifiée avec succès !');
    }


}
