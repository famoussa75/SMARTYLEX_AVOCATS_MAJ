<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\clients;
use App\Models\CourierArriver;
use App\Models\courierLiers;
use Illuminate\Support\Str; 
use App\Models\CourierDepart;
use App\Models\CourierFiles;
use App\Models\Fichiers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use PHPMailer\PHPMailer\PHPMailer;
use Fpdf\Fpdf;


class CourierArriverController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response 
     */

    public function getAllCourierArriverForSearch($search)
    {
        // récuperation des tâches dans la base de donnees
        $courierArriver = DB::select("select slug,LOWER(objet) as objet from courier_arrivers where objet like '%$search%'");

        return response()->json([
            'courierArriver' => $courierArriver,
        ]);


        //return view('taches.showTask', compact('taches'));
    }

    public function index()
    {
        // Recuperation des Courriers - Arrivée pour les affichers dans la vue du client
        $couriers = CourierArriver::all();
        return view('couriers.arriver.allCourierArrive', compact('couriers'));
    }

    public function classer($slug)
    {
        DB::update("update courier_arrivers set statut='Classé' where slug=?", [$slug]);
        return back()->with('success', 'Courrier classé avec succès !');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function allDutys()
    {
        // Recuperation des Courriers - Arrivée pour les affichers dans la vue du client
        $couriersArriver = CourierArriver::all();

        // Récuperation des couries depart
        $couriersDepart = CourierDepart::all();

        return view('couriers.allCouriers', compact('couriersArriver', 'couriersDepart'));
    }

    public function deleteLiaisonCourier($slugCourierLier)
    {
        DB::delete("delete from courier_liers where slug=?",[$slugCourierLier]);
        return redirect()->back()->with('success','Liaison supprimée avec succès');
    }

    public function saveCourierLier(Request $request)
    {
        // On récupère la cleCommune s'il existe
        $cleCommune = $request->cleCommune ?? '';

        // Validation des données
        $request->validate([
            'idCourierLier' => 'required|array',
            'idCourierLier.*' => 'nullable|string', // chaque élément peut être null ou une string
            'slugCourier' => $request->filled('cleCommune') ? 'nullable|string' : 'required|string',
        ]);

        try {
            // Si cleCommune est vide, on crée d'abord le courrier principal
            if (empty($cleCommune)) {
                $mainCourier = courierLiers::create([
                    'slugCourierLier' => $request->slugCourier,
                    'cleCommune' => Str::uuid()->toString(), // Génère un UUID unique
                    'slug' => Str::slug($request->_token . now()->timestamp),
                ]);

                // On réutilise la cleCommune générée
                $cleCommune = $mainCourier->cleCommune;
            }

            // Nettoyer le tableau des courriers secondaires pour enlever les null
            $idCouriers = array_filter($request->idCourierLier, function ($item) {
                return !empty($item);
            });

            // Liaison des courriers secondaires
            foreach ($idCouriers as $courierSlug) {
                courierLiers::create([
                    'slugCourierLier' => $courierSlug,
                    'cleCommune' => $cleCommune,
                    'slug' => Str::slug($request->_token . now()->timestamp),
                ]);
            }

            return redirect()->back()->with('success', 'Liaison créée avec succès');

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Erreur lors de la création de la liaison: ' . $e->getMessage())
                ->withInput();
        }
    }



    /**
     * Afficher the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // Recuperation des informations des clients dans la base de données
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

        $courierArrivers = DB::select("select * from courier_arrivers where statut !='Annulé' ");
        $courierDeparts = DB::select("select * from courier_departs where statut !='Annulé' ");
        
        //recuperation du nombre de courier arriver

        $verif = DB::select('select * from courier_arrivers order by numero Desc limit 1 ');
        if (empty($verif)) {
            $numero = 1;
        } else {
            $numero =  $verif[0]->numero + 1;
        }

        $huissier = DB::select("select * from huissiers");
       
        // renvoi du formulaire d'enregistrement du Courriers - Arrivée
        return view('couriers.arriver.courierArriveForm', compact('client', 'numero', 'courierDeparts','courierArrivers','huissier'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // L'instance du model courierArriver
        $courierArriver = new CourierArriver();

        $courierFile = new Fichiers();


        if ($request) {

            //personnel connecter
            if (Session::has('idPersonnel')) {
                foreach (Session::get('idPersonnel') as $Personnel) {
                    $idPersonConnected = $Personnel->idPersonnel;
                }
            } else {
                $idPersonConnected = 'admin';
            }

                $courierArriver->expediteur = $request->expediteur;
                $courierArriver->dateCourier = $request->dateCourier;
                $courierArriver->idAffaire = $request->idAffaire;
                $courierArriver->signifie = $request->huissier;
                $courierArriver->dateArriver = $request->dateArriver;
                $courierArriver->numero = $request->numero;
                $courierArriver->objet = $request->objet;
                $courierArriver->niveau = 'Transmission';
                $courierArriver->statutCourierTrasmise = 'Non Trasmis';
                $courierArriver->statut = 'Reçu';
                $courierArriver->idClient = $request->idClient;
                $courierArriver->confidentialite = $request->confidentialite;
                $courierArriver->slug = $request->_token . '' . rand(1234, 3458);
              


              // Creation des fichiers
            // dossiers : affaires,taches,audiences,courier-departs,courier-arrivers
            if ($request->file('fichiers') != null) {

                $fichiers = request()->file('fichiers');


                foreach ($fichiers as $fichier) {

                    $courierFile = new Fichiers();

                    $filename = strtoupper(substr(str_shuffle(md5($request->_token . "" . rand(124, 345))), 0, 4)) . date('YmdHi') . '.' . $fichier->extension();
                    $courierFile->nomOriginal = $fichier->getClientOriginalName();
                    $courierFile->slugSource = $courierArriver->slug;
                    $courierFile->filename = $filename;
                    $courierFile->slug = $request->_token . "" . rand(1234, 3458);
                    $courierFile->path = 'assets/upload/fichiers/courier-arrivers/' . $filename;
                    $fichier->move(public_path('assets/upload/fichiers/courier-arrivers'), $filename);
                    $courierFile->save();
                }
            }

            /*

                //personnel connecter
                if (Session::has('idPersonnel')) {
                    foreach (Session::get('idPersonnel') as $Personnel) {
                        $idPersonConnected = $Personnel->idPersonnel;
                    }
                    $admins = DB::select("select * from users where role='Administrateur'");

                    foreach ($admins as $a) {
                        DB::select(
                            'INSERT INTO notifications(categorie, messages, etat, idRecepteur,slug,a_biper,urlName,urlParam,idAdmin) VALUES(?,?,?,?,?,?,?,?,?)',
                            [
                                    'Courriers - Arrivée',
                                    "Un courrier arrivé a été enregistré.",
                                    'masquer',
                                    'admin',
                                    'non',
                                    $request->_token . "" . rand(1234, 3458),
                                    "detailCourierArriver",
                                    $courierArriver->slug,
                                    $a->id
                            ]
                        );
                    }
                } else {
                    $assistantSelect = DB::select("select personnels.idPersonnel as idPersonnel,personnels.email,users.email from personnels,users where personnels.email = users.email and users.role='Assistant'");
                    if (empty($assistantSelect)) {
                        $assistant = 'Assistant';
                    } else {
                        $assistant = $assistantSelect[0]->idPersonnel;
                    }
    

                    DB::select(
                        'INSERT INTO notifications(categorie, messages, etat, idRecepteur,a_biper,slug,urlName,urlParam) VALUES(?,?,?,?,?,?,?,?)',
                        [
                            'Courriers - Arrivée',
                            "Un courrier arrivé a été enregistré.",
                            'masquer',
                            $assistant,
                            'non',
                            $request->_token . "" . rand(1234, 3458),
                            "detailCourierArriver",
                            $courierArriver->slug
                        ]
                    );
                }*/

                $admins = DB::select("select * from users where role='Administrateur'");

                foreach ($admins as $a) {
                    DB::select(
                        'INSERT INTO notifications(categorie, messages, etat, idRecepteur,slug,a_biper,urlName,urlParam,idAdmin) VALUES(?,?,?,?,?,?,?,?,?)',
                        [
                            'Courriers - Arrivée',
                            "Un courrier arrivé a été enregistré.",
                            'masquer',
                            'admin',
                            'non',
                            $request->_token . "" . rand(1234, 3458),
                            "detailCourierArriver",
                            $courierArriver->slug,
                            $a->id
                        ]
                    );
                }

                $assistantSelect = DB::select("select personnels.idPersonnel as idPersonnel,personnels.email,users.email from personnels,users where personnels.email = users.email and users.role='Assistant'");
               
                foreach($assistantSelect as $assistant){
                    DB::select(
                        'INSERT INTO notifications(categorie, messages, etat, idRecepteur,a_biper,slug,urlName,urlParam) VALUES(?,?,?,?,?,?,?,?)',
                        [
                            'Courriers - Arrivée',
                            "Un courrier arrivé a été enregistré.",
                            'masquer',
                            $assistant->idPersonnel,
                            'non',
                            $request->_token . "" . rand(1234, 3458),
                            "detailCourierArriver",
                            $courierArriver->slug
                        ]
                    );
                }


               
                

                $slug = $courierArriver->slug;

                // Enregistrement
                $courierArriver->save();

    
                $cleCommune = $request->_token . "" . rand(1234, 3458);

                courierLiers::create([
                    'slugCourierLier' => $slug,
                    'cleCommune' => $cleCommune,
                    'slug' => $request->_token . "" . rand(1234, 3458),
                ]);

                foreach ($request->idCourierLier as $key => $value) {
                    if ($value==0) {
                    # ne rien faire
                    } else {
                    courierLiers::create([
                        'slugCourierLier' => $value,
                        'cleCommune' => $cleCommune,
                        'slug' => $request->_token . "" . rand(1234, 3458),
                    ]);
                    }
                    
                }
            return redirect()->route('detailCourierArriver',  [$courierArriver->slug])->with('success', 'Courrier - Arrivée enregistré avec succès !');
        
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  string  $slug
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {


        $courierArriver = DB::select("select * from courier_arrivers where slug=?",[$slug]);

        $cleCommune = DB::select('select * from courier_liers where slugCourierLier=?',[$slug]);

        $courierDepartLiers = [];
        $courierArriverLiers = [];

        if (!empty($cleCommune)) {

            foreach ($cleCommune as $key => $value) {

                $courierDepartLiersItem = DB::select("SELECT courier_departs.slug as slugDepart,numCourier, courier_departs.idCourierDep, courier_liers.slugCourierLier, courier_liers.slug as slugTCourierLier, cleCommune, objet
                FROM courier_departs, courier_liers 
                WHERE courier_departs.slug = courier_liers.slugCourierLier AND courier_liers.cleCommune = :cle1",['cle1' => $value->cleCommune]);

                $courierArriverLiersItem = DB::select("SELECT courier_arrivers.slug as slugArriver,numero, courier_liers.slugCourierLier, courier_liers.slug as slugTCourierLier, cleCommune, courier_arrivers.idCourierArr, objet
                FROM courier_arrivers, courier_liers 
                WHERE courier_arrivers.slug = courier_liers.slugCourierLier AND courier_liers.cleCommune = :cle2",['cle2' => $value->cleCommune]);

                $courierDepartLiers = array_merge($courierDepartLiers, $courierDepartLiersItem);
                $courierArriverLiers = array_merge($courierArriverLiers, $courierArriverLiersItem);
            }
           // dd($courierDepartLiers,$courierArriverLiers,$slug);
         
        }

        if (!empty($courierArriver)) {
            $tacheCourier = DB::select("select * from taches where courrierTache=?", [$courierArriver[0]->idCourierArr]);
            if (empty($tacheCourier)) {
                DB::update("update courier_arrivers set statut='Traitement annulé' where statut='En Traitement' and slug=? ",[$slug]);
            }
        } else {
            $tacheCourier = [];
        }

       
        


        $courierFile = DB::select("select * from fichiers where slugSource=?", [$slug]);

        if (Auth::user()->role == 'Administrateur' && $courierArriver[0]->statut == 'Reçu') {
            DB::update("update courier_arrivers set statut='Lu' where slug=? ", [$slug]);
        } else {
            # code...
        }

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

        $client = DB::select("select * from clients");


        
        $courierArriversCabinet = DB::select("select * from courier_arrivers where statut != 'Annulé' and idAffaire is null ");

        $clientAffaire = DB::select("select clients.idClient, affaires.idAffaire, prenom, nom, denomination,nomAffaire, clients.slug as slugClient, affaires.slug as slugAffaire from courier_arrivers,clients,affaires where courier_arrivers.idClient=clients.idClient and courier_arrivers.idAffaire=affaires.idAffaire and courier_arrivers.slug=?",[$slug]);


        $courierArrivers = DB::select("select * from courier_arrivers  where   idAffaire is null and  statut !='Annulé' ");
        $courierDeparts = DB::select("select * from courier_departs where statut !='Annulé' ");
        //dd(  $courierArrivers,$courierDeparts);


        $couriersHuissier = DB::select("select huissiers.*,courier_arrivers.* from huissiers, courier_arrivers where huissiers.idHss = courier_arrivers.signifie and courier_arrivers.slug =?",[$slug]);




        $courriersArriverCabinet = DB::select("SELECT * FROM courier_arrivers WHERE statut != 'Annulé' AND idAffaire is null  AND (? IS NULL OR courier_arrivers.slug != ?) ",[$slug,$slug] );
    
        $courriersDepartCabinet = DB::select("SELECT * FROM courier_departs WHERE  statut != 'Annulé' AND idAffaire is null AND (? IS NULL OR courier_departs.slug != ?) ",[$slug,$slug]);


        $suggeCourierDepart = DB::select("
            SELECT cd.*, cd.slug as slugDepart, c.*, a.*
            FROM courier_departs cd
            INNER JOIN clients c ON cd.idClient = c.idClient
            INNER JOIN courier_arrivers ca ON ca.idClient = c.idClient
            INNER JOIN affaires a ON cd.idAffaire = a.idAffaire
            WHERE cd.statut != 'Annulé'
            AND ca.slug = ?
        ", [$slug]);

        
        
        //dd($suggeCourierDepart);
    

        return view('couriers.arriver.infoCourierArriver', compact('courierArriver', 'courierFile', 'tacheCourier','clientAffaire','courierDepartLiers','courierArriverLiers','courierArrivers','courierDeparts','client','courriersArriverCabinet','courriersDepartCabinet','couriersHuissier','suggeCourierDepart'));
    }

    // Dans TonControleur.php
    public function fetchAffaireCouriers(Request $request,$id)
    {
        // 1. Récupérer le client
        $client = DB::select("SELECT * FROM clients WHERE idClient = ?", [$id]);
    
        // 2. Récupérer les affaires du client
        $affaires = DB::select("SELECT * FROM affaires WHERE idClient = ?", [$id]);
    
       


        $slugcourier = $request->input('slugCourier'); // peut être null

         // 3. Pour chaque affaire, récupérer ses courriers arrivés et départs
         $affairesAvecCouriers = [];
    
         foreach ($affaires as $affaire) {

            $courriersArriver = DB::select("
                SELECT ca.*, c.nom, c.prenom, c.idClient, ? AS nomAffaire
                FROM courier_arrivers ca
                INNER JOIN clients c ON ca.idClient = c.idClient
                WHERE ca.statut != 'Annulé'
                AND (? IS NULL OR ca.slug != ?)
                AND ca.idAffaire = ?
            ", [$affaire->nomAffaire, $slugcourier, $slugcourier, $affaire->idAffaire]);
        
            $courriersDepart = DB::select("
                SELECT cd.*, c.nom, c.prenom, c.idClient, ? AS nomAffaire
                FROM courier_departs cd
                INNER JOIN clients c ON cd.idClient = c.idClient
                WHERE cd.statut != 'Annulé'
                AND (? IS NULL OR cd.slug != ?)
                AND cd.idAffaire = ?
            ", [$affaire->nomAffaire, $slugcourier, $slugcourier, $affaire->idAffaire]);
        
            $affairesAvecCouriers[] = [
                'affaire' => $affaire,
                'couriers_arrivers' => $courriersArriver,
                'couriers_departs' => $courriersDepart,
            ];
        }
        
        
        // 5. Retourner la réponse structurée
        return response()->json([
            'client' => $client,
            'affaires' => $affairesAvecCouriers,
            
        ]);
    }


    /**
     * Afficher the form for editing the specified resource.
     *
     * @param  \App\Models\CourierArriver  $courierArriver
     * @return \Illuminate\Http\Response
     */
    public function edit(CourierArriver $courierArriver)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\CourierArriver  $courierArriver
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, CourierArriver $courierArriver)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\CourierArriver  $courierArriver
     * @return \Illuminate\Http\Response
     */
    public function deleteCourierArriver(Request $request)
    {
        $slug = $request->slug;

        // $fichier = DB::select("select * from fichiers where slugSource=?", [$slug]);
        // // Suppression des fichiers lié au suivi
        // if (!empty($fichier)) {
        //     foreach ($fichier as $key => $value) {

        //         if (file_exists($value->path)) {
        //             unlink(public_path($value->path));
        //         } else {
                   
        //         }
        //     }
        //     DB::delete("delete from fichiers where slugSource=? ", [$slug]);
        // } else {
        // }

        // DB::delete("delete from courier_arrivers where slug=?",[$slug]);
        DB::update("update courier_arrivers set statut='Annulé' where slug=?",[$slug]);
        return back()->with('success', 'Courrier annulé avec succès');
    }

    public function offConfArriver($slug)
    {
        DB::update("update courier_arrivers set confidentialite='off' where slug=?",[$slug]);
        return back()->with('success', 'Confidentialité désactiver avec succès');
    }

    public function onConfArriver($slug)
    {
        DB::update("update courier_arrivers set confidentialite='on' where slug=?",[$slug]);
        return back()->with('success', 'Confidentialité activer avec succès');
    }

    public function soumetre(Request $request)
    {
        $slug = $request->input('slugCourier');
        
        // Récupération du courrier + client + affaire
        $courierClient = DB::table('courier_arrivers')
            ->join('clients', 'courier_arrivers.idClient', '=', 'clients.idClient')
            ->join('affaires', 'courier_arrivers.idAffaire', '=', 'affaires.idAffaire')
            ->select(
                'courier_arrivers.objet as objetCourier',
                'courier_arrivers.idClient',
                'courier_arrivers.idAffaire',
                'clients.email as emailClient',
                'clients.prenom as clientPrenom',
                'clients.nom as nomClient'
            )
            ->where('courier_arrivers.slug', $slug)
            ->first();
            
    
        // Récupération des fichiers liés par slugSource = $slug
        $courierFiles = DB::select("SELECT * FROM fichiers WHERE slugSource = ?", [$slug]);
        //dd( $courierFiles);
    
        // Configuration cabinet et serveur mail
        $cabinet = DB::table('cabinets')->first();
        $serveurEmail = DB::table('serveur_mails')->first();
    
        if (!$cabinet || !$serveurEmail) {
            return back()->with('error', "Configuration du cabinet ou du serveur mail manquante.");
        }
    
        // Données client
        $email  = $courierClient->emailClient;
        $objet  = $courierClient->objetCourier;
        $prenom = $courierClient->clientPrenom;
        $nom    = $courierClient->nomClient;
    
        try {
            $mail = new PHPMailer(true);
            $mail->isSMTP();
            $mail->SMTPDebug = 0;
            $mail->Host       = $serveurEmail->host;
            $mail->SMTPAuth   = true;
            $mail->Username   = $cabinet->emailFinance;
            $mail->Password   = $cabinet->cleFinance;
            $mail->SMTPSecure = $serveurEmail->smtpSecure;
            $mail->Port       = $serveurEmail->smtpPort;
            $mail->SMTPOptions = [
                'ssl' => [
                    'verify_peer'       => false,
                    'verify_peer_name'  => false,
                    'allow_self_signed' => true,
                ],
            ];
    
            $mail->setFrom($cabinet->emailFinance, $cabinet->nomCabinet);
            $mail->addAddress($email, "$prenom $nom");
            $mail->addAddress($cabinet->emailContact);
    
            // Attacher les fichiers (physiquement) : on utilise le chemin public
            $inlineImagesHtml = ''; // si on veut afficher les images inline
            foreach ($courierFiles as $index => $file) {
                // $file->path est par ex. "assets/upload/fichiers/courier-departs/xxx.png"
                $fullPath = public_path($file->path);
                $filename = $file->filename ?? basename($file->path);
    
                if (file_exists($fullPath)) {
                    // Joindre comme pièce jointe
                    $mail->addAttachment($fullPath, $filename);
    
                    // Si c'est une image, intégrer inline aussi (optionnel)
                    $ext = strtolower(pathinfo($fullPath, PATHINFO_EXTENSION));
                    if (in_array($ext, ['jpg', 'jpeg', 'png', 'gif', 'webp'])) {
                        // cid unique par fichier
                        $cid = "img{$index}";
                        $mail->addEmbeddedImage($fullPath, $cid, $filename);
                        $inlineImagesHtml .= "<p>Prévisualisation :<br><img src=\"cid:$cid\" style=\"max-width:300px; height:auto;\" /></p>";
                    }
                } else {
                    \Log::warning("Fichier introuvable pour attachement : $fullPath");
                }
            }
    
            // Corps du mail
            $body = "
                <div class='container'>
                    <p>Madame / Monsieur <strong>$prenom $nom</strong>,</p>
                    <p>Nous vous informons que le courrier intitulé « <strong>$objet</strong> » a été envoyé avec les documents ci-joints.</p>
                    $inlineImagesHtml
                    <p>Vous pouvez télécharger les pièces jointes directement depuis cet email.</p>
                    <p>Cordialement,<br>{$cabinet->nomCabinet}<br>{$cabinet->signature}</p>
                </div>
            ";
    
            $mail->isHTML(true);
            $mail->Subject = "Notification d'envoi de courrier : $objet";
            $mail->CharSet = 'UTF-8';
            $mail->Encoding = 'base64';
            $mail->Body = $body;
            $mail->AltBody = "Bonjour $prenom $nom,\n\nNous vous informons que le courrier intitulé \"$objet\" a été envoyé avec ses documents joints.\n\nCordialement,\n{$cabinet->nomCabinet}";
    
            if (!$mail->send()) {
                \Log::error("Erreur envoi mail : " . $mail->ErrorInfo);
                return back()->with('error', "Échec de l'envoi de la notification au client.");
            }
    
            return back()->with('success', "Notification envoyée au client ($prenom $nom) concernant « $objet ».");
        } catch (Exception $e) {
            \Log::error("Exception PHPMailer : " . $e->getMessage());
            return back()->with('error', "Erreur interne lors de l'envoi du mail : " . $e->getMessage());
        }
    }
    
}
