<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;
use App\Models\Factures;
use App\Models\Paiements;
use App\Models\Revenus;
use App\Models\DetailFactures;
use App\Models\ModePaiementBancaires;
use App\Models\AutreModePaiements;
use App\Models\paiementFactures;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;


class FacturationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function list()
    {
        $monnaieParDefaut = DB::select("select monnaieParDefaut from cabinets");
        $GNF = DB::select("select valeurTaux from monnaies where description='GNF'");
        $valeurTauxGNF =  $GNF[0]->valeurTaux;
        $EURO = DB::select("select valeurTaux from monnaies where description='EURO'");
        $valeurTauxEURO =  $EURO[0]->valeurTaux;
        $USD = DB::select("select valeurTaux from monnaies where description='USD'");
        $valeurTauxUSD =  $USD[0]->valeurTaux;
        $FCFA = DB::select("select valeurTaux from monnaies where description='FCFA'");
        $valeurTauxFCFA =  $FCFA[0]->valeurTaux;



        $today = date('Y-m-d');
        DB::select("update factures,paiement_factures set factures.statut='En retard' where factures.statut='Créée' and dateEcheance<?",[$today]);
        $factures = DB::select("select * from clients,affaires,factures where  factures.idClient=clients.idClient and factures.idAffaire=affaires.idAffaire");
        $facturesPaiements = DB::select("select * from paiement_factures");
                             
        $TFactures = DB::select("
            SELECT
            SUM(
                CASE
                    WHEN monnaie = 'GNF' THEN montantTTC * $valeurTauxGNF
                    WHEN monnaie = '€' THEN montantTTC * $valeurTauxEURO
                    WHEN monnaie = '$' THEN montantTTC * $valeurTauxUSD
                    WHEN monnaie = 'FCFA' THEN montantTTC * $valeurTauxFCFA
                    ELSE 0 
                END
            ) AS TFactures
        FROM factures
        WHERE factures.statut != 'Annulée'");
        
        $TFacturesPaye = DB::select("
        SELECT 
                SUM(
                    CASE
                        WHEN factures.idFacture=paiement_factures.idFacture and monnaie = 'GNF' THEN montantPayer * $valeurTauxGNF
                        WHEN factures.idFacture=paiement_factures.idFacture and monnaie = '€' THEN montantPayer * $valeurTauxEURO
                        WHEN factures.idFacture=paiement_factures.idFacture and monnaie = '$' THEN montantPayer * $valeurTauxUSD
                        WHEN factures.idFacture=paiement_factures.idFacture and monnaie = 'FCFA' THEN montantPayer * $valeurTauxFCFA
                        ELSE 0 
                    END
                ) AS TFacturesPaye
            FROM factures,paiement_factures
            WHERE factures.statut = 'Payée' ");

        $TFacturesEncours = DB::select("
                SELECT
                SUM(
                    CASE
                        WHEN monnaie = 'GNF' THEN montantTTC * $valeurTauxGNF
                        WHEN monnaie = '€' THEN montantTTC * $valeurTauxEURO
                        WHEN monnaie = '$' THEN montantTTC * $valeurTauxUSD
                        WHEN monnaie = 'FCFA' THEN montantTTC * $valeurTauxFCFA
                        ELSE 0 
                    END
                ) AS TFacturesEncours
            FROM factures
            WHERE statut = 'En cours de paiement' ");

        $TFacturesDue1 = DB::select("
                        SELECT
                    SUM(
                        CASE
                            WHEN monnaie = 'GNF' THEN montantTTC * $valeurTauxGNF
                            WHEN monnaie = '€' THEN montantTTC * $valeurTauxEURO
                            WHEN monnaie = '$' THEN montantTTC * $valeurTauxUSD
                            WHEN monnaie = 'FCFA' THEN montantTTC * $valeurTauxFCFA
                            ELSE 0 
                        END
                    ) AS TFacturesDue
                FROM factures
                WHERE factures.statut = 'En retard' ");
        

        $TFacturesDue2 = DB::select("
                SELECT
            SUM(
                CASE
                    WHEN factures.idFacture=paiement_factures.idFacture and monnaie = 'GNF' THEN montantRestant * $valeurTauxGNF
                    WHEN factures.idFacture=paiement_factures.idFacture and monnaie = '€' THEN montantRestant * $valeurTauxEURO
                    WHEN factures.idFacture=paiement_factures.idFacture and monnaie = '$' THEN montantRestant * $valeurTauxUSD
                    WHEN factures.idFacture=paiement_factures.idFacture and monnaie = 'FCFA' THEN montantRestant * $valeurTauxFCFA
                    ELSE 0 
                END
            ) AS TFacturesDue
        FROM factures,paiement_factures 
        WHERE factures.statut = 'En cours de paiement'");


        $TFacturesDue = $TFacturesDue1[0]->TFacturesDue + $TFacturesDue2[0]->TFacturesDue;


        $cabinet = DB::select("select * from cabinets");
        $plan = $cabinet[0]->plan;
        return view('facturations.historique',compact('factures','TFactures','TFacturesPaye','TFacturesEncours','TFacturesDue','monnaieParDefaut','plan','facturesPaiements'));
    }

    /**
     * Afficher the form for creating a new resource.
     */
    public function create()
    {
        $client = DB::select("select * from clients");
        $monnaies = DB::select("select * from monnaies");
        $compteBancaire = DB::select("select * from compte_bancaires");

        $cabinet = DB::select("select * from cabinets");
        $plan = $cabinet[0]->plan;
       return view('facturations.creation',compact('client','monnaies','compteBancaire','plan','cabinet'));
    }

    public function createFromClient($idClient)
    {
        $client = DB::select("select * from clients where idClient=?",[$idClient]);
        $monnaies = DB::select("select * from monnaies");
        $compteBancaire = DB::select("select * from compte_bancaires");
        $affaire = DB::select("select * from affaires where idClient=?",[$idClient]);

        $cabinet = DB::select("select * from cabinets");
        $plan = $cabinet[0]->plan;

       return view('facturations.creation',compact('client','monnaies','compteBancaire','affaire','plan','cabinet'));

    }

    public function createFromAffaire($idClient,$idAffaire)
    {
        $client = DB::select("select * from clients where idClient=?",[$idClient]);
        $monnaies = DB::select("select * from monnaies");
        $compteBancaire = DB::select("select * from compte_bancaires");
        $affaire = DB::select("select * from affaires where idAffaire=?",[$idAffaire]);

        $cabinet = DB::select("select * from cabinets");
        $plan = $cabinet[0]->plan;
       return view('facturations.creation',compact('client','monnaies','compteBancaire','affaire','plan','cabinet'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $today = date('d-m-Y');
        if ($request->dateFacture=='') {
            $dateFacture=$today;
        }else {
            $dateFacture = $request->dateFacture;
        }
        Factures::create([
            'dateFacture' => $dateFacture,
            'idClient' => $request->idClient,
            'idAffaire' => $request->idAffaire,
            'montantHT' =>$request->montantHT,
            'montantTVA' =>$request->montantTVA,
            'montantTTC' =>$request->montantTTC,
            'monnaie' =>$request->monnaie,
            'dateEcheance' =>$request->dateEcheance,
            'rappel' => 'non',
            'statut' => 'Créée',
            'slug' => $request->_token . "" . rand(1234, 3458),
        ]);

        $idFacture = DB::select("select idFacture,slug from factures order by idFacture desc limit 1");
              
        foreach ($request->formset as $key => $value) {
            
                DetailFactures::create([
                    'idFacture' => $idFacture[0]->idFacture,
                    'designation' => $value['designation'],
                    'prix' => $value['prix'],
                    'slug' => $request->_token . "" . rand(1234, 3458),
                ]);          
        }

        if (empty($request->idCompteBank)) {
            # code...
        } else {
            foreach ($request->idCompteBank as $key => $cb) {
            
                ModePaiementBancaires::create([
                    'idFacture' => $idFacture[0]->idFacture,
                    'idCompteBank' => $cb,
                    'slug' => $request->_token . "" . rand(1234, 3458),
                ]);          
            }
        }

        if ($request->descMode=='') {
            # code...
        } else {
            AutreModePaiements::create([
                'idFacture' => $idFacture[0]->idFacture,
                'descMode' =>$request->descMode,
                'slug' => $request->_token . "" . rand(1234, 3458),
            ]);  
        }
        /*

        if (Session::has('idPersonnel')) {
            foreach (Session::get('idPersonnel') as $Personnel) {
                $idPersonConnected = $Personnel->idPersonnel;
            }
            $admins = DB::select("select * from users where role='Administrateur'");

                    foreach ($admins as $a) {
                        DB::select(
                            'INSERT INTO notifications(categorie, messages, etat, idRecepteur,slug,a_biper,urlName,urlParam,idAdmin) VALUES(?,?,?,?,?,?,?,?,?)',
                            [
                                'Facture',
                                "Une facture a été enregistrée.",
                                'masquer',
                                'admin',
                                'non',
                                $request->_token . "" . rand(1234, 3458),
                                "facture",
                                $idFacture[0]->slug,
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

            foreach($assistantSelect as $assistant){
                DB::select(
                    'INSERT INTO notifications(categorie, messages, etat, idRecepteur,a_biper,slug,urlName,urlParam) VALUES(?,?,?,?,?,?,?,?)',
                    [
                        'Facture',
                        "Une facture a été enregistrée.",
                        'masquer',
                        $assistant->idPersonnel, 
                        'non',
                        $request->_token . "" . rand(1234, 3458),
                        "facture",
                        $idFacture[0]->slug
                    ]
                );
            }


           
          //  dd( $assistantSelect);
        }
          */

        $admins = DB::select("select * from users where role='Administrateur'");

        foreach ($admins as $a) {
            DB::select(
            'INSERT INTO notifications(categorie, messages, etat, idRecepteur,slug,a_biper,urlName,urlParam,idAdmin) VALUES(?,?,?,?,?,?,?,?,?)',
            [
                'Facture',
                "Une facture a été enregistrée.",
                'masquer',
                'admin',
                'non',
                $request->_token . "" . rand(1234, 3458),
                "facture",
                $idFacture[0]->slug,
                $a->id
            ]);
        }

        $assistantSelect = DB::select("select personnels.idPersonnel as idPersonnel,personnels.email,users.email from personnels,users where personnels.email = users.email and users.role='Assistant'");

        foreach($assistantSelect as $assistant){
            DB::select(
                'INSERT INTO notifications(categorie, messages, etat, idRecepteur,a_biper,slug,urlName,urlParam) VALUES(?,?,?,?,?,?,?,?)',
                [
                    'Facture',
                    "Une facture a été enregistrée.",
                    'masquer',
                    $assistant->idPersonnel, 
                    'non',
                    $request->_token . "" . rand(1234, 3458),
                    "facture",
                    $idFacture[0]->slug
                ]
            );
        }
       // dd( $assistantSelect,$admins);
        
        $lastFacture = DB::select("select slug,idFacture from factures order by idFacture desc limit 1 ");

        return redirect()->route('facture', $lastFacture[0]->slug)->with('success','Facture créée avec succès !');
    }

    /**
     * Display the specified resource.
     */
    public function show($slug)
    {
        $today=date('Y-m-d');
        $cabinets = DB::select("select * from cabinets");
        $facture = DB::select("select * from clients,factures where clients.idClient=factures.idClient and factures.slug=?",[$slug]);
        
        $factureDetails = DB::select("select * from factures,detail_factures where factures.idFacture=detail_factures.idFacture and factures.slug=?",[$slug]);
        $client = DB::select("select * from clients where idClient=?",[$facture[0]->idClient]);
        $modePaieBank = DB::select("select * from mode_paiement_bancaires,factures,compte_bancaires where mode_paiement_bancaires.idCompteBank=compte_bancaires.idCompteBank and mode_paiement_bancaires.idFacture=factures.idFacture and factures.slug=?",[$slug]);
        $autreMode = DB::select("select * from autre_mode_paiements,factures where autre_mode_paiements.idFacture=factures.idFacture and factures.slug=?",[$slug]);

        $paiement = DB::select("select * from paiement_factures where idFacture=? order by idPaiementFacture desc",[$facture[0]->idFacture]);


        //Update de notification
        $email = Auth::user()->email;
        $personnel = DB::select('select * from personnels where email=? ', [$email]);

        foreach ($facture as $key => $value) {

            if (empty($personnel)) {
                DB::update("update notifications set etat='vue' where idRecepteur='admin' and idAdmin=? and urlParam=?", [Auth::user()->id,$value->slug]);
            } else {
                $idPersonnel = $personnel[0]->idPersonnel;
                $etat = 'vue';
                $idPerso = strval($idPersonnel);
                DB::select(
                    'UPDATE notifications SET etat=? where idRecepteur=? AND urlParam=?',
                    [$etat, $idPerso,$value->slug]
                );
            }
        }

        $factureBreadcrumbs = DB::select("select idFacture,factures.idClient,factures.idAffaire,nomAffaire,prenom,nom,denomination,clients.slug as slugClient,affaires.slug as slugAffaire from factures,clients,affaires where factures.idClient=clients.idClient and factures.idAffaire=affaires.idAffaire and factures.slug=?",[$slug]);
        return view('facturations.facture',compact('cabinets','facture','client','factureDetails','modePaieBank','autreMode','paiement','factureBreadcrumbs'));
    }

    /**
     * Afficher the form for editing the specified resource.
     */
    public function storePaiement(Request $request)
    {
        $slugFacture = $request->slugFacture;
       
        paiementFactures::create([
            'idFacture' => $request->idFacture,
            'datePaiement' => $request->datePaiement,
            'montantPayer' => $request->montantPayer,
            'montantRestant' =>$request->montantRestant,
            'methodePaiement' =>$request->methodePaiement,
            'banqueCheque' =>$request->banqueCheque,
            'numeroCheque' =>$request->numeroCheque,
            'dateVirement' =>$request->dateVirement,
            'statut' =>'Non validé',
            'slug' => $request->_token . "" . rand(1234, 3458),
        ]);


        DB::update("update factures set statut='En cours de paiement' where slug=?",[$slugFacture]);

        /*

        if (Session::has('idPersonnel')) {
            foreach (Session::get('idPersonnel') as $Personnel) {
                $idPersonConnected = $Personnel->idPersonnel;
            }
            $admins = DB::select("select * from users where role='Administrateur'");

                    foreach ($admins as $a) {
                        DB::select(
                            'INSERT INTO notifications(categorie, messages, etat, idRecepteur,slug,a_biper,urlName,urlParam,idAdmin) VALUES(?,?,?,?,?,?,?,?,?)',
                                [
                                    'Facture',
                                    "Un paiement de facture a été initié.",
                                    'masquer',
                                    'admin',
                                    'non',
                                    $request->_token . "" . rand(1234, 3458),
                                    "facture",
                                    $slugFacture,
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
                    'Facture',
                    "Un paiement de facture a été initié.",
                    'masquer',
                    $assistant,
                    'non',
                    $request->_token . "" . rand(1234, 3458),
                    "facture",
                    $slugFacture
                ]
            );
        }

        */

        $admins = DB::select("select * from users where role='Administrateur'");

        foreach ($admins as $a) {
            DB::select(
                'INSERT INTO notifications(categorie, messages, etat, idRecepteur,slug,a_biper,urlName,urlParam,idAdmin) VALUES(?,?,?,?,?,?,?,?,?)',
                [
                    'Facture',
                    "Un paiement de facture a été initié.",
                    'masquer',
                    'admin',
                    'non',
                    $request->_token . "" . rand(1234, 3458),
                    "facture",
                    $slugFacture,
                    $a->id
            ]);
        }

        $assistantSelect = DB::select("select personnels.idPersonnel as idPersonnel,personnels.email,users.email from personnels,users where personnels.email = users.email and users.role='Assistant'");

        foreach($assistantSelect as $assistant){
            DB::select(
                'INSERT INTO notifications(categorie, messages, etat, idRecepteur,a_biper,slug,urlName,urlParam) VALUES(?,?,?,?,?,?,?,?)',
                [
                    'Facture',
                    "Un paiement de facture a été initié.",
                    'masquer',
                    $assistant->idPersonnel,
                    'non',
                    $request->_token . "" . rand(1234, 3458),
                    "facture",
                    $slugFacture
                ]
            );
        }

       // dd($admins, $assistantSelect);
        
        return back()->with('success','Paiement initié avec succès !');
    }

    /**
     * Update the specified resource in storage.
     */
    public function validePaiement($idFacture,$montantPayer,$montantRestant,$idPaiementFacture)
    {
       
        if ($montantRestant==0) {
           DB::update("update factures set statut='Payée' where idFacture=?",[$idFacture]);
           DB::update("update paiement_factures set statut='Validé' where idPaiementFacture=?",[$idPaiementFacture]);
        } else {
         
            DB::select("update paiement_factures set statut='Validé' where idPaiementFacture=?",[$idPaiementFacture]);
        }

        return back()->with('success','Paiement validé avec succès !');
        
    }

    /**
     * Remove the specified resource from storage.
     */
    public function deletePaiement($idPaiementFacture,$idFacture)
    {
        DB::delete("delete from paiement_factures where idPaiementFacture=?",[$idPaiementFacture]);
        $totalPayer = DB::select("select * from paiement_factures where idFacture=?",[$idFacture]);
        if (empty($totalPayer)) {
            DB::update("update factures set statut='Créée' where idFacture=?",[$idFacture]);
        } else {
            DB::update("update factures set statut='En cours de paiement' where idFacture=?",[$idFacture]);
        }
        
        return back()->with('success','Paiement non validé  !');
    }

    public function envoiFacture(Request $request)
    {

        
        $slug =  $request->slug;
        $cabinet = DB::select("select * from cabinets");
        $serveurEmail = DB::select("select * from serveur_mails");
        $clientFacture = DB::select("select * from clients,factures where clients.idClient=factures.idClient and factures.slug=?",[$slug]);

      

        require base_path("vendor/autoload.php");
        $mail = new PHPMailer(true);     // Passing `true` enables exceptions

        try {

            // Email server settings
            $mail->SMTPDebug = 0;
            $mail->isSMTP();
            $mail->Host = $serveurEmail[0]->host;            //  titan: smtp.titan.email, google: smtp.gmail.com
            $mail->SMTPAuth = true;
            $mail->Username = $cabinet[0]->emailFinance;   //  sender username
            $mail->Password = $cabinet[0]->cleFinance;       // sender password
            $mail->SMTPSecure = $serveurEmail[0]->smtpSecure;                  // encryption - ssl/tls
            $mail->Port = $serveurEmail[0]->smtpPort;                        // port - 587/465 titan: 465, titan: 587
            $mail->SMTPOptions = array(
                'ssl' => array(
                    'verify_peer' => false,
                    'verify_peer_name' => false,
                    'allow_self_signed' => true
                )
            );

            $mail->setFrom($cabinet[0]->emailFinance, $cabinet[0]->nomCabinet);
            $mail->addAddress($request->emailFacture);
          


            if ($_FILES['attachment']['tmp_name'][0] != "") {
                for ($i = 0; $i < count($_FILES['attachment']['tmp_name']); $i++) {
                    $mail->addAttachment($_FILES['attachment']['tmp_name'][$i], $_FILES['attachment']['name'][$i]);
                }
            }

            $body = "       
                <div class='container'>
                    <p>Madame/Monsieur</p><br>
                    <p>".$cabinet[0]->nomCabinet." vous remercie de votre confiance et vous prie de trouver en pièce jointe la facture N° ".$clientFacture[0]->idFacture.", pour votre aimable règlement.</p>
                    <p>Dans l'attente recevez nos salutations cordiales.</p>
                    <br><br><br>
                
                    ".$cabinet[0]->signature."
                </div>
        
                ";
                $mail->isHTML(true);                // Set email content format to HTML
                $mail->Subject = $cabinet[0]->nomCabinet.' FACTURE N° ' .$clientFacture[0]->idFacture;
                $mail->CharSet = "UTF-8";
                $mail->Encoding = 'base64';
                $mail->Body = $body;
    
                // $mail->AltBody = plain text version of email body;
    
                if (!$mail->send()) {
                    return back()->with("error", "Message non envoyé ! Réessayez à nouveau.")->withErrors($mail->ErrorInfo);
                    
                } else {
                    
                    DB::update("update factures set notification='envoyer' where slug=?",[$slug]);

                    if (Session::has('idPersonnel')) {
                        foreach (Session::get('idPersonnel') as $Personnel) {
                            $idPersonConnected = $Personnel->idPersonnel;
                        }
                       $admins = DB::select("select * from users where role='Administrateur'");

                    foreach ($admins as $a) {
                        DB::select(
                            'INSERT INTO notifications(categorie, messages, etat, idRecepteur,slug,a_biper,urlName,urlParam,idAdmin) VALUES(?,?,?,?,?,?,?,?,?)',
                            [
                                'Facture',
                                "Une facture a été envoyé au client.",
                                'masquer',
                                'admin',
                                'non',
                                $request->_token . "" . rand(1234, 3458),
                                "facture",
                                $slug,
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
                                'Facture',
                                "Une facture a été envoyé au client.",
                                'masquer',
                                $assistant,
                                'non',
                                $request->_token . "" . rand(1234, 3458),
                                "facture",
                                $slug
                            ]
                        );
                    }
    
                    return back()->with("success", "Facture envoyée avec succès.");
                }
        } catch (Exception $e) {
            

            return back()->with('error', 'Erreur d\'envoie de mail. Veuillez vous assurer que vous êtes connecté à internet et que les emails sont bien configurés dans les paramètres avancés.');
        }

    }

    public function deleteFacture($idFacture)
    {
        DB::update("update factures set statut='Annulée' where idFacture=?",[$idFacture]);
        return redirect()->route('histoFacture')->with('success','Facture annulée avec succès !');
    }

    public function factureFilter(Request $request)
    {
        $dateDebut = strval($request->dateDebut);
        $dateFin = strval($request->dateFin);


        $monnaieParDefaut = DB::select("select monnaieParDefaut from cabinets");
        $GNF = DB::select("select valeurTaux from monnaies where description='GNF'");
        $valeurTauxGNF =  $GNF[0]->valeurTaux;
        $EURO = DB::select("select valeurTaux from monnaies where description='EURO'");
        $valeurTauxEURO =  $EURO[0]->valeurTaux;
        $USD = DB::select("select valeurTaux from monnaies where description='USD'");
        $valeurTauxUSD =  $USD[0]->valeurTaux;
        $FCFA = DB::select("select valeurTaux from monnaies where description='FCFA'");
        $valeurTauxFCFA =  $FCFA[0]->valeurTaux;


        $today = date('Y-m-d');
        DB::select("update factures set statut='En retard' where statut!='Payée' and dateEcheance<?",[$today]);
        $factures = DB::select("select * from clients,affaires,factures where factures.idClient=clients.idClient and factures.idAffaire=affaires.idAffaire and dateFacture BETWEEN '$dateDebut' AND '$dateFin'");
        $TFactures = DB::select("
            SELECT
            SUM(
                CASE
                    WHEN monnaie = 'GNF' THEN montantTTC * $valeurTauxGNF
                    WHEN monnaie = '€' THEN montantTTC * $valeurTauxEURO
                    WHEN monnaie = '$' THEN montantTTC * $valeurTauxUSD
                    WHEN monnaie = 'FCFA' THEN montantTTC * $valeurTauxFCFA
                    ELSE 0 
                END
            ) AS TFactures
        FROM factures
        WHERE dateFacture BETWEEN '$dateDebut' AND '$dateFin'");
        
        $TFacturesPaye = DB::select("
        SELECT
                SUM(
                    CASE
                    WHEN factures.idFacture=paiement_factures.idFacture and monnaie = 'GNF' THEN montantPayer * $valeurTauxGNF
                    WHEN factures.idFacture=paiement_factures.idFacture and monnaie = '€' THEN montantPayer * $valeurTauxEURO
                    WHEN factures.idFacture=paiement_factures.idFacture and monnaie = '$' THEN montantPayer * $valeurTauxUSD
                    WHEN factures.idFacture=paiement_factures.idFacture and monnaie = 'FCFA' THEN montantPayer * $valeurTauxFCFA
                    ELSE 0 
                END
            ) AS TFacturesPaye
             FROM factures,paiement_factures
            WHERE factures.statut = 'Payée' AND dateFacture BETWEEN '$dateDebut' AND '$dateFin'");

        $TFacturesEncours = DB::select("
                SELECT
                SUM(
                    CASE
                        WHEN monnaie = 'GNF' THEN montantTTC * $valeurTauxGNF
                        WHEN monnaie = '€' THEN montantTTC * $valeurTauxEURO
                        WHEN monnaie = '$' THEN montantTTC * $valeurTauxUSD
                        WHEN monnaie = 'FCFA' THEN montantTTC * $valeurTauxFCFA
                        ELSE 0 
                    END
                ) AS TFacturesEncours
            FROM factures
            WHERE statut = 'En cours de paiement'  AND dateFacture BETWEEN '$dateDebut' AND '$dateFin'");

        $TFacturesDue1 = DB::select("
                        SELECT
                    SUM(
                        CASE
                            WHEN monnaie = 'GNF' THEN montantTTC * $valeurTauxGNF
                            WHEN monnaie = '€' THEN montantTTC * $valeurTauxEURO
                            WHEN monnaie = '$' THEN montantTTC * $valeurTauxUSD
                            WHEN monnaie = 'FCFA' THEN montantTTC * $valeurTauxFCFA
                            ELSE 0 
                        END
                    ) AS TFacturesDue
                FROM factures
                WHERE statut = 'En retard'  AND dateFacture BETWEEN '$dateDebut' AND '$dateFin'");
        
        $TFacturesDue2 = DB::select("
                        SELECT
                    SUM(
                        CASE
                            WHEN factures.idFacture=paiement_factures.idFacture and monnaie = 'GNF' THEN montantRestant * $valeurTauxGNF
                            WHEN factures.idFacture=paiement_factures.idFacture and monnaie = '€' THEN montantRestant * $valeurTauxEURO
                            WHEN factures.idFacture=paiement_factures.idFacture and monnaie = '$' THEN montantRestant * $valeurTauxUSD
                            WHEN factures.idFacture=paiement_factures.idFacture and monnaie = 'FCFA' THEN montantRestant * $valeurTauxFCFA
                            ELSE 0 
                        END
                    ) AS TFacturesDue
                FROM factures,paiement_factures 
                WHERE factures.statut = 'En cours de paiement' AND dateFacture BETWEEN '$dateDebut' AND '$dateFin'");


        $TFacturesDue = $TFacturesDue1[0]->TFacturesDue + $TFacturesDue2[0]->TFacturesDue;

        $cabinet = DB::select("select * from cabinets");
        $plan = $cabinet[0]->plan;
            

        return view('facturations.historique',compact('factures','TFactures','TFacturesPaye','TFacturesEncours','TFacturesDue','monnaieParDefaut','dateDebut','dateFin','plan'));
    }

}