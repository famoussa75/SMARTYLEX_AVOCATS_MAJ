<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Auth;
use App\Models\ActeIntroductifs;
use App\Models\AdverseEntreprise;
use App\Models\AdversePersonne;
use App\Models\Affaire;
use App\Models\AssignationAudience;
use App\Models\Assignations;
use App\Models\Audiences;
use App\Models\audienceJoints;
use App\Models\AvocatAdverse;
use App\Models\AvocatParties;
use App\Models\CitationDirectes;
use App\Models\clients;
use App\Models\Contredits;
use App\Models\DeclarationAppels;
use App\Models\EntrepriseAdverse;
use App\Models\Fichiers;
use App\Models\FileAudience;
use App\Models\Oppositions;
use App\Models\OrdonnanceRenvois;
use App\Models\Parties;
use App\Models\Pcpcs;
use App\Models\PersonneAdverse;
use App\Models\Pourvois;
use App\Models\PvInterrogatoires;
use App\Models\Requetes;
use App\Models\Requisitoires;
use App\Models\SuivitAudience;
use App\Models\SuivitAudienceAppel;
use App\Models\Significations;
use App\Models\ProcedureRequete;
use App\Models\PartiesRequetes;
use App\Models\AvocatPartiesRequetes;
use App\Models\PersonneAdversesRequetes;
use App\Models\EntrepriseAdversesRequetes;
use App\Models\SuivitRequete;
use App\Models\RequeteLiers;
use App\Models\ContraditoiresLiers;
use App\Models\ProcedureLiers;
use App\Models\Citations;
use App\Models\AutreActes;
use Illuminate\Http\Request;
use DateTime;
use Illuminate\Support\Facades\DB;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

use Illuminate\Support\Facades\Log;



