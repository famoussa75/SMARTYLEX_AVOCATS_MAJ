<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Session;

/** require_once 'C:\xampp\htdocs\ask-office\vendor\autoload.php'; */

use App\Models\Affaires;
use App\Models\Audiences;
use Illuminate\Http\Request;
use App\Models\clients;
use App\Models\CourierArriver;
use App\Models\CourierDepart;
use App\Models\Personnels;
use App\Models\Representants;
use App\Models\AffectationPersonnels;
use App\Models\ClientMorales;
use App\Models\ClientPhysiques;
use App\Models\Taches;
use App\Models\SuivitAudience;
use App\Models\SuivitAudienceAppel;
use App\Models\contratSigners;
use App\Models\avenantContrat;
use App\Models\contratTerminer;
use App\Models\Annuaires;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Twilio\Rest\Client;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Validator;
use  Illuminate\Support\Str;

use App\Imports\ExcelImportEmployee;
use App\Models\Fichiers;

class ClientController extends Controller
{

    public function getAllClientForSearch($search)
    {
        if (Auth::user()->role == 'Administrateur' || Auth::user()->role == 'Assistant') {
            // récuperation des tâches dans la base de donnees
            $clients = DB::select("select idClient,slug,LOWER(prenom) as prenom,LOWER(nom) as nom,LOWER(denomination) as denomination from clients where LOWER(prenom) like '%$search%' OR LOWER(nom) like '%$search%' OR LOWER(denomination) like '%$search%'");
        } else {
            $email = Auth::user()->email;
            $personnel = DB::select('select * from personnels where email=? ', [$email]);
            $idPersonnel = $personnel[0]->idPersonnel;

            $clients = DB::select("select idClient,slug,LOWER(prenom) as prenom,LOWER(nom) as nom,LOWER(denomination) as denomination from clients,affectation_personnels where clients.idClient=affectation_personnels.idClient and affectation_personnels.idPersonnel= $idPersonnel and LOWER(prenom) like '%$search%' OR LOWER(nom) like '%$search%' OR LOWER(denomination) like '%$search%'");

        }

        return response()->json([
            'clients' => $clients,
        ]);


        //return view('taches.showTask', compact('taches'));
    }


    public function fetchSuivit($id)
    {

        // Verication du typeContent pour retourner une bonne reponse
        $suivitAud = SuivitAudience::all()->where('idSuivit', $id);
      
        return response()->json([
            'suivitAud' => $suivitAud,
        ]);
    }

    public function fetchClientName($denomination)
    {

        // Verication du typeContent pour retourner une bonne reponse
        $client = DB::select("SELECT * FROM clients WHERE denomination LIKE ?", ["%$denomination%"]);
      
        return response()->json([
            'client' => $client,
        ]);
    }

    public function fetchClientName2($prenom,$nom)
    {

        // Verication du typeContent pour retourner une bonne reponse
        $client = DB::select("SELECT * FROM clients WHERE prenom LIKE ? AND nom LIKE ?", ["%$prenom%","%$nom%"]);
      
        return response()->json([
            'client' => $client,
        ]);
    }

    public function fetchSuivitAppel($id)
    {

        // Verication du typeContent pour retourner une bonne reponse
        $suivitAudAppel = SuivitAudienceAppel::all()->where('idSuivitAppel', $id);
      
        return response()->json([
            'suivitAudAppel' => $suivitAudAppel,
        ]);
    }