class AudiencesController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */


    // ========== [ Compose Email ] ================
    public function sendMail(Request $request)
    {
        $cabinet = DB::select("select * from cabinets"); 
        $serveurEmail = DB::select("select * from serveur_mails");
       
        require base_path("vendor/autoload.php");
        $mail = new PHPMailer(true);     // Passing `true` enables exceptions

        try {

            // Email server settings
            $mail->SMTPDebug = 0;
            $mail->isSMTP();
            $mail->Host = $serveurEmail[0]->host;           //  smtp host
            $mail->SMTPAuth = true;
            $mail->Username = $cabinet[0]->emailAudience;   //  sender username
            $mail->Password = $cabinet[0]->cleAudience;       // sender password
            $mail->SMTPSecure = $serveurEmail[0]->smtpSecure;                  // encryption - ssl/tls
            $mail->Port = $serveurEmail[0]->smtpPort;                        // port - 587/465
            $mail->SMTPOptions = array(
                'ssl' => array(
                    'verify_peer' => false,
                    'verify_peer_name' => false,
                    'allow_self_signed' => true
                )
            );

            $mail->setFrom($cabinet[0]->emailAudience, $cabinet[0]->nomCabinet);
            $mail->addAddress($request->input('email'));
            // dd($request->input('email'));
            if (!empty($request->input('emails'))) {
                for ($i = 0; $i < count($_POST['emails']); $i++) {
                    $mail->addCC($_POST['emails'][$i]);
                }
            }

            $apiKey = 'aACHmfSPkxd4TBsJvWXFj'; // Remplacez par votre clé API EmailListVerify
            $recipientEmail = $request->input('email');
            
            // Encoder l'email pour éviter les problèmes avec des caractères spéciaux
            $encodedEmail = urlencode($recipientEmail);
            
            $url = "https://apps.emaillistverify.com/api/verifyEmail?secret=$apiKey&email=$encodedEmail";
            
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // À activer en production si vous avez un certificat SSL valide
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
            
            $response = curl_exec($ch);
            
            if (curl_errno($ch)) {
                $error_msg = curl_error($ch);
                curl_close($ch);
                return back()->with("error", "Erreur cURL : $error_msg");
            }
            
            curl_close($ch);
            
            // Vérifiez si la réponse est 'ok' ou 'fail'
            if (trim($response) === 'ok' || trim($response) === 'risk' || trim($response) === 'ok_for_all') {
                // L'email est valide ou risqué → poursuivre l'envoi
            } else {
                return back()->with("error", "Adresse e-mail invalide : $recipientEmail");
            }
            
            
            
            // Vérification des adresses CC avec EmailListVerify
            if ($request->has('emails') && is_array($request->input('emails'))) {
                foreach ($request->input('emails') as $email) {
                    $email = trim($email); // Nettoyer les espaces blancs

                    if (!empty($email)) {
                        // Vérifier l'email avec EmailListVerify
                        $apiKey = 'aACHmfSPkxd4TBsJvWXFj'; // Remplacez par votre clé API
                        $encodedEmail = urlencode($email); // Encoder l'email pour éviter les problèmes d'URL
                        $ccUrl = "https://apps.emaillistverify.com/api/verifyEmail?secret=$apiKey&email=$encodedEmail";

                        // Appeler l'API avec cURL
                        $ch = curl_init();
                        curl_setopt($ch, CURLOPT_URL, $ccUrl);
                        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // Désactiver la vérif SSL (à activer en prod)
                        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);

                        $ccResponse = curl_exec($ch);

                        if (curl_errno($ch)) {
                            $error_msg = curl_error($ch);
                            curl_close($ch);
                            return back()->with("error", "Erreur cURL lors de la vérification de l'email : $error_msg");
                        }

                        curl_close($ch);

                        // Vérifier la réponse de l'API
                        if (trim($response) === 'ok' || trim($response) === 'risk' || trim($response) === 'ok_for_all') {
                            $mail->addCC($email); // Ajouter l'email en CC si valide
                        } else {
                            return back()->with("error", "Adresse e-mail CC invalide : $email");
                        }
                    }
                }
            }





            if ($_FILES['attachment']['tmp_name'][0] != "") {
                for ($i = 0; $i < count($_FILES['attachment']['tmp_name']); $i++) {
                    $mail->addAttachment($_FILES['attachment']['tmp_name'][$i], $_FILES['attachment']['name'][$i]);
                }
            }

            $juridiction = $request->input('juridiction');
            $dateAudience = $request->input('dateAudience');
            $idAudience = $request->input('idAudience');
            $parties = $request->input('parties');
            $objetAudience = $request->input('objetAudience');
            $decision = $request->input('decision');
            $affaire = $request->input('affaire');
            $commentaire = $request->input('commentaire');

           
            if ($cabinet[0]->nomCabinet=='ASK AVOCATS') {
               
                $body = "
           
                <div class='container'>
                        <p>Madame/Monsieur</p><br>
                        <p>".$cabinet[0]->nomCabinet." vous informe :</p>
                        <ul>
                        <li>&nbsp;<b>Juridiction :</b> $juridiction </li>                        
                        <li>&nbsp;<b>Audience du :</b> $dateAudience </li>
                        <li>&nbsp;<b>Parties :</b> $parties </li>
                        <li>&nbsp;<b>Objet :</b> $objetAudience </li>
                        <li>&nbsp;<b>Décision :</b> $decision </li>
                        <li>&nbsp;<b>Affaire :</b> $affaire </li>
                        </ul>
                        <p>$commentaire .</p>
                      
                        <p>N'hesitez pas à nous contacter pour toute précision complémentaire.</p>
                       
                        <ul>
                        <li>&nbsp;<b>Maître Jonas KOUROUMA </b> Tel: +224 623 20 70 63 / Email: jkourouma@ask-avocats.com </li>                        
                        <li>&nbsp;<b>Amara CISSE </b> Tel: +224 612 12 50 02 / Email: acisse@ask-avocats.com </li>                        
                        <li>&nbsp;<b>Sayon OULARE </b> Tel: +224 612 12 50 01 / Email: sayonoulare@ask-avocats.com </li>                        
                        <li>&nbsp;<b>Karamo Oulen TOURE </b> Tel: +224 612 12 50 07 / Email: ktoure@ask-avocats.com </li> 
                        </ul>
                        <br><br>
                        <p>Cordialement</p><br/><br/><br/>
                        ".$cabinet[0]->signature."
                    
                      
                     </div>
              
                ";
            } else {
                $body = "
           
                <div class='container'>
                    <p>Madame/Monsieur</p><br>
                    <p>".$cabinet[0]->nomCabinet." vous informe :</p>
                    <ul>
                    <li>&nbsp;<b>Juridiction :</b> $juridiction </li>                        
                    <li>&nbsp;<b>Audience du :</b> $dateAudience </li>
                    <li>&nbsp;<b>Parties :</b> $parties </li>
                    <li>&nbsp;<b>Objet :</b> $objetAudience </li>
                    <li>&nbsp;<b>Décision :</b> $decision </li>
                    <li>&nbsp;<b>Affaire :</b> $affaire </li>
                    </ul>
                    <p>$commentaire .</p>
                
                    <p>N'hesitez pas à nous contacter pour toute précision complémentaire.</p>
                    <br><br>
                    <p>Cordialement</p><br/><br/><br/>
                
                    ".$cabinet[0]->signature."
                </div>
        
                ";
            }
            

            $mail->isHTML(true);                // Set email content format to HTML
            $mail->Subject = 'Compte rendu d\'audience - ' . $parties;
            $mail->CharSet = "UTF-8";
            $mail->Encoding = 'base64';
            $mail->Body = $body;

            // $mail->AltBody = plain text version of email body;

            if (!$mail->send()) {
                return back()->with("error", "Message non envoyé ! Réessayez à nouveau.")->withErrors($mail->ErrorInfo);
                
            } else {
                
                $idSuivit = $request->idSuivit;
                $idSuivitAppel = $request->idSuivitAppel;

                if (!empty($idSuivit)) {
                    DB::update("update suivit_audiences set email='envoyer' where idSuivit=?", [$idSuivit]);
                } 

                if (!empty($idSuivitAppel)) {
                    DB::update("update suivit_audience_appels set email='envoyer' where idSuivitAppel=?", [$idSuivitAppel]);
                }


                return back()->with("success", "Email envoyé avec succès...");
            }
        } catch (Exception $e) {
           
            dd($e);
            return back()->with('error', 'Erreur d\'envoie de mail. Veuillez vous assurer que vous êtes connecté à internet et que les emails sont bien configurés dans les paramètres avancés.');
        }
    }


    // ========== [ Formulaire de creation d'audience ] ================
    public function audiences()
    {
        // Recuperation des clients dans la base de donnees
       // Récuperation de l'ensemble des clients dans la base de donnees'
       if (Auth::user()->role=='Collaborateur') {
            $clients = DB::table('clients')
            ->join('affectation_personnels', 'clients.idClient', '=', 'affectation_personnels.idClient')
            ->join('personnels', 'affectation_personnels.idPersonnel', '=', 'personnels.idPersonnel')
            ->where('personnels.email', Auth::user()->email)
            ->select('clients.*')
            ->get();        
        }else {
            $clients = DB::select('select * from clients');
        }
        $avocats = DB::select('select * from avocats');
        $huissiers = DB::select('select * from huissiers');
        $juriductions = DB::select('select * from juriductions');
        return view('audiences.audienceForm', compact('clients', 'avocats', 'huissiers', 'juriductions'));
    }

    public function audienceNewLevel($slug, $idAudience)
    {
        // Recuperation des clients dans la base de donnees
       // Récuperation de l'ensemble des clients dans la base de donnees'
       if (Auth::user()->role=='Collaborateur') {
            $clients = DB::table('clients')
            ->join('affectation_personnels', 'clients.idClient', '=', 'affectation_personnels.idClient')
            ->join('personnels', 'affectation_personnels.idPersonnel', '=', 'personnels.idPersonnel')
            ->where('personnels.email', Auth::user()->email)
            ->select('clients.*')
            ->get();        
        }else {
            $clients = DB::select('select * from clients');
        }
        $avocats = DB::select('select * from avocats');
        $huissiers = DB::select('select * from huissiers');
        $juriductions = DB::select('select * from juriductions');
        $audiencePrecedent = DB::select("select * from audiences where idAudience=?", [$idAudience]);
        $natureActions = DB::select('select * from nature_actions');

        $avocatsParties = DB::select("select * from avocat_parties,avocats where avocat_parties.idAvocat=avocats.idAvc ");

        $cabinet =  DB::select("select parties.idPartie,nom,prenom,email,emailEntreprise,affaires.slug as affaireslug,nomAffaire,affaires.idAffaire,denomination,clients.slug as clientslug,clients.idClient,role from parties,clients,affaires where parties.idClient=clients.idClient and parties.idAffaire=affaires.idAffaire and idAudience=? ", [$idAudience]);

        $personne_adverses = DB::select("select * from personne_adverses,parties where parties.idPartie=personne_adverses.idPartie and parties.idAudience=?", [$idAudience]);

        $entreprise_adverses = DB::select("select * from entreprise_adverses,parties where parties.idPartie=entreprise_adverses.idPartie and parties.idAudience=?", [$idAudience]);

        return view('audiences.audienceNewLevel', compact('clients', 'avocats', 'huissiers', 'juriductions', 'audiencePrecedent', 'cabinet', 'personne_adverses', 'entreprise_adverses', 'avocatsParties','natureActions'));
    }

    public function premiereInstanceCivile()
    {
        // Recuperation des clients dans la base de donnees
       // Récuperation de l'ensemble des clients dans la base de donnees'
       if (Auth::user()->role=='Collaborateur') {
            $clients = DB::table('clients')
            ->join('affectation_personnels', 'clients.idClient', '=', 'affectation_personnels.idClient')
            ->join('personnels', 'affectation_personnels.idPersonnel', '=', 'personnels.idPersonnel')
            ->where('personnels.email', Auth::user()->email)
            ->select('clients.*')
            ->get();        
        }else {
            $clients = DB::select('select * from clients');
        }
        $avocats = DB::select('select * from avocats');
        $huissiers = DB::select('select * from huissiers');
        $juriductions = DB::select('select * from juriductions');
        return view('audiences.formAudiences.premiereInstanceCivile', compact('clients', 'avocats', 'huissiers', 'juriductions'));
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

    public function filtreAudience(Request $request)
    {

        //WHERE dateFacture BETWEEN '$dateDebut' AND '$dateFin'"
        $dateDebut = strval($request->dateDebut);
        $dateFin = strval($request->dateFin);
        $typeListe = "filtrer";

        $cabinet =  DB::select("select parties.idPartie,nom,prenom,email,emailEntreprise,affaires.slug as affaireslug,nomAffaire,affaires.idAffaire,denomination,clients.slug as clientslug,clients.idClient,role,autreRole,idAudience from parties,clients,affaires where parties.idClient=clients.idClient and parties.idAffaire=affaires.idAffaire");

        $personne_adverses = DB::select("select * from personne_adverses,parties where parties.idPartie=personne_adverses.idPartie");

        $entreprise_adverses = DB::select("select * from entreprise_adverses,parties where parties.idPartie=entreprise_adverses.idPartie");

        $autreRoles = DB::select("select * from parties,audiences where audiences.idAudience=parties.idAudience");

        $audiences = DB::select("
                SELECT DISTINCT
                    objet,
                    niveauProcedural,
                    dateProchaineAudience AS dateAudience,
                    audiences.idAudience,
                    audiences.slug AS slug,
                    audiences.numRg,
                    audiences.slug AS slugAud,
                    audiences.prochaineAudience,
                    audiences.heure,
                    audiences.statut AS statutAud
                FROM 
                    audiences
                INNER JOIN 
                    suivit_audiences ON audiences.idAudience = suivit_audiences.idAudience
                WHERE 
                    dateProchaineAudience  BETWEEN ? AND ?
                
                UNION
                
                SELECT DISTINCT
                    objet,
                    niveauProcedural,
                    dateLimite AS dateAudience,
                    audiences.idAudience,
                    audiences.slug AS slug,
                    audiences.numRg,
                    audiences.slug AS slugAud,
                    audiences.prochaineAudience,
                    audiences.heure,
                    audiences.statut AS statutAud
                FROM 
                    audiences
                INNER JOIN 
                    suivit_audience_appels ON audiences.idAudience = suivit_audience_appels.idAudience
                WHERE 
                    dateLimite BETWEEN ? AND ?
                
                UNION
                
                SELECT DISTINCT
                    objet,
                    niveauProcedural,
                    datePremiereComp AS dateAudience,
                    audiences.idAudience,
                    audiences.slug AS slug,
                    audiences.numRg,
                    audiences.slug AS slugAud,
                    audiences.prochaineAudience,
                    audiences.heure,
                    audiences.statut AS statutAud
                FROM 
                    audiences
                INNER JOIN 
                    acte_introductifs ON audiences.idAudience = acte_introductifs.idAudience
                INNER JOIN 
                    assignations ON acte_introductifs.idActe = assignations.idActe
                WHERE 
                    datePremiereComp BETWEEN ? AND ?
                
                ORDER BY 
                    dateAudience
            ", [
                $dateDebut, $dateFin,  // Pour dateProchaineAudience
                $dateDebut, $dateFin,  // Pour dateLimite
                $dateDebut, $dateFin   // Pour datePremiereComp
            ]);


        $formattedAudiences = $this->getAudienceData($audiences, $cabinet, $personne_adverses, $entreprise_adverses, $autreRoles);
        
        

        // dump($data);
        return view('audiences.allAudiences', compact('formattedAudiences', 'cabinet', 'entreprise_adverses', 'personne_adverses','autreRoles','typeListe','dateDebut','dateFin'));
    }


    
    
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($typeListe)
    {
        // recuperation des informations audiences

        $today = date("Y-m-d");
       

        if ($typeListe=='a_venir') {

            // Forcer la locale en anglais pour DateTime
            setlocale(LC_TIME, 'en_US.UTF-8');

            // Calcul des dates de début et de fin avec heure précise pour la période de vendredi à vendredi
            $now = new DateTime();
            $dernierVendredi = (clone $now)->modify('last friday')->format('Y-m-d') . ' 12:00:00';
            $prochainVendredi = (clone $now)->modify('next friday')->format('Y-m-d') . ' 11:59:59';




        $audiences = DB::select("
            SELECT DISTINCT
                objet,
                niveauProcedural,
                dateProchaineAudience AS dateAudience,
                audiences.idAudience,
                audiences.slug AS slug,
                audiences.numRg,
                audiences.slug AS slugAud,
                audiences.prochaineAudience,
                audiences.heure,
                audiences.statut AS statutAud
            FROM 
                audiences
            INNER JOIN 
                suivit_audiences ON audiences.idAudience = suivit_audiences.idAudience
            WHERE 
                CONCAT(dateProchaineAudience, ' ', COALESCE(audiences.heure, '00:00:00')) BETWEEN ? AND ?

            UNION

            SELECT DISTINCT
                objet,
                niveauProcedural,
                dateLimite AS dateAudience,
                audiences.idAudience,
                audiences.slug AS slug,
                audiences.numRg,
                audiences.slug AS slugAud,
                audiences.prochaineAudience,
                audiences.heure,
                audiences.statut AS statutAud
            FROM 
                audiences
            INNER JOIN 
                suivit_audience_appels ON audiences.idAudience = suivit_audience_appels.idAudience
            WHERE 
                CONCAT(dateLimite, ' ', COALESCE(audiences.heure, '00:00:00')) BETWEEN ? AND ?

            UNION

            SELECT DISTINCT
                objet,
                niveauProcedural,
                datePremiereComp AS dateAudience,
                audiences.idAudience,
                audiences.slug AS slug,
                audiences.numRg,
                audiences.slug AS slugAud,
                audiences.prochaineAudience,
                audiences.heure,
                audiences.statut AS statutAud
            FROM 
                audiences
            INNER JOIN 
                acte_introductifs ON audiences.idAudience = acte_introductifs.idAudience
            INNER JOIN 
                assignations ON acte_introductifs.idActe = assignations.idActe
            WHERE 
                CONCAT(datePremiereComp, ' ', COALESCE(audiences.heure, '00:00:00')) BETWEEN ? AND ?

            ORDER BY 
            dateAudience
        ", [
            $dernierVendredi, $prochainVendredi,  // Pour dateProchaineAudience
            $dernierVendredi, $prochainVendredi,  // Pour dateLimite
            $dernierVendredi, $prochainVendredi   // Pour datePremiereComp
        ]);

            
        $dernierVendredi = new DateTime('last friday');
        $dateDernierVendredi = $dernierVendredi->format('Y-m-d');
        
        // Date du vendredi suivant sans heure
        $prochainVendredi = new DateTime('next friday');
        $dateProchainVendredi = $prochainVendredi->format('Y-m-d');





        }else {
            $audiences = DB::select("SELECT idAudience,subquery.numRg, subquery.objet, subquery.niveauProcedural, subquery.slugAud, subquery.statutAud, isChild, prochaineAudience 
            FROM (
                SELECT MAX(idAudience) as idAudience, MAX(numRg) as numRg, MAX(objet) as objet, MAX(niveauProcedural) as niveauProcedural, slugAud, statutAud, MAX(isChild) as isChild, MAX(prochaineAudience) as prochaineAudience
                FROM (
                    SELECT  audiences.idAudience, audiences.slug AS slugAud, numRg, objet, niveauProcedural, prenom, nom, denomination, NULL as numRccm, NULL as formeLegal, audiences.statut as statutAud, audiences.isChild, audiences.prochaineAudience
                    FROM audiences
                    JOIN parties ON audiences.idAudience = parties.idAudience
                    LEFT JOIN clients ON parties.idClient = clients.idClient
            
                    UNION
            
                    SELECT audiences.idAudience, audiences.slug AS slugAud, numRg, objet, niveauProcedural, prenom, nom, NULL as denomination, NULL as numRccm, NULL as formeLegal, audiences.statut as statutAud, audiences.isChild, audiences.prochaineAudience
                    FROM audiences
                    JOIN parties ON audiences.idAudience = parties.idAudience
                    JOIN personne_adverses ON parties.idPartie = personne_adverses.idPartie
            
                    UNION
            
                    SELECT audiences.idAudience, audiences.slug AS slugAud, numRg, objet, niveauProcedural, NULL as prenom, NULL as nom, denomination, numRccm, formeLegal, audiences.statut as statutAud, audiences.isChild, audiences.prochaineAudience
                    FROM audiences
                    JOIN parties ON audiences.idAudience = parties.idAudience
                    JOIN entreprise_adverses ON parties.idPartie = entreprise_adverses.idPartie
                ) AS subquery_internal
                GROUP BY subquery_internal.slugAud,subquery_internal.statutAud
            ) AS subquery
            WHERE isChild is null or isChild!='oui'
            ORDER BY idAudience ASC");

            $dateDernierVendredi = '';
            $dateProchainVendredi = '';
        }
       

        $cabinet =  DB::select("select parties.idPartie,nom,prenom,email,emailEntreprise,affaires.slug as affaireslug,nomAffaire,affaires.idAffaire,denomination,clients.slug as clientslug,clients.idClient,role,autreRole,idAudience from parties,clients,affaires where parties.idClient=clients.idClient and parties.idAffaire=affaires.idAffaire");

        $personne_adverses = DB::select("select * from personne_adverses,parties where parties.idPartie=personne_adverses.idPartie");

        $entreprise_adverses = DB::select("select * from entreprise_adverses,parties where parties.idPartie=entreprise_adverses.idPartie");

        $autreRoles = DB::select("select * from parties,audiences where audiences.idAudience=parties.idAudience");

        $formattedAudiences = $this->getAudienceData($audiences, $cabinet, $personne_adverses, $entreprise_adverses, $autreRoles);

        $date = date('Y-m-d');

        return view('audiences.allAudiences', compact('audiences', 'cabinet', 'entreprise_adverses', 'personne_adverses','autreRoles','typeListe','dateDernierVendredi','dateProchainVendredi', 'formattedAudiences'));
    }

    /**
     * Afficher the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function listRequetes(Request $request)
    {
       $requetes = DB::select("select * from procedure_requetes");
       $personne_adverses = DB::select("select * from personne_adverses_requetes,parties_requetes where parties_requetes.idPartie=personne_adverses_requetes.idPartie");
       $entreprise_adverses = DB::select("select * from entreprise_adverses_requetes,parties_requetes where parties_requetes.idPartie=entreprise_adverses_requetes.idPartie");
       $autreRoles = DB::select("select * from parties_requetes,procedure_requetes where procedure_requetes.idProcedure=parties_requetes.idRequete");
       $cabinet =  DB::select("select parties_requetes.idRequete,parties_requetes.idPartie,nom,prenom,email,emailEntreprise,affaires.slug as affaireslug,nomAffaire,affaires.idAffaire,denomination,clients.slug as clientslug,clients.idClient,role from parties_requetes,clients,affaires where parties_requetes.idClient=clients.idClient and parties_requetes.idAffaire=affaires.idAffaire");

       $date = date('d-m-Y');

       return view('audiences.allRequetes',compact('requetes','personne_adverses','entreprise_adverses','autreRoles','cabinet'));
    }

    public function detailRequete($slug)
    {
        $requete = DB::select("select * from procedure_requetes,juriductions where procedure_requetes.juridiction=juriductions.id and procedure_requetes.slug=?", [$slug]);
        $cabinet =  DB::select("select parties_requetes.idPartie,nom,prenom,email,emailEntreprise,affaires.slug as affaireslug,nomAffaire,affaires.idAffaire,denomination,clients.slug as clientslug,clients.idClient,role,autreRole from parties_requetes,clients,affaires where parties_requetes.idClient=clients.idClient and parties_requetes.idAffaire=affaires.idAffaire and idRequete=? ", [$requete[0]->idProcedure]);
        $pieceREQ = DB::select("select * from fichiers where slugSource=?", [$requete[0]->slug]);
        $parties = DB::select("select * from parties_requetes  where  idRequete=?", [$requete[0]->idProcedure]);

        $avocats = DB::select("select * from avocat_parties_requetes,avocats where avocat_parties_requetes.idAvocat=avocats.idAvc");
        $paramCabinet = DB::select("select * from cabinets");

        $personne_adverses = DB::select("select * from personne_adverses_requetes,parties_requetes where parties_requetes.idPartie=personne_adverses_requetes.idPartie and parties_requetes.idRequete=?", [$requete[0]->idProcedure]);
        $entreprise_adverses = DB::select("select * from entreprise_adverses_requetes,parties_requetes where parties_requetes.idPartie=entreprise_adverses_requetes.idPartie and parties_requetes.idRequete=?", [$requete[0]->idProcedure]);
        $autreRoles = DB::select("select * from parties_requetes,procedure_requetes where procedure_requetes.idProcedure=parties_requetes.idRequete and parties_requetes.idRequete=?", [$requete[0]->idProcedure]);

        $pieceSupplement = DB::select("select * from fichiers where slugSource=?", [$requete[0]->slug]);

        $suiviRequete = DB::select("select * from suivit_requetes where idRequete=?",[$requete[0]->idProcedure]);
        $pieceOrd = DB::select("select * from fichiers");

        $requeteLiers = DB::select("select * from requete_liers,procedure_requetes where requete_liers.requete=procedure_requetes.idProcedure and requete_liers.slugProcedure=?",[$requete[0]->slug]);

        $requeteClientFetch = DB::select("select * from procedure_requetes, parties_requetes where procedure_requetes.idProcedure=parties_requetes.idRequete and parties_requetes.idClient=?",[$cabinet[0]->idClient]);
        //Update de notification
        $email = Auth::user()->email;
        $personnel = DB::select('select * from personnels where email=? ', [$email]);

        foreach ($suiviRequete as $key => $value) {

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


        foreach ($requete as $key => $value) {

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

        $SqltacheSuivit = DB::select(" SELECT taches.idSuivitRequete,taches.slug,suivit_requetes.idSuivit FROM taches JOIN suivit_requetes ON suivit_requetes.idSuivit = taches.idSuivitRequete ");
        $tacheSuivit = collect($SqltacheSuivit)->pluck('idSuivit')->toArray();

        $clients = DB::select('select * from clients');

        $requete_requete = DB::select("SELECT * FROM procedure_liers,procedure_requetes WHERE typeProcedure ='requete' and procedure_liers.slugProcedure=procedure_requetes.slug and  COALESCE(procedure_liers.slugSource, procedure_liers.slugProcedure) = ?",[$slug]);

       // $requete_contraditoire = DB::select("SELECT procedure_liers.*,procedure_liers.typeProcedure as Procedure ,audiences.* FROM procedure_liers,audiences WHERE procedure_liers.typeProcedure ='audience' and procedure_liers.slugProcedure=audiences.slug and  COALESCE(procedure_liers.slugSource, procedure_liers.slugProcedure) = ?",[$slug]);
     

        $slug = $requete[0]->slug;

        $requete_contraditoire_partie = DB::select("SELECT * FROM clients ,parties, procedure_requetes, audiences, procedure_liers where  procedure_liers.slugSource = procedure_requetes.slug and  clients.idClient = parties.idClient 
        and parties.idAudience = audiences.idAudience and procedure_liers.typeProcedure ='audience' and procedure_liers.slugProcedure = audiences.slug and procedure_liers.slugSource =? ",[$slug]) ;

       
       // dd($requete_contraditoire_partie);

        $requete_contraditoire_entreprise_adverses = DB::select("SELECT * FROM entreprise_adverses,parties, procedure_requetes, audiences, procedure_liers where  procedure_liers.slugSource = procedure_requetes.slug 
        and entreprise_adverses.idPartie = parties.idPartie and procedure_liers.typeProcedure ='audience' and  parties.idAudience = audiences.idAudience and procedure_liers.slugProcedure = audiences.slug and procedure_liers.slugSource =? ",[$slug]) ;

        $requete_contraditoire_presonne_adverses = DB::select("SELECT * FROM personne_adverses,parties, procedure_requetes, audiences, procedure_liers where  procedure_liers.slugSource = procedure_requetes.slug 
        and personne_adverses.idPartie = parties.idPartie and procedure_liers.typeProcedure ='audience' and  parties.idAudience = audiences.idAudience and procedure_liers.slugProcedure = audiences.slug and procedure_liers.slugSource =? ",[$slug]) ;

        //dd("contraditoire",$requete_contraditoire_partie,"requete",$requete_contraditoire_entreprise_adverses);

        //dd($requete_contraditoire_presonne_adverses);

       

       


        // audience

        $audience_contraditoire = DB::select("SELECT * FROM audiences,procedure_liers where procedure_liers.typeProcedure='requete' and procedure_liers.slugSource = audiences.slug and  procedure_liers.slugProcedure =? ",[$slug] );

        $audience_contraditoire_client = DB::select("SELECT * FROM audiences, parties, procedure_liers,clients where procedure_liers.typeProcedure = 'requete' and procedure_liers.slugSource = audiences.slug and parties.idAudience = audiences.idAudience 
        and clients.idClient = parties.idClient and procedure_liers.slugProcedure =?",[$slug]);

        //dd($audience_contraditoire,$audience_contraditoire_client);

      
        $audience_contraditoire_personne_adverses = DB::select("SELECT * FROM audiences, parties,personne_adverses, procedure_liers where procedure_liers.typeProcedure = 'requete' and personne_adverses.idPartie = parties.idPartie and 
        procedure_liers.slugSource = audiences.slug and parties.idAudience = audiences.idAudience  and  procedure_liers.slugProcedure =?",[$slug]);
        //dd($audience_contraditoire_personne_adverses);



        $audience_contraditoire_entreprise_adverses = DB::select("SELECT * FROM audiences, parties,entreprise_adverses, procedure_liers where procedure_liers.typeProcedure = 'requete' and entreprise_adverses.idPartie = parties.idPartie and 
        procedure_liers.slugSource = audiences.slug and parties.idAudience = audiences.idAudience  and  procedure_liers.slugProcedure =?",[$slug]);
       // dd($audience_contraditoire_entreprise_adverses);



        $audience_contraditoire_entreprise_adverses2 = DB::select("SELECT * FROM audiences, parties,entreprise_adverses, procedure_liers where procedure_liers.typeProcedure = 'audience' and entreprise_adverses.idPartie = parties.idPartie and 
        procedure_liers.slugProcedure = audiences.slug and parties.idAudience = audiences.idAudience  and  procedure_liers.slugSource =?",[$slug]);
       // dd($audience_contraditoire_entreprise_adverses2);

        $audience_contraditoire2 = DB::select("SELECT * FROM audiences,procedure_liers where procedure_liers.typeProcedure='audience' and procedure_liers.slugProcedure = audiences.slug and  procedure_liers.slugSource =? ",[$slug] );
        //dd($audience_contraditoire2);

        $audience_contraditoire_client2 = DB::select("SELECT * FROM audiences, parties, procedure_liers,clients where procedure_liers.typeProcedure = 'audience' and procedure_liers.slugProcedure = audiences.slug and parties.idAudience = audiences.idAudience 
        and clients.idClient = parties.idClient and procedure_liers.slugSource =?",[$slug]);
        //dd($audience_contraditoire_client2);

        $audience_contraditoire_personne_adverses2 = DB::select("SELECT * FROM audiences, parties,personne_adverses, procedure_liers where procedure_liers.typeProcedure = 'audience' and personne_adverses.idPartie = parties.idPartie and 
        procedure_liers.slugProcedure = audiences.slug and parties.idAudience = audiences.idAudience  and  procedure_liers.slugSource =?",[$slug]);
        //dd($audience_contraditoire_personne_adverses2);



        // requete 

        $procedure_requete = DB::select("SELECT * FROM procedure_liers,procedure_requetes where procedure_liers.typeProcedure = 'requete' and procedure_liers.slugProcedure = procedure_requetes.slug and  procedure_liers.slugSource = ? ",[$slug]);
        //dd($procedure_requete);

       $procedure_requete_client = DB::select("SELECT * FROM procedure_requetes, parties_requetes, procedure_liers,clients where procedure_liers.typeProcedure = 'requete' and procedure_liers.slugProcedure = procedure_requetes.slug and parties_requetes.idRequete = procedure_requetes.idProcedure 
        and clients.idClient = parties_requetes.idClient and procedure_liers.slugSource =?",[$slug]);
        
        // dd($audience_contraditoire_client);

        $procedure_requete_personne_adverses = DB::select("SELECT * FROM procedure_requetes, parties_requetes,personne_adverses_requetes, procedure_liers where procedure_liers.typeProcedure = 'requete' and personne_adverses_requetes.idPartie = parties_requetes.idPartie and 
        procedure_liers.slugProcedure = procedure_requetes.slug and parties_requetes.idRequete = procedure_requetes.idProcedure  and  procedure_liers.slugSource =?",[$slug]);
        //dd($procedure_requete_personne_adverses);

        $procedure_requete_entreprise_adverses_requete = DB::select("SELECT * FROM procedure_liers, parties_requetes,entreprise_adverses_requetes, procedure_requetes where procedure_liers.typeProcedure = 'requete' and entreprise_adverses_requetes.idPartie = parties_requetes.idPartie and 
        procedure_liers.slugProcedure = procedure_requetes.slug and parties_requetes.idRequete = procedure_requetes.idProcedure  and  procedure_liers.slugSource =?",[$slug]);
        //dd($procedure_requete_entreprise_adverses_requete);


        $procedure_requete2 = DB::select("SELECT * FROM procedure_liers,procedure_requetes where procedure_liers.typeProcedure = 'requete' and procedure_liers.slugSource = procedure_requetes.slug and  procedure_liers.slugProcedure = ? ",[$slug]);
        //dd($procedure_requete2);
        
        $procedure_requete_entreprise_adverses_requete2 = DB::select("SELECT * FROM procedure_liers, parties_requetes,entreprise_adverses_requetes, procedure_requetes where procedure_liers.typeProcedure = 'requete' and entreprise_adverses_requetes.idPartie = parties_requetes.idPartie and 
        procedure_liers.slugSource = procedure_requetes.slug and parties_requetes.idRequete = procedure_requetes.idProcedure  and  procedure_liers.slugProcedure =?",[$slug]);
        //dd($procedure_requete_entreprise_adverses_requete);

        $procedure_requete_client2 = DB::select("SELECT * FROM procedure_requetes, parties_requetes, procedure_liers,clients where procedure_liers.typeProcedure = 'requete' and procedure_liers.slugSource = procedure_requetes.slug and parties_requetes.idRequete = procedure_requetes.idProcedure 
        and clients.idClient = parties_requetes.idClient and procedure_liers.slugProcedure =?",[$slug]);
       // dd($procedure_requete_client2);

       $procedure_requete_personne_adverses_requete2 = DB::select("SELECT * FROM procedure_liers, parties_requetes,personne_adverses_requetes, procedure_requetes where procedure_liers.typeProcedure = 'requete' and personne_adverses_requetes.idPartie = parties_requetes.idPartie and 
       procedure_liers.slugSource = procedure_requetes.slug and parties_requetes.idRequete = procedure_requetes.idProcedure  and  procedure_liers.slugProcedure =?",[$slug]);
       //dd($procedure_requete_personne_adverses_requete2);



       $procedure_autreRole = DB::select("SELECT * From audiences, parties ,procedure_liers where  audiences.idAudience = parties.idAudience and procedure_liers.slugProcedure = audiences.slug  and parties.role = 'Autre'");

       $procedure_autreRole1 = DB::select("SELECT * From audiences, parties ,procedure_liers where  audiences.idAudience = parties.idAudience and procedure_liers.slugSource = audiences.slug  and parties.role = 'Autre'");
       //dd($procedure_autreRole);



       $requete_autreRole = DB::select("SELECT * From procedure_requetes, parties_requetes ,procedure_liers where  procedure_requetes.idProcedure = parties_requetes.idRequete and procedure_liers.slugProcedure = procedure_requetes.slug  and parties_requetes.role = 'Autre'");

       $procedure_autreRole1 = DB::select("SELECT * From procedure_requetes, parties_requetes ,procedure_liers where  procedure_requetes.idProcedure = parties_requetes.idRequete and procedure_liers.slugSource = procedure_requetes.slug  and parties_requetes.role = 'Autre'");


       //dd($requete_autreRole);




       return view('audiences.infosRequete',compact('requete','cabinet','pieceREQ','avocats','cabinet','paramCabinet','personne_adverses','entreprise_adverses','autreRoles','pieceSupplement','suiviRequete','pieceOrd','requeteLiers','requeteClientFetch','tacheSuivit','clients',
       'requete_requete','procedure_requete','requete_contraditoire_entreprise_adverses','requete_contraditoire_partie','requete_contraditoire_presonne_adverses','audience_contraditoire','audience_contraditoire_client','audience_contraditoire_personne_adverses',
       'audience_contraditoire_entreprise_adverses','audience_contraditoire_entreprise_adverses2','audience_contraditoire2','audience_contraditoire_client2','audience_contraditoire_personne_adverses2','procedure_requete_client','procedure_requete_entreprise_adverses_requete','procedure_requete_personne_adverses',
        'procedure_requete2','procedure_requete_entreprise_adverses_requete','procedure_requete_entreprise_adverses_requete2','procedure_requete_client2','procedure_requete_personne_adverses_requete2','procedure_autreRole1','procedure_autreRole',
        'requete_autreRole','procedure_autreRole1'));
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
  
            $TYPE_ADVERSE = ['Entreprise', 'Personne physique'];

            $today = date('Y-m-d');
    
            // L'instance du model FileAudience'
            $fichiers = new Fichiers();
    
    
    
            if ($request) {

    
                $messages = [
                    'juridiction.required' => 'Le champ juridiction est obligatoire.',
                    'objet.required' => 'Le champ objet est obligatoire.',
                    'niveauProcedural.required' => 'Le champ niveau procedural est obligatoire.',
                    'nature.required' => 'Le champ nature est obligatoire.',
                   
                    // ...
                ];
    

                //Enregistrement de la procedure sur requete
                if ($request->typeProcedure == 'requete') {

                    $request->validate([
                        'juridiction' => 'required',
                        'objet' => 'required',
                        
                    ], $messages);

                    $procedure = new ProcedureRequete();
                    $procedure->typeRequete = $request->typeRequete;
                    $procedure->juridiction = $request->juridiction;
                    $procedure->objet = $request->objet;
                    $procedure->numRgRequete = $request->numRgRequete;
                    $procedure->natureObligation = $request->natureObligation;
                    $procedure->designationBien = $request->designationBien;
                    $procedure->montantReclamer = $request->montantReclamer;
                    $procedure->juridictionPresidentielle = $request->juridictionPresidentielle;
                    $procedure->identiteRequerent = $request->identiteRequerent;
                    $procedure->idAvocatRequete = $request->idAvocatRequete;
                    $procedure->dateRequete = $request->dateRequete;
                    $procedure->dateArriver = $request->dateArriver;
                    $procedure->demandeRequete = $request->demandeRequete;
                    $procedure->statut = 'Déposée';
                    $procedure->createur = Auth::user()->name;
                    $procedure->slug = rand(124, 875) . $request->_token . rand(1234, 8765);


                    $partieCabinet = false;


                    $arr = is_array($request->requeteLier) ? $request->requeteLier : [$request->requeteLier];
                    //dd($arr);
                   
                    /*

                    foreach ($arr as $requete) {
                        RequeteLiers::create([
                            'requete' => $requete,
                            'slugProcedure' => $procedure->slug,
                            'slug' => $request->_token . rand(1234, 3458),
                        ]);
                    }
                    */

                    // On filtre les valeurs nulles ou vides
                    $arr = array_filter($arr, function ($val) {
                        return !is_null($val) && $val !== '';
                    });

                    if(!empty($arr)){
                        foreach ($arr as $slugToLier) {
    
                            // On vérifie dans les deux tables
                            $existsInAudience = DB::table('audiences')->where('slug', $slugToLier)->exists();
                            $existsInRequete = DB::table('procedure_requetes')->where('slug', $slugToLier)->exists();
    
                    
                            if ($existsInAudience) {
                                $type = 'audience';
                            } elseif ($existsInRequete) {
                                $type = 'requete';
                            } 
                    
                            // Enregistrement de la liaison
                            ProcedureLiers::create([
                                'typeProcedure' => $type,
                                'slugSource' => $procedure->slug ,
                                'slugProcedure' => $slugToLier,
                                'slug' => $request->_token . rand(1234, 3458),
                            ]);
                           
                        }
                    }
                   

                   

        
                    if (isset($request->formset)) {
                            foreach ($request->formset as $key => $value) {
                                // Vérifier si typeAvocat est égal à '1'
                                if (isset($value['typeAvocat']) && $value['typeAvocat'] === '1') {
                                    $partieCabinet = true;
                                    // Si trouvé, vous pouvez sortir de la boucle car une occurrence suffit
                                    break;
                                }
                            }

                            if( $partieCabinet === false){
                                return redirect()->back()->with('error', 'L\'une des parties doit être cliente de votre cabinet.');
                            }
            
                            $procedure->save();
                            
                            foreach ($request->formset as $key => $value) {
                
                                if (isset($value['autreRole'])) {
                                    $autreRole = $value['autreRole'];
                                } else {
                                    $autreRole = '';
                                }
                
                                if (isset($value['idClient'])) {
                                    $idClient = $value['idClient'];
                                } else {
                                    $idClient = null;
                                }
                
                                if (isset($value['idAffaire'])) {
                                    $idAffaire = $value['idAffaire'];
                                } else {
                                    $idAffaire = null;
                                }
                                if (isset($value['typeAvocat'])) {
                
                                    $typeAvocat = $value['typeAvocat'];
                                
                                } else {
                                    $typeAvocat = null;
                                }

                                $idRequeteSelect = DB::select("select idProcedure from procedure_requetes order by idProcedure desc limit 1");
                
                                PartiesRequetes::create([
                                    'idRequete' => $idRequeteSelect[0]->idProcedure,
                                    'role' => $value['role'],
                                    'autreRole' =>  $autreRole,
                                    'idClient' => $idClient,
                                    'idAffaire' => $idAffaire,
                                    'typeAvocat' => $typeAvocat,
                                    'slug' => $request->_token . "" . rand(1234, 3458),
                                ]);
                
                                // Enregistrement des avocats
                                $idPartieSelect = DB::select("select idPartie from parties_requetes order by idPartie desc limit 1");
                
                                if (isset($value['idAvocat'])) {
                                    $arr = $value['idAvocat'];
                
                                    for ($i = 0; $i < count($arr); $i++) {
                
                                        AvocatPartiesRequetes::create([
                                            'idPartie' => $idPartieSelect[0]->idPartie,
                                            'idAvocat' =>  $arr[$i],
                                            'slug' => $request->_token . "" . rand(1234, 3458),
                                        ]);
                                    }
                                }
                
                                if (isset($value['typeAdverse']) && $value['typeAdverse'] == "Personne physique") {
                
                                    PersonneAdversesRequetes::create([
                                        'idPartie' => $idPartieSelect[0]->idPartie,
                                        'prenom' => $value['prenom'],
                                        'nom' => $value['nom'],
                                        'telephone' => $value['telephone'],
                                        'nationalite' => $value['nationalite'],
                                        'profession' => $value['profession'],
                                        'dateNaissance' => $value['dateNaissance'],
                                        'lieuNaissance' => $value['lieuNaissance'],
                                        'pays' => $value['pays'],
                                        'domicile' => $value['domicile'],
                                        'slug' => $request->_token . "" . rand(1234, 3458),
                                    ]);
                                }
                                if (isset($value['typeAdverse']) && $value['typeAdverse'] == "Entreprise") {
                
                                
                                    EntrepriseAdversesRequetes::create([
                                        'idPartie' => $idPartieSelect[0]->idPartie,
                                        'denomination' => $value['denomination'],
                                        'numRccm' => $value['numRccm'],
                                        'siegeSocial' => $value['siegeSocial'],
                                        'formeLegal' => $value['formeLegal'],
                                        'representantLegal' => $value['representantLegal'],
                                        'slug' => $request->_token . "" . rand(1234, 3458),
                                    ]);
                                }
                            } 

                            $suivi = new SuivitRequete();
                            $suivi->idRequete = $procedure->idProcedure;
                            $suivi->reference = $procedure->numRgRequete;
                            $suivi->dateDecision = $procedure->dateArriver;
                            $suivi->dateReception = $procedure->dateRequete;
                            $suivi->reponse = 'Déposée';
                            $suivi->suiviPar = Auth::user()->name;
                            $suivi->slug = rand(124, 875) . $request->_token . rand(1234, 8765);
                            //dd($suivi);
                
                            // Enregistrement en base
                            $suivi->save();
        
                            
                            
                            if ($request->file('pieceREQ') != null) {
                
                                $slugRequete = DB::select("select slug from procedure_requetes order by idProcedure desc limit 1");
                                $slugSuivitRequete = DB::select("select slug from suivit_requetes order by idSuivit desc limit 1");
            
                                $fichier = request()->file('pieceREQ');

                                $filename = strtoupper(substr(str_shuffle(md5($request->_token . "" . rand(124, 345))), 0, 4)) . date('YmdHi') . '.' . $fichier->extension();

                                // enregistrment de la piece de la requete en temps que procedure requete 
                                $pieceREQ = new Fichiers();
            
                                
                               // $filename = strtoupper(substr(str_shuffle(md5($request->_token . "" . rand(124, 345))), 0, 4)) . date('YmdHi') . '.' . $fichier->extension();
                                $pieceREQ->nomOriginal = $fichier->getClientOriginalName();
                                $pieceREQ->slugSource =  $slugRequete[0]->slug;
                                $pieceREQ->filename = $filename;
                                $pieceREQ->slug = $request->_token . "" . rand(1234, 3458);
                                $pieceREQ->path = 'assets/upload/fichiers/audiences/requetes/' . $filename;
                                $fichier->move(public_path('assets/upload/fichiers/audiences/requetes/'), $filename);
                                $pieceREQ->save();


                                // enregistrement de la piece de requete en que temps que suivitreque 
                                $pieceREQSuivit = new Fichiers();
            
                                //$filenameSuivit = strtoupper(substr(str_shuffle(md5($request->_token . "" . rand(124, 345))), 0, 4)) . date('YmdHi') . '.' . $fichier->extension();
                                //dd($filenameSuivit);
                                $pieceREQSuivit->nomOriginal = $fichier->getClientOriginalName();
                                //$pieceREQSuivit->slugSource =  $slugSuivitRequete[0]->slug;
                                $pieceREQSuivit->slugSource = $suivi->slug; // identique
                                $pieceREQSuivit->filename = $filename;
                                $pieceREQSuivit->slug = $request->_token . "" . rand(1234, 3458);
                                $pieceREQSuivit->path = 'assets/upload/fichiers/ordonnances/' . $filename;
                                //$fichier->move(public_path('assets/upload/fichiers/ordonnances/'), $filename);
                                copy(
                                    public_path('assets/upload/fichiers/audiences/requetes/' . $filename),
                                    public_path('assets/upload/fichiers/ordonnances/' . $filename)
                                );

                                $pieceREQSuivit->save();
            
                                
                                    if (isset($request->formsetPiece)) {
                                        foreach ($request->formsetPiece as $key => $value) {
                                        $fichier =$value['autrePieces'];
                                        $pieceREQ = new Fichiers();
            
                                        $filename = strtoupper(substr(str_shuffle(md5($request->_token . "" . rand(124, 345))), 0, 4)) . date('YmdHi') . '.' . $fichier->extension();
                                        $pieceREQ->nomOriginal = $fichier->getClientOriginalName();
                                        $pieceREQ->slugSource =  $slugRequete[0]->slug;
                                        $pieceREQ->filename = $filename;
                                        $pieceREQ->slug = $request->_token . "" . rand(1234, 3458);
                                        $pieceREQ->path = 'assets/upload/fichiers/audiences/requetes/' . $filename;
                                        $fichier->move(public_path('assets/upload/fichiers/audiences/requetes/'), $filename);
                                        $pieceREQ->save();
                                        }
                                    }
                            
                            }
                         
                        }
                    

                    // Notifications
                    //$personnels = DB::select("select * from personnels,users where personnels.email=users.email and users.role='Collaborateur'");
                    $personnels = DB::select("select * from personnels,users where personnels.email=users.email ");
                    foreach ($personnels as $p) {
        
                        DB::select(
                            'INSERT INTO notifications(categorie, messages, etat, idRecepteur,slug,a_biper,urlName,urlParam) VALUES(?,?,?,?,?,?,?,?)',
                            [
                                'Requete',
                                'Une nouvelle requête a été introduite.',
                                'masquer',
                                $p->idPersonnel,
                                $request->_token . "" . rand(1234, 3458),
                                "non",
                                "detailRequete",
                                $procedure->slug
                            ]
                        );
                    }
        
                    $admins = DB::select("select * from users where role='Administrateur'");
        
                    foreach ($admins as $a) {
                                DB::select(
                                    'INSERT INTO notifications(categorie, messages, etat, idRecepteur,slug,a_biper,urlName,urlParam,idAdmin) VALUES(?,?,?,?,?,?,?,?,?)',
                                    [
                                        'Requete',
                                        'Une nouvelle requête a été introduite.',
                                        'masquer',
                                        'admin',
                                        $request->_token . "" . rand(1234, 3458),
                                        "non",
                                        "detailRequete",
                                        $procedure->slug,
                                        $a->id
                                    ]
                                );
                    }

                    
                    return redirect()->route('listRequete')->with('success', 'Requete créée avec succès');


                }else{  //Enregistrement de la procedure contentieuse

                    $request->validate([
                        'juridiction' => 'required',
                        'objet' => 'required',
                        'niveauProcedural' => 'required',
                        'nature' => 'required',
                        
                    ], $messages);

                        // L'instance du model Audience
                        $audiences = new Audiences();
                        if (isset($request->numRg)) {
                            $num = $request->numRg;
                        } elseif (isset($request->numRgOpp)) {
                            $num = $request->numRgOpp;
                        } elseif (isset($request->numRgRequete)) {
                            $num = $request->numRgRequete;
                        } elseif (isset($request->numRgDeclaration)) {
                            $num = $request->numRgDeclaration;
                        } else {
                            $num = '';
                        }
                        $audiences->objet = $request->objet;
                        $audiences->juridiction = $request->juridiction;
                        $audiences->typeProcedure = $request->typeProcedure;
                        $audiences->orientation = $request->orientationProcedure;
                        $audiences->niveauProcedural = $request->niveauProcedural;
                        $audiences->nature = $request->nature;
                        $audiences->dateCreation = $today;
                        $audiences->numRg = $num;
                        $audiences->createur = Auth::user()->name;
                        $audiences->statut = 'En cours';
                        $audiences->slug = rand(124, 875) . $request->_token . rand(1234, 8765);
                          
                        $audiences->save();
                    

                        $arr = is_array($request->requeteLier) ? $request->requeteLier : [$request->requeteLier];

                        /*

                        foreach ($arr as $requete) {
                            RequeteLiers::create([
                                'requete' => $requete,
                                'slugProcedure' => $audiences->slug,
                                'slug' => $request->_token . rand(1234, 3458),
                            ]);
                        }
                        */

                        $arr = array_filter($arr, function ($val) {
                            return !is_null($val) && $val !== '';
                        });

                        if(!empty($arr)){
                            foreach ($arr as $slugToLier) {
        
                                // On vérifie dans les deux tables
                                $existsInAudience = DB::table('audiences')->where('slug', $slugToLier)->exists();
                                $existsInRequete = DB::table('procedure_requetes')->where('slug', $slugToLier)->exists();
        
                        
                                if ($existsInAudience) {
                                    $type = 'audience';
                                } elseif ($existsInRequete) {
                                    $type = 'requete';
                                } 
                        
                                // Enregistrement de la liaison
                                ProcedureLiers::create([
                                    'typeProcedure' => $type,
                                    'slugSource' => $audiences->slug ,
                                    'slugProcedure' => $slugToLier,
                                    'slug' => $request->_token . rand(1234, 3458),
                                ]);
                               
                            }
                        }

                       
            
                        $idAudienceSelect = DB::select("select idAudience from audiences order by idAudience desc limit 1");

                    if ($request->file('pieceInstruction') != null) {
    
                        $audiences->pieceInstruction = rand(124, 875) . $request->_token . rand(1234, 8765);
        
                        $fichier = request()->file('pieceInstruction');
                        $pieceInstruction = new Fichiers();
        
                        $filename = strtoupper(substr(str_shuffle(md5($request->_token . "" . rand(124, 345))), 0, 4)) . date('YmdHi') . '.' . $fichier->extension();
                        $pieceInstruction->nomOriginal = $fichier->getClientOriginalName();
                        $pieceInstruction->slugSource =  $audiences->pieceInstruction;
                        $pieceInstruction->filename = $filename;
                        $pieceInstruction->slug = $request->_token . "" . rand(1234, 3458);
                        $pieceInstruction->path = 'assets/upload/fichiers/audiences/instructions/' . $filename;
                        $fichier->move(public_path('assets/upload/fichiers/audiences/instructions/'), $filename);
                        $pieceInstruction->save();
                    }
        
                    $partieCabinet = false;
        
                    if (isset($request->formset)) {
                        foreach ($request->formset as $key => $value) {
                            // Vérifier si typeAvocat est égal à '1'
                            if (isset($value['typeAvocat']) && $value['typeAvocat'] === '1') {
                                $partieCabinet = true;
                                // Si trouvé, vous pouvez sortir de la boucle car une occurrence suffit
                                break;
                            }
                        }

                        if( $partieCabinet === false){
                            return redirect()->back()->with('error', 'L\'une des parties doit être cliente de votre cabinet.');
                        }


                          

                            foreach ($request->formset as $key => $value) {
                
                                if (isset($value['autreRole'])) {
                                    $autreRole = $value['autreRole'];
                                } else {
                                    $autreRole = '';
                                }
                
                                if (isset($value['idClient'])) {
                                    $idClient = $value['idClient'];
                                } else {
                                    $idClient = null;
                                }
                
                                if (isset($value['idAffaire'])) {
                                    $idAffaire = $value['idAffaire'];
                                } else {
                                    $idAffaire = null;
                                }
                                if (isset($value['typeAvocat'])) {
                
                                    $typeAvocat = $value['typeAvocat'];
                                
                                } else {
                                    $typeAvocat = null;
                                }
                
                                Parties::create([
                                    'idAudience' => $idAudienceSelect[0]->idAudience,
                                    'role' => $value['role'],
                                    'autreRole' =>  $autreRole,
                                    'idClient' => $idClient,
                                    'idAffaire' => $idAffaire,
                                    'typeAvocat' => $typeAvocat,
                                    'slug' => $request->_token . "" . rand(1234, 3458),
                                ]);
                
                                // Enregistrement des avocats
                                $idPartieSelect = DB::select("select idPartie from parties order by idPartie desc limit 1");
                
                                if (isset($value['idAvocat'])) {
                                    $arr = $value['idAvocat'];
                
                                    for ($i = 0; $i < count($arr); $i++) {
                
                                        AvocatParties::create([
                                            'idPartie' => $idPartieSelect[0]->idPartie,
                                            'idAvocat' =>  $arr[$i],
                                            'slug' => $request->_token . "" . rand(1234, 3458),
                                        ]);
                                    }
                                }
                
                                if (isset($value['typeAdverse']) && $value['typeAdverse'] == "Personne physique") {
                
                                    PersonneAdverse::create([
                                        'idPartie' => $idPartieSelect[0]->idPartie,
                                        'prenom' => $value['prenom'],
                                        'nom' => $value['nom'],
                                        'telephone' => $value['telephone'],
                                        'nationalite' => $value['nationalite'],
                                        'profession' => $value['profession'],
                                        'dateNaissance' => $value['dateNaissance'],
                                        'lieuNaissance' => $value['lieuNaissance'],
                                        'pays' => $value['pays'],
                                        'domicile' => $value['domicile'],
                                        'slug' => $request->_token . "" . rand(1234, 3458),
                                    ]);
                                }
                                if (isset($value['typeAdverse']) && $value['typeAdverse'] == "Entreprise") {
                
                                
                                    EntrepriseAdverse::create([
                                        'idPartie' => $idPartieSelect[0]->idPartie,
                                        'denomination' => $value['denomination'],
                                        'numRccm' => $value['numRccm'],
                                        'siegeSocial' => $value['siegeSocial'],
                                        'formeLegal' => $value['formeLegal'],
                                        'representantLegal' => $value['representantLegal'],
                                        'slug' => $request->_token . "" . rand(1234, 3458),
                                    ]);
                                }
                            }
    
                            
                
                            // Enregistrement de l'acte introductifs
                            ActeIntroductifs::create([
                                'idAudience' => $idAudienceSelect[0]->idAudience,
                                'typeActe' => $request->typeActe,
                                'idNatureAction' => $request->idNatureAction,
                                'slug' => $request->_token . "" . rand(1234, 3458),
                            ]);
                
                            $idActeSelect = DB::select("select idActe from acte_introductifs order by idActe desc limit 1");
                
                            // Enregistrement de l'Assignation
                            if ($request->typeActe == 'Assignation') {
                                Assignations::create([
                                    'idActe' => $idActeSelect[0]->idActe,
                                    'numRg' =>  $request->numRg,
                                    'idHuissier' =>  $request->idHuissier,
                                    'recepteurAss' =>  $request->recepteurAss,
                                    'dateAssignation' =>  $request->dateAssignation,
                                    'datePremiereComp' =>  $request->datePremiereComp,
                                    'dateEnrollement' =>  $request->dateEnrollement,
                                    'mentionParticuliere' =>  $request->mentionParticuliere,
                                    'slug' => $request->_token . "" . rand(1234, 3458),
                                ]);
                
                                DB::update('update audiences set prochaineAudience=? where idAudience=?',[$request->datePremiereComp,$idAudienceSelect[0]->idAudience]);
                
                                if ($request->file('pieceAS') != null) {
                
                                    $slugAssignation = DB::select("select slug from assignations order by idAssignation desc limit 1");
                
                                    $fichier = request()->file('pieceAS');
                                    $pieceAS = new Fichiers();
                
                                    $filename = strtoupper(substr(str_shuffle(md5($request->_token . "" . rand(124, 345))), 0, 4)) . date('YmdHi') . '.' . $fichier->extension();
                                    $pieceAS->nomOriginal = $fichier->getClientOriginalName();
                                    $pieceAS->slugSource =  $slugAssignation[0]->slug;
                                    $pieceAS->filename = $filename;
                                    $pieceAS->slug = $request->_token . "" . rand(1234, 3458);
                                    $pieceAS->path = 'assets/upload/fichiers/audiences/assignations/' . $filename;
                                    $fichier->move(public_path('assets/upload/fichiers/audiences/assignations/'), $filename);
                                    $pieceAS->save();
                
                
                                    if (isset($request->formsetPiece)) {
                                        foreach ($request->formsetPiece as $key => $value) {
                                            $fichier =$value['autrePieces'];
                                            $pieceAS = new Fichiers();
                        
                                            $filename = strtoupper(substr(str_shuffle(md5($request->_token . "" . rand(124, 345))), 0, 4)) . date('YmdHi') . '.' . $fichier->extension();
                                            $pieceAS->nomOriginal = $fichier->getClientOriginalName();
                                            $pieceAS->slugSource =  $slugAssignation[0]->slug;
                                            $pieceAS->filename = $filename;
                                            $pieceAS->slug = $request->_token . "" . rand(1234, 3458);
                                            $pieceAS->path = 'assets/upload/fichiers/audiences/assignations/' . $filename;
                                            $fichier->move(public_path('assets/upload/fichiers/audiences/assignations/'), $filename);
                                            $pieceAS->save();
                                        }
                                    }
                                }
                
                                
                            }
                
                            // Enregistrement de la requete
                            if ($request->typeActe == 'Requete') {
                                Requetes::create([
                                    'idActe' => $idActeSelect[0]->idActe,
                                    'dateRequete' => $request->dateRequete,
                                    'dateArriver' => $request->dateArriver,
                                    'numRg' => $request->numRgRequete,
                                    'juriductionPresidentielle' => $request->juriductionPresidentielle,
                                    'slug' => $request->_token . "" . rand(1234, 3458),
                                ]);
                
                                if ($request->file('pieceREQ') != null) {
                
                                    $slugRequete = DB::select("select slug from requetes order by idRequete desc limit 1");
                
                                    $fichier = request()->file('pieceREQ');
                                    $pieceREQ = new Fichiers();
                
                                    $filename = strtoupper(substr(str_shuffle(md5($request->_token . "" . rand(124, 345))), 0, 4)) . date('YmdHi') . '.' . $fichier->extension();
                                    $pieceREQ->nomOriginal = $fichier->getClientOriginalName();
                                    $pieceREQ->slugSource =  $slugRequete[0]->slug;
                                    $pieceREQ->filename = $filename;
                                    $pieceREQ->slug = $request->_token . "" . rand(1234, 3458);
                                    $pieceREQ->path = 'assets/upload/fichiers/audiences/requetes/' . $filename;
                                    $fichier->move(public_path('assets/upload/fichiers/audiences/requetes/'), $filename);
                                    $pieceREQ->save();
                
                                    
                                        if (isset($request->formsetPiece)) {
                                            foreach ($request->formsetPiece as $key => $value) {
                                            $fichier =$value['autrePieces'];
                                            $pieceREQ = new Fichiers();
                
                                            $filename = strtoupper(substr(str_shuffle(md5($request->_token . "" . rand(124, 345))), 0, 4)) . date('YmdHi') . '.' . $fichier->extension();
                                            $pieceREQ->nomOriginal = $fichier->getClientOriginalName();
                                            $pieceREQ->slugSource =  $slugRequete[0]->slug;
                                            $pieceREQ->filename = $filename;
                                            $pieceREQ->slug = $request->_token . "" . rand(1234, 3458);
                                            $pieceREQ->path = 'assets/upload/fichiers/audiences/requetes/' . $filename;
                                            $fichier->move(public_path('assets/upload/fichiers/audiences/requetes/'), $filename);
                                            $pieceREQ->save();
                                            }
                                        }
                                
                                }
                            }

                            // Enregistrement de la signification de la citation
                            if ($request->typeActe == 'Citation') {
                                Citations::create([
                                    'idActe' => $idActeSelect[0]->idActe,
                                    'dateSignification' => $request->dateSignification,
                                    'dateCitation' => $request->dateCitation,
                                    'dateAudience' => $request->dateAudienceCitation,
                                    'personneCharger' => $request->personneCharger,
                                    'numRg' => $request->numRgCitation,
                                    'lieuAudience' => $request->lieuAudience,
                                    'idHuissier' => $request->idHuissierCit,
                                    'slug' => $request->_token . "" . rand(1234, 3458),
                                ]);
                
                                if ($request->file('pieceCitation') != null) {
                
                                    $slugCitations = DB::select("select slug from citations order by idCitation desc limit 1");
                
                                    $fichier = request()->file('pieceCitation');

                                    $pieceCitation = new Fichiers();
                
                                    $filename = strtoupper(substr(str_shuffle(md5($request->_token . "" . rand(124, 345))), 0, 4)) . date('YmdHi') . '.' . $fichier->extension();
                                    $pieceCitation->nomOriginal = $fichier->getClientOriginalName();
                                    $pieceCitation->slugSource =  $slugCitations[0]->slug;
                                    $pieceCitation->filename = $filename;
                                    $pieceCitation->slug = $request->_token . "" . rand(1234, 3458);
                                    $pieceCitation->path = 'assets/upload/fichiers/audiences/signification_citations/' . $filename;
                                    $fichier->move(public_path('assets/upload/fichiers/audiences/signification_citations/'), $filename);
                                    $pieceCitation->save();
                
                                    
                                        if (isset($request->formsetPiece)) {
                                            foreach ($request->formsetPiece as $key => $value) {
                                            $fichier =$value['autrePieces'];
                                            $pieceCitation = new Fichiers();
                
                                            $filename = strtoupper(substr(str_shuffle(md5($request->_token . "" . rand(124, 345))), 0, 4)) . date('YmdHi') . '.' . $fichier->extension();
                                            $pieceCitation->nomOriginal = $fichier->getClientOriginalName();
                                            $pieceCitation->slugSource =  $slugCitations[0]->slug;
                                            $pieceCitation->filename = $filename;
                                            $pieceCitation->slug = $request->_token . "" . rand(1234, 3458);
                                            $pieceCitation->path = 'assets/upload/fichiers/audiences/signification_citations/' . $filename;
                                            $fichier->move(public_path('assets/upload/fichiers/audiences/signification_citations/'), $filename);
                                            $pieceCitation->save();
                                            }
                                        }
                                
                                }
                            }

                            // Enregistrement autres actes
                            if ($request->typeActe == 'Autre acte') {

                                if (isset($request->formsetAutreActe)) {

                                    foreach ($request->formsetAutreActe as $key => $value) {

                                        AutreActes::create([
                                            'idActe' => $idActeSelect[0]->idActe,
                                            'mention' => $value['mention'],
                                            'valeur' => $value['valeur'],
                                            'slug' => $request->_token . "" . rand(1234, 3458),
                                        ]);

                                    }

                                }
                                
                            }
                
                            // Enregistrement de la requete
                            if ($request->typeActe == 'Opposition') {
                                Oppositions::create([
                                    'idActe' => $idActeSelect[0]->idActe,
                                    'idHuissier' => $request->idHuissierOpp,
                                    'dateActe' => $request->dateActe,
                                    'dateProchaineAud' => $request->dateProchaineAud,
                                    'numDecision' => $request->numDecisConcerner,
                                    'numRg' => $request->numRgOpp,
                                    'recepteurAss' => $request->recepteurAssOpp,
                                    'datePremiereComp' => $request->datePremiereCompOpp,
                                    'dateEnrollement' => $request->dateEnrollementOpp,
                                    'mentionParticuliere' => $request->mentionParticuliereOpp,
                                    'slug' => $request->_token . "" . rand(1234, 3458),
                                ]);
                
                                DB::update('update audiences set prochaineAudience=? where idAudience=?',[$request->datePremiereCompOpp,$idAudienceSelect[0]->idAudience]);
                
                
                                if ($request->file('pieceASOpp') != null) {
                
                                    $slugOpposition = DB::select("select slug from oppositions order by idOpposition desc limit 1");
                
                                    $fichier = request()->file('pieceASOpp');
                                    $pieceAS = new Fichiers();
                
                                    $filename = strtoupper(substr(str_shuffle(md5($request->_token . "" . rand(124, 345))), 0, 4)) . date('YmdHi') . '.' . $fichier->extension();
                                    $pieceAS->nomOriginal = $fichier->getClientOriginalName();
                                    $pieceAS->slugSource =  $slugOpposition[0]->slug;
                                    $pieceAS->filename = $filename;
                                    $pieceAS->slug = $request->_token . "" . rand(1234, 3458);
                                    $pieceAS->path = 'assets/upload/fichiers/audiences/oppositions/' . $filename;
                                    $fichier->move(public_path('assets/upload/fichiers/audiences/oppositions/'), $filename);
                                    $pieceAS->save();
                
                                    if (isset($request->formsetPiece)) {
                                        foreach ($request->formsetPiece as $key => $value) {
                                            $fichier =$value['autrePieces'];
                                            $pieceAS = new Fichiers();
                
                                            $filename = strtoupper(substr(str_shuffle(md5($request->_token . "" . rand(124, 345))), 0, 4)) . date('YmdHi') . '.' . $fichier->extension();
                                            $pieceAS->nomOriginal = $fichier->getClientOriginalName();
                                            $pieceAS->slugSource =  $slugOpposition[0]->slug;
                                            $pieceAS->filename = $filename;
                                            $pieceAS->slug = $request->_token . "" . rand(1234, 3458);
                                            $pieceAS->path = 'assets/upload/fichiers/audiences/oppositions/' . $filename;
                                            $fichier->move(public_path('assets/upload/fichiers/audiences/oppositions/'), $filename);
                                            $pieceAS->save();
                                        }
                                    }
                                }
                            }
                
                            // Enregistrement du PV introgatoire
                            if ($request->typeActe == 'PV introgatoire') {
                                PvInterrogatoires::create([
                                    'idActe' => $idActeSelect[0]->idActe,
                                    'dateAudition' => $request->dateAudition,
                                    'identiteOPJ' => $request->identiteOPJ,
                                    'infractions' => $request->infractions,
                                    'dateAudience' => $request->dateAudience,
                                    'slug' => $request->_token . "" . rand(1234, 3458),
                                ]);
                
                                DB::update('update audiences set prochaineAudience=? where idAudience=?',[$request->dateAudience,$idAudienceSelect[0]->idAudience]);
                
                            }
                
                            // Enregistrement du Requisitoire
                            if ($request->typeActe == 'Requisitoire') {
                                Requisitoires::create([
                                    'idActe' => $idActeSelect[0]->idActe,
                                    'numInstruction' => $request->numInstruction,
                                    'identiteOPJ' => $request->identiteOPJ,
                                    'procureur' => $request->procureur,
                                    'chefAccusation' => $request->chefAccusationReq,
                                    'slug' => $request->_token . "" . rand(1234, 3458),
                                ]);
                            }
                
                            // Enregistrement de Ordonnance Renvoi
                            if ($request->typeActe == 'Ordonnance Renvoi') {
                                OrdonnanceRenvois::create([
                                    'idActe' => $idActeSelect[0]->idActe,
                                    'numOrd' => $request->numOrd,
                                    'cabinetIns' => $request->cabinetIns,
                                    'typeProcedure' => $request->typeProcedure,
                                    'chefAccusation' => $request->chefAccusationOrd,
                                    'slug' => $request->_token . "" . rand(1234, 3458),
                                ]);
                            }
                
                            // Enregistrement de Citation directe
                            if ($request->typeActe == 'Citation directe') {
                                CitationDirectes::create([
                                    'idActe' => $idActeSelect[0]->idActe,
                                    'saisi' => $request->saisi,
                                    'dateHeureAud' => $request->dateHeureAud,
                                    'idHuissier' => $request->idHuissier,
                                    'recepteurCitation' => $request->recepteurCitation,
                                    'dateSignification' => $request->dateSignification,
                                    'mentionParticuliere' => $request->mentionParticuliere,
                                    'chefAccusation' => $request->chefAccusation,
                                    'slug' => $request->_token . "" . rand(1234, 3458),
                                ]);
                            }
                
                            // Enregistrement du PCPC
                            if ($request->typeActe == 'PCPC') {
                                Pcpcs::create([
                                    'idActe' => $idActeSelect[0]->idActe,
                                    'reference' => $request->reference,
                                    'datePcpc' => $request->datePcpc,
                                    'dateProchaineAud' => $request->dateProchaineAud,
                                    'slug' => $request->_token . "" . rand(1234, 3458),
                                ]);
                
                                DB::update('update audiences set prochaineAudience=? where idAudience=?',[$request->dateProchaineAud,$idAudienceSelect[0]->idAudience]);
                
                            }
                
                            // Enregistrement de Declaration d'appel
                            if ($request->typeActe == "Declaration d'appel") {
                                DeclarationAppels::create([
                                    'idActe' => $idActeSelect[0]->idActe,
                                    'numRg' => $request->numRgDeclaration,
                                    'numJugement' => $request->numJugement,
                                    'dateAppel' => $request->dateAppel,
                                    'slug' => $request->_token . "" . rand(1234, 3458),
                                ]);
                            }
                
                            // Enregistrement de Contredit
                            if ($request->typeActe == "Contredit") {
                                Contredits::create([
                                    'idActe' => $idActeSelect[0]->idActe,
                                    'numConcerner' => $request->numConcerner,
                                    'numDecisConcerner' => $request->numDecisConcerner,
                                    'dateContredit' => $request->dateContredit,
                                    'dateDecision' => $request->dateDecision,
                                    'slug' => $request->_token . "" . rand(1234, 3458),
                                ]);
                            }
                
                            // Enregistrement de Contredit
                            if ($request->typeActe == "Pourvoi") {
                                Pourvois::create([
                                    'idActe' => $idActeSelect[0]->idActe,
                                    'numPourvoi' => $request->numPourvoi,
                                    'numDecision' => $request->numDecisConcerner,
                                    'datePourvoi' => $request->datePourvoi,
                                    'dateDecision' => $request->dateDecision,
                                    'slug' => $request->_token . "" . rand(1234, 3458),
                                ]);
                            }
                    }
                    
        

            
            
                        // Notifications
                       // $personnels = DB::select("select * from personnels,users where personnels.email=users.email and users.role='Collaborateur'");
                        $personnels = DB::select("select * from personnels,users where personnels.email=users.email ");
                        foreach ($personnels as $p) {
            
                            DB::select(
                                'INSERT INTO notifications(categorie, messages, etat, idRecepteur,slug,a_biper,urlName,urlParam) VALUES(?,?,?,?,?,?,?,?)',
                                [
                                    'Audience',
                                    'Une nouvelle audience a été ajoutée.',
                                    'masquer',
                                    $p->idPersonnel,
                                    $request->_token . "" . rand(1234, 3458),
                                    "non",
                                    "detailAudience",
                                    $audiences->slug
                                ]
                            );
                        }
            
                        $admins = DB::select("select * from users where role='Administrateur'");
            
                        foreach ($admins as $a) {
                                    DB::select(
                                        'INSERT INTO notifications(categorie, messages, etat, idRecepteur,slug,a_biper,urlName,urlParam,idAdmin) VALUES(?,?,?,?,?,?,?,?,?)',
                                        [
                                            'Audience',
                                            'Une nouvelle audience a été ajoutée.',
                                            'masquer',
                                            'admin',
                                            $request->_token . "" . rand(1234, 3458),
                                            "non",
                                            "detailAudience",
                                            $audiences->slug,
                                            $a->id
                                        ]
                                    );
                        }
                
                        return redirect()->route('listAudience', 'generale')->with('success', 'Audience créée avec succès');
                }
            }

            // Rediriger vers la route avec une erreur
            //return redirect()->back()->with('error', "Une erreur s\'est produite lors de la création de l\'audience");
        });
    }

    public function storeNewLevel(Request $request)
    {
        return DB::transaction(function () use ($request) {

        $TYPE_ADVERSE = ['Entreprise', 'Personne physique'];

        $today = date('Y-m-d');

        // L'instance du model FileAudience'
        $fichiers = new Fichiers();
        $idAudience = $request->idAudience;

        $audiencePrecedent = DB::select("select * from audiences where idAudience=?", [$idAudience]);



        if ($request) {


            // Enregistrement des informations de l'audience

            // L'instance du model Audience
            $audiences = new Audiences();
            if (isset($request->numRg)) {
                $num = $request->numRg;
            } elseif (isset($request->numRgOpp)) {
                $num = $request->numRgOpp;
            } elseif (isset($request->numRgRequete)) {
                $num = $request->numRgRequete;
            } elseif (isset($request->numRgDeclaration)) {
                $num = $request->numRgDeclaration;
            } else {
                $num = '';
            }
            $audiences->objet = $request->objet;
            $audiences->juridiction = $request->juridiction;
            $audiences->niveauProcedural = $request->niveauProcedural;
            $audiences->nature = $request->nature;
            $audiences->dateCreation = $today;
            $audiences->numRg = $num;
            $audiences->statut = 'En cours';
            $audiences->slug = $request->slugAudience;

            if ($request->file('pieceInstruction') != null) {

                $audiences->pieceInstruction = rand(124, 875) . $request->_token . rand(1234, 8765);

                $fichier = request()->file('pieceInstruction');
                $pieceInstruction = new Fichiers();

                $filename = strtoupper(substr(str_shuffle(md5($request->_token . "" . rand(124, 345))), 0, 4)) . date('YmdHi') . '.' . $fichier->extension();
                $pieceInstruction->nomOriginal = $fichier->getClientOriginalName();
                $pieceInstruction->slugSource =  $audiences->pieceInstruction;
                $pieceInstruction->filename = $filename;
                $pieceInstruction->slug = $request->_token . "" . rand(1234, 3458);
                $pieceInstruction->path = 'assets/upload/fichiers/audiences/instructions' . $filename;
                $fichier->move(public_path('assets/upload/fichiers/audiences/instructions'), $filename);
                $pieceInstruction->save();
            }

            $audiences->save();

            // Enregistrement des parties
            $idAudienceSelect = DB::select("select idAudience from audiences order by idAudience desc limit 1");
            
            $partiePrecedente = DB::select("select * from parties where idAudience=?",[$idAudience]);
            foreach ($partiePrecedente as $p) {
           
                    // Formset 1
                if (isset($request->formset1)) {
                    foreach ($request->formset1 as $key => $value) {
                        
                        if ($value['idPartie1']==$p->idPartie) {
                               
                            Parties::create([
                                'idAudience' => $idAudienceSelect[0]->idAudience,
                                'role' => $value['role1'],
                                'autreRole' =>  '',
                                'idClient' => $p->idClient,
                                'idAffaire' => $p->idAffaire,
                                'typeAvocat' => $p->typeAvocat,
                                'slug' => $request->_token . "" . rand(1234, 3458),
                            ]);
    
                            // Enregistrement des avocats
                            $idPartieSelect = DB::select("select idPartie from parties order by idPartie desc limit 1");
    
                            $avocatsParties = DB::select("select * from avocat_parties where idPartie=?",[$p->idPartie]);
                            if (!empty($avocatsParties)) {
                                foreach ($avocatsParties as $a) {
                                    AvocatParties::create([
                                        'idPartie' => $idPartieSelect[0]->idPartie,
                                        'idAvocat' =>  $a->idAvocat,
                                        'slug' => $request->_token . "" . rand(1234, 3458),
                                    ]);
                                }
                            } 
                            
                            $personnesAdverses = DB::select("select * from personne_adverses where idPartie=?",[$p->idPartie]);
                            if (!empty($personnesAdverses)) {
                                foreach ($personnesAdverses as $prs) {
                                PersonneAdverse::create([
                                    'idPartie' => $idPartieSelect[0]->idPartie,
                                    'prenom' => $prs->prenom,
                                    'nom' => $prs->nom,
                                    'telephone' => $prs->telephone,
                                    'nationalite' => $prs->nationalite,
                                    'profession' => $prs->profession,
                                    'dateNaissance' => $prs->dateNaissance,
                                    'lieuNaissance' => $prs->lieuNaissance,
                                    'pays' => $prs->pays,
                                    'domicile' => $prs->domicile,
                                    'slug' => $request->_token . "" . rand(1234, 3458),
                                ]);
                              }
                            }
    
                            $entreprisesAdverses = DB::select("select * from entreprise_adverses where idPartie=?",[$p->idPartie]);
                            if (!empty($entreprisesAdverses)) {
                                foreach ($personnesAdverses as $entrep) {
                                EntrepriseAdverse::create([
                                    'idPartie' => $idPartieSelect[0]->idPartie,
                                    'denomination' => $entrep->denomination,
                                    'numRccm' => $entrep->numRccm,
                                    'siegeSocial' => $entrep->siegeSocial,
                                    'formeLegal' => $entrep->formeLegal,
                                    'representantLegal' => $entrep->representantLegal,
                                    'slug' => $request->_token . "" . rand(1234, 3458),
                                ]);
                              }
                            }

                        }
                    }
                }                

                // Formset 2
                if (isset($request->formset2)) {
                   
                    foreach ($request->formset2 as $key => $value) {

                        if ($value['idPartie2']==$p->idPartie) {
                            Parties::create([
                                'idAudience' => $idAudienceSelect[0]->idAudience,
                                'role' => $value['role2'],
                                'autreRole' =>  '',
                                'idClient' => $p->idClient,
                                'idAffaire' => $p->idAffaire,
                                'typeAvocat' => $p->typeAvocat,
                                'slug' => $request->_token . "" . rand(1234, 3458),
                            ]);

                            // Enregistrement des avocats
                            $idPartieSelect = DB::select("select idPartie from parties order by idPartie desc limit 1");

                            $avocatsParties = DB::select("select * from avocat_parties where idPartie=?",[$p->idPartie]);
                            if (!empty($avocatsParties)) {
                                foreach ($avocatsParties as $a) {
                                    AvocatParties::create([
                                        'idPartie' => $idPartieSelect[0]->idPartie,
                                        'idAvocat' =>  $a->idAvocat,
                                        'slug' => $request->_token . "" . rand(1234, 3458),
                                    ]);
                                }
                            } 
                            
                            $personnesAdverses = DB::select("select * from personne_adverses where idPartie=?",[$p->idPartie]);
                            if (!empty($personnesAdverses)) {
                                foreach ($personnesAdverses as $prs) {
                                PersonneAdverse::create([
                                    'idPartie' => $idPartieSelect[0]->idPartie,
                                    'prenom' => $prs->prenom,
                                    'nom' => $prs->nom,
                                    'telephone' => $prs->telephone,
                                    'nationalite' => $prs->nationalite,
                                    'profession' => $prs->profession,
                                    'dateNaissance' => $prs->dateNaissance,
                                    'lieuNaissance' => $prs->lieuNaissance,
                                    'pays' => $prs->pays,
                                    'domicile' => $prs->domicile,
                                    'slug' => $request->_token . "" . rand(1234, 3458),
                                ]);
                            }
                            }

                            $entreprisesAdverses = DB::select("select * from entreprise_adverses where idPartie=?",[$p->idPartie]);
                            if (!empty($entreprisesAdverses)) {
                                foreach ($personnesAdverses as $entrep) {
                                EntrepriseAdverse::create([
                                    'idPartie' => $idPartieSelect[0]->idPartie,
                                    'denomination' => $entrep->denomination,
                                    'numRccm' => $entrep->numRccm,
                                    'siegeSocial' => $entrep->siegeSocial,
                                    'formeLegal' => $entrep->formeLegal,
                                    'representantLegal' => $entrep->representantLegal,
                                    'slug' => $request->_token . "" . rand(1234, 3458),
                                ]);
                               }
                            }
                        }
                    }  
                
                }

                     // Formset 3
                if (isset($request->formset3)) {
                    foreach ($request->formset3 as $key => $value) {

                        if ($value['idPartie3']==$p->idPartie) {
                        
                            Parties::create([
                                'idAudience' => $idAudienceSelect[0]->idAudience,
                                'role' => $value['role3'],
                                'autreRole' =>  '',
                                'idClient' => $p->idClient,
                                'idAffaire' => $p->idAffaire,
                                'typeAvocat' => $p->typeAvocat,
                                'slug' => $request->_token . "" . rand(1234, 3458),
                            ]);

                            // Enregistrement des avocats
                            $idPartieSelect = DB::select("select idPartie from parties order by idPartie desc limit 1");

                            $avocatsParties = DB::select("select * from avocat_parties where idPartie=?",[$p->idPartie]);
                            if (!empty($avocatsParties)) {
                                foreach ($avocatsParties as $a) {
                                    AvocatParties::create([
                                        'idPartie' => $idPartieSelect[0]->idPartie,
                                        'idAvocat' =>  $a->idAvocat,
                                        'slug' => $request->_token . "" . rand(1234, 3458),
                                    ]);
                                }
                            } 
                            
                            $personnesAdverses = DB::select("select * from personne_adverses where idPartie=?",[$p->idPartie]);
                            if (!empty($personnesAdverses)) {
                                foreach ($personnesAdverses as $prs) {
                                PersonneAdverse::create([
                                    'idPartie' => $idPartieSelect[0]->idPartie,
                                    'prenom' => $prs->prenom,
                                    'nom' => $prs->nom,
                                    'telephone' => $prs->telephone,
                                    'nationalite' => $prs->nationalite,
                                    'profession' => $prs->profession,
                                    'dateNaissance' => $prs->dateNaissance,
                                    'lieuNaissance' => $prs->lieuNaissance,
                                    'pays' => $prs->pays,
                                    'domicile' => $prs->domicile,
                                    'slug' => $request->_token . "" . rand(1234, 3458),
                                ]);
                            }
                            }

                            $entreprisesAdverses = DB::select("select * from entreprise_adverses where idPartie=?",[$p->idPartie]);
                            if (!empty($entreprisesAdverses)) {
                                foreach ($entreprisesAdverses as $entrep) {
                                EntrepriseAdverse::create([
                                    'idPartie' => $idPartieSelect[0]->idPartie,
                                    'denomination' => $entrep->denomination,
                                    'numRccm' => $entrep->numRccm,
                                    'siegeSocial' => $entrep->siegeSocial,
                                    'formeLegal' => $entrep->formeLegal,
                                    'representantLegal' => $entrep->representantLegal,
                                    'slug' => $request->_token . "" . rand(1234, 3458),
                                ]);
                               }
                            }

                        }
                    }
                }

            }


            // Enregistrement de l'acte introductifs
            ActeIntroductifs::create([
                'idAudience' => $idAudienceSelect[0]->idAudience,
                'typeActe' => $request->typeActe,
                'idNatureAction' => $request->idNatureAction,
                'slug' => $request->_token . "" . rand(1234, 3458),
            ]);

            $idActeSelect = DB::select("select idActe from acte_introductifs order by idActe desc limit 1");

            // Enregistrement de l'Assignation
            if ($request->typeActe == 'Assignation') {
                Assignations::create([
                    'idActe' => $idActeSelect[0]->idActe,
                    'numRg' =>  $request->numRg,
                    'idHuissier' =>  $request->idHuissier,
                    'recepteurAss' =>  $request->recepteurAss,
                    'dateAssignation' =>  $request->dateAssignation,
                    'datePremiereComp' =>  $request->datePremiereComp,
                    'dateEnrollement' =>  $request->dateEnrollement,
                    'mentionParticuliere' =>  $request->mentionParticuliere,
                    'slug' => $request->_token . "" . rand(1234, 3458),
                ]);

                if ($request->file('pieceAS') != null) {

                    $slugAssignation = DB::select("select slug from assignations order by idAssignation desc limit 1");

                    $fichier = request()->file('pieceAS');
                    $pieceAS = new Fichiers();

                    $filename = strtoupper(substr(str_shuffle(md5($request->_token . "" . rand(124, 345))), 0, 4)) . date('YmdHi') . '.' . $fichier->extension();
                    $pieceAS->nomOriginal = $fichier->getClientOriginalName();
                    $pieceAS->slugSource =  $slugAssignation[0]->slug;
                    $pieceAS->filename = $filename;
                    $pieceAS->slug = $request->_token . "" . rand(1234, 3458);
                    $pieceAS->path = 'assets/upload/fichiers/audiences/assignations/' . $filename;
                    $fichier->move(public_path('assets/upload/fichiers/audiences/assignations/'), $filename);
                    $pieceAS->save();

                    if (isset($request->formsetPiece)) {
                        foreach ($request->formsetPiece as $key => $value) {
                            $fichier =$value['autrePieces'];
                            $pieceAS = new Fichiers();
        
                            $filename = strtoupper(substr(str_shuffle(md5($request->_token . "" . rand(124, 345))), 0, 4)) . date('YmdHi') . '.' . $fichier->extension();
                            $pieceAS->nomOriginal = $fichier->getClientOriginalName();
                            $pieceAS->slugSource =  $slugAssignation[0]->slug;
                            $pieceAS->filename = $filename;
                            $pieceAS->slug = $request->_token . "" . rand(1234, 3458);
                            $pieceAS->path = 'assets/upload/fichiers/audiences/assignations/' . $filename;
                            $fichier->move(public_path('assets/upload/fichiers/audiences/assignations/'), $filename);
                            $pieceAS->save();
                        }
                     }
                }
            }

            // Enregistrement de la requete
            if ($request->typeActe == 'Requete') {
                Requetes::create([
                    'idActe' => $idActeSelect[0]->idActe,
                    'dateRequete' => $request->dateRequete,
                    'dateArriver' => $request->dateArriver,
                    'numRg' => $request->numRgRequete,
                    'juriductionPresidentielle' => $request->juriductionPresidentielle,
                    'slug' => $request->_token . "" . rand(1234, 3458),
                ]);

                if ($request->file('pieceREQ') != null) {

                    $slugRequete = DB::select("select slug from requetes order by idRequete desc limit 1");

                    $fichier = request()->file('pieceREQ');
                    $pieceREQ = new Fichiers();

                    $filename = strtoupper(substr(str_shuffle(md5($request->_token . "" . rand(124, 345))), 0, 4)) . date('YmdHi') . '.' . $fichier->extension();
                    $pieceREQ->nomOriginal = $fichier->getClientOriginalName();
                    $pieceREQ->slugSource =  $slugRequete[0]->slug;
                    $pieceREQ->filename = $filename;
                    $pieceREQ->slug = $request->_token . "" . rand(1234, 3458);
                    $pieceREQ->path = 'assets/upload/fichiers/audiences/requetes/' . $filename;
                    $fichier->move(public_path('assets/upload/fichiers/audiences/requetes/'), $filename);
                    $pieceREQ->save();

                    if (isset($request->formsetPiece)) {
                        foreach ($request->formsetPiece as $key => $value) {
                            $fichier =$value['autrePieces'];
                            $pieceREQ = new Fichiers();

                            $filename = strtoupper(substr(str_shuffle(md5($request->_token . "" . rand(124, 345))), 0, 4)) . date('YmdHi') . '.' . $fichier->extension();
                            $pieceREQ->nomOriginal = $fichier->getClientOriginalName();
                            $pieceREQ->slugSource =  $slugRequete[0]->slug;
                            $pieceREQ->filename = $filename;
                            $pieceREQ->slug = $request->_token . "" . rand(1234, 3458);
                            $pieceREQ->path = 'assets/upload/fichiers/audiences/requetes/' . $filename;
                            $fichier->move(public_path('assets/upload/fichiers/audiences/requetes/'), $filename);
                            $pieceREQ->save();
                        }
                     }
                }
            }

            // Enregistrement de la requete
            if ($request->typeActe == 'Opposition') {
                Oppositions::create([
                    'idActe' => $idActeSelect[0]->idActe,
                    'idHuissier' => $request->idHuissierOpp,
                    'dateActe' => $request->dateActe,
                    'dateProchaineAud' => $request->dateProchaineAud,
                    'numDecision' => $request->numDecisConcerner,
                    'numRg' => $request->numRgOpp,
                    'recepteurAss' => $request->recepteurAssOpp,
                    'datePremiereComp' => $request->datePremiereCompOpp,
                    'dateEnrollement' => $request->dateEnrollementOpp,
                    'mentionParticuliere' => $request->mentionParticuliereOpp,
                    'slug' => $request->_token . "" . rand(1234, 3458),
                ]);

                if ($request->file('pieceASOpp') != null) {

                    $slugOpposition = DB::select("select slug from oppositions order by idOpposition desc limit 1");

                    $fichier = request()->file('pieceASOpp');
                    $pieceAS = new Fichiers();

                    $filename = strtoupper(substr(str_shuffle(md5($request->_token . "" . rand(124, 345))), 0, 4)) . date('YmdHi') . '.' . $fichier->extension();
                    $pieceAS->nomOriginal = $fichier->getClientOriginalName();
                    $pieceAS->slugSource =  $slugOpposition[0]->slug;
                    $pieceAS->filename = $filename;
                    $pieceAS->slug = $request->_token . "" . rand(1234, 3458);
                    $pieceAS->path = 'assets/upload/fichiers/audiences/oppositions/' . $filename;
                    $fichier->move(public_path('assets/upload/fichiers/audiences/oppositions/'), $filename);
                    $pieceAS->save();

                    if (isset($request->formsetPiece)) {
                        foreach ($request->formsetPiece as $key => $value) {
                            $fichier =$value['autrePieces'];
                            $pieceAS = new Fichiers();

                            $filename = strtoupper(substr(str_shuffle(md5($request->_token . "" . rand(124, 345))), 0, 4)) . date('YmdHi') . '.' . $fichier->extension();
                            $pieceAS->nomOriginal = $fichier->getClientOriginalName();
                            $pieceAS->slugSource =  $slugOpposition[0]->slug;
                            $pieceAS->filename = $filename;
                            $pieceAS->slug = $request->_token . "" . rand(1234, 3458);
                            $pieceAS->path = 'assets/upload/fichiers/audiences/oppositions/' . $filename;
                            $fichier->move(public_path('assets/upload/fichiers/audiences/oppositions/'), $filename);
                            $pieceAS->save();
                        }
                     }
                    
                }
            }

            // Enregistrement du PV introgatoire
            if ($request->typeActe == 'PV introgatoire') {
                PvInterrogatoires::create([
                    'idActe' => $idActeSelect[0]->idActe,
                    'dateAudition' => $request->dateAudition,
                    'identiteOPJ' => $request->identiteOPJ,
                    'infractions' => $request->infractions,
                    'dateAudience' => $request->dateAudience,
                    'slug' => $request->_token . "" . rand(1234, 3458),
                ]);
            }

            // Enregistrement du Requisitoire
            if ($request->typeActe == 'Requisitoire') {
                Requisitoires::create([
                    'idActe' => $idActeSelect[0]->idActe,
                    'numInstruction' => $request->numInstruction,
                    'identiteOPJ' => $request->identiteOPJ,
                    'procureur' => $request->procureur,
                    'chefAccusation' => $request->chefAccusationReq,
                    'slug' => $request->_token . "" . rand(1234, 3458),
                ]);
            }

            // Enregistrement de Ordonnance Renvoi
            if ($request->typeActe == 'Ordonnance Renvoi') {
                OrdonnanceRenvois::create([
                    'idActe' => $idActeSelect[0]->idActe,
                    'numOrd' => $request->numOrd,
                    'cabinetIns' => $request->cabinetIns,
                    'typeProcedure' => $request->typeProcedure,
                    'chefAccusation' => $request->chefAccusationOrd,
                    'slug' => $request->_token . "" . rand(1234, 3458),
                ]);
            }

            // Enregistrement de Citation directe
            if ($request->typeActe == 'Citation directe') {
                CitationDirectes::create([
                    'idActe' => $idActeSelect[0]->idActe,
                    'saisi' => $request->saisi,
                    'dateHeureAud' => $request->dateHeureAud,
                    'idHuissier' => $request->idHuissier,
                    'recepteurCitation' => $request->recepteurCitation,
                    'dateSignification' => $request->dateSignification,
                    'mentionParticuliere' => $request->mentionParticuliere,
                    'chefAccusation' => $request->chefAccusation,
                    'slug' => $request->_token . "" . rand(1234, 3458),
                ]);
            }

            // Enregistrement du PCPC
            if ($request->typeActe == 'PCPC') {
                Pcpcs::create([
                    'idActe' => $idActeSelect[0]->idActe,
                    'reference' => $request->reference,
                    'datePcpc' => $request->datePcpc,
                    'dateProchaineAud' => $request->dateProchaineAud,
                    'slug' => $request->_token . "" . rand(1234, 3458),
                ]);
            }

            // Enregistrement de Declaration d'appel
            if ($request->typeActe == "Declaration d'appel") {
                DeclarationAppels::create([
                    'idActe' => $idActeSelect[0]->idActe,
                    'numRg' => $request->numRgDeclaration,
                    'numJugement' => $request->numJugement,
                    'dateAppel' => $request->dateAppel,
                    'slug' => $request->_token . "" . rand(1234, 3458),
                ]);
            }

            // Enregistrement de Contredit
            if ($request->typeActe == "Contredit") {
                Contredits::create([
                    'idActe' => $idActeSelect[0]->idActe,
                    'numConcerner' => $request->numConcerner,
                    'numDecisConcerner' => $request->numDecisConcerner,
                    'dateContredit' => $request->dateContredit,
                    'dateDecision' => $request->dateDecision,
                    'slug' => $request->_token . "" . rand(1234, 3458),
                ]);
            }

            // Enregistrement de Contredit
            if ($request->typeActe == "Pourvoi") {
                Pourvois::create([
                    'idActe' => $idActeSelect[0]->idActe,
                    'numPourvoi' => $request->numPourvoi,
                    'numDecision' => $request->numDecisConcerner,
                    'datePourvoi' => $request->datePourvoi,
                    'dateDecision' => $request->dateDecision,
                    'slug' => $request->_token . "" . rand(1234, 3458),
                ]);
            }

            // Notifications
            //$personnels = DB::select("select * from personnels,users where personnels.email=users.email and users.role='Collaborateur'");
            $personnels = DB::select("select * from personnels,users where personnels.email=users.email ");
            foreach ($personnels as $p) {

                DB::select(
                    'INSERT INTO notifications(categorie, messages, etat, idRecepteur,slug,a_biper,urlName,urlParam) VALUES(?,?,?,?,?,?,?,?)',
                    [
                        'Audience',
                        'Un niveau procedural a été ajoutée.',
                        'masquer',
                        $p->idPersonnel,
                        $request->_token . "" . rand(1234, 3458),
                        "non",
                        "detailAudience",
                        $audiences->slug
                    ]
                );
            }

            $admins = DB::select("select * from users where role='Administrateur'");

            foreach ($admins as $a) {
                DB::select(
                    'INSERT INTO notifications(categorie, messages, etat, idRecepteur,slug,a_biper,urlName,urlParam,idAdmin) VALUES(?,?,?,?,?,?,?,?,?)',
                    [
                        'Audience',
                        'Un niveau procedural a été ajoutée.',
                        'masquer',
                        'admin',
                        $request->_token . "" . rand(1234, 3458),
                        "non",
                        "detailAudience",
                        $audiences->slug,
                        $a->id
                    ]
                );
            }
        }
        

        return redirect()->route('listAudience', 'generale')->with('success', ' Passage de l\'audience au niveau suivant effectué avec succès');

        });
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param   int $id
     * @param   string $slug
     * @return \Illuminate\Http\Response
     */
    public function editAudience(Request $request, $slug, $id)
    {
        return DB::transaction(function () use ($request, $slug, $id) {

        $TYPE_ADVERSE = ['Entreprise', 'Personne physique'];

        $today = date('Y-m-d');

        // L'instance du model FileAudience'
        $fichiers = new Fichiers();


        if ($request) {

            $messages = [
                'juridiction.required' => 'Le champ juridiction est obligatoire.',
                'objet.required' => 'Le champ objet est obligatoire.',
                'niveauProcedural.required' => 'Le champ niveau procedural est obligatoire.',
                'nature.required' => 'Le champ nature est obligatoire.',
               
                // ...
            ];

            // Enregistrement des informations de l'audience
            $request->validate([
                'juridiction' => 'required',
                'objet' => 'required',
                'niveauProcedural' => 'required',
                'nature' => 'required',
                
            ], $messages);
            // L'instance du model Audience
            $audiences = Audiences::find($id);
            if (isset($request->numRg)) {
                $num = $request->numRg;
            } elseif (isset($request->numRgOpp)) {
                $num = $request->numRgOpp;
            } elseif (isset($request->numRgRequete)) {
                $num = $request->numRgRequete;
            } elseif (isset($request->numRgDeclaration)) {
                $num = $request->numRgDeclaration;
            } else {
                $num = '';
            }
            $audiences->objet = $request->objet;
            $audiences->juridiction = $request->juridiction;
            $audiences->niveauProcedural = $request->niveauProcedural;
            $audiences->nature = $request->nature;
            $audiences->numRg = $num;
            $audiences->statut = 'En cours';

            if ($request->file('pieceInstruction') != null) {

                $audiences->pieceInstruction = rand(124, 875) . $request->_token . rand(1234, 8765);

                $fichier = request()->file('pieceInstruction');
                $pieceInstruction = new Fichiers();

                $filename = strtoupper(substr(str_shuffle(md5($request->_token . "" . rand(124, 345))), 0, 4)) . date('YmdHi') . '.' . $fichier->extension();
                $pieceInstruction->nomOriginal = $fichier->getClientOriginalName();
                $pieceInstruction->slugSource =  $audiences->pieceInstruction;
                $pieceInstruction->filename = $filename;
                $pieceInstruction->slug = $request->_token . "" . rand(1234, 3458);
                $pieceInstruction->path = 'assets/upload/fichiers/audiences/instructions/' . $filename;
                $fichier->move(public_path('assets/upload/fichiers/audiences/instructions/'), $filename);
                $pieceInstruction->save();
            }

            $audiences->save();

            // Enregistrement des parties
            $idAudienceSelect = DB::select("select idAudience from audiences where idAudience=? order by idAudience desc limit 1",[$id]);
            $partiesEnrg = DB::select("select * from parties where idAudience=?",[$id]);
            foreach ($partiesEnrg as $key => $v) {
                DB::delete("delete from avocat_parties where idPartie=?",[$v->idPartie]);
                DB::delete("delete from personne_adverses where idPartie=?",[$v->idPartie]);
                DB::delete("delete from entreprise_adverses where idPartie=?",[$v->idPartie]);
            }
            DB::delete("delete from parties where idAudience=?",[$id]);
            foreach ($request->formset as $key => $value) {

                if (isset($value['autreRole'])) {
                    $autreRole = $value['autreRole'];
                } else {
                    $autreRole = '';
                }

                if (isset($value['idClient'])) {
                    $idClient = $value['idClient'];
                } else {
                    $idClient = null;
                }

                if (isset($value['idAffaire'])) {
                    $idAffaire = $value['idAffaire'];
                } else {
                    $idAffaire = null;
                }
                if (isset($value['typeAvocat'])) {
                    $typeAvocat = $value['typeAvocat'];
                } else {
                    $typeAvocat = 2;
                }

                if (is_array($value)) {
                    Parties::create([
                        'idAudience' => $idAudienceSelect[0]->idAudience,
                        'role' => $value['role'],
                        'autreRole' =>  $autreRole,
                        'idClient' => $idClient,
                        'idAffaire' => $idAffaire,
                        'typeAvocat' => $typeAvocat,
                        'slug' => $request->_token . "" . rand(1234, 3458),
                    ]);

                    $dernierePartie = DB::select("select * from parties order by idPartie desc limit 1");

                    if (isset($value['idAvocat'])) {
                        $arr = $value['idAvocat'];
    
                        for ($i = 0; $i < count($arr); $i++) {
    
                            AvocatParties::create([
                                'idPartie' => $dernierePartie[0]->idPartie,
                                'idAvocat' =>  $arr[$i],
                                'slug' => $request->_token . "" . rand(1234, 3458),
                            ]);
                        }
                    }

                    if (isset($value['typeAdverse']) && $value['typeAdverse'] == "Personne physique") {

                        PersonneAdverse::create([
                            'idPartie' => $dernierePartie[0]->idPartie,
                            'prenom' => $value['prenom'],
                            'nom' => $value['nom'],
                            'telephone' => $value['telephone'],
                            'nationalite' => $value['nationalite'],
                            'profession' => $value['profession'],
                            'dateNaissance' => $value['dateNaissance'],
                            'lieuNaissance' => $value['lieuNaissance'],
                            'pays' => $value['pays'],
                            'domicile' => $value['domicile'],
                            'slug' => $request->_token . "" . rand(1234, 3458),
                        ]);
                    }

                    if (isset($value['typeAdverse']) && $value['typeAdverse'] == "Entreprise") {

                        EntrepriseAdverse::create([
                            'idPartie' => $dernierePartie[0]->idPartie,
                            'denomination' => $value['denomination'],
                            'numRccm' => $value['numRccm'],
                            'siegeSocial' => $value['siegeSocial'],
                            'formeLegal' => $value['formeLegal'],
                            'representantLegal' => $value['representantLegal'],
                            'slug' => $request->_token . "" . rand(1234, 3458),
                        ]);
                    }

                }
            
            }


            // Enregistrement de l'acte introductifs
            // ActeIntroductifs::create([
            //     'idAudience' => $idAudienceSelect[0]->idAudience,
            //     'typeActe' => $request->typeActe,
            //     'idNatureAction' => $request->idNatureAction,
            //     'slug' => $request->_token . "" . rand(1234, 3458),
            // ]);

            $idActeSelect = DB::select("select idActe from acte_introductifs where idAudience=? order by idActe desc limit 1",[$id]);

            // Enregistrement de l'Assignation
            if ($request->typeActe == 'Assignation') {
                $assignations = Assignations::where('idActe', $idActeSelect[0]->idActe)->firstOrFail();
                $assignations->idActe = $idActeSelect[0]->idActe;
                $assignations->numRg =  $request->numRg;
                $assignations->idHuissier =  $request->idHuissier;
                $assignations->recepteurAss =  $request->recepteurAss;
                $assignations->dateAssignation=  $request->dateAssignation;
                $assignations->datePremiereComp =  $request->datePremiereComp;
                $assignations->dateEnrollement =  $request->dateEnrollement;
                $assignations->mentionParticuliere =  $request->mentionParticuliere;
                $assignations->save();

                if ($request->file('pieceAS') != null) {

                    $slugAssignation = DB::select("select slug from assignations order by idAssignation desc limit 1");

                    $fichier = request()->file('pieceAS');
                    $pieceAS = new Fichiers();

                    $filename = strtoupper(substr(str_shuffle(md5($request->_token . "" . rand(124, 345))), 0, 4)) . date('YmdHi') . '.' . $fichier->extension();
                    $pieceAS->nomOriginal = $fichier->getClientOriginalName();
                    $pieceAS->slugSource =  $slugAssignation[0]->slug;
                    $pieceAS->filename = $filename;
                    $pieceAS->path = 'assets/upload/fichiers/audiences/assignations/' . $filename;
                    $fichier->move(public_path('assets/upload/fichiers/audiences/assignations/'), $filename);
                    $pieceAS->save();
                }
            }

            // Enregistrement de la requete
            if ($request->typeActe == 'Requete') {
                
                $requetes = Requetes::where('idActe', $idActeSelect[0]->idActe)->firstOrFail();
                $requetes->idActe = $idActeSelect[0]->idActe;
                $requetes->dateRequete =  $request->dateRequete;
                $requetes->dateArriver =  $request->dateArriver;
                $requetes->numRg =  $request->numRgRequete;
                $requetes->juriductionPresidentielle=  $request->juriductionPresidentielle;                
                $requetes->save();

                if ($request->file('pieceREQ') != null) {

                    $slugRequete = DB::select("select slug from requetes order by idRequete desc limit 1");

                    $fichier = request()->file('pieceREQ');
                    $pieceREQ = new Fichiers();

                    $filename = strtoupper(substr(str_shuffle(md5($request->_token . "" . rand(124, 345))), 0, 4)) . date('YmdHi') . '.' . $fichier->extension();
                    $pieceREQ->nomOriginal = $fichier->getClientOriginalName();
                    $pieceREQ->slugSource =  $slugRequete[0]->slug;
                    $pieceREQ->filename = $filename;
                    $pieceREQ->slug = $request->_token . "" . rand(1234, 3458);
                    $pieceREQ->path = 'assets/upload/fichiers/audiences/requetes/' . $filename;
                    $fichier->move(public_path('assets/upload/fichiers/audiences/requetes/'), $filename);
                    $pieceREQ->save();
                }
            }

            // Enregistrement de la requete
            if ($request->typeActe == 'Opposition') {
               

                $oppositions = Oppositions::where('idActe', $idActeSelect[0]->idActe)->firstOrFail();
                $oppositions->idActe = $idActeSelect[0]->idActe;
                $oppositions->idHuissier =  $request->idHuissierOpp;
                $oppositions->dateActe =  $request->dateActe;
                $oppositions->dateProchaineAud =  $request->dateProchaineAud;
                $oppositions->numDecision =  $request->numDecisConcerner;
                $oppositions->numRg =  $request->numRgOpp;
                $oppositions->recepteurAss =  $request->recepteurAssOpp;
                $oppositions->datePremiereComp =  $request->datePremiereCompOpp;
                $oppositions->dateEnrollement =  $request->dateEnrollementOpp;
                $oppositions->mentionParticuliere=  $request->mentionParticuliereOpp;                
                $oppositions->save();

                if ($request->file('pieceASOpp') != null) {

                    $slugOpposition = DB::select("select slug from oppositions order by idOpposition desc limit 1");

                    $fichier = request()->file('pieceASOpp');
                    $pieceAS = new Fichiers();

                    $filename = strtoupper(substr(str_shuffle(md5($request->_token . "" . rand(124, 345))), 0, 4)) . date('YmdHi') . '.' . $fichier->extension();
                    $pieceAS->nomOriginal = $fichier->getClientOriginalName();
                    $pieceAS->slugSource =  $slugOpposition[0]->slug;
                    $pieceAS->filename = $filename;
                    $pieceAS->slug = $request->_token . "" . rand(1234, 3458);
                    $pieceAS->path = 'assets/upload/fichiers/audiences/oppositions/' . $filename;
                    $fichier->move(public_path('assets/upload/fichiers/audiences/oppositions/'), $filename);
                    $pieceAS->save();
                }
            }

            // Enregistrement du PV introgatoire
            if ($request->typeActe == 'PV introgatoire') {
               
                $pvInterrogatoires = PvInterrogatoires::where('idActe', $idActeSelect[0]->idActe)->firstOrFail();
                $pvInterrogatoires->idActe = $idActeSelect[0]->idActe;
                $pvInterrogatoires->dateAudition =  $request->dateAudition;
                $pvInterrogatoires->identiteOPJ =  $request->identiteOPJ;
                $pvInterrogatoires->infractions =  $request->infractions;
                $pvInterrogatoires->dateAudience =  $request->dateAudience;               
                $pvInterrogatoires->save();
            }

            // Enregistrement du Requisitoire
            if ($request->typeActe == 'Requisitoire') {

                $requisitoires = Requisitoires::where('idActe', $idActeSelect[0]->idActe)->firstOrFail();
                $requisitoires->idActe = $idActeSelect[0]->idActe;
                $requisitoires->numInstruction =  $request->numInstruction;
                $requisitoires->identiteOPJ =  $request->identiteOPJ;
                $requisitoires->procureur =  $request->procureur;
                $requisitoires->chefAccusation =  $request->chefAccusationReq;               
                $requisitoires->save();
            }

            // Enregistrement de Ordonnance Renvoi
            if ($request->typeActe == 'Ordonnance Renvoi') {

                $ordonnanceRenvois = OrdonnanceRenvois::where('idActe', $idActeSelect[0]->idActe)->firstOrFail();
                $ordonnanceRenvois->idActe = $idActeSelect[0]->idActe;
                $ordonnanceRenvois->numOrd =  $request->numOrd;
                $ordonnanceRenvois->cabinetIns =  $request->cabinetIns;
                $ordonnanceRenvois->typeProcedure =  $request->typeProcedure;
                $ordonnanceRenvois->chefAccusation =  $request->chefAccusationOrd;               
                $ordonnanceRenvois->save();
            }

            // Enregistrement de Citation directe
            if ($request->typeActe == 'Citation directe') {

                $citationDirectes = CitationDirectes::where('idActe', $idActeSelect[0]->idActe)->firstOrFail();
                $citationDirectes->idActe = $idActeSelect[0]->idActe;
                $citationDirectes->saisi =  $request->saisi;
                $citationDirectes->dateHeureAud =  $request->dateHeureAud;
                $citationDirectes->idHuissier =  $request->idHuissier;
                $citationDirectes->recepteurCitation =  $request->recepteurCitation;               
                $citationDirectes->dateSignification =  $request->dateSignification;               
                $citationDirectes->mentionParticuliere =  $request->mentionParticuliere;               
                $citationDirectes->chefAccusation =  $request->chefAccusation;               
                $citationDirectes->save();
            }

            // Enregistrement du PCPC
            if ($request->typeActe == 'PCPC') {

                $pcpcs = Pcpcs::where('idActe', $idActeSelect[0]->idActe)->firstOrFail();
                $pcpcs->idActe = $idActeSelect[0]->idActe;
                $pcpcs->reference =  $request->reference;
                $pcpcs->datePcpc =  $request->datePcpc;
                $pcpcs->dateProchaineAud =  $request->dateProchaineAud;             
                $pcpcs->save();
            }

            // Enregistrement de Declaration d'appel
            if ($request->typeActe == "Declaration d'appel") {
                
                $declarationAppels = DeclarationAppels::where('idActe', $idActeSelect[0]->idActe)->firstOrFail();
                $declarationAppels->idActe = $idActeSelect[0]->idActe;
                $declarationAppels->numRg =  $request->numRgDeclaration;
                $declarationAppels->numJugement =  $request->numJugement;
                $declarationAppels->dateAppel =  $request->dateAppel;             
                $declarationAppels->save();
            }

            // Enregistrement de Contredit
            if ($request->typeActe == "Contredit") {

                $contredits = Contredits::where('idActe', $idActeSelect[0]->idActe)->firstOrFail();
                $contredits->idActe = $idActeSelect[0]->idActe;
                $contredits->numConcerner =  $request->numConcerner;
                $contredits->numDecisConcerner =  $request->numDecisConcerner;
                $contredits->dateContredit =  $request->dateContredit;             
                $contredits->dateDecision =  $request->dateDecision;             
                $contredits->save();
            }

            // Enregistrement de Contredit
            if ($request->typeActe == "Pourvoi") {
               

                $pourvois = Pourvois::where('idActe', $idActeSelect[0]->idActe)->firstOrFail();
                $pourvois->idActe = $idActeSelect[0]->idActe;
                $pourvois->numPourvoi =  $request->numPourvoi;
                $pourvois->numDecision =  $request->numDecisConcerner;
                $pourvois->datePourvoi =  $request->datePourvoi;             
                $pourvois->dateDecision =  $request->dateDecision;             
                $pourvois->save();
            }


           
        }
        

        return redirect()->back()->with('success', 'Audience modifiée avec succès');

     });
    }

    /**
     * Display the specified resource.
     *
     * @param  string  $slug
     * @return \Illuminate\Http\Response
     */
    public function show($id, $slug, $niveau)
    {

        $monClient = DB::table('parties')
            ->join('affectation_personnels', 'parties.idClient', '=', 'affectation_personnels.idClient')
            ->join('personnels', 'affectation_personnels.idPersonnel', '=', 'personnels.idPersonnel')
            ->where('personnels.email', Auth::user()->email)
            ->where('parties.idAudience', $id)
            ->select('parties.*')
            ->get();
   
            $verif_client = !$monClient->isEmpty();

            // Utilisation de la variable $is_client
            if ($verif_client) {
                $is_client=true;
            } else {
                $is_client=false;
            }
       
        // Récupérer le nom de la route précédente
        $nomRoutePrecedente = URL::previous();

        $allAudience = DB::select("SELECT idAudience, numRg, objet, niveauProcedural, slugAud, statutAud
            FROM (
                SELECT MAX(idAudience) as idAudience, MAX(numRg) as numRg, MAX(objet) as objet, MAX(niveauProcedural) as niveauProcedural, slugAud, statutAud
                FROM (
                    SELECT  audiences.idAudience, audiences.slug AS slugAud, numRg, objet, niveauProcedural, prenom, nom, denomination, NULL as numRccm, NULL as formeLegal, audiences.statut as statutAud
                    FROM audiences
                    JOIN parties ON audiences.idAudience = parties.idAudience
                    LEFT JOIN clients ON parties.idClient = clients.idClient
        
                    UNION
        
                    SELECT audiences.idAudience, audiences.slug AS slugAud, numRg, objet, niveauProcedural, prenom, nom, NULL as denomination, NULL as numRccm, NULL as formeLegal, audiences.statut as statutAud
                    FROM audiences
                    JOIN parties ON audiences.idAudience = parties.idAudience
                    JOIN personne_adverses ON parties.idPartie = personne_adverses.idPartie
        
                    UNION
        
                    SELECT audiences.idAudience, audiences.slug AS slugAud, numRg, objet, niveauProcedural, NULL as prenom, NULL as nom, denomination, numRccm, formeLegal, audiences.statut as statutAud
                    FROM audiences
                    JOIN parties ON audiences.idAudience = parties.idAudience
                    JOIN entreprise_adverses ON parties.idPartie = entreprise_adverses.idPartie
                ) AS subquery_internal
                GROUP BY subquery_internal.slugAud, subquery_internal.statutAud
            ) AS subquery 
            WHERE niveauProcedural = '$niveau'
            ORDER BY idAudience ASC
        ");


        $personne_adverses2 = DB::select("select * from personne_adverses,parties where parties.idPartie=personne_adverses.idPartie");

        $entreprise_adverses2 = DB::select("select * from entreprise_adverses,parties where parties.idPartie=entreprise_adverses.idPartie");

        $autreRoles2 = DB::select("select * from parties,audiences where audiences.idAudience=parties.idAudience");

        $cabinet2 =  DB::select("select parties.idPartie,nom,prenom,email,emailEntreprise,affaires.slug as affaireslug,nomAffaire,affaires.idAffaire,denomination,clients.slug as clientslug,clients.idClient,role,idAudience from parties,clients,affaires where parties.idClient=clients.idClient and parties.idAffaire=affaires.idAffaire");


        $idAudience = $id;

        $audience = DB::select("select * from audiences,juriductions where audiences.juridiction=juriductions.id and audiences.slug=? and niveauProcedural=?", [$slug, $niveau]);
        
        $SqltacheSuivit = DB::select("select idSuivit,slug from taches where audTache=?",[$id]);

        $tacheSuivit = collect($SqltacheSuivit)->pluck('idSuivit')->toArray();


        $audience2 = DB::select("select * from audiences,juriductions where audiences.juridiction=juriductions.id and audiences.slug=? order by audiences.idAudience desc limit 1", [$slug]);

        if (empty($audience)) {

            $parties = [];
            $acteIntroductif = [];
            $acteSignifications = [];
            $avocats = [];
            $cabinet = [];
            $personne_adverses = [];
            $entreprise_adverses = [];
            $assignation = [];
            $citationDirect = [];
            $citations = [];
            $autreActes = [];
            $contredit = [];
            $declarationAppel = [];
            $opposition = [];
            $ordonnanceRenvois = [];
            $pcpcs = [];
            $pourvoi = [];
            $pvIntrogatoire = [];
            $requete = [];
            $requisitoire = [];
            $suivi = [];
            $pieceAS = [];
            $pieceCita = [];
            $pieceSign = [];
            $pieceREQ = [];
            $pieceOpp = [];
            $pieceSupplement = [];
            $autreRoles = [];
            $suiviAppel = [];
            $pieceParents = [];
            $autrePieceParents = [];
            $audienceParents = [];
            $audienceFils = [];
            $cabinet =  DB::select("select parties.idPartie,nom,prenom,parties.idAudience,email,emailEntreprise,affaires.slug as affaireslug,nomAffaire,affaires.idAffaire,denomination,clients.slug as clientslug,clients.idClient,role,autreRole from parties,clients,affaires where parties.idClient=clients.idClient and parties.idAffaire=affaires.idAffaire and idAudience=? ", [$audience2[0]->idAudience]);

            $paramCabinet = DB::select("select * from cabinets");

        } else {

            $parties = DB::select("select * from parties  where  idAudience=?", [$audience[0]->idAudience]);

            $avocats = DB::select("select * from avocat_parties,avocats where avocat_parties.idAvocat=avocats.idAvc");

            $cabinet =  DB::select("select parties.idPartie,parties.idAudience,nom,prenom,email,emailEntreprise,affaires.slug as affaireslug,nomAffaire,affaires.idAffaire,denomination,clients.slug as clientslug,clients.idClient,role,autreRole from parties,clients,affaires where parties.idClient=clients.idClient and parties.idAffaire=affaires.idAffaire and idAudience=? ", [$audience[0]->idAudience]);
            
            $paramCabinet = DB::select("select * from cabinets");
            

            $personne_adverses = DB::select("select * from personne_adverses,parties where parties.idPartie=personne_adverses.idPartie and parties.idAudience=?", [$audience[0]->idAudience]);

            $entreprise_adverses = DB::select("select * from entreprise_adverses,parties where parties.idPartie=entreprise_adverses.idPartie and parties.idAudience=?", [$audience[0]->idAudience]);

            $autreRoles = DB::select("select * from parties,audiences where audiences.idAudience=parties.idAudience and parties.idAudience=?", [$audience[0]->idAudience]);

            $acteIntroductif = DB::select("select * from acte_introductifs where  idAudience=?", [$audience[0]->idAudience]);

            $acteSignifications = DB::select("select * from huissiers,significations where huissiers.idHss=significations.idHss and slugAudience=? order by idSignification desc", [$audience[0]->slug]);
            if (!empty($acteSignifications)) {
                $pieceSign = DB::select("select * from fichiers where slugSource=?", [$acteSignifications[0]->slug]);
            } else {
               $pieceSign = [];
            }
            

            $assignation = [];
            $citationDirect = [];
            $citations = [];
            $autreActes = [];
            $contredit = [];
            $declarationAppel = [];
            $opposition = [];
            $ordonnanceRenvois = []; 
            $pcpcs = [];
            $pourvoi = [];
            $pvIntrogatoire = [];
            $requete = [];
            $requisitoire = [];


            foreach ($acteIntroductif as $key => $value) {

                $assignationItem = DB::select("select assignations.slug,numRg,recepteurAss,dateAssignation,datePremiereComp,dateEnrollement,mentionParticuliere,prenomHss,nomHss from assignations,huissiers where assignations.idHuissier=huissiers.idHss and idActe=?", [$value->idActe]);

                $citationDirectItem = DB::select("select * from citation_directes,huissiers where citation_directes.idHuissier=huissiers.idHss and idActe=?", [$value->idActe]);
                $contreditItem = DB::select("select * from contredits where idActe=?", [$value->idActe]);
                $declarationAppelItem = DB::select("select * from declaration_appels where idActe=?", [$value->idActe]);
                $oppositionItem = DB::select("select * from huissiers,oppositions where oppositions.idHuissier=huissiers.idHss and idActe=?", [$value->idActe]);
                $ordonnanceRenvoisItem = DB::select("select * from ordonnance_renvois where idActe=?", [$value->idActe]);
                $pcpcsItem = DB::select("select * from pcpcs where idActe=?", [$value->idActe]);
                $pourvoiItem = DB::select("select * from pourvois where idActe=?", [$value->idActe]);
                $pvIntrogatoireItem = DB::select("select * from pv_interrogatoires where idActe=?", [$value->idActe]);
                $requeteItem = DB::select("select * from requetes where idActe=?", [$value->idActe]);
                $autreActesItem = DB::select("select * from autre_actes where idActe=?", [$value->idActe]);
                $citationsItem = DB::select("select * from huissiers,citations where citations.idHuissier=huissiers.idHss and idActe=?", [$value->idActe]);
                $requisitoireItem = DB::select("select * from requisitoires where idActe=?", [$value->idActe]);
            
                if (empty($assignationItem)) {
                    $pieceAS = [];
                } else {
                    $pieceAS = DB::select("select * from fichiers where slugSource=?", [$assignationItem[0]->slug]);
                }

                if (empty($requeteItem)) {
                    $pieceREQ = [];
                } else {
                    $pieceREQ = DB::select("select * from fichiers where slugSource=?", [$requeteItem[0]->slug]);
                }

                if (empty($oppositionItem)) {
                    $pieceOpp = [];
                } else {
                    $pieceOpp = DB::select("select * from fichiers where slugSource=?", [$oppositionItem[0]->slug]);
                }

                if (empty($citationsItem)) {
                    $pieceCita = [];
                } else {
                    $pieceCita = DB::select("select * from fichiers where slugSource=?", [$citationsItem[0]->slug]);
                }



                $assignation = array_merge($assignation, $assignationItem);
                $citationDirect = array_merge($citationDirect, $citationDirectItem);
                $citations = array_merge($citations, $citationsItem);
                $autreActes = array_merge($autreActes, $autreActesItem);
                $contredit = array_merge($contredit, $contreditItem);
                $declarationAppel = array_merge($declarationAppel, $declarationAppelItem);
                $opposition = array_merge($opposition, $oppositionItem);
                $ordonnanceRenvois = array_merge($ordonnanceRenvois, $ordonnanceRenvoisItem);
                $pcpcs = array_merge($pcpcs, $pcpcsItem);
                $pourvoi = array_merge($pourvoi, $pourvoiItem);
                $pvIntrogatoire = array_merge($pvIntrogatoire, $pvIntrogatoireItem);
                $requete = array_merge($requete, $requeteItem);
                $requisitoire = array_merge($requisitoire, $requisitoireItem);
            }

           
           
            $pieceSupplement = DB::select("select * from fichiers where slugSource=?", [$audience[0]->slug]);

            //dd($assignation);
            // Récuperation des données du suivi depuis la base de données
            $suivi = DB::select("select * from suivit_audiences where idAudience=? ORDER BY DATE(dateAudience) DESC", [$audience[0]->idAudience]);


            $suiviAppel = DB::select("select * from suivit_audience_appels where idAudience=? ORDER BY DATE(dateActe) DESC", [$audience[0]->idAudience]);

            $audienceParents = DB::select("select * from audiences where isChild='non' and slugJonction=?",[$audience[0]->slugJonction]);

            $audienceFils = DB::select("select * from audiences where isChild='oui' and slugJonction=?",[$audience[0]->slugJonction]);

            if (empty($audienceParents)) {
                $pieceParents=[];
                $autrePieceParents=[];
            } else {

                $pieceParents=[];
                $autrePieceParents=[];

                foreach ($audienceParents as $key => $value) {

                    $acteIntroductif2 = DB::select("select * from acte_introductifs where  idAudience=?", [$value->idAudience]);

                    $assignation2 = DB::select("select assignations.slug,numRg,recepteurAss,dateAssignation,datePremiereComp,dateEnrollement,mentionParticuliere,prenomHss,nomHss from assignations,huissiers where assignations.idHuissier=huissiers.idHss and idActe=?", [$acteIntroductif2[0]->idActe]);
                    $citationDirect2 = DB::select("select * from citation_directes,huissiers where citation_directes.idHuissier=huissiers.idHss and idActe=?", [$acteIntroductif2[0]->idActe]);
                    $contredit2 = DB::select("select * from contredits where idActe=?", [$acteIntroductif2[0]->idActe]);
                    $declarationAppel2 = DB::select("select * from declaration_appels where idActe=?", [$acteIntroductif2[0]->idActe]);
                    $opposition2 = DB::select("select * from huissiers,oppositions where oppositions.idHuissier=huissiers.idHss and idActe=?", [$acteIntroductif2[0]->idActe]);
                    $ordonnanceRenvois2 = DB::select("select * from ordonnance_renvois where idActe=?", [$acteIntroductif2[0]->idActe]);
                    $pcpcs2 = DB::select("select * from pcpcs where idActe=?", [$acteIntroductif2[0]->idActe]);
                    $pourvoi2 = DB::select("select * from pourvois where idActe=?", [$acteIntroductif2[0]->idActe]);
                    $pvIntrogatoire2 = DB::select("select * from pv_interrogatoires where idActe=?", [$acteIntroductif2[0]->idActe]);
                    $requete2 = DB::select("select * from requetes where idActe=?", [$acteIntroductif2[0]->idActe]);
                    $requisitoire2 = DB::select("select * from requisitoires where idActe=?", [$acteIntroductif2[0]->idActe]);
                    $citations2 = DB::select("select * from citations where idActe=?", [$acteIntroductif2[0]->idActe]);
                
                    if (empty($assignation2)) {
                        $pieceAS = [];
                    } else {
                        $pieceAS = DB::select("select * from fichiers where slugSource=?", [$assignation2[0]->slug]);
                        $pieceParents = array_merge($pieceParents, $pieceAS);
                    }

                    if (empty($requete2)) {
                        $pieceREQ = [];
                    } else {
                        $pieceREQ = DB::select("select * from fichiers where slugSource=?", [$requete2[0]->slug]);
                        $pieceParents = array_merge($pieceParents, $pieceREQ);
                    }

                    if (empty($opposition2)) {
                        $pieceOpp = [];
                    } else {
                        $pieceOpp = DB::select("select * from fichiers where slugSource=?", [$opposition2[0]->slug]);
                        $pieceParents = array_merge($pieceParents, $pieceOpp);
                    }
                    if (empty($citations2)) {
                        $pieceCita = [];
                    } else {
                        $pieceCita = DB::select("select * from fichiers where slugSource=?", [$opposition2[0]->slug]);
                        $pieceParents = array_merge($pieceParents, $pieceCita);
                    }
                    $autrePieceParents = DB::select("select * from fichiers where slugSource=?", [$value->slug]);
                }
            }

            //Update de notification
            $email = Auth::user()->email;
            $personnel = DB::select('select * from personnels where email=? ', [$email]);

            foreach ($suivi as $key => $value) {

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

            foreach ($suiviAppel as $key => $value) {

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

            foreach ($audience as $key => $value) {

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
        }

        $annuaires = DB::select('select * from annuaires');

        $huissiers = DB::select('select * from huissiers');

        $fichiers = DB::select('select * from fichiers');

        $cabinetForPlan = DB::select("select * from cabinets");

        $plan = $cabinetForPlan[0]->plan;

        $clients = DB::select('select * from clients');



       // $contraditoire_requete = DB::select("SELECT * FROM procedure_liers,procedure_requetes WHERE typeProcedure ='requete' and procedure_liers.slugProcedure=procedure_requetes.slug and procedure_liers.slugSource=?",[$slug]);
       // dd($contraditoire_requete);

        $audiences_contraditoire = DB::select("SELECT * FROM procedure_liers,audiences  WHERE procedure_liers.typeProcedure ='audience' and procedure_liers.slugProcedure = audiences.slug  and  procedure_liers.slugSource=?",[$slug]);

        $audiences_contraditoire_lier = DB::select("SELECT * FROM procedure_liers,audiences  WHERE procedure_liers.typeProcedure ='audience' and procedure_liers.slugSource = audiences.slug  and  procedure_liers.slugProcedure=?",[$slug]);
        //dd($audiences_contraditoire_lier);


        $audience_contraditoire_partie = DB::select("
        SELECT clients.*, parties.*, procedure_liers.*, audiences.*
            FROM parties
            INNER JOIN clients ON clients.idClient = parties.idClient
            INNER JOIN audiences ON audiences.idAudience = parties.idAudience
            INNER JOIN procedure_liers ON procedure_liers.slugSource = audiences.slug
            WHERE procedure_liers.typeProcedure = 'audience'
            AND procedure_liers.slugProcedure = ?
        ", [$slug]);

        //dd($audience_contraditoire_partie);

        $audience_contraditoire_partie2 = DB::select("
        SELECT clients.*, parties.*, procedure_liers.*, audiences.*
            FROM parties
            INNER JOIN clients ON clients.idClient = parties.idClient
            INNER JOIN audiences ON audiences.idAudience = parties.idAudience
            INNER JOIN procedure_liers ON procedure_liers.slugProcedure = audiences.slug
            WHERE procedure_liers.typeProcedure = 'audience'
            AND procedure_liers.slugSource = ?
        ", [$slug]);

        //dd($audience_contraditoire_partie2);



        $procedure_autreRole = DB::select("SELECT * From audiences, parties ,procedure_liers where  audiences.idAudience = parties.idAudience and procedure_liers.slugProcedure = audiences.slug  and parties.role = 'Autre'");
   
        //dd($procedure_autreRole);

        $procedure_autreRole1 = DB::select("SELECT * From audiences, parties ,procedure_liers where  audiences.idAudience = parties.idAudience and procedure_liers.slugSource = audiences.slug  and parties.role = 'Autre'");
   
        //dd($procedure_autreRole);

        $procedure_autreRole_requete = DB::select("SELECT * From procedure_requetes, parties_requetes ,procedure_liers where  procedure_requetes.idProcedure = parties_requetes.idRequete and procedure_liers.slugProcedure = procedure_requetes.slug  and parties_requetes.role = 'Autre'");
   
        //dd($procedure_autreRole);

        $procedure_autreRole_requete1 = DB::select("SELECT * From procedure_requetes, parties_requetes ,procedure_liers where  procedure_requetes.idProcedure = parties_requetes.idRequete and procedure_liers.slugSource = procedure_requetes.slug  and parties_requetes.role = 'Autre'");
      //dd($procedure_autreRole_requete1);
        
        

        $audience_contraditoire_entreprise_adverses = DB::select("SELECT * FROM entreprise_adverses,parties, audiences, procedure_liers where  entreprise_adverses.idPartie = parties.idPartie and procedure_liers.typeProcedure ='audience' and  parties.idAudience = audiences.idAudience and procedure_liers.slugSource = audiences.slug and procedure_liers.slugProcedure =? ",[$slug]) ;

        $audience_contraditoire_entreprise_adverses2 = DB::select("SELECT * FROM entreprise_adverses,parties, audiences, procedure_liers where  entreprise_adverses.idPartie = parties.idPartie and procedure_liers.typeProcedure ='audience' and  parties.idAudience = audiences.idAudience and procedure_liers.slugProcedure = audiences.slug and procedure_liers.slugSource =? ",[$slug]) ;
        //dd($audience_contraditoire_entreprise_adverses2);

        $audience_contraditoire_personne_adverses = DB::select("SELECT * FROM personne_adverses,parties, audiences, procedure_liers where  personne_adverses.idPartie = parties.idPartie and procedure_liers.typeProcedure ='audience' and  parties.idAudience = audiences.idAudience and procedure_liers.slugSource = audiences.slug and procedure_liers.slugProcedure =? ",[$slug]) ;
        //dd($audience_contraditoire_partie,$audience_contraditoire_personne_adverses);

        $audience_contraditoire_personne_adverses2 = DB::select("SELECT * FROM personne_adverses,parties, audiences, procedure_liers where  personne_adverses.idPartie = parties.idPartie and procedure_liers.typeProcedure ='audience' and  parties.idAudience = audiences.idAudience and procedure_liers.slugProcedure = audiences.slug and procedure_liers.slugSource =? ",[$slug]) ;
        //dd($audience_contraditoire_personne_adverses2);
       

        //dd($audiences_contraditoire_lier,$audience_contraditoire_partie,$audience_contraditoire_entreprise_adverses,$audience_contraditoire_personne_adverses);


        $requete_contraditoire = DB::select("SELECT * FROM procedure_liers ,audiences,procedure_requetes where procedure_liers.typeProcedure ='audience' and  procedure_liers.slugSource=procedure_requetes.slug and procedure_liers.slugProcedure = audiences.slug  and procedure_liers.slugProcedure =?",[$slug]);
        //dd($requete_contraditoire);


        $requete_contraditoire_partie = DB::select("
        SELECT clients.*, parties_requetes.*, procedure_requetes.*, procedure_liers.*, audiences.*
            FROM parties_requetes
            INNER JOIN clients ON clients.idClient = parties_requetes.idClient
            INNER JOIN procedure_requetes ON procedure_requetes.idProcedure = parties_requetes.idRequete
            INNER JOIN procedure_liers ON procedure_liers.slugSource = procedure_requetes.slug
            INNER JOIN audiences ON audiences.slug = procedure_liers.slugProcedure
            WHERE procedure_liers.typeProcedure = 'audience'
            AND procedure_liers.slugProcedure = ?
        ", [$slug]);
    
        
       

        $requete_contraditoire_entreprise_adverses = DB::select("SELECT * FROM entreprise_adverses_requetes,parties_requetes, procedure_requetes, audiences, procedure_liers where  procedure_liers.slugProcedure = audiences.slug 
        and entreprise_adverses_requetes.idPartie = parties_requetes.idPartie and procedure_liers.typeProcedure ='audience' and  parties_requetes.idRequete = procedure_requetes.idProcedure  and procedure_liers.slugSource =? ",[$slug]) ;

        //dd($requete_contraditoire_entreprise_adverses);
        

        $requete_contraditoire_presonne_adverses = DB::select("SELECT * FROM personne_adverses_requetes,parties_requetes, procedure_requetes, audiences, procedure_liers where  procedure_liers.slugSource = procedure_requetes.slug 
        and personne_adverses_requetes.idPartie = parties_requetes.idPartie and procedure_liers.typeProcedure ='audience' and  parties_requetes.idRequete = procedure_requetes.idProcedure and procedure_liers.slugProcedure = audiences.slug 
        and procedure_liers.slugProcedure =? ",[$slug]) ;


        //dd($requete_contraditoire,$requete_contraditoire_presonne_adverses);




       $personne_adverses = DB::select("select * from personne_adverses, parties, audiences where personne_adverses.idPartie = parties.idPartie and parties.idAudience = audiences.idAudience  and audiences.slug = ?",[$slug]);

       $entreprise_adverses = DB::select("select * from entreprise_adverses, parties,audiences  where entreprise_adverses.idPartie = parties.idPartie and parties.idAudience = audiences.idAudience and audiences.slug =?",[$slug]);
       //dd($entreprise_adverses,$personne_adverses);

        //dd($audiencesFilles);


        // requete

        $procedure_requete = DB::select("SELECT * FROM procedure_liers ,procedure_requetes where procedure_liers.typeProcedure ='requete' and procedure_liers.slugProcedure = procedure_requetes.slug  and procedure_liers.slugSource =?",[$slug]);
        // dd($procedure_requete);

        $procedure_requete_personne_adverses_requetes = DB::select("SELECT * FROM personne_adverses_requetes,procedure_liers ,procedure_requetes,parties_requetes where procedure_liers.typeProcedure ='requete' and 
        parties_requetes.idPartie = personne_adverses_requetes.idPartie and parties_requetes.idRequete = procedure_requetes.idProcedure and procedure_liers.slugProcedure = procedure_requetes.slug  and procedure_liers.slugSource =?",[$slug]);
        //dd($procedure_requete_personne_adverses_requetes);

        $procedure_requete_entreprise_adverses_requetes = DB::select("SELECT * FROM entreprise_adverses_requetes,procedure_liers ,procedure_requetes,parties_requetes where procedure_liers.typeProcedure ='requete' and 
        parties_requetes.idPartie = entreprise_adverses_requetes.idPartie and parties_requetes.idRequete = procedure_requetes.idProcedure and procedure_liers.slugProcedure = procedure_requetes.slug  and procedure_liers.slugSource =?",[$slug]);
       // dd($procedure_requete_entreprise_adverses_requetes);

       $procedure_requete_clients = DB::select("SELECT * FROM clients,procedure_liers ,procedure_requetes,parties_requetes where procedure_liers.typeProcedure ='requete' and 
       parties_requetes.idClient = clients.idClient and parties_requetes.idRequete = procedure_requetes.idProcedure and procedure_liers.slugProcedure = procedure_requetes.slug  and procedure_liers.slugSource =?",[$slug]);
      //dd($procedure_requete_clients);
        

       

       $requeteClientFetch = DB::select("select * from procedure_requetes, parties_requetes where procedure_requetes.idProcedure=parties_requetes.idRequete and parties_requetes.idClient=?",[$cabinet[0]->idClient]);

        return view('audiences.infosAudience', compact(
            'suivi',
            'requeteClientFetch',
            'nomRoutePrecedente',
            'audience',
            'audience2',
            'tacheSuivit',
            'parties',
            'acteIntroductif',
            'avocats',
            'cabinet',
            'cabinet2',
            'personne_adverses',
            'entreprise_adverses',
            'personne_adverses2',
            'entreprise_adverses2',
            'idAudience',
            'assignation',
            'citationDirect',
            'contredit',
            'declarationAppel',
            'opposition',
            'ordonnanceRenvois',
            'pcpcs',
            'pourvoi',
            'pvIntrogatoire',
            'requete',
            'requisitoire',
            'pieceAS',
            'fichiers',
            'annuaires',
            'pieceOpp',
            'pieceREQ',
            'pieceCita',
            'pieceSign',
            'pieceSupplement',
            'niveau',
            'huissiers',
            'suiviAppel',
            'paramCabinet',
            'autreRoles',
            'autreRoles2',
            'plan',
            'allAudience',
            'pieceParents',
            'autrePieceParents',
            'audienceParents',
            'audienceFils',
            'acteSignifications',
            'is_client',
            'requete_contraditoire',
            'audiences_contraditoire',
           
            'citations',
            'autreActes',
            'clients',
            'personne_adverses',
            'entreprise_adverses',
            'requete_contraditoire',
            'requete_contraditoire_partie',
            'requete_contraditoire_entreprise_adverses',
            'requete_contraditoire_presonne_adverses',
            'requete_contraditoire',
            'audience_contraditoire_entreprise_adverses',
            'audiences_contraditoire_lier',
            'audience_contraditoire_partie',
            'audience_contraditoire_entreprise_adverses2',
            'audience_contraditoire_personne_adverses',
            'audience_contraditoire_partie2',
            'audience_contraditoire_personne_adverses2',


            'procedure_requete',
            'procedure_requete_personne_adverses_requetes',
            'procedure_requete_entreprise_adverses_requetes',
            'procedure_requete_clients',
            'procedure_autreRole',
            'procedure_autreRole1',
            'procedure_autreRole_requete1',
            'procedure_autreRole_requete'
            
            

        ));
    }

    public function showJonction($id, $slug, $niveau)
    {
        // Récupérer le nom de la route précédente
        $nomRoutePrecedente = URL::previous();

        $allAudience = DB::select("SELECT idAudience, numRg, objet, niveauProcedural, slugAud, statutAud
                FROM (
                    SELECT MAX(idAudience) as idAudience, MAX(numRg) as numRg, MAX(objet) as objet, MAX(niveauProcedural) as niveauProcedural, slugAud, statutAud
                    FROM (
                        SELECT  audiences.idAudience, audiences.slug AS slugAud,, numRg, objet, niveauProcedural, prenom, nom, denomination, NULL as numRccm, NULL as formeLegal, audiences.statut as statutAud
                        FROM audiences
                        JOIN parties ON audiences.idAudience = parties.idAudience
                        LEFT JOIN clients ON parties.idClient = clients.idClient
            
                        UNION
            
                        SELECT audiences.idAudience, audiences.slug AS slugAud,, numRg, objet, niveauProcedural, prenom, nom, NULL as denomination, NULL as numRccm, NULL as formeLegal, audiences.statut as statutAud
                        FROM audiences
                        JOIN parties ON audiences.idAudience = parties.idAudience
                        JOIN personne_adverses ON parties.idPartie = personne_adverses.idPartie
            
                        UNION
            
                        SELECT audiences.idAudience, audiences.slug AS slugAud,, numRg, objet, niveauProcedural, NULL as prenom, NULL as nom, denomination, numRccm, formeLegal, audiences.statut as statutAud
                        FROM audiences
                        JOIN parties ON audiences.idAudience = parties.idAudience
                        JOIN entreprise_adverses ON parties.idPartie = entreprise_adverses.idPartie
                    ) AS subquery_internal
                    GROUP BY subquery_internal.slugAud, subquery_internal.statutAud
                ) AS subquery 
                WHERE niveauProcedural = '$niveau'
                ORDER BY idAudience ASC
            ");
        
        $personne_adverses2 = DB::select("select * from personne_adverses,parties where parties.idPartie=personne_adverses.idPartie");

        $entreprise_adverses2 = DB::select("select * from entreprise_adverses,parties where parties.idPartie=entreprise_adverses.idPartie");

        $autreRoles2 = DB::select("select * from parties,audiences where audiences.idAudience=parties.idAudience");

        $cabinet2 =  DB::select("select parties.idPartie,nom,prenom,email,emailEntreprise,affaires.slug as affaireslug,nomAffaire,affaires.idAffaire,denomination,clients.slug as clientslug,clients.idClient,role,idAudience from parties,clients,affaires where parties.idClient=clients.idClient and parties.idAffaire=affaires.idAffaire");


        $idAudience = $id;

        $audience = DB::select("select * from audiences,juriductions,audience_joints where audience_joints.idAudienceJoint=audiences.idAudienceJoint and audiences.juridiction=juriductions.id and niveauProcedural=? and audiences.idAudienceJoint=?", [$niveau,$id]);


        if (empty($audience )) {

           return redirect()->back()->with('Informations incomplètes');
        } 
        
        $SqltacheSuivit = DB::select("select idSuivit,slug from taches where audTache=?",[$id]);

        $tacheSuivit = collect($SqltacheSuivit)->pluck('idSuivit')->toArray();

        $audience2 = DB::select("select * from audiences,juriductions where audiences.juridiction=juriductions.id and audiences.slug=? order by audiences.idAudience desc limit 1", [$slug]);
       

        if (empty($audience)) {
            $parties = [];
            $acteIntroductif = [];
            $avocats = [];
            $cabinet = [];
            $personne_adverses = [];
            $entreprise_adverses = [];
            $assignation = [];
            $citationDirect = [];
            $citations = [];
            $autreActes = [];
            $contredit = [];
            $declarationAppel = [];
            $opposition = [];
            $ordonnanceRenvois = [];
            $pcpcs = [];
            $pourvoi = [];
            $pvIntrogatoire = [];
            $requete = [];
            $requisitoire = [];
            $suivi = [];
            $pieceAS = [];
            $pieceREQ = [];
            $pieceOpp = [];
            $pieceSupplement = [];
            $autreRoles = [];
            $suiviAppel = [];
            $cabinet =  DB::select("select parties.idPartie,nom,prenom,email,emailEntreprise,affaires.slug as affaireslug,nomAffaire,affaires.idAffaire,denomination,clients.slug as clientslug,clients.idClient,role from parties,clients,affaires where parties.idClient=clients.idClient and parties.idAffaire=affaires.idAffaire and idAudience=? ", [$audience2[0]->idAudience]);

            $paramCabinet = DB::select("select * from cabinets");

        } else {

            $parties = DB::select("select * from parties,audiences,audience_joints where audience_joints.idAudienceJoint=audiences.idAudienceJoint and parties.idAudience=audiences.idAudience and audience_joints.idAudienceJoint=? ", [$id]);

            $acteIntroductif = DB::select("select * from acte_introductifs where  idAudience=?", [$audience[0]->idAudience]);

            $avocats = DB::select("select * from avocat_parties,avocats where avocat_parties.idAvocat=avocats.idAvc");

            $cabinet =  DB::select("select parties.idPartie,nom,prenom,email,emailEntreprise,affaires.slug as affaireslug,nomAffaire,affaires.idAffaire,denomination,clients.slug as clientslug,clients.idClient,role from parties,clients,affaires where parties.idClient=clients.idClient and parties.idAffaire=affaires.idAffaire and idAudience=? ", [$audience[0]->idAudience]);
            
            $paramCabinet = DB::select("select * from cabinets");
            

            $personne_adverses = DB::select("select * from personne_adverses,parties where parties.idPartie=personne_adverses.idPartie and parties.idAudience=?", [$audience[0]->idAudience]);

            $entreprise_adverses = DB::select("select * from entreprise_adverses,parties where parties.idPartie=entreprise_adverses.idPartie and parties.idAudience=?", [$audience[0]->idAudience]);

            $autreRoles = DB::select("select * from parties,audiences where audiences.idAudience=parties.idAudience and parties.idAudience=?", [$audience[0]->idAudience]);


            $assignation = DB::select("select assignations.slug,numRg,recepteurAss,dateAssignation,datePremiereComp,dateEnrollement,mentionParticuliere,prenomHss,nomHss from assignations,huissiers where assignations.idHuissier=huissiers.idHss and idActe=?", [$acteIntroductif[0]->idActe]);
            $citationDirect = DB::select("select * from citation_directes,huissiers where citation_directes.idHuissier=huissiers.idHss and idActe=?", [$acteIntroductif[0]->idActe]);
            $citations = DB::select("select * from citations, huissiers where citations.idHuissier=huissiers.idHss and idActe=?", [$acteIntroductif[0]->idActe]);
            $autreActes = DB::select("select * from autre_actes where idActe=?", [$acteIntroductif[0]->idActe]);
            $contredit = DB::select("select * from contredits where idActe=?", [$acteIntroductif[0]->idActe]);
            $declarationAppel = DB::select("select * from declaration_appels where idActe=?", [$acteIntroductif[0]->idActe]);
            $opposition = DB::select("select * from huissiers,oppositions where oppositions.idHuissier=huissiers.idHss and idActe=?", [$acteIntroductif[0]->idActe]);
            $ordonnanceRenvois = DB::select("select * from ordonnance_renvois where idActe=?", [$acteIntroductif[0]->idActe]);
            $pcpcs = DB::select("select * from pcpcs where idActe=?", [$acteIntroductif[0]->idActe]);
            $pourvoi = DB::select("select * from pourvois where idActe=?", [$acteIntroductif[0]->idActe]);
            $pvIntrogatoire = DB::select("select * from pv_interrogatoires where idActe=?", [$acteIntroductif[0]->idActe]);
            $requete = DB::select("select * from requetes where idActe=?", [$acteIntroductif[0]->idActe]);
            $requisitoire = DB::select("select * from requisitoires where idActe=?", [$acteIntroductif[0]->idActe]);
           
            if (empty($assignation)) {
                $pieceAS = [];
            } else {
                $pieceAS = DB::select("select * from fichiers where slugSource=?", [$assignation[0]->slug]);
            }

            if (empty($requete)) {
                $pieceREQ = [];
            } else {
                $pieceREQ = DB::select("select * from fichiers where slugSource=?", [$requete[0]->slug]);
            }

            if (empty($opposition)) {
                $pieceOpp = [];
            } else {
                $pieceOpp = DB::select("select * from fichiers where slugSource=?", [$opposition[0]->slug]);
            }

            if (empty($citations)) {
                $pieceCita = [];
            } else {
                $pieceCita = DB::select("select * from fichiers where slugSource=?", [$citations[0]->slug]);
            }

            $pieceSupplement = DB::select("select * from fichiers where slugSource=?", [$audience[0]->slug]);

            //dd($assignation);
            // Récuperation des données du suivi depuis la base de données
            $suivi = DB::select("select * from suivit_audiences where idAudience=?", [$audience[0]->idAudience]);

            $suiviAppel = DB::select("select * from suivit_audience_appels where idAudience=?", [$audience[0]->idAudience]);


            //Update de notification
            $email = Auth::user()->email;
            $personnel = DB::select('select * from personnels where email=? ', [$email]);

            foreach ($suivi as $key => $value) {

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

            foreach ($suiviAppel as $key => $value) {

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

            foreach ($audience as $key => $value) {

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
        }

        $annuaires = DB::select('select * from annuaires');

        $huissiers = DB::select('select * from huissiers');

        $fichiers = DB::select('select * from fichiers');

        $cabinetForPlan = DB::select("select * from cabinets");
        
        $plan = $cabinetForPlan[0]->plan;




        return view('audiences.infosAudience', compact(
            'suivi',
            'nomRoutePrecedente',
            'audience',
            'audience2',
            'tacheSuivit',
            'parties',
            'acteIntroductif',
            'avocats',
            'cabinet',
            'cabinet2',
            'personne_adverses',
            'entreprise_adverses',
            'personne_adverses2',
            'entreprise_adverses2',
            'idAudience',
            'assignation',
            'citationDirect',
            'contredit',
            'declarationAppel',
            'opposition',
            'ordonnanceRenvois',
            'pcpcs',
            'citations',
            'autreActes',
            'pourvoi',
            'pvIntrogatoire',
            'requete',
            'requisitoire',
            'pieceAS',
            'fichiers',
            'annuaires',
            'pieceOpp',
            'pieceREQ',
            'pieceSupplement',
            'niveau',
            'huissiers',
            'suiviAppel',
            'paramCabinet',
            'autreRoles',
            'autreRoles2',
            'plan',
            'allAudience'
        ));
    }


    /**
     * Display the specified resource.
     *
     * @param  string  $slug
     * @return \Illuminate\Http\Response
     */
    public function pubUpdate($slug, $id)
    {
         // Recuperation des clients dans la base de donnees
         // Récuperation de l'ensemble des clients dans la base de donnees'
        if (Auth::user()->role=='Collaborateur') {
            $clients = DB::table('clients')
            ->join('affectation_personnels', 'clients.idClient', '=', 'affectation_personnels.idClient')
            ->join('personnels', 'affectation_personnels.idPersonnel', '=', 'personnels.idPersonnel')
            ->where('personnels.email', Auth::user()->email)
            ->select('clients.*')
            ->get();        
        }else {
            $clients = DB::select('select * from clients');
        }
         $avocats = DB::select('select * from avocats');
         $huissiers = DB::select('select * from huissiers');
         $juriductions = DB::select('select * from juriductions');
         $natureActions = DB::select('select * from nature_actions');

         // Requetes de la page de modification
         $juriductionsAud = DB::select('select * from juriductions,audiences where audiences.juridiction=juriductions.id and audiences.idAudience=?',[$id]);
         $partiesCabinet = DB::select("select * from parties,audiences,clients,affaires where parties.idAudience=audiences.idAudience and parties.idClient=clients.idClient and parties.idAffaire=affaires.idAffaire and parties.idAudience=?",[$id]);
       
         $partiesAdverse = DB::select("
         SELECT idAudience, numRg, objet, niveauProcedural, slugAud, denomination,
                role, idPartie, prenom, nom, numRccm, siegeSocial, formeLegal, representantLegal, 
                telephone, profession, nationalite, dateNaissance, lieuNaissance, pays, domicile, 
                autreRole, typeAvocat
         FROM (
             SELECT audiences.idAudience, audiences.slug AS slugAud, numRg, objet, 
                    niveauProcedural, NULL as prenom, NULL as nom, NULL as denomination, NULL as numRccm, NULL as formeLegal,
                    role, parties.idPartie, NULL as siegeSocial, NULL as representantLegal, NULL as telephone, 
                    NULL as profession, NULL as nationalite, NULL as dateNaissance, NULL as lieuNaissance, 
                    NULL as pays, NULL as domicile, autreRole, typeAvocat
             FROM audiences
             JOIN parties ON audiences.idAudience = parties.idAudience
             WHERE parties.idAudience = ? AND role = 'Autre' AND parties.typeAvocat = 2
     
             UNION
     
             SELECT audiences.idAudience, audiences.slug AS slugAud, numRg, objet, 
                    niveauProcedural, prenom, nom, NULL as denomination, NULL as numRccm, NULL as formeLegal,
                    role, parties.idPartie, NULL as siegeSocial, NULL as representantLegal, telephone, 
                    profession, nationalite, dateNaissance, lieuNaissance, pays, domicile, autreRole, typeAvocat
             FROM audiences
             JOIN parties ON audiences.idAudience = parties.idAudience
             JOIN personne_adverses ON parties.idPartie = personne_adverses.idPartie
             WHERE parties.idAudience = ? AND parties.typeAvocat = 2
     
             UNION
     
             SELECT audiences.idAudience, audiences.slug AS slugAud, numRg, objet, 
                    niveauProcedural, NULL as prenom, NULL as nom, denomination, numRccm, formeLegal,
                    role, parties.idPartie, siegeSocial, representantLegal, NULL as telephone, 
                    NULL as profession, NULL as nationalite, NULL as dateNaissance, NULL as lieuNaissance, 
                    NULL as pays, NULL as domicile, autreRole, typeAvocat
             FROM audiences
             JOIN parties ON audiences.idAudience = parties.idAudience
             JOIN entreprise_adverses ON parties.idPartie = entreprise_adverses.idPartie
             WHERE parties.idAudience = ? AND parties.typeAvocat = 2
         ) AS subquery_internal
     ", [$id, $id, $id]); // Sécurisation avec les paramètres liés
     

         $avocatsParties = DB::select('select * from avocats,avocat_parties,parties where avocats.idAvc=avocat_parties.idAvocat and parties.idPartie=avocat_parties.idPartie and parties.idAudience=?',[$id]);
         $actes = DB::select("select * from acte_introductifs,audiences where acte_introductifs.idAudience=audiences.idAudience and audiences.idAudience=?",[$id]);

         //premiere instance - civile
         if (!empty($actes) && $actes[0]->typeActe=='Assignation') {
            $acteDetail = DB::select("select * from assignations,huissiers where assignations.idHuissier=huissiers.idHss and idActe=?",[$actes[0]->idActe]);
         }
         if (!empty($actes) && $actes[0]->typeActe=='Requete') {
            $acteDetail = DB::select("select * from requetes where idActe=?",[$actes[0]->idActe]);
         }
         if (!empty($actes) && $actes[0]->typeActe=='Opposition') {
            $acteDetail = DB::select("select * from oppositions,huissiers where oppositions.idHuissier=huissiers.idHss and idActe=?",[$actes[0]->idActe]);
         }

         //premiere instance - penal
         if (!empty($actes) && $actes[0]->typeActe=='PV introgatoire') {
            $acteDetail = DB::select("select * from pv_interrogatoires where idActe=?",[$actes[0]->idActe]);
         }
         if (!empty($actes) && $actes[0]->typeActe=='Requisitoire') {
            $acteDetail = DB::select("select * from requisitoires where idActe=?",[$actes[0]->idActe]);
         }
         if (!empty($actes) && $actes[0]->typeActe=='Ordonnance Renvoi') {
            $acteDetail = DB::select("select * from ordonnance_renvois where idActe=?",[$actes[0]->idActe]);
         }
         if (!empty($actes) && $actes[0]->typeActe=='Citation directe') {
            $acteDetail = DB::select("select * from citation_directes where idActe=?",[$actes[0]->idActe]);
         }
         if (!empty($actes) && $actes[0]->typeActe=='Citation') {
            $acteDetail = DB::select("select * from citations where idActe=?",[$actes[0]->idActe]);
         }
         if (!empty($actes) && $actes[0]->typeActe=='PCPC') {
            $acteDetail = DB::select("select * from pcpcs where idActe=?",[$actes[0]->idActe]);
         }

         //Appel 
         // ------ Utilisation de assignations et requetes depuis premiere instance civile---- //
         if (!empty($actes) && $actes[0]->typeActe=='Contredit') {
            $acteDetail = DB::select("select * from contredits where idActe=?",[$actes[0]->idActe]);
         }
         if (!empty($actes) && $actes[0]->typeActe=='Declaration d\'appel') {
            $acteDetail = DB::select("select * from declaration_appels where idActe=?",[$actes[0]->idActe]);
         }

         //Cassation
         if (!empty($actes) && $actes[0]->typeActe=='Pourvoi') {
            $acteDetail = DB::select("select * from pourvois where idActe=?",[$actes[0]->idActe]);
         }



         return view('audiences.audienceUpdateForm', compact(
            'clients', 'avocats', 'huissiers', 'juriductions',
            'juriductionsAud','natureActions','partiesCabinet','partiesAdverse','avocatsParties','actes','acteDetail'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @param  string  $slug
     * @return \Illuminate\Http\Response
     */
    public function audienceAffaire($slug, $id)
    {

        // Recuperation de l'aafaire dans la base de donnees
        $affaire = DB::select('select * from affaires where slug = ?', [$slug]);

        // Information du client lié a l'affaire
        $infoClient = clients::all()->where('id', $affaire[0]->idClient);
        return view('audiences.audienceAffaireForm', compact('infoClient', 'affaire'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @param  string  $slug
     * @return \Illuminate\Http\Response
     */
    public function audienceClient($slug, $id)
    {
        // Recuperation du clients dans la base de donnees
        $infoClient = clients::all()->where('id', $id);
        return view('audiences.audienceClientForm', compact('infoClient'));
    }



    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     * @param  \Illuminate\Http\Request  $request
     */
    public function autreFichier(Request $request)
    {
        $slugAud = $request->slugAudience;

        // enregistrement des informations du fichier

        try {
         
            if ($request->file('fichiers') != null) {

                $fichiers = request()->file('fichiers');


                foreach ($fichiers as $fichier) {

                    $otherFile = new Fichiers();

                    $filename = strtoupper(substr(str_shuffle(md5($request->_token . "" . rand(124, 345))), 0, 4)) . date('YmdHi') . '.' . $fichier->extension();
                    $otherFile->nomOriginal = $fichier->getClientOriginalName();
                    $otherFile->filename = $filename;
                    $otherFile->slugSource = $slugAud;
                    $otherFile->slug = $request->_token . "" . rand(1234, 3458);
                    $otherFile->path = 'assets/upload/fichiers/audiences/' . $filename;
                    $fichier->move(public_path('assets/upload/fichiers/audiences'), $filename);
                    $otherFile->save();
                }
            }
            return back()->with('success', 'Fichier joint à l\'audience avec succès');

        } catch (Exception $e) {

            return back()->with('error', 'Vérifiez votre connexion internet et réessayez à nouveau !');
        }
    }



    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     * @param  \Illuminate\Http\Request  $request
     */
    public function suiviAudience(Request $request)
    {

        return DB::transaction(function () use ($request) {
        // L'instance de la classe SuivitAudience
        $suivi = new SuivitAudience();


        if ($request) {

            $extrait = '';
            if ($request->decision == 'renvoi') {
                $decision = 'Renvoyée au ' . date('d-m-Y', strtotime($request->dateRenvoi)) . ' pour ' . $request->RenvoiPour;
                $rappelLettre = 'ne_pas_rappeler';
                $rappelSignification = 'ne_pas_rappeler'; 


            }
            if ($request->decision == 'miseDeliberer') {
                $decision = 'Mise en délibéré pour décision être rendue le ' . date('d-m-Y', strtotime($request->dateMiseDeliberer));
                $rappelLettre = 'ne_pas_rappeler';
                $rappelSignification = 'ne_pas_rappeler'; 


            }
            if ($request->decision == 'viderDeliberer') {
                $decision = 'Vidé du delibéré en faveur de ' . $request->viderDeliberer;
                $extrait = $request->extrait;
                $rappelLettre = 'A_rappeler';         
                $rappelSignification = 'A_rappeler';         
            }
          
            if ($request->decision == 'autre') {
                $decision = $request->autreDecision;
                $rappelLettre = 'ne_pas_rappeler';
                $rappelSignification = 'ne_pas_rappeler'; 

            }

            $suivi->idAudience = $request->idAudience;
            $suivi->dateAudience = $request->dateAudience;
            $suivi->dateProchaineAudience = $request->dateProchaineAudience;
            $suivi->TypeDecision = $request->decision;
            $suivi->decision = $decision;
            $suivi->extrait = $extrait;
            $suivi->heureDebut = $request->heureDebut;
            $suivi->heureFin = $request->heureFin;
            $suivi->president = $request->president;
            $suivi->greffier = $request->greffier;
            $suivi->rappelLettre = $rappelLettre;
            $suivi->rappelSignification = $rappelSignification;
            $suivi->suiviPar = Auth::user()->name;
            $suivi->slug = $request->_token . rand(34827, 86214);


            // Creation des fichiers
            // dossiers : affaires,taches,audiences,courier-departs,courier-arrivers
            if ($request->file('fichiers') != null) {

                $fichiers = request()->file('fichiers');


                foreach ($fichiers as $fichier) {

                    $suiviFile = new Fichiers();

                    $filename = strtoupper(substr(str_shuffle(md5($request->_token . "" . rand(124, 345))), 0, 4)) . date('YmdHi') . '.' . $fichier->extension();
                    $suiviFile->nomOriginal = $fichier->getClientOriginalName();
                    $suiviFile->filename = $filename;
                    $suiviFile->slugSource = $suivi->slug;
                    $suiviFile->slug = $request->_token . "" . rand(1234, 3458);
                    $suiviFile->path = 'assets/upload/fichiers/audiences/' . $filename;
                    $fichier->move(public_path('assets/upload/fichiers/audiences'), $filename);
                    $suiviFile->save();
                }
            }


            // Notifications

            if ($request->decision == 'viderDeliberer') {
               
               // $personnels = DB::select("select * from personnels,users where personnels.email=users.email and users.role='Collaborateur'");
                $personnels = DB::select("select * from personnels,users where personnels.email=users.email ");
                foreach ($personnels as $p) {
    
                    DB::select(
                        'INSERT INTO notifications(categorie, messages, etat, idRecepteur,slug,a_biper,urlName,urlParam) VALUES(?,?,?,?,?,?,?,?)',
                        [
                            'Audience',
                            '(URGENT) Une audience a été vidé du délibéré.',
                            'masquer',
                            $p->idPersonnel,
                            $request->_token . "" . rand(1234, 3458),
                            "non",
                            "suiviAudience",
                            $suivi->slug
                        ]
                    );
                }
    
                $admins = DB::select("select * from users where role='Administrateur'");
    
                foreach ($admins as $a) {
                    DB::select(
                        'INSERT INTO notifications(categorie, messages, etat, idRecepteur,slug,a_biper,urlName,urlParam,idAdmin) VALUES(?,?,?,?,?,?,?,?,?)',
                        [
                        'Audience',
                        '(URGENT) Une audience a été vidé du délibéré.',
                        'masquer',
                        'admin',
                        $request->_token . "" . rand(1234, 3458),
                        "non",
                        "suiviAudience",
                        $suivi->slug,
                        $a->id
                        ]
                    );
                }
    
            }
           
            //Enregistrement du suivi
            $suivi->save();

            DB::update('update audiences set prochaineAudience=? where idAudience=?',[$request->dateProchaineAudience,$request->idAudience]);


            // Notifications
            //$personnels = DB::select("select * from personnels,users where personnels.email=users.email and users.role='Collaborateur'");
            $personnels = DB::select("select * from personnels,users where personnels.email=users.email");
            foreach ($personnels as $p) {

                DB::select(
                    'INSERT INTO notifications(categorie, messages, etat, idRecepteur,slug,a_biper,urlName,urlParam) VALUES(?,?,?,?,?,?,?,?)',
                    [
                        'Audience',
                        'Un nouveau suivi d\'audience a été ajouté.',
                        'masquer',
                        $p->idPersonnel,
                        $request->_token . "" . rand(1234, 3458),
                        "non",
                        "suiviAudience",
                        $suivi->slug
                    ]
                );
            }

            $admins = DB::select("select * from users where role='Administrateur'");

            foreach ($admins as $a) {
                DB::select(
                    'INSERT INTO notifications(categorie, messages, etat, idRecepteur,slug,a_biper,urlName,urlParam,idAdmin) VALUES(?,?,?,?,?,?,?,?,?)',
                    [
                    'Audience',
                    'Un nouveau suivi d\'audience a été ajouté.',
                    'masquer',
                    'admin',
                    $request->_token . "" . rand(1234, 3458),
                    "non",
                    "suiviAudience",
                    $suivi->slug,
                    $a->id
                    ]
                );
            }
        }

        return back()->with('success', 'Suivi ajouté avec succès');

     });
    }

    public function suiviAudienceAppel(Request $request)
    {
        return DB::transaction(function () use ($request) {
        // L'instance de la classe SuivitAudience
        $suivi = new SuivitAudienceAppel();


        if ($request) {

            if ($request->acte == 'Conclusions') {

                $timestamp = date($request->dateReceptionConclusion);
                $dateLimite=date('Y-m-d', strtotime($timestamp . ' + 15 days'));
               
                

                $suivi->idAudience = $request->idAudience;
                $suivi->acte = ''.$request->acte.' de l\''.$request->appelantIntimeConclusion;
                $suivi->dateActe = $request->dateActeConclusion;
                $suivi->dateReception = $request->dateReceptionConclusion;
                $suivi->dateLimite = $dateLimite;
                $suivi->suiviPar = Auth::user()->name;
                $suivi->slug = $request->_token . rand(34827, 86214);
    
                $suivi->save();
                
                DB::update('update audiences set prochaineAudience=? where idAudience=?',[$dateLimite,$request->idAudience]);

            }

            if ($request->acte == 'Invitation à conclure') {
                $suivi->idAudience = $request->idAudience;
                $suivi->acte = ''.$request->acte.' de l\''.$request->appelantIntimeInvitation;
                $suivi->dateActe = $request->dateActeInvitation;
                $suivi->dateReception = $request->dateActeInvitation;
                $suivi->dateLimite = $request->dateLimiteInvitation;
                $suivi->suiviPar = Auth::user()->name;
                $suivi->slug = $request->_token . rand(34827, 86214);
    
                $suivi->save();

                DB::update('update audiences set prochaineAudience=? where idAudience=?',[$request->dateLimiteInvitation,$request->idAudience]);


            }

            if ($request->acte == 'Injonction à conclure') {
                $suivi->idAudience = $request->idAudience;
                $suivi->acte = ''.$request->acte.' de l\''.$request->appelantIntimeInjonction;
                $suivi->dateActe = $request->dateActeInjonction;
                $suivi->dateReception = $request->dateActeInjonction;
                $suivi->dateLimite = $request->dateLimiteInjonction;
                $suivi->suiviPar = Auth::user()->name;
                $suivi->slug = $request->_token . rand(34827, 86214);
    
                $suivi->save();

                DB::update('update audiences set prochaineAudience=? where idAudience=?',[$request->dateLimiteInvitation,$request->idAudience]);


            }

            if ($request->acte == 'PV de constat de carence') {

                $timestamp = date($request->dateActeConstat);
                $dateLimite=date('Y-m-d', strtotime($timestamp . ' + 15 days'));

                $suivi->idAudience = $request->idAudience;
                $suivi->acte = ''.$request->acte.' par '.$request->huissierConstat;
                $suivi->dateActe = $request->dateActeConstat;
                $suivi->dateReception = $request->dateActeConstat;
                $suivi->dateLimite = $dateLimite;
                $suivi->suiviPar = Auth::user()->name;
                $suivi->slug = $request->_token . rand(34827, 86214);
    
                $suivi->save();

                DB::update('update audiences set prochaineAudience=? where idAudience=?',[$dateLimite,$request->idAudience]);


            }

            if ($request->acte == "Avenir d'audience") {

                $timestamp = date($request->dateReceptionAvenir);
                $dateLimite=date('Y-m-d', strtotime($timestamp . ' + 15 days'));

                $suivi->idAudience = $request->idAudience;
                $suivi->acte = ''.$request->acte.' de l\''.$request->appelantIntimeAvenir;
                $suivi->dateActe = $request->dateActeAvenir;
                $suivi->dateReception = $request->dateActeAvenir;
                $suivi->dateLimite = $request->dateProchaineAudienceAvenir;
                $suivi->suiviPar = Auth::user()->name;
                $suivi->slug = $request->_token . rand(34827, 86214);
    
                $suivi->save();

                DB::update('update audiences set prochaineAudience=? where idAudience=?',[$request->dateProchaineAudienceAvenir,$request->idAudience]);


            }

            if ($request->acte == "Conférence de mise en état/cloture") {


                $suivi->idAudience = $request->idAudience;
                $suivi->acte = $request->acte;
                $suivi->dateActe = $request->dateEtat;
                $suivi->dateReception = $request->dateConferenceRecu;
                $suivi->dateLimite =  $request->dateExpConference;
                $suivi->suiviPar = Auth::user()->name;
                $suivi->slug = $request->_token . rand(34827, 86214);
    
                $suivi->save();

                DB::update('update audiences set prochaineAudience=? where idAudience=?',[$request->dateExpConference,$request->idAudience]);


            }

            if ($request->acte == "Mise en délibéré") {

                $suivi->idAudience = $request->idAudience;
                $suivi->acte = $request->acte;
                $suivi->dateActe = 'N/A';
                $suivi->dateReception = 'N/A';
                $suivi->dateLimite = $request->dateDeliberer;
                $suivi->suiviPar = Auth::user()->name;
                $suivi->slug = $request->_token . rand(34827, 86214);
    
                $suivi->save();

                DB::update('update audiences set prochaineAudience=? where idAudience=?',[$request->dateDeliberer,$request->idAudience]);


            }

            if ($request->acte == "Délibéré prorogé") {

                $suivi->idAudience = $request->idAudience;
                $suivi->acte = $request->acte;
                $suivi->dateActe = 'N/A';
                $suivi->dateReception = 'N/A';
                $suivi->dateLimite = $request->dateProrogé;
                $suivi->suiviPar = Auth::user()->name;
                $suivi->slug = $request->_token . rand(34827, 86214);
    
                $suivi->save();

                DB::update('update audiences set prochaineAudience=? where idAudience=?',[$request->dateProrogé,$request->idAudience]);


            }

            if ($request->acte == "Renvoi") {

                $suivi->idAudience = $request->idAudience;
                $suivi->acte = 'Renvoyé pour '.$request->raisonRenvoi;
                $suivi->dateActe = 'N/A';
                $suivi->dateReception = 'N/A';
                $suivi->dateLimite = $request->dateRenvoiAppel;
                $suivi->suiviPar = Auth::user()->name;
                $suivi->slug = $request->_token . rand(34827, 86214);
    
                $suivi->save();

                DB::update('update audiences set prochaineAudience=? where idAudience=?',[$request->dateRenvoiAppel,$request->idAudience]);

            }


            if ($request->acte == "Autre") {
                $suivi->idAudience = $request->idAudience;
                $suivi->acte = $request->autres;
                $suivi->dateActe = 'N/A';
                $suivi->dateReception = 'N/A';
                $suivi->dateLimite = $request->dateProchaineAudience;
                $suivi->suiviPar = Auth::user()->name;
                $suivi->slug = $request->_token . rand(34827, 86214);

                // Creation des fichiers
                // dossiers : affaires,taches,audiences,courier-departs,courier-arrivers
                if ($request->file('fichiers') != null) {

                    $fichiers = request()->file('fichiers');


                    foreach ($fichiers as $fichier) {

                        $suiviFile = new Fichiers();

                        $filename = strtoupper(substr(str_shuffle(md5($request->_token . "" . rand(124, 345))), 0, 4)) . date('YmdHi') . '.' . $fichier->extension();
                        $suiviFile->nomOriginal = $fichier->getClientOriginalName();
                        $suiviFile->filename = $filename;
                        $suiviFile->slugSource = $suivi->slug;
                        $suiviFile->slug = $request->_token . "" . rand(1234, 3458);
                        $suiviFile->path = 'assets/upload/fichiers/audiences/' . $filename;
                        $fichier->move(public_path('assets/upload/fichiers/audiences'), $filename);
                        $suiviFile->save();
                    }
                }
    
                $suivi->save();

            }


            // Notifications
           // $personnels = DB::select("select * from personnels,users where personnels.email=users.email and users.role='Collaborateur'");
            $personnels = DB::select("select * from personnels,users where personnels.email=users.email ");
            foreach ($personnels as $p) {

                DB::select(
                    'INSERT INTO notifications(categorie, messages, etat, idRecepteur,slug,a_biper,urlName,urlParam) VALUES(?,?,?,?,?,?,?,?)',
                    [
                        'Audience',
                        'Un nouveau suivi d\'audience a été ajouté.',
                        'masquer',
                        $p->idPersonnel,
                        $request->_token . "" . rand(1234, 3458),
                        "non",
                        "suiviAudience",
                        $suivi->slug
                    ]
                );
            }

            $admins = DB::select("select * from users where role='Administrateur'");

            foreach ($admins as $a) {
                DB::select(
                    'INSERT INTO notifications(categorie, messages, etat, idRecepteur,slug,a_biper,urlName,urlParam,idAdmin) VALUES(?,?,?,?,?,?,?,?,?)',
                    [
                    'Audience',
                    'Un nouveau suivi d\'audience a été ajouté.',
                    'masquer',
                    'admin',
                    $request->_token . "" . rand(1234, 3458),
                    "non",
                    "suiviAudience",
                    $suivi->slug,
                    $a->id
                    ]
                );
             }
        }

        return back()->with('success', 'Suivi ajouté avec succès');

     });
    }

    public function suiviRequete(Request $request)
    {
        return DB::transaction(function () use ($request) {
        // L'instance de la classe SuivitAudience
        $suivi = new SuivitRequete();


        if ($request) {

            $suivi->idRequete = $request->idRequete;
            $suivi->reference = $request->reference;
            $suivi->dateDecision = $request->dateDecision;
            $suivi->dateReception = $request->dateReception;
            $suivi->reponse = $request->reponse;
            $suivi->suiviPar = Auth::user()->name;
            $suivi->slug = $request->_token . rand(34827, 86214);

            $suivi->save();
            
            if ($request->file('ordonnance') != null) {

                $fichier = request()->file('ordonnance');

                $suiviFile = new Fichiers();

                $filename = strtoupper(substr(str_shuffle(md5($request->_token . "" . rand(124, 345))), 0, 4)) . date('YmdHi') . '.' . $fichier->extension();
                $suiviFile->nomOriginal = $fichier->getClientOriginalName();
                $suiviFile->filename = $filename;
                $suiviFile->slugSource = $suivi->slug;
                $suiviFile->slug = $request->_token . "" . rand(1234, 3458);
                $suiviFile->path = 'assets/upload/fichiers/ordonnances/' . $filename;
                $fichier->move(public_path('assets/upload/fichiers/ordonnances'), $filename);
                $suiviFile->save();

                //  Mise à jour du statut de la requête correspondante
                DB::update("UPDATE procedure_requetes SET statut = ? WHERE idProcedure = ?", [
                    $suivi->reponse,  // ou $request->reponse
                    $request->idRequete
                ]);
            }



            // Notifications
            //$personnels = DB::select("select * from personnels,users where personnels.email=users.email and users.role='Collaborateur'");
            $personnels = DB::select("select * from personnels,users where personnels.email=users.email");
            foreach ($personnels as $p) {

                DB::select(
                    'INSERT INTO notifications(categorie, messages, etat, idRecepteur,slug,a_biper,urlName,urlParam) VALUES(?,?,?,?,?,?,?,?)',
                    [
                        'Requete',
                        'Un nouveau suivi de requête a été ajouté.',
                        'masquer',
                        $p->idPersonnel,
                        $request->_token . "" . rand(1234, 3458),
                        "non",
                        "detailRequete",
                        $suivi->slug
                    ]
                );
            }

            $admins = DB::select("select * from users where role='Administrateur'");

            foreach ($admins as $a) {
                DB::select(
                    'INSERT INTO notifications(categorie, messages, etat, idRecepteur,slug,a_biper,urlName,urlParam,idAdmin) VALUES(?,?,?,?,?,?,?,?,?)',
                    [
                    'Requete',
                    'Un nouveau suivi de requête a été ajouté.',
                    'masquer',
                    'admin',
                    $request->_token . "" . rand(1234, 3458),
                    "non",
                    "detailRequete",
                    $suivi->slug,
                    $a->id
                    ]
                );
             }
        }

        return back()->with('success', 'Suivi ajouté avec succès');

     });
    }

    /**
     * Afficher the form for editing the specified resource.
     *
     * @param  \App\Models\Audiences  $audiences
     * @return \Illuminate\Http\Response
     */
    public function deleteSuiviAud($slug)
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

        DB::delete("delete from suivit_audiences where slug=?", [$slug]);
        DB::delete("delete from notifications where urlParam=?", [$slug]);
        return back()->with('success', 'Suivi supprimé avec succès');
    }

    public function deleteSuiviAppel($slug)
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

        DB::delete("delete from suivit_audience_appels where slug=?", [$slug]);
        DB::delete("delete from notifications where urlParam=?", [$slug]);
        return back()->with('success', 'Suivi supprimé avec succès');
    }

    public function deleteSuiviRequete($slug)
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

        DB::delete("delete from suivit_requetes where slug=?", [$slug]);
        DB::delete("delete from notifications where urlParam=?", [$slug]);
        return back()->with('success', 'Suivi supprimé avec succès');
    }

    public function deletePiece($slug)
    {
        $fichier = DB::select("select * from fichiers where slug=?", [$slug]);
        // Suppression des fichiers lié au suivi
        if (!empty($fichier)) {
            foreach ($fichier as $key => $value) {
                if (file_exists($value->path)) {
                    unlink(public_path($value->path));
                } else {
                   
                }
                
            }
            DB::delete("delete from fichiers where slug=? ", [$slug]);
        } else {
        }

        return back()->with('success', 'Fichier supprimé avec succès');
    }

    public function deleteAud($id)
    {

        $slugAud = DB::select("select * from audiences where idAudience=?",[$id]);
        $slugSuivi = DB::select("select * from suivit_audiences where idAudience=?",[$id]);
        DB::delete("delete from requete_liers where slugProcedure=?",[$slugAud[0]->slug]);
        $audience = audiences::find($id);
        $audience->delete();
        DB::delete("delete from notifications where urlParam=?", [$slugAud[0]->slug]);
        if (!empty($slugSuivi)) {
            DB::delete("delete from notifications where urlParam=?", [$slugSuivi[0]->slug]);
        }
        DB::delete("delete from notifications where urlParam=?", [$slugAud[0]->slug]);
        return redirect()->route('addAudience')->with('success', 'Audience supprimé avec succès');
    }

    public function deleteReq($id)
    {

        $slugReq = DB::select("select * from procedure_requetes where idProcedure=?",[$id]);
        $slugSuivi = DB::select("select * from suivit_requetes where idRequete=?",[$id]);
        DB::delete("delete from requete_liers where slugProcedure=?",[$slugReq[0]->slug]);
        $requete = ProcedureRequete::find($id);
        $requete->delete();
        DB::delete("delete from notifications where urlParam=?", [$slugReq[0]->slug]);
        if (!empty($slugSuivi)) {
            DB::delete("delete from notifications where urlParam=?", [$slugSuivi[0]->slug]);
        }
        DB::delete("delete from notifications where urlParam=?", [$slugReq[0]->slug]);
        return redirect()->route('addAudience')->with('success', 'Requete supprimé avec succès');
    }

    public function terminer($slug)
    {

        DB::update("update audiences set statut='Terminée' where slug=?",[$slug]);
        return back()->with('success', 'Cette audience est terminée.');
    }

    public function terminerRequete($slug ,Request $request)
    {
        $suivi = new SuivitRequete();

        // On suppose que tu veux récupérer la requête liée au slug
        $requete = DB::table('procedure_requetes')->where('slug', $slug)->first();

        //dd( $requete);

        if ($requete) {
            $suivi->idRequete = $requete->idProcedure;
            $suivi->slug = $slug . '-' . rand(34827, 86214); // Génération d’un nouveau slug unique
            $suivi->reference = null;
            $suivi->dateDecision = null;
            $suivi->dateReception = null;
            $suivi->reponse = 'Terminée';
            $suivi->suiviPar = Auth::user()->name;

            //dd($suivi);

            $suivi->save(); // On sauvegarde maintenant
        }

        DB::update("update procedure_requetes set statut='Terminée' where slug=?",[$slug]);
        return back()->with('success', 'Cette requete est terminée.');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Audiences  $audiences
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Audiences $audiences)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Audiences  $audiences
     * @return \Illuminate\Http\Response
     */
    public function destroy(Audiences $audiences)
    {
        //
    }

    public function createJonctionEtape1(Audiences $audiences)
    {
        $allAudience = DB::select("SELECT idAudience, numRg, objet, niveauProcedural, slugAud, statutAud
        FROM (
            SELECT MAX(idAudience) as idAudience, MAX(numRg) as numRg, MAX(objet) as objet, MAX(niveauProcedural) as niveauProcedural, slugAud, statutAud, MAX(isChild) as isChild
            FROM (
                SELECT  audiences.idAudience, audiences.slug AS slugAud,, numRg, objet, niveauProcedural, prenom, nom, denomination, NULL as numRccm, NULL as formeLegal, audiences.statut as statutAud, audiences.isChild
                FROM audiences
                JOIN parties ON audiences.idAudience = parties.idAudience
                LEFT JOIN clients ON parties.idClient = clients.idClient
        
                UNION
        
                SELECT audiences.idAudience, audiences.slug AS slugAud,, numRg, objet, niveauProcedural, prenom, nom, NULL as denomination, NULL as numRccm, NULL as formeLegal, audiences.statut as statutAud, audiences.isChild
                FROM audiences
                JOIN parties ON audiences.idAudience = parties.idAudience
                JOIN personne_adverses ON parties.idPartie = personne_adverses.idPartie
        
                UNION
        
                SELECT audiences.idAudience, audiences.slug AS slugAud,, numRg, objet, niveauProcedural, NULL as prenom, NULL as nom, denomination, numRccm, formeLegal, audiences.statut as statutAud, audiences.isChild
                FROM audiences
                JOIN parties ON audiences.idAudience = parties.idAudience
                JOIN entreprise_adverses ON parties.idPartie = entreprise_adverses.idPartie
            ) AS subquery_internal
            GROUP BY subquery_internal.slugAud, subquery_internal.statutAud
        ) AS subquery 
        WHERE isChild is null
        ORDER BY idAudience ASC;
        
            ");


            $personne_adverses2 = DB::select("select * from personne_adverses,parties where parties.idPartie=personne_adverses.idPartie");

            $entreprise_adverses2 = DB::select("select * from entreprise_adverses,parties where parties.idPartie=entreprise_adverses.idPartie");

            $autreRoles2 = DB::select("select * from parties,audiences where audiences.idAudience=parties.idAudience");

            $cabinet2 =  DB::select("select parties.idPartie,nom,prenom,email,emailEntreprise,affaires.slug as affaireslug,nomAffaire,affaires.idAffaire,denomination,clients.slug as clientslug,clients.idClient,role,idAudience from parties,clients,affaires where parties.idClient=clients.idClient and parties.idAffaire=affaires.idAffaire");
        
            $juriductions = DB::select("select * from juriductions");

            return view('audiences.jonctions.etape1', compact('allAudience','personne_adverses2','entreprise_adverses2','autreRoles2','cabinet2','juriductions'));

    }

    public function createJonctionEtape2(Request $request)
    {
         $arr = $request->idAudienceSource;

         // Recuperation des clients dans la base de donnees
         // Récuperation de l'ensemble des clients dans la base de donnees'
         if (Auth::user()->role=='Collaborateur') {
            $clients = DB::table('clients')
            ->join('affectation_personnels', 'clients.idClient', '=', 'affectation_personnels.idClient')
            ->join('personnels', 'affectation_personnels.idPersonnel', '=', 'personnels.idPersonnel')
            ->where('personnels.email', Auth::user()->email)
            ->select('clients.*')
            ->get();        
        }else {
            $clients = DB::select('select * from clients');
        }
         $avocats = DB::select('select * from avocats');
         $huissiers = DB::select('select * from huissiers');
         $juriductions = DB::select('select * from juriductions');
         $natureActions = DB::select('select * from nature_actions');

         // Requetes de la page de modification
         $juriductionsAud = DB::select('select * from juriductions,audiences where audiences.juridiction=juriductions.id and audiences.idAudience=?',[$arr[0]]);

         $avocatsParties = DB::select('select * from avocats,avocat_parties,parties where avocats.idAvc=avocat_parties.idAvocat and parties.idPartie=avocat_parties.idPartie and parties.idAudience=?',[$arr[0]]);

         $partiesAdverse = [];
         $partiesCabinet = [];
         $actes = [];

         foreach ($arr as $key => $aud) {
         
         $partiesCabinetItem = DB::select("select * from parties,audiences,clients,affaires where parties.idAudience=audiences.idAudience and parties.idClient=clients.idClient and parties.idAffaire=affaires.idAffaire and parties.idAudience=?",[$aud]);
                
         $partiesAdverseItem = DB::select("SELECT idAudience,subquery_internal.numRg, subquery_internal.objet, 
         subquery_internal.niveauProcedural, subquery_internal.slugAud, subquery_internal.denomination,
         role,idPartie,prenom,nom,numRccm,siegeSocial,formeLegal,representantLegal,telephone,profession,nationalite,
         dateNaissance,lieuNaissance,pays,domicile,autreRole
         FROM (

                SELECT audiences.idAudience, audiences.slug AS slugAud,, numRg, objet, 
                 niveauProcedural, NULL as prenom, NULL as nom, NULL as denomination, NULL as numRccm, NULL as formeLegal,
                 role,parties.idPartie,NULL as siegeSocial,NULL as representantLegal,NULL as telephone,NULL as profession,NULL as nationalite,
                 NULL as dateNaissance,NULL as lieuNaissance,NULL as pays,NULL as domicile, autreRole
                 FROM audiences
                 JOIN parties ON audiences.idAudience = parties.idAudience
                 WHERE parties.idAudience =$aud AND role='Autre'

                 UNION

                 SELECT audiences.idAudience, audiences.slug AS slugAud,, numRg, objet, 
                 niveauProcedural, prenom, nom, NULL as denomination, NULL as numRccm, NULL as formeLegal,
                 role,parties.idPartie,NULL as siegeSocial,NULL as representantLegal,telephone,profession,nationalite,
                 dateNaissance,lieuNaissance,pays,domicile,autreRole
                 FROM audiences
                 JOIN parties ON audiences.idAudience = parties.idAudience
                 JOIN personne_adverses ON parties.idPartie = personne_adverses.idPartie
                 WHERE parties.idAudience =$aud
         
                 UNION
         
                 SELECT audiences.idAudience, audiences.slug AS slugAud,, numRg, objet, 
                 niveauProcedural, NULL as prenom, NULL as nom, denomination, numRccm, formeLegal,
                 role,parties.idPartie,siegeSocial,representantLegal,NULL as telephone,NULL as profession,NULL as nationalite,
                 NULL as dateNaissance,NULL as lieuNaissance,NULL as pays,NULL as domicile,autreRole
                 FROM audiences
                 JOIN parties ON audiences.idAudience = parties.idAudience
                 JOIN entreprise_adverses ON parties.idPartie = entreprise_adverses.idPartie
                 WHERE parties.idAudience = $aud

             ) AS subquery_internal

            ");

                $actesItem = DB::select("select * from acte_introductifs,audiences where acte_introductifs.idAudience=audiences.idAudience and audiences.idAudience=?",[$aud]);


                $partiesAdverse = array_merge($partiesAdverse, $partiesAdverseItem);
                $partiesCabinet = array_merge($partiesCabinet, $partiesCabinetItem);
                $actes = array_merge($actes, $actesItem);

            }
         
         
         
         //premiere instance - civile
         $acteDetail = [];
         foreach ($actes as $key => $item) {

            if (!empty($actes) && $item->typeActe=='Assignation') {
                $acteDetailItem = DB::select("select * from assignations,huissiers where assignations.idHuissier=huissiers.idHss and idActe=?",[$item->idActe]);
             }
             if (!empty($actes) && $item->typeActe=='Requete') {
                $acteDetailItem = DB::select("select * from requetes where idActe=?",[$item->idActe]);
             }
             if (!empty($actes) && $actes[0]->typeActe=='Opposition') {
                $acteDetailItem = DB::select("select * from oppositions,huissiers where oppositions.idHuissier=huissiers.idHss and idActe=?",[$item->idActe]);
             }
             
             $acteDetail = array_merge($acteDetail, $acteDetailItem);
         }

        
         //premiere instance - penal
         if (!empty($actes) && $actes[0]->typeActe=='PV introgatoire') {
            $acteDetail = DB::select("select * from pv_interrogatoires where idActe=?",[$actes[0]->idActe]);
         }
         if (!empty($actes) && $actes[0]->typeActe=='Requisitoire') {
            $acteDetail = DB::select("select * from requisitoires where idActe=?",[$actes[0]->idActe]);
         }
         if (!empty($actes) && $actes[0]->typeActe=='Ordonnance Renvoi') {
            $acteDetail = DB::select("select * from ordonnance_renvois where idActe=?",[$actes[0]->idActe]);
         }
         if (!empty($actes) && $actes[0]->typeActe=='Citation directe') {
            $acteDetail = DB::select("select * from citation_directes where idActe=?",[$actes[0]->idActe]);
         }
         if (!empty($actes) && $actes[0]->typeActe=='PCPC') {
            $acteDetail = DB::select("select * from pcpcs where idActe=?",[$actes[0]->idActe]);
         }

         //Appel 
         // ------ Utilisation de assignations et requetes depuis premiere instance civile---- //
         if (!empty($actes) && $actes[0]->typeActe=='Contredit') {
            $acteDetail = DB::select("select * from contredits where idActe=?",[$actes[0]->idActe]);
         }
         if (!empty($actes) && $actes[0]->typeActe=='Declaration d\'appel') {
            $acteDetail = DB::select("select * from declaration_appels where idActe=?",[$actes[0]->idActe]);
         }

         //Cassation
         if (!empty($actes) && $actes[0]->typeActe=='Pourvoi') {
            $acteDetail = DB::select("select * from pourvois where idActe=?",[$actes[0]->idActe]);
         }



         return view('audiences.jonctions.etape2', compact(
            'arr','clients', 'avocats', 'huissiers', 'juriductions',
            'juriductionsAud','natureActions','partiesCabinet','partiesAdverse','avocatsParties','actes','acteDetail'));
    }

    public function saveJonction(Request $request)
    {
        return DB::transaction(function () use ($request) {

        $arr = $request->idAudienceSource;
        $slugJonction = $request->_token . rand(34827, 86214);

        for ($i = 0; $i < count($arr); $i++)  {     

            DB::update("update audiences set slugJonction=?, isChild='non', statut='Jonction' where idAudience=?",[$slugJonction, $arr[$i]]);
        }


        $TYPE_ADVERSE = ['Entreprise', 'Personne physique'];

        $today = date('Y-m-d');

        // L'instance du model FileAudience'
        $fichiers = new Fichiers();



        if ($request) {

            $messages = [
                'juridiction.required' => 'Le champ juridiction est obligatoire.',
                'objet.required' => 'Le champ objet est obligatoire.',
                'niveauProcedural.required' => 'Le champ niveau procedural est obligatoire.',
                'nature.required' => 'Le champ nature est obligatoire.',
               
                // ...
            ];

            // Enregistrement des informations de l'audience
            $request->validate([
                'juridiction' => 'required',
                'objet' => 'required',
                'niveauProcedural' => 'required',
                'nature' => 'required',
                
            ], $messages);
            // L'instance du model Audience
            $audiences = new Audiences();
            if (isset($request->numRg)) {
                $num = $request->numRg;
            } elseif (isset($request->numRgOpp)) {
                $num = $request->numRgOpp;
            } elseif (isset($request->numRgRequete)) {
                $num = $request->numRgRequete;
            } elseif (isset($request->numRgDeclaration)) {
                $num = $request->numRgDeclaration;
            } else {
                $num = '';
            }
            $audiences->objet = $request->objet;
            $audiences->juridiction = $request->juridiction;
            $audiences->niveauProcedural = $request->niveauProcedural;
            $audiences->nature = $request->nature;
            $audiences->dateCreation = $today;
            $audiences->numRg = $num;
            $audiences->createur = Auth::user()->name;
            $audiences->statut = 'En cours';
            $audiences->isChild = 'oui';
            $audiences->slugJonction = $slugJonction;
            $audiences->slug = rand(124, 875) . $request->_token . rand(1234, 8765);

            if ($request->file('pieceInstruction') != null) {

                $audiences->pieceInstruction = rand(124, 875) . $request->_token . rand(1234, 8765);

                $fichier = request()->file('pieceInstruction');
                $pieceInstruction = new Fichiers();

                $filename = strtoupper(substr(str_shuffle(md5($request->_token . "" . rand(124, 345))), 0, 4)) . date('YmdHi') . '.' . $fichier->extension();
                $pieceInstruction->nomOriginal = $fichier->getClientOriginalName();
                $pieceInstruction->slugSource =  $audiences->pieceInstruction;
                $pieceInstruction->filename = $filename;
                $pieceInstruction->slug = $request->_token . "" . rand(1234, 3458);
                $pieceInstruction->path = 'assets/upload/fichiers/audiences/instructions/' . $filename;
                $fichier->move(public_path('assets/upload/fichiers/audiences/instructions/'), $filename);
                $pieceInstruction->save();
            }

            $partieCabinet = false;

            foreach ($request->formsetCabinet as $key => $value) {
                // Vérifier si typeAvocat est égal à '1'
                if (isset($value['typeAvocat']) && $value['typeAvocat'] === '1') {
                    $partieCabinet = true;
                    // Si trouvé, vous pouvez sortir de la boucle car une occurrence suffit
                    break;
                }
            }

            if( $partieCabinet === false){
                return redirect()->back()->with('error', 'L\'une des parties doit être cliente de votre cabinet.');
            }

            $audiences->save();

            // Enregistrement des parties
            $idAudienceSelect = DB::select("select idAudience from audiences order by idAudience desc limit 1");

            // Parties cabinet
            foreach ($request->formsetCabinet as $key => $value) {

                if (isset($value['autreRole'])) {
                    $autreRole = $value['autreRole'];
                } else {
                    $autreRole = '';
                }

                if (isset($value['idClient'])) {
                    $idClient = $value['idClient'];
                } else {
                    $idClient = null;
                }

                if (isset($value['idAffaire'])) {
                    $idAffaire = $value['idAffaire'];
                } else {
                    $idAffaire = null;
                }
                if (isset($value['typeAvocat'])) {
                    $typeAvocat = $value['typeAvocat'];
                } else {
                    $typeAvocat = null;
                }

                if (is_array($value)) {
                    Parties::create([
                        'idAudience' => $idAudienceSelect[0]->idAudience,
                        'role' => $value['role'],
                        'autreRole' =>  $autreRole,
                        'idClient' => $idClient,
                        'idAffaire' => $idAffaire,
                        'typeAvocat' => $typeAvocat,
                        'slug' => $request->_token . "" . rand(1234, 3458),
                    ]);
                 }
                // Enregistrement des avocats
                $idPartieSelect = DB::select("select idPartie from parties order by idPartie desc limit 1");

                if (isset($value['idAvocat'])) {
                    $arr = $value['idAvocat'];

                    for ($i = 0; $i < count($arr); $i++) {

                        AvocatParties::create([
                            'idPartie' => $idPartieSelect[0]->idPartie,
                            'idAvocat' =>  $arr[$i],
                            'slug' => $request->_token . "" . rand(1234, 3458),
                        ]);
                    }
                }

                if (isset($value['typeAdverse']) && $value['typeAdverse'] == "Personne physique") {

                    PersonneAdverse::create([
                        'idPartie' => $idPartieSelect[0]->idPartie,
                        'prenom' => $value['prenom'],
                        'nom' => $value['nom'],
                        'telephone' => $value['telephone'],
                        'nationalite' => $value['nationalite'],
                        'profession' => $value['profession'],
                        'dateNaissance' => $value['dateNaissance'],
                        'lieuNaissance' => $value['lieuNaissance'],
                        'pays' => $value['pays'],
                        'domicile' => $value['domicile'],
                        'slug' => $request->_token . "" . rand(1234, 3458),
                    ]);
                }
                if (isset($value['typeAdverse']) && $value['typeAdverse'] == "Entreprise") {

                 
                    EntrepriseAdverse::create([
                        'idPartie' => $idPartieSelect[0]->idPartie,
                        'denomination' => $value['denomination'],
                        'numRccm' => $value['numRccm'],
                        'siegeSocial' => $value['siegeSocial'],
                        'formeLegal' => $value['formeLegal'],
                        'representantLegal' => $value['representantLegal'],
                        'slug' => $request->_token . "" . rand(1234, 3458),
                    ]);
                }
            }

            // Parties adverse
            foreach ($request->formset as $key => $value) {

                if (isset($value['autreRole'])) {
                    $autreRole = $value['autreRole'];
                } else {
                    $autreRole = '';
                }

                if (isset($value['idClient'])) {
                    $idClient = $value['idClient'];
                } else {
                    $idClient = null;
                }

                if (isset($value['idAffaire'])) {
                    $idAffaire = $value['idAffaire'];
                } else {
                    $idAffaire = null;
                }
                if (isset($value['typeAvocat'])) {
                    $typeAvocat = $value['typeAvocat'];
                } else {
                    $typeAvocat = null;
                }

                if (is_array($value)) {
                    Parties::create([
                        'idAudience' => $idAudienceSelect[0]->idAudience,
                        'role' => $value['role'],
                        'autreRole' =>  $autreRole,
                        'idClient' => $idClient,
                        'idAffaire' => $idAffaire,
                        'typeAvocat' => $typeAvocat,
                        'slug' => $request->_token . "" . rand(1234, 3458),
                    ]);
                 }
                // Enregistrement des avocats
                $idPartieSelect = DB::select("select idPartie from parties order by idPartie desc limit 1");

                if (isset($value['idAvocat'])) {
                    $arr = $value['idAvocat'];

                    for ($i = 0; $i < count($arr); $i++) {

                        AvocatParties::create([
                            'idPartie' => $idPartieSelect[0]->idPartie,
                            'idAvocat' =>  $arr[$i],
                            'slug' => $request->_token . "" . rand(1234, 3458),
                        ]);
                    }
                }

                if (isset($value['typeAdverse']) && $value['typeAdverse'] == "Personne physique") {

                    PersonneAdverse::create([
                        'idPartie' => $idPartieSelect[0]->idPartie,
                        'prenom' => $value['prenom'],
                        'nom' => $value['nom'],
                        'telephone' => $value['telephone'],
                        'nationalite' => $value['nationalite'],
                        'profession' => $value['profession'],
                        'dateNaissance' => $value['dateNaissance'],
                        'lieuNaissance' => $value['lieuNaissance'],
                        'pays' => $value['pays'],
                        'domicile' => $value['domicile'],
                        'slug' => $request->_token . "" . rand(1234, 3458),
                    ]);
                }
                if (isset($value['typeAdverse']) && $value['typeAdverse'] == "Entreprise") {

                 
                    EntrepriseAdverse::create([
                        'idPartie' => $idPartieSelect[0]->idPartie,
                        'denomination' => $value['denomination'],
                        'numRccm' => $value['numRccm'],
                        'siegeSocial' => $value['siegeSocial'],
                        'formeLegal' => $value['formeLegal'],
                        'representantLegal' => $value['representantLegal'],
                        'slug' => $request->_token . "" . rand(1234, 3458),
                    ]);
                }
            }


            // Enregistrement de l'acte introductifs
            foreach ($request->formsetActe as $key => $value) {
                ActeIntroductifs::create([
                    'idAudience' => $idAudienceSelect[0]->idAudience,
                    'typeActe' => $value['typeActe'],
                    'slug' => $request->_token . "" . rand(1234, 3458),
                ]);
           

            $idActeSelect = DB::select("select idActe from acte_introductifs order by idActe desc limit 1");

            // Enregistrement de l'Assignation
            if ($value['typeActe'] == 'Assignation') {
                
                Assignations::create([
                    'idActe' => $idActeSelect[0]->idActe,
                    'numRg' =>  $value['numRg'],
                    'idHuissier' =>   $value['idHuissier'],
                    'recepteurAss' =>  $value['recepteurAss'],
                    'dateAssignation' => $value['dateAssignation'],
                    'datePremiereComp' =>  $value['datePremiereComp'],
                    'dateEnrollement' =>  $value['dateEnrollement'],
                    'mentionParticuliere' =>  $value['mentionParticuliere'],
                    'slug' => $request->_token . "" . rand(1234, 3458),
                ]);

                if ($request->file('pieceAS') != null) {

                    $slugAssignation = DB::select("select slug from assignations order by idAssignation desc limit 1");

                    $fichier = request()->file('pieceAS');
                    $pieceAS = new Fichiers();

                    $filename = strtoupper(substr(str_shuffle(md5($request->_token . "" . rand(124, 345))), 0, 4)) . date('YmdHi') . '.' . $fichier->extension();
                    $pieceAS->nomOriginal = $fichier->getClientOriginalName();
                    $pieceAS->slugSource =  $slugAssignation[0]->slug;
                    $pieceAS->filename = $filename;
                    $pieceAS->slug = $request->_token . "" . rand(1234, 3458);
                    $pieceAS->path = 'assets/upload/fichiers/audiences/assignations/' . $filename;
                    $fichier->move(public_path('assets/upload/fichiers/audiences/assignations/'), $filename);
                    $pieceAS->save();
                }
            }

            // Enregistrement de la requete
            if ($value['typeActe'] == 'Requete') {
                Requetes::create([
                    'idActe' => $idActeSelect[0]->idActe,
                    'dateRequete' => $value['dateRequete'],
                    'dateArriver' => $value['dateArriver'],
                    'numRg' => $value['numRgRequete'],
                    'juriductionPresidentielle' => $value['juriductionPresidentielle'],
                    'slug' => $request->_token . "" . rand(1234, 3458),
                ]);

                if ($request->file('pieceREQ') != null) {

                    $slugRequete = DB::select("select slug from requetes order by idRequete desc limit 1");

                    $fichier = request()->file('pieceREQ');
                    $pieceREQ = new Fichiers();

                    $filename = strtoupper(substr(str_shuffle(md5($request->_token . "" . rand(124, 345))), 0, 4)) . date('YmdHi') . '.' . $fichier->extension();
                    $pieceREQ->nomOriginal = $fichier->getClientOriginalName();
                    $pieceREQ->slugSource =  $slugRequete[0]->slug;
                    $pieceREQ->filename = $filename;
                    $pieceREQ->slug = $request->_token . "" . rand(1234, 3458);
                    $pieceREQ->path = 'assets/upload/fichiers/audiences/requetes/' . $filename;
                    $fichier->move(public_path('assets/upload/fichiers/audiences/requetes/'), $filename);
                    $pieceREQ->save();
                }
            }

            // Enregistrement de la requete
            if ($value['typeActe'] == 'Opposition') {
                Oppositions::create([
                    'idActe' => $idActeSelect[0]->idActe,
                    'idHuissier' => $value['idHuissierOpp'],
                    'dateActe' => $value['dateActe'],
                    'dateProchaineAud' => $value['dateProchaineAud'],
                    'numDecision' => $value['numDecisConcerner'],
                    'numRg' => $value['numRgOpp'],
                    'recepteurAss' => $value['recepteurAssOpp'],
                    'datePremiereComp' => $value['datePremiereCompOpp'],
                    'dateEnrollement' => $value['dateEnrollementOpp'],
                    'mentionParticuliere' => $value['mentionParticuliereOpp'],
                    'slug' => $request->_token . "" . rand(1234, 3458),
                ]);

                if ($request->file('pieceASOpp') != null) {

                    $slugOpposition = DB::select("select slug from oppositions order by idOpposition desc limit 1");

                    $fichier = request()->file('pieceASOpp');
                    $pieceAS = new Fichiers();

                    $filename = strtoupper(substr(str_shuffle(md5($request->_token . "" . rand(124, 345))), 0, 4)) . date('YmdHi') . '.' . $fichier->extension();
                    $pieceAS->nomOriginal = $fichier->getClientOriginalName();
                    $pieceAS->slugSource =  $slugOpposition[0]->slug;
                    $pieceAS->filename = $filename;
                    $pieceAS->slug = $request->_token . "" . rand(1234, 3458);
                    $pieceAS->path = 'assets/upload/fichiers/audiences/oppositions/' . $filename;
                    $fichier->move(public_path('assets/upload/fichiers/audiences/oppositions/'), $filename);
                    $pieceAS->save();
                }
            }

            // Enregistrement du PV introgatoire
            if ($value['typeActe'] == 'PV introgatoire') {
                PvInterrogatoires::create([
                    'idActe' => $idActeSelect[0]->idActe,
                    'dateAudition' => $value['dateAudition'],
                    'identiteOPJ' => $value['identiteOPJ'],
                    'infractions' => $value['infractions'],
                    'dateAudience' => $value['dateAudience'],
                    'slug' => $request->_token . "" . rand(1234, 3458),
                ]);
            }

            // Enregistrement du Requisitoire
            if ($value['typeActe'] == 'Requisitoire') {
                Requisitoires::create([
                    'idActe' => $idActeSelect[0]->idActe,
                    'numInstruction' => $value['numInstruction'],
                    'identiteOPJ' => $value['identiteOPJ'],
                    'procureur' => $value['procureur'],
                    'chefAccusation' => $value['chefAccusationReq'],
                    'slug' => $request->_token . "" . rand(1234, 3458),
                ]);
            }

            // Enregistrement de Ordonnance Renvoi
            if ($value['typeActe'] == 'Ordonnance Renvoi') {
                OrdonnanceRenvois::create([
                    'idActe' => $idActeSelect[0]->idActe,
                    'numOrd' => $value['numOrd'],
                    'cabinetIns' => $value['cabinetIns'],
                    'typeProcedure' => $value['typeProcedure'],
                    'chefAccusation' => $value['chefAccusationOrd'],
                    'slug' => $request->_token . "" . rand(1234, 3458),
                ]);
            }

            // Enregistrement de Citation directe
            if ($value['typeActe'] == 'Citation directe') {
                CitationDirectes::create([
                    'idActe' => $idActeSelect[0]->idActe,
                    'saisi' => $value['saisi'],
                    'dateHeureAud' => $value['dateHeureAud'],
                    'idHuissier' => $value['idHuissier'],
                    'recepteurCitation' => $value['recepteurCitation'],
                    'dateSignification' => $value['dateSignification'],
                    'mentionParticuliere' => $value['mentionParticuliere'],
                    'chefAccusation' => $value['chefAccusation'],
                    'slug' => $request->_token . "" . rand(1234, 3458),
                ]);
            }

            // Enregistrement du PCPC
            if ($value['typeActe'] == 'PCPC') {
                Pcpcs::create([
                    'idActe' => $idActeSelect[0]->idActe,
                    'reference' => $value['reference'],
                    'datePcpc' => $value['datePcpc'],
                    'dateProchaineAud' => $value['dateProchaineAud'],
                    'slug' => $request->_token . "" . rand(1234, 3458),
                ]);
            }

            // Enregistrement de Declaration d'appel
            if ($value['typeActe'] == "Declaration d'appel") {
                DeclarationAppels::create([
                    'idActe' => $idActeSelect[0]->idActe,
                    'numRg' =>  $value['numRgDeclaration'],
                    'numJugement' =>  $value['numJugement'],
                    'dateAppel' =>  $value['dateAppel'],
                    'slug' => $request->_token . "" . rand(1234, 3458),
                ]);
            }

            // Enregistrement de Contredit
            if ($value['typeActe'] == "Contredit") {
                Contredits::create([
                    'idActe' => $idActeSelect[0]->idActe,
                    'numConcerner' => $value['numConcerner'],
                    'numDecisConcerner' => $value['numDecisConcerner'],
                    'dateContredit' => $value['dateContredit'],
                    'dateDecision' => $value['dateDecision'],
                    'slug' => $request->_token . "" . rand(1234, 3458),
                ]);
            }

            // Enregistrement de Contredit
            if ($value['typeActe'] == "Pourvoi") {
                Pourvois::create([
                    'idActe' => $idActeSelect[0]->idActe,
                    'numPourvoi' =>  $value['numPourvoi'],
                    'numDecision' =>  $value['numDecisConcerner'],
                    'datePourvoi' =>  $value['datePourvoi'],
                    'dateDecision' =>  $value['dateDecision'],
                    'slug' => $request->_token . "" . rand(1234, 3458),
                ]);
            }

            }

            // Notifications
            $personnels = DB::select("select * from personnels,users where personnels.email=users.email and users.role='Collaborateur'");
            foreach ($personnels as $p) {

                DB::select(
                    'INSERT INTO notifications(categorie, messages, etat, idRecepteur,slug,a_biper,urlName,urlParam) VALUES(?,?,?,?,?,?,?,?)',
                    [
                        'Audience',
                        'Une nouvelle audience de jonction a été ajoutée.',
                        'masquer',
                        $p->idPersonnel,
                        $request->_token . "" . rand(1234, 3458),
                        "non",
                        "detailAudience",
                        $audiences->slug
                    ]
                );
            }

            $admins = DB::select("select * from users where role='Administrateur'");

            foreach ($admins as $a) {
                DB::select(
                    'INSERT INTO notifications(categorie, messages, etat, idRecepteur,slug,a_biper,urlName,urlParam,idAdmin) VALUES(?,?,?,?,?,?,?,?,?)',
                    [
                        'Audience',
                        'Une nouvelle audience de jonction a été ajoutée.',
                        'masquer',
                        'admin',
                        $request->_token . "" . rand(1234, 3458),
                        "non",
                        "detailAudience",
                        $audiences->slug,
                        $a->id
                    ]
                );
             }
        }
        

        return redirect()->route('listAudience', 'generale')->with('success', 'Audience de jonction créée avec succès');

      });
    }

    public function fetchAudienceJonction($idJuridiction)
    {

        // Verication du typeContent pour retourner une bonne reponse
        $audJonctions = DB::select("select * from audiences where  isChild is null and juridiction=?",[$idJuridiction]);
      
        return response()->json([
            'audJonctions' => $audJonctions,
        ]);
    }

    public function annulerAppel(Request $request, $slugSuivi)
    {
        $suiviAudience = DB::select("select * from suivit_audiences where slug=?",[$slugSuivi]);

        $audiences = DB::select("select * from audiences where idAudience=?",[$suiviAudience[0]->idAudience]);


        DB::update("update suivit_audiences set rappelLettre='ne_pas_rappeler' where slug=?",[$slugSuivi]);

        // Notifications
        $personnels = DB::select("select * from personnels,users where personnels.email=users.email and users.role='Collaborateur'");
        foreach ($personnels as $p) {

            DB::select(
                'INSERT INTO notifications(categorie, messages, etat, idRecepteur,slug,a_biper,urlName,urlParam) VALUES(?,?,?,?,?,?,?,?)',
                [
                    'Audience',
                    'Une action pour faire appel a été annulée.',
                    'masquer',
                    $p->idPersonnel,
                    $request->_token . "" . rand(1234, 3458),
                    "non",
                    "detailAudience",
                    $audiences[0]->slug
                ]
            );
        }

        $admins = DB::select("select * from users where role='Administrateur'");

        foreach ($admins as $a) {
            DB::select(
                'INSERT INTO notifications(categorie, messages, etat, idRecepteur,slug,a_biper,urlName,urlParam,idAdmin) VALUES(?,?,?,?,?,?,?,?,?)',
                [
                    'Audience',
                    'Une action pour faire appel a été annulée.',
                    'masquer',
                    'admin',
                    $request->_token . "" . rand(1234, 3458),
                    "non",
                    "detailAudience",
                    $audiences[0]->slug,
                    $a->id
                ]
            );
            }

        return redirect()->back()->with('success', 'Action pour faire appel est annulée');

    }

    public function annulerSignification(Request $request, $slugSuivi)
    {
        $suiviAudience = DB::select("select * from suivit_audiences where slug=?",[$slugSuivi]);

        $audiences = DB::select("select * from audiences where idAudience=?",[$suiviAudience[0]->idAudience]);


        DB::update("update suivit_audiences set rappelSignification='ne_pas_rappeler' where slug=?",[$slugSuivi]);

        // Notifications
        $personnels = DB::select("select * from personnels,users where personnels.email=users.email and users.role='Collaborateur'");
        foreach ($personnels as $p) {

            DB::select(
                'INSERT INTO notifications(categorie, messages, etat, idRecepteur,slug,a_biper,urlName,urlParam) VALUES(?,?,?,?,?,?,?,?)',
                [
                    'Audience',
                    'Une action pour signifier a été annulée.',
                    'masquer',
                    $p->idPersonnel,
                    $request->_token . "" . rand(1234, 3458),
                    "non",
                    "detailAudience",
                    $audiences[0]->slug
                ]
            );
        }

        $admins = DB::select("select * from users where role='Administrateur'");

        foreach ($admins as $a) {
            DB::select(
                'INSERT INTO notifications(categorie, messages, etat, idRecepteur,slug,a_biper,urlName,urlParam,idAdmin) VALUES(?,?,?,?,?,?,?,?,?)',
                [
                    'Audience',
                    'Une action pour signifier a été annulée.',
                    'masquer',
                    'admin',
                    $request->_token . "" . rand(1234, 3458),
                    "non",
                    "detailAudience",
                    $audiences[0]->slug,
                    $a->id
                ]
            );
            }

        return redirect()->back()->with('success', 'Action pour signifier est annulée');

    }

    public function saveSignification(Request $request){


        Significations::create([
            'numJugement' => $request->numJugement,
            'slugAudience' => $request->slugAudience,
            'dateSignification' => $request->dateSignification,
            'idHss' => $request->idHss,
            'reserve' => $request->reserve,
            'recepteur' => $request->recepteur,
            'slug' => $request->_token . "" . rand(1234, 3458),
        ]);

        if ($request->file('fileSignification') != null) {

            $slugSignification = DB::select("select slug from significations order by idSignification desc limit 1");

            $fichier = request()->file('fileSignification');
            $pieceSignification = new Fichiers();

            $filename = strtoupper(substr(str_shuffle(md5($request->_token . "" . rand(124, 345))), 0, 4)) . date('YmdHi') . '.' . $fichier->extension();
            $pieceSignification->nomOriginal = $fichier->getClientOriginalName();
            $pieceSignification->slugSource =  $slugSignification[0]->slug;
            $pieceSignification->filename = $filename;
            $pieceSignification->slug = $request->_token . "" . rand(1234, 3458);
            $pieceSignification->path = 'assets/upload/fichiers/audiences/significations/' . $filename;
            $fichier->move(public_path('assets/upload/fichiers/audiences/significations/'), $filename);
            $pieceSignification->save();
        }

        $audience = DB::select("select idAudience from audiences where slug=?", [$request->slugAudience]);

        DB::update("update suivit_audiences set rappelSignification='ne_pas_rappeler' where idAudience=?",[$audience[0]->idAudience]);

            // Notifications
            $personnels = DB::select("select * from personnels,users where personnels.email=users.email and users.role='Collaborateur'");
            foreach ($personnels as $p) {
    
                DB::select(
                    'INSERT INTO notifications(categorie, messages, etat, idRecepteur,slug,a_biper,urlName,urlParam) VALUES(?,?,?,?,?,?,?,?)',
                    [
                        'Audience',
                        'Un jugement a été signifier.',
                        'masquer',
                        $p->idPersonnel,
                        $request->_token . "" . rand(1234, 3458),
                        "non",
                        "detailAudience",
                        $audience[0]->slug
                    ]
                );
            }
    
            $admins = DB::select("select * from users where role='Administrateur'");
    
            foreach ($admins as $a) {
                DB::select(
                    'INSERT INTO notifications(categorie, messages, etat, idRecepteur,slug,a_biper,urlName,urlParam,idAdmin) VALUES(?,?,?,?,?,?,?,?,?)',
                    [
                        'Audience',
                        'Un jugement a été signifier.',
                        'masquer',
                        'admin',
                        $request->_token . "" . rand(1234, 3458),
                        "non",
                        "detailAudience",
                        $audience[0]->slug,
                        $a->id
                    ]
                );
            }

        return redirect()->back()->with('success', 'Signification enregistrée avec succès !');

        
    }

    public function fetchRequete( Request $request, $id)
    {
        // Verication du typeContent pour retourner une bonne reponse
        
       // $requeteClientFetch = DB::select("select * from procedure_requetes, parties_requetes where procedure_requetes.idProcedure=parties_requetes.idRequete and parties_requetes.idClient=?",[$id]);
       

/*
        $requeteClientFetch = DB::select("
            SELECT procedure_requetes.objet AS objet, procedure_requetes.slug AS slug
            FROM procedure_requetes
            INNER JOIN parties_requetes ON procedure_requetes.idProcedure = parties_requetes.idRequete
            WHERE parties_requetes.idClient = ?
            and procedure_requetes.slug!='$slugProcedure'

            UNION

            SELECT audiences.objet AS objet, audiences.slug AS slug
            FROM audiences
            INNER JOIN parties ON audiences.idAudience = parties.idPartie
            WHERE parties.idClient = ?
            and audiences.slug!='$slugProcedure'
        ", [$id, $id]);
*/
            $slugProcedure = $request->input('slugProcedure'); // peut être null

            $requeteClientFetch = DB::select("
                SELECT procedure_requetes.objet AS objet, procedure_requetes.slug AS slug
                FROM procedure_requetes
                INNER JOIN parties_requetes 
                    ON procedure_requetes.idProcedure = parties_requetes.idRequete
                WHERE parties_requetes.idClient = ?
                AND (? IS NULL OR procedure_requetes.slug != ?)

                UNION

                SELECT audiences.objet AS objet, audiences.slug AS slug
                FROM audiences
                INNER JOIN parties 
                    ON audiences.idAudience = parties.idAudience
                WHERE parties.idClient = ?
                AND (? IS NULL OR audiences.slug != ?)
            ", [
                $id, $slugProcedure, $slugProcedure,
                $id, $slugProcedure, $slugProcedure
            ]);


        $client = DB::select("SELECT * FROM clients WHERE idClient = ?", [$id]);

        return response()->json([
            'requeteClientFetch' => $requeteClientFetch,
            'client' => $client,
        ]);
    }
    public function lierRequeteManuelRequete(Request $request)
    {
        $arr = is_array($request->requeteLier) ? $request->requeteLier : [$request->requeteLier];

        foreach ($arr as $requete) {
            RequeteLiers::create([
                'requete' => $requete,
                'slugProcedure' => $request->slugProcedure,
                'slug' => $request->_token . rand(1234, 3458),
            ]);
        }
        return redirect()->back()->with('success', 'Requete enregistrée avec succès !'); 

    }

    public function lierRequeteManuelContraditoire(Request $request)
    {
       
        $arr = is_array($request->contraditoireLier) ? $request->contraditoireLier : [$request->contraditoireLier];
    
        foreach ($arr as $slugToLier) {
    
            // On vérifie dans les deux tables
            $existsInAudience = DB::table('audiences')->where('slug', $slugToLier)->exists();
            $existsInRequete = DB::table('procedure_requetes')->where('slug', $slugToLier)->exists();
            // Récupération de la valeur du champ 'slugAudience'
            $slugAudience = $request->input('slugProcedure');
            //dd($slugAudience, $existsInRequete, $existsInAudience);
    
            if ($existsInAudience) {
                $type = 'audience';
            } elseif ($existsInRequete) {
                $type = 'requete';
            } else {
                // Aucun type trouvé, on passe ou on renvoie une erreur
                return redirect()->back()->with('error', "Le slug \"$slugToLier\" n'existe ni dans audiences ni dans requêtes.");
            }

            // Vérifier si le slug existe dans l'une des deux tables
            if ($existsInAudience || $existsInRequete ) {
                // Vérifier aussi que la liaison n'existe pas déjà pour éviter les doublons
                $alreadyLinked = DB::table('procedure_liers')
                ->where('slugSource', $slugAudience)
                ->where('slugProcedure', $slugToLier)
                ->exists();

                $alreadyLinked2 = DB::table('procedure_liers')
                ->where('slugProcedure', $slugAudience)
                ->where('slugSource', $slugToLier)
                ->exists();
                if($alreadyLinked || $alreadyLinked2){
                    return redirect()->back()->with('error', 'Cette liaison existe déjà.');
                }
                else{
                    // Enregistrement de la liaison
                    ProcedureLiers::create([
                        'typeProcedure' => $type,
                        'slugSource' => $slugAudience,
                        'slugProcedure' => $slugToLier,
                        'slug' => $request->_token . rand(1234, 3458),
                    ]);
                }

            }
           
           
        }
    
        return redirect()->back()->with('success', 'Requêtes liées avec succès !');
    }
    

    public function deleteRequeteLier(Request $request, $id)
    {
        DB::delete("delete from procedure_liers where idProcedureLier=?",[$id]);
        return redirect()->back()->with('success', 'Requete lier supprimé avec succès !'); 

    }


}