    public function fetchClient($id)
    {
  
        $client = DB::select("select * from clients where idClient=?",[$id]);
        return response()->json([
            'client' => $client,
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $client = DB::table('clients')->get();
        return view('clients.allClient', compact('client'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function collabList()
    {
        if (Session::has('idPersonnel')) {
            foreach (Session::get('idPersonnel') as $Personnel) {
                $id = $Personnel->idPersonnel;
            }
        }



        $client = DB::select('select clients.idClient , clients.slug, prenom,adresse,adresseEntreprise,typeClient,email,emailEntreprise, nom,denomination,telephone,telephoneEntreprise from clients,affectation_personnels where affectation_personnels.idClient = clients.idClient and affectation_personnels.idPersonnel =?', [$id]);

        return view('clients.cardClient', compact('client'));
    }

    public function card()
    {
        $client = DB::table('clients')->get();
        return view('clients.cardClient', compact('client'));
    }

    /**
     * Afficher the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('clients.index');
    }


    /**
     * Fonction permettant d'envoyer un message (SMS) a un client
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function sentSMS(Request  $request)
    {


    }


    /**
     * Fonction permettant d'enregister un client sur le formulaire
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        // Tableau des types de client disponible
        $CLIENTS = ["Client Moral", "Client Physique"];

        // instance du model client
        $client = new clients();

        // instance du model representant
        $representant = new Representants();

        if ($request->typeClient == $CLIENTS[0]) {


            try {
                DB::beginTransaction(); // Début de la transaction
                // enregistrement du réprensentant
                $representant->nom = $request->nomRepresentant;
                $representant->prenom = $request->prenomRepresentant;
                $representant->email = $request->emailRepresentant;
                $representant->telephone = $request->telephoneRepresentant;
                $representant->slug = $request->_token;
                $representant->save();

                // Enregistrement du client morale
                $completeSlug = substr(str_shuffle(md5($request->email)), 0, 4);
                $client->denomination = $request->denomination;
                $client->capitalSocial = $request->capitalSocial;
                $client->idRepresentant = $representant->idRepresentant;
                $client->emailEntreprise = $request->emailEntreprise;
                $client->emailFacture = $request->emailFacture;
                $client->telephoneEntreprise = $request->telephoneEntreprise;
                $client->adresseEntreprise = $request->adresseEntreprise;
                $client->typeClient = $request->typeClient;
                $client->rccm = $request->rccm;
                $client->nif = $request->nif;
                $client->cnss = $request->cnss;
                $client->slug = Str::uuid();
                if ($request->file('logo') != null) {

                        $fichier = request()->file('logo');
                        $filename = strtoupper(substr(str_shuffle(md5($request->_token . "" . rand(124, 345))), 0, 4)) . date('YmdHi') . '.' . $fichier->extension();
                        $path = 'assets/upload/photos/'.$filename;
                        $fichier->move(public_path('assets/upload/photos'), $filename);
                        $client->logo =  $path;
                }
                $client->save();


                $dernierClient = DB::select("select idClient from clients order by idClient desc limit 1");
                $idClient = $dernierClient[0]->idClient;

                $personnelAffec = new AffectationPersonnels();

                if (Auth::user()->role == 'Collaborateur') {

                    $email = Auth::user()->email;
                    $personnel = DB::select('select * from personnels where email=? ', [$email]);
                    $idPersonnel = $personnel[0]->idPersonnel;

                    $personnelAffec->idClient = $idClient;
                    $personnelAffec->idPersonnel = $idPersonnel;
                    $personnelAffec->slug = rand(4827, 9432) . $request->_token . rand(34827, 98432);
                    $personnelAffec->save();
                }
             

                $contact = new Annuaires();    
    
                $contact->societe = $request->denomination;
                $contact->prenom_et_nom = ''.$request->prenomRepresentant.' '.$request->nomRepresentant;
                $contact->poste_de_responsabilite = 'Représentant';
                $contact->telephone = $request->telephoneRepresentant;
                $contact->email = $request->emailRepresentant;
                $contact->idClient = $client->idClient;
    
                $contact->save();

                foreach ($request->formset as $key => $value) {
    
                    Annuaires::create([
                        'societe' => $request->denomination,
                        'prenom_et_nom' => ''.$value['prenom'].' '.$value['nom'],
                        'poste_de_responsabilite' =>  $value['poste'],
                        'telephone' => $value['telephone'],
                        'email' =>  $value['email'],
                        'idClient' => $client->idClient,
                    ]);
                } 
     
                DB::commit(); // Commit de la transaction
                return back()->with('success', 'Client enregistré avec succès');
            } catch (\Exception $e) {
                DB::rollBack(); // Rollback de la transaction en cas d'erreur
                return back()->with('error', 'Erreur d\'enregistrement du client: ' . $e->getMessage());
            }
           
        } elseif ($request->typeClient == $CLIENTS[1]) {

            try {

                // Enregistrement du client Physique
                $client->typeClient = $request->typeClient;
                $client->nom = $request->nom;
                $client->prenom = $request->prenom;
                $client->email = $request->email;
                $client->emailFacture = $request->emailFacture;
                $client->telephone = $request->telephone;
                $client->adresse = $request->adresse;
                $client->slug = Str::uuid();
                $client->save();

                $dernierClient = DB::select("select idClient from clients order by idClient desc limit 1");
                $idClient = $dernierClient[0]->idClient;

                $personnelAffec = new AffectationPersonnels();

                if (Auth::user()->role == 'Collaborateur') {

                    $email = Auth::user()->email;
                    $personnel = DB::select('select * from personnels where email=? ', [$email]);
                    $idPersonnel = $personnel[0]->idPersonnel;

                    $personnelAffec->idClient = $idClient;
                    $personnelAffec->idPersonnel = $idPersonnel;
                    $personnelAffec->slug = rand(4827, 9432) . $request->_token . rand(34827, 98432);
                    $personnelAffec->save();
                }

                $contact = new Annuaires();    
    
                $contact->societe = '';
                $contact->prenom_et_nom = ''.$request->prenom.' '.$request->nom;
                $contact->poste_de_responsabilite = '';
                $contact->telephone = $request->telephone;
                $contact->email = $request->email;
                $contact->idClient = $client->idClient;
    
                $contact->save();

                foreach ($request->formset as $key => $value) {
    
                    Annuaires::create([
                        'societe' => ''.$request->prenom.' '.$request->nom,
                        'prenom_et_nom' => ''.$value['prenom'].' '.$value['nom'],
                        'poste_de_responsabilite' =>  $value['poste'],
                        'telephone' => $value['telephone'],
                        'email' =>  $value['email'],
                        'idClient' => $client->idClient,
                    ]);
                }

                DB::commit(); // Commit de la transaction
                return back()->with('success', 'Client enregistré avec succès');

            } catch (\Exception $e) {
                DB::rollBack();
                return back()->with('error', 'Erreur d\'enregistrement du client: ' . $e->getMessage());
            }
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
                'prochaineAudience' => $row->prochaineAudience,
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
    public function clientInfo($id, $slug)
    {
        // Recuperation des informations du clients
        $infoClient = DB::select("select * from clients where idClient=?", [$id]);
        

        $idEntreprise = '';

        foreach ($infoClient as $client) {
            if ($client->typeClient == "Client Moral") {
                $idEntreprise = $client->idRepresentant;

            } else {
                $idEntreprise = '';
            }
        }

        //recuperation du nombre de courier arriver

        $verif = DB::select('select * from courier_arrivers order by numero Desc limit 1 ');
        if (empty($verif)) {
            $numero = 1;
        } else {
            $numero =  $verif[0]->numero + 1;
        }

        // Comptage des nombres de courier depart
        $idCourier = CourierDepart::all()->count() == 0 ? 1 : CourierDepart::all()->count() + 1;

        // recuperation des informations de la tâhe du client
        $tacheClient = Taches::all()->where('idClient', $id);

        // recuperation des informations des affaires du Client
        $affaireClient = DB::select("select * from affaires where idClient=?",[$id]);


        // recuperation des informations audiences du clients

        $audienceClient = DB::select("SELECT idAudience,subquery.numRg, subquery.objet, subquery.niveauProcedural, subquery.slugAud, subquery.statutAud, isChild, prochaineAudience 
        FROM (
            SELECT MAX(idAudience) as idAudience, MAX(numRg) as numRg, MAX(objet) as objet, MAX(niveauProcedural) as niveauProcedural, slugAud, statutAud, MAX(isChild) as isChild, MAX(prochaineAudience) as prochaineAudience
            FROM (
                SELECT  parties.idClient,audiences.idAudience, audiences.slug as slugAud, numRg, objet, niveauProcedural, prenom, nom, denomination, NULL as numRccm, NULL as formeLegal, audiences.statut as statutAud, audiences.isChild, audiences.prochaineAudience
                FROM audiences
                JOIN parties ON audiences.idAudience = parties.idAudience
                LEFT JOIN clients ON parties.idClient = clients.idClient

                UNION

                SELECT parties.idClient,audiences.idAudience, audiences.slug as slugAud, numRg, objet, niveauProcedural, prenom, nom, NULL as denomination, NULL as numRccm, NULL as formeLegal, audiences.statut as statutAud, audiences.isChild, audiences.prochaineAudience
                FROM audiences
                JOIN parties ON audiences.idAudience = parties.idAudience
                JOIN personne_adverses ON parties.idPartie = personne_adverses.idPartie

                UNION

                SELECT parties.idClient,audiences.idAudience, audiences.slug as slugAud, numRg, objet, niveauProcedural, NULL as prenom, NULL as nom, denomination, numRccm, formeLegal, audiences.statut as statutAud, audiences.isChild, audiences.prochaineAudience
                FROM audiences
                JOIN parties ON audiences.idAudience = parties.idAudience
                JOIN entreprise_adverses ON parties.idPartie = entreprise_adverses.idPartie
            ) AS subquery_internal WHERE subquery_internal.idClient = $id
            GROUP BY subquery_internal.slugAud,subquery_internal.statutAud
        ) AS subquery
        WHERE isChild is null or isChild!='oui'
        ORDER BY idAudience ASC");



        // recuperation des informations du courrier depart du client
        $courierDepartClient = CourierDepart::all()->where('idClient', $id);

        // Recuperation des informations du Courriers - Arrivée du client
        $courierArriverClient = CourierArriver::all()->where('idClient', $id);

        // Recuperation des informations du representant d'un client entreprise
        $representant = Representants::all()->where('idRepresentant', $idEntreprise);


        // Recuperation des informations des personnels
        $personnels = Personnels::all();

        if (empty($audienceClient)) {
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
       


        // Personnels du client
        $personnelClient = DB::select("select * from personnel_clients where idClient=?",[$id]);

        $factures = DB::select("select * from factures where idClient=?",[$id]);

        $annuaires = DB::select("select * from annuaires where idClient=? order by id asc",[$id]);

        $formattedAudiences = $this->getAudienceData($audienceClient, $cabinet, $personne_adverses, $entreprise_adverses, $autreRoles);


        // procedure requete

        $requetes1 = DB::select("SELECT procedure_requetes.slug, procedure_requetes.* FROM procedure_requetes JOIN parties_requetes ON procedure_requetes.idProcedure = parties_requetes.idRequete
         JOIN clients ON parties_requetes.idClient = clients.idClient
         WHERE clients.idClient = ?
        ", [$id]);

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
       

        return view('clients.infoClient', compact(
            'cabinet',
            'personne_adverses',
            'entreprise_adverses',
            'autreRoles',
            'infoClient',
            'tacheClient',
            'affaireClient',
            'formattedAudiences',
            'courierDepartClient',
            'courierArriverClient',
            'representant',
            'personnels',
            'idCourier',
            'numero',
            'personnelClient',
            'factures',
            'annuaires',

            'requetes1',
            'personne_adverses1',
            'entreprise_adverses1',
            'autreRoles1',
            'cabinet1'

        ));
    }

    /**
     * Afficher the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function importEmployeeData(Request $request)
    {
        $file = $request->file('fichiers');
        $idClient = $request->idClient;

        if ($file) {
            DB::delete("delete from personnel_clients where idClient=?",[$idClient]);
            Excel::import(new ExcelImportEmployee, $file);
            DB::delete("delete from personnel_clients where idClient=? AND prenomEtNom is NULL",[$idClient]);            

            return redirect()->back()->with('success', 'Import effectué avec succès.');
        }

        return redirect()->back()->with('error', 'Erreur d\import veuillez respecter le format.');
        
    }

    public function contratEmployee($slug)
    {
       
       $contrat = DB::select("select * from personnel_clients,clients where personnel_clients.idClient=clients.idClient and personnel_clients.slug=?",[$slug]);

       return view('clients.contrat',compact('contrat'));
        
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
        // Recuperation et mise a jour du client selectionner
        $client = clients::where('slug', $slug)->get();

        if ($client[0]->typeClient == "Client Moral") {

            // mise a jours du réprensentant
            DB::select('update representants set
                nom = ?,
                prenom = ?,
                email = ?,
                telephone = ?,
                slug = ? where idRepresentant = ? ', [
                $request->nom,
                $request->prenom,
                $request->email,
                $request->telephone,
                $request->_token,
                $client[0]->idRepresentant,
            ]);

            
            if ($request->file('logo') != null) {

                $fichier = request()->file('logo');
                $filename = strtoupper(substr(str_shuffle(md5($request->_token . "" . rand(124, 345))), 0, 4)) . date('YmdHi') . '.' . $fichier->extension();
                $path = 'assets/upload/photos/'.$filename;
                $fichier->move(public_path('assets/upload/photos'), $filename);
            }else {
                $path =$client[0]->logo;
            }
            // Mise a jours du client
            DB::select('update clients set
                denomination = ?,
                capitalSocial = ?,
                emailEntreprise = ?,
                emailFacture = ?,
                telephoneEntreprise = ?,
                adresseEntreprise = ?,
                typeClient = ?,
                rccm = ?,
                nif = ?,
                cnss = ?,
                idRepresentant = ?,
                logo = ?
                 where
                slug = ?
            ', [
                $request->denomination,
                $request->capitalSocial,
                $request->emailEntreprise,
                $request->emailFacture,
                $request->telephoneEntreprise,
                $request->adresseEntreprise,
                $request->typeClient,
                $request->rccm,
                $request->nif,
                $request->cnss,
                $client[0]->idRepresentant,
                $path,
                $slug,
            ]);
            return back()->with('success', 'Modification effectuée avec succès');
        } elseif ($client[0]->typeClient == "Client Physique") {

            // Mise a jours du client
            DB::select('update clients set
                nom = ?,
                prenom = ?,
                email = ?,
                emailFacture = ?,
                telephone = ?,
                adresse = ?,
                typeClient = ?
                where
                slug = ?
            ', [
                $request->nom,
                $request->prenom,
                $request->email,
                $request->emailFacture,
                $request->telephone,
                $request->adresse,
                $request->typeClient,
                $slug
            ]);
            return back()->with('success', 'Modification effectuée avec succès');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function deleteClient($slug)
    {
       

        $client =  DB::select("select * from clients where slug=?", [$slug]);
        $idClient = $client[0]->idClient;

        $idClientString = trim($client[0]->idClient);

        DB::delete('delete from affectation_personnels where idClient=?', [$idClient]);
        $affaire =  DB::select("select * from affaires where idClient=?", [$idClient]);

        if (empty($affaire)) {
            # code...
        } else {
            DB::delete('delete from affaires where idClient=?', [$idClient]);
        }

        $audience =  DB::select("select * from audiences where idClient=?", [$idClient]);
        if (empty($audience)) {
            # code...
        } else {
            DB::delete('delete from assignation_audiences where idAudience=?', [$audience[0]->idAudience]);
            DB::delete('delete from suivit_audiences  where idAudience=?', [$audience[0]->idAudience]);
            DB::delete('delete from audiences where idClient=?', [$idClient]);
        }


        $idCourierD =  DB::select("select * from courier_departs where idClient=?", [$idClient]);
        $idCourierA =  DB::select("select * from courier_arrivers where idClient=?", [$idClient]);

        if (empty($idCourierD)) {
            # code...
        } else {
            DB::delete('delete from courier_departs where idClient=?', [$idClient]);
        }
        if (empty($idCourierA)) {
            # code...
        } else {
            DB::delete('delete from courier_arrivers where idClient=?', [$idClient]);
        }



        $tache =  DB::select("select * from taches where idClient=?", [$idClient]);
        if (empty($tache)) {
            # code...
        } else {

            DB::delete("delete from tache_files where idTache=?", [$tache[0]->id]);
            DB::delete("delete from traitement_taches where idTache=?", [$tache[0]->id]);
            DB::delete("delete from tache_personnels where idTache=?", [$tache[0]->id]);
            DB::delete('delete from taches where idClient=?', [$idClient]);
        }

        DB::delete('delete from clients where idClient=?', [$idClient]);

        return redirect()->route('allClient')->with('success', 'Client supprimé avec succes !');
    }

    public function infoPersonnel($slug){

        $personnel = DB::select('select * from personnel_clients where slug=? ', [$slug]);
        $contrat = DB::select("select * from personnel_clients,clients where personnel_clients.idClient=clients.idClient and personnel_clients.slug=?",[$slug]);

        $contratSigner = DB::select("select contrat_signers.slug,dateSignature,accordConf,dateAccord from personnel_clients,clients,contrat_signers where personnel_clients.idPersonnelClient=contrat_signers.idPersonnelClient and personnel_clients.idClient=clients.idClient and personnel_clients.slug=? order by idContratSigner desc",[$slug]);
        if (!empty($contratSigner)) {
            $fichierContratSigner = DB::select("select * from fichiers where slugSource=?",[ $contratSigner[0]->slug]);
        } else {
            $fichierContratSigner ='';
        }

        $avenantSigner = DB::select("select avenant_contrats.slug,nature,dateAvenant from personnel_clients,clients,avenant_contrats where personnel_clients.idPersonnelClient=avenant_contrats.idPersonnelClient and personnel_clients.idClient=clients.idClient and personnel_clients.slug=? order by idAvenant desc",[$slug]);
        if (!empty($avenantSigner)) {
            $fichierAvenant = DB::select("select * from fichiers where slugSource=?",[ $avenantSigner[0]->slug]);
        } else {
            $fichierAvenant ='';
        }

        $finContrat = DB::select("select contrat_terminers.slug,dateTerminer,motif from personnel_clients,clients,contrat_terminers where personnel_clients.idPersonnelClient=contrat_terminers.idPersonnelClient and personnel_clients.idClient=clients.idClient and personnel_clients.slug=? order by idContratTerminer desc",[$slug]);
        if (!empty($finContrat)) {
            $fichierFinContrat = DB::select("select * from fichiers where slugSource=?",[ $finContrat[0]->slug]);
        } else {
            $fichierFinContrat ='';
        }

        return view('clients.infoPersonnelClient', compact('personnel','contrat','contratSigner','fichierContratSigner','avenantSigner','fichierAvenant','finContrat','fichierFinContrat'));
    }

    public function addContratSignerClient(Request $request)
    {

       
        contratSigners::create([
            'idPersonnelClient' => $request->idPersonnelClient,
            'dateSignature' => $request->dateSignature,
            'accordConf' => $request->accordConf,
            'dateAccord' => $request->dateAccord,
            'slug' => $request->_token . "" . rand(1234, 3458),
        ]);

        if ($request->file('fichierContratSigner') != null) {

            $slug= DB::select("select slug from contrat_signers order by idContratSigner desc limit 1");

            $fichier = request()->file('fichierContratSigner');
            $contratSigner = new Fichiers();

            $filename = strtoupper(substr(str_shuffle(md5($request->_token . "" . rand(124, 345))), 0, 4)) . date('YmdHi') . '.' . $fichier->extension();
            $contratSigner->nomOriginal = $fichier->getClientOriginalName();
            $contratSigner->slugSource =  $slug[0]->slug;
            $contratSigner->filename = $filename;
            $contratSigner->slug = $request->_token . "" . rand(1234, 3458);
            $contratSigner->path = 'assets/upload/fichiers/contrats/' . $filename;
            $fichier->move(public_path('assets/upload/fichiers/contrats/'), $filename);
            $contratSigner->save();
        }

        return redirect()->back()->with('success', 'Contrat signé avec succès !');
        
    }

    public function addContratAvenantClient(Request $request)
    {

       
        avenantContrat::create([
            'idPersonnelClient' => $request->idPersonnelClient,
            'dateAvenant' => $request->dateAvenant,
            'nature' => $request->nature,
            'slug' => $request->_token . "" . rand(1234, 3458),
        ]);

        if ($request->file('fichierAvenant') != null) {

            $slug= DB::select("select slug from avenant_contrats order by idAvenant desc limit 1");

            $fichier = request()->file('fichierAvenant');
            $avenant = new Fichiers();

            $filename = strtoupper(substr(str_shuffle(md5($request->_token . "" . rand(124, 345))), 0, 4)) . date('YmdHi') . '.' . $fichier->extension();
            $avenant->nomOriginal = $fichier->getClientOriginalName();
            $avenant->slugSource =  $slug[0]->slug;
            $avenant->filename = $filename;
            $avenant->slug = $request->_token . "" . rand(1234, 3458);
            $avenant->path = 'assets/upload/fichiers/contrats/' . $filename;
            $fichier->move(public_path('assets/upload/fichiers/contrats/'), $filename);
            $avenant->save();
        }

        return redirect()->back()->with('success', 'Avenant signé avec succès !');
        
    }

    public function addFinContratClient(Request $request)
    {

       
        contratTerminer::create([
            'idPersonnelClient' => $request->idPersonnelClient,
            'dateTerminer' => $request->dateTerminer,
            'motif' => $request->motif,
            'slug' => $request->_token . "" . rand(1234, 3458),
        ]);

        if ($request->file('fichierFinContrat') != null) {

            $slug= DB::select("select slug from contrat_terminers order by idContratTerminer desc limit 1");

            $fichier = request()->file('fichierFinContrat');
            $finContrat = new Fichiers();

            $filename = strtoupper(substr(str_shuffle(md5($request->_token . "" . rand(124, 345))), 0, 4)) . date('YmdHi') . '.' . $fichier->extension();
            $finContrat->nomOriginal = $fichier->getClientOriginalName();
            $finContrat->slugSource =  $slug[0]->slug;
            $finContrat->filename = $filename;
            $finContrat->slug = $request->_token . "" . rand(1234, 3458);
            $finContrat->path = 'assets/upload/fichiers/contrats/' . $filename;
            $fichier->move(public_path('assets/upload/fichiers/contrats/'), $filename);
            $finContrat->save();
        }

        return redirect()->back()->with('success', 'Contrat terminé avec succès !');
        
    }


    public function deleteContraSignerClient($slug)
    {

        $fichier = DB::select("select * from fichiers where slugSource=?", [$slug]);
        // Suppression des fichiers lié au suivi
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


        DB::delete("delete from contrat_signers where slug=?",[$slug]);
        return back()->with('success', 'Contrat supprimé avec succès');


    }

    public function deleteContraAvenantClient($slug)
    {

        $fichier = DB::select("select * from fichiers where slugSource=?", [$slug]);
        // Suppression des fichiers lié au suivi
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


        DB::delete("delete from avenant_contrats where slug=?",[$slug]);
        return back()->with('success', 'Avenant supprimé avec succès');


    }

    public function deleteFinContratClient($slug)
    {

        $fichier = DB::select("select * from fichiers where slugSource=?", [$slug]);
        // Suppression des fichiers lié au suivi
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


        DB::delete("delete from contrat_terminers where slug=?",[$slug]);
        return back()->with('success', 'Document de fin de contrat supprimé avec succès');


    }
}
