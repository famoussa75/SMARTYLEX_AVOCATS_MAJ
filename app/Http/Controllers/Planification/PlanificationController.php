<?php

namespace App\Http\Controllers\Planification;

use App\Http\Controllers\Controller;
use App\Models\Audiences;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;


use App\Models\clients;
use App\Models\Affaire;
use App\Models\User; 
use App\Models\Personnels;
use App\Models\Taches;
use App\Models\RapportTaches;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use DateTime;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

use Illuminate\Support\Facades\Log;


class PlanificationController extends Controller
{
    // Fonction permettante d'envoyer à chaque 16h 00min le recapitulatif des audiences à vénir le lendemain
    public function sendRecapEmail()
    {
        // Recuperer toutes les audiences prévues pour le lendemain
        $date = now()->addDay()->format('d/m/Y');
        $tomorrow = now()->addDay()->toDateString();
        $audiences = DB::select("
            SELECT subquery.idAudience, j.nom as juridiction_nom,
                subquery.numRg, subquery.objet, subquery.niveauProcedural,
                CONCAT(j.nom, ' - ', j.adresse) AS juridiction_info,
                subquery.slugAud, subquery.statutAud, subquery.isChild, subquery.prochaineAudience,
                GROUP_CONCAT(
                    CASE
                        WHEN subquery.denomination IS NOT NULL THEN subquery.denomination
                        WHEN subquery.prenom IS NOT NULL AND subquery.nom IS NOT NULL THEN CONCAT(subquery.prenom, ' ', subquery.nom)
                        ELSE ''
                    END
                    SEPARATOR ', '
                ) AS parties
            FROM (
                SELECT a.idAudience, a.slug AS slugAud, a.numRg, a.objet, a.niveauProcedural,
                    a.statut as statutAud, a.isChild, a.prochaineAudience, a.juridiction,
                    c.prenom, c.nom, c.denomination
                FROM audiences a
                JOIN parties p ON a.idAudience = p.idAudience
                LEFT JOIN clients c ON p.idClient = c.idClient

                UNION ALL

                SELECT a.idAudience, a.slug, a.numRg, a.objet, a.niveauProcedural,
                    a.statut, a.isChild, a.prochaineAudience, a.juridiction,
                    pa.prenom, pa.nom, NULL as denomination
                FROM audiences a
                JOIN parties p ON a.idAudience = p.idAudience
                JOIN personne_adverses pa ON p.idPartie = pa.idPartie

                UNION ALL

                SELECT a.idAudience, a.slug, a.numRg, a.objet, a.niveauProcedural,
                    a.statut, a.isChild, a.prochaineAudience, a.juridiction,
                    NULL as prenom, NULL as nom, ea.denomination
                FROM audiences a
                JOIN parties p ON a.idAudience = p.idAudience
                JOIN entreprise_adverses ea ON p.idPartie = ea.idPartie
            ) AS subquery
            JOIN juriductions j ON j.id = subquery.juridiction
            WHERE (subquery.isChild IS NULL OR subquery.isChild != 'oui')
            AND DATE(subquery.prochaineAudience) = ?
            GROUP BY subquery.idAudience, j.nom, subquery.numRg, subquery.objet,
                    subquery.niveauProcedural, j.adresse, subquery.slugAud,
                    subquery.statutAud, subquery.isChild, subquery.prochaineAudience
            ORDER BY subquery.idAudience ASC
        ", [$tomorrow]);


        $emailBody = "<h3>Récapitulatif des audiences prévues pour le " . $date . "</h3>";
        if (empty($audiences) == true) {
            $emailBody .= "<p>Aucune audience prévue pour demain.</p>";
            // Signature en bas à droite
            $emailBody .= '<div style="text-align:right;margin-top:20px;">
            <em>Envoyé depuis <a href="https://smartylex.com" target="_blank" style="color:#007bff;text-decoration:none;">smartylex.com</a></em>
            </div>';
        } else {
            $emailBody .= '<table border="1" cellpadding="5" cellspacing="0" style="width:100%">
            <thead>
            <tr>
            <th>N°</th>
            <th>Juridiction</th>
            <th>N°RG</th>
            <th>Parties</th>
            <th>Objet</th>
            <th>Niveau Procedural</th>
            <th>Prochaine audience</th>
            <th>Statut</th>
            </tr>
            </thead>
            <tbody>';
            foreach ($audiences as $i => $row) {
            $niveauLabel = $row->niveauProcedural == "1ère instance" ?
            '<small style="background:#28a745;color:#fff;padding:2px 6px;border-radius:3px;">'.$row->niveauProcedural.'</small>' :
            ($row->niveauProcedural == "Appel" ?
            '<small style="background:#ffc107;color:#212529;padding:2px 6px;border-radius:3px;">'.$row->niveauProcedural.'</small>' :
            '<small style="background:#dc3545;color:#fff;padding:2px 6px;border-radius:3px;">'.$row->niveauProcedural.'</small>');
            $dateAudienceDisplay = empty($row->prochaineAudience) ? 'N/A' : date('d/m/Y', strtotime($row->prochaineAudience));
            $emailBody .= '<tr>
            <td>'.($i+1).'</td>
            <td>'.$row->juridiction_info.'</td>
            <td>'.$row->numRg.'</td>
            <td>'.($row->parties ?? '').'</td>
            <td>'.$row->objet.'</td>
            <td>'.$niveauLabel.'</td>
            <td>'.$dateAudienceDisplay.'</td>
            <td>'.$row->statutAud.'</td>
            </tr>';
            }
            $emailBody .= '</tbody></table>';

            // Signature en bas à droite
            $emailBody .= '<div style="text-align:right;margin-top:20px;">
            <em>Envoyé depuis <a href="https://smartylex.com" target="_blank" style="color:#007bff;text-decoration:none;">smartylex.com</a></em>
            </div>';
        }

        $users = DB::table('users')->pluck('email')->toArray();
        foreach ($users as $toEmail) {
            Mail::send([], [], function ($message) use ($toEmail, $emailBody) {
            $message->to($toEmail)
            ->subject("Récapitulatif des audiences prévues pour demain")
            ->html($emailBody);
            });
        }

         
        $aujourdhui = date('Y-m-d');

        // 1ere instance

        // Récupérer les suivis du jour
        $suivis = DB::select("
            SELECT * FROM suivit_audiences
            WHERE DATE(dateProchaineAudience) = ?
        ", [$aujourdhui]);
        //dd($suivis );
        
        if (!empty($suivis)) {

            foreach ($suivis as $s) {

                if (empty($s->slug)) {
                    continue; // ignorer les entrées sans slug
                }

                $slugSuivi = $s->slug;

                $personnels = DB::select("select * from personnels,users where personnels.email=users.email and users.role!='Administrateur'");
                foreach ($personnels as $p) {

                    DB::select(
                        'INSERT INTO notifications(categorie, messages, etat, idRecepteur,slug,a_biper,urlName,urlParam) VALUES(?,?,?,?,?,?,?,?)',
                        [
                            'Audience',
                            'Aucun suivi n’a été effectué aujourd’hui pour cette audience en 1ère instance',
                            'masquer',
                            $p->id,
                            $slugSuivi,
                            "non",
                            "detailAudience",
                            $slugSuivi 
                        ]
                    );
                }

                $admins = DB::select("select * from users where role='Administrateur'");

                foreach ($admins as $a) {
                    DB::select(
                        'INSERT INTO notifications(categorie, messages, etat, idRecepteur,slug,a_biper,urlName,urlParam,idAdmin) VALUES(?,?,?,?,?,?,?,?,?)',
                        [
                            'Audience',
                            'Aucun suivi n’a été effectué aujourd’hui pour cette audience en 1ère instance',
                            'masquer',
                            'admin',
                            $slugSuivi,
                            "non",
                            "detailAudience",
                            $slugSuivi ,
                            $a->id
                        ]
                    );
                }
            
            }

            
        }

        // Appel

        // Récupérer les suivis du jour
        $suivisAppel = DB::select("
            SELECT * FROM suivit_audience_appels
            WHERE DATE(dateLimite) = ?
        ", [$aujourdhui]);
        ///dd($suivisAppel );


        if (!empty($suivisAppel)) {


            foreach ($suivisAppel as $s) {

                if (empty($s->slug)) {
                    continue; // ignorer les entrées sans slug
                }

                $suivisAppel = $s->slug;

                $personnels = DB::select("select * from personnels,users where personnels.email=users.email and users.role!='Administrateur'");
                foreach ($personnels as $p) {

                    DB::select(
                        'INSERT INTO notifications(categorie, messages, etat, idRecepteur,slug,a_biper,urlName,urlParam) VALUES(?,?,?,?,?,?,?,?)',
                        [
                            'Audience',
                            'Aucun suivi n’a été effectué aujourd’hui pour cette audience en appel.',
                            'masquer',
                            $p->id,
                            $suivisAppel,
                            "non",
                            "detailAudience",
                            $suivisAppel 
                        ]
                    );
                }

                $admins = DB::select("select * from users where role='Administrateur'");

                foreach ($admins as $a) {
                    DB::select(
                        'INSERT INTO notifications(categorie, messages, etat, idRecepteur,slug,a_biper,urlName,urlParam,idAdmin) VALUES(?,?,?,?,?,?,?,?,?)',
                        [
                            'Audience',
                            'Aucun suivi n’a été effectué aujourd’hui pour cette audience en appel.',
                            'masquer',
                            'admin',
                            $suivisAppel,
                            "non",
                            "detailAudience",
                            $suivisAppel ,
                            $a->id
                        ]
                    );
                }

            }

            
        }


        /* nouveau */

        $dateActuelle = date('Y-m-d');
        $cabinet = DB::select("select * from cabinets"); 
        $serveurEmail = DB::select("select * from serveur_mails");

        $Tvalider = count(DB::select("select * from taches where statut='validée'"));
        $ThorsDelais = count(DB::select("select * from taches where statut='Hors Délais'"));
        $Tencours = count(DB::select("select * from taches where statut='En cours'"));
        $Tsuspendus = count(DB::select("select * from taches where statut='suspendu'"));


        
        //envoi de rapport journaliere

        if ($cabinet[0]->rapportTache=='on' && $cabinet[0]->frequenceRapport=='journalier') {

            $dateHier = date('Y-m-d', strtotime($dateActuelle . ' -1 day'));
            $rapportExist = DB::select("select * from rapport_taches where dateRapport=? and idUser=?", [$dateHier, Auth::user()->id]);

            if (empty($rapportExist)) {

                require base_path("vendor/autoload.php");
                $mail = new PHPMailer(true);     // Passing `true` enables exceptions
        
                try {
        
                    // Email server settings
                    $mail->SMTPDebug = 0;
                    $mail->isSMTP();
                    $mail->Host = $serveurEmail[0]->host;              //  smtp host
                    $mail->SMTPAuth = true;
                    $mail->Username = $cabinet[0]->emailContact;   //  sender username
                    $mail->Password = $cabinet[0]->cleContact;       // sender password
                    $mail->SMTPSecure = $serveurEmail[0]->smtpSecure;                  // encryption - ssl/tls
                    $mail->Port = $serveurEmail[0]->smtpPort;                        // port - 587/465
                    $mail->SMTPOptions = array(
                        'ssl' => array(
                            'verify_peer' => false,
                            'verify_peer_name' => false,
                            'allow_self_signed' => true
                        )
                    );
        
                    $mail->setFrom($cabinet[0]->emailContact, $cabinet[0]->nomCabinet);
                    if (Auth::user()->role == 'Administrateur') {
                        // S'il est admin → renvoi à lui-même
                        $mail->addAddress(Auth::user()->email);
                    } else {
                        // Sinon → renvoi aux admins
                        $admins = User::where('role', 'Administrateur')->get();
                        foreach ($admins as $admin) {
                            $mail->addAddress($admin->email);
                        }
                    }

                    /// $mail->addAddress(Auth::user()->email);
                    
        
                    $body = "       
                            <h3> Statistique par statut : </h3>
                            <table  border='1' cellpadding='10' cellspacing='0'>
                                <tr>
                                    <th>Tâches validées</th>
                                    <th>Tâches encours</th>
                                    <th>Tâches hors délais</th>
                                    <th>Fréquence du rapport</th>
                                </tr>
                                <tr>
                                    <td>".$Tvalider."</td>
                                    <td>".$Tencours."</td>
                                    <td>".$ThorsDelais."</td>
                                    <td>".$cabinet[0]->frequenceRapport."</td>
                                </tr>                          
                            </table>
                        ";
                    $mail->isHTML(true);                // Set email content format to HTML
                    $mail->Subject ='RAPPORT DE TÂCHES DU : '.'-'.date('d/m/Y', strtotime($dateHier));
                    $mail->CharSet = "UTF-8";
                    $mail->Encoding = 'base64';
                    $mail->Body = $body;
        
                    // $mail->AltBody = plain text version of email body;
        
                    if (!$mail->send()) {
                        
                    } else {
                        
                        $newRapport = new RapportTaches;
                        $newRapport->valider = $Tvalider;
                        $newRapport->encour = $Tencours;
                        $newRapport->horsDelais = $ThorsDelais;
                        $newRapport->suspendu = $Tsuspendus;
                        $newRapport->dateRapport = $dateHier;
                        $newRapport->idUser = Auth::user()->id;
                        $newRapport->slug = uniqid() . '' . rand(1234, 3458);
                        $newRapport->save();
                                
                    }

                } catch (Exception $e) {}

            }
        }

        ///envoi de rapport mensuel
        if ($cabinet[0]->rapportTache=='on' && $cabinet[0]->frequenceRapport=='mensuel') {

            $dateMoisDernierDB = date('Y-m-d', strtotime($dateActuelle . ' -1 month'));
            $dateMoisDernier = date('Y-m', strtotime($dateActuelle . ' -1 month'));
            $rapportExist = DB::select("select * from rapport_taches where dateRapport like '%$dateMoisDernier%' and idUser=?", [Auth::user()->id]);

        if (empty($rapportExist)) {

                require base_path("vendor/autoload.php");
                $mail = new PHPMailer(true);     // Passing `true` enables exceptions
        
                try {
                    // Email server settings
                    $mail->SMTPDebug = 0;
                    $mail->isSMTP();
                    $mail->Host = $serveurEmail[0]->host;            //  smtp host
                    $mail->SMTPAuth = true;
                    $mail->Username = $cabinet[0]->emailContact;   //  sender username
                    $mail->Password = $cabinet[0]->cleContact;       // sender password
                    $mail->SMTPSecure = $serveurEmail[0]->smtpSecure;                  // encryption - ssl/tls
                    $mail->Port = $serveurEmail[0]->smtpPort;                        // port - 587/465
                    $mail->SMTPOptions = array(
                        'ssl' => array(
                            'verify_peer' => false,
                            'verify_peer_name' => false,
                            'allow_self_signed' => true
                        )
                    );
        
                    $mail->setFrom($cabinet[0]->emailContact, $cabinet[0]->nomCabinet);
                    ///$mail->addAddress(Auth::user()->email);

                    /// $mail->setFrom($cabinet[0]->emailContact, $cabinet[0]->nomCabinet);
                    if (Auth::user()->role == 'Administrateur') {
                        // S'il est admin → renvoi à lui-même
                        $mail->addAddress(Auth::user()->email);
                    } else {
                        // Sinon → renvoi aux admins
                        $admins = User::where('role', 'Administrateur')->get();
                        foreach ($admins as $admin) {
                            $mail->addAddress($admin->email);
                        }
                    } 
                    
        
                    $body = "       
                            <h3> Statistique par statut : </h3>
                            <table  border='1' cellpadding='10' cellspacing='0'>
                                <tr>
                                    <th>Tâches validées</th>
                                    <th>Tâches encours</th>
                                    <th>Tâches hors délais</th>
                                    <th>Fréquence du rapport</th>
                                </tr>
                                <tr>
                                    <td>".$Tvalider."</td>
                                    <td>".$Tencours."</td>
                                    <td>".$ThorsDelais."</td>
                                    <td>".$cabinet[0]->frequenceRapport."</td>
                                </tr>                          
                            </table>
                        ";
                        $mail->isHTML(true);                // Set email content format to HTML
                        $mail->Subject ='RAPPORT DE TÂCHES DU MOIS DERNIER';
                        $mail->CharSet = "UTF-8";
                        $mail->Encoding = 'base64';
                        $mail->Body = $body;
            
                        // $mail->AltBody = plain text version of email body;
            
                        if (!$mail->send()) {
                            
                        } else {
                            
                            $newRapport = new RapportTaches;
                            $newRapport->valider = $Tvalider;
                            $newRapport->encour = $Tencours;
                            $newRapport->horsDelais = $ThorsDelais;
                            $newRapport->suspendu = $Tsuspendus;
                            $newRapport->dateRapport = $dateMoisDernierDB;
                            $newRapport->idUser = Auth::user()->id;
                            $newRapport->slug = uniqid() . '' . rand(1234, 3458);
                            $newRapport->save();
                                    
                        }
    
                    } catch (Exception $e) {}
    
                }
        }

        ///envoi de rapport trimestriel
        if ($cabinet[0]->rapportTache=='on' && $cabinet[0]->frequenceRapport=='trimestriel') {

            $dateTrimestreDernierDB = date('Y-m-d', strtotime($dateActuelle . ' -3 month'));
            $dateTrimestreDernier = date('Y-m', strtotime($dateActuelle . ' -3 month'));
            $rapportExist = DB::select("select * from rapport_taches where dateRapport like %'$dateTrimestreDernier'% and idUser=?", [$dateTrimestreDernier, Auth::user()->id]);
            
            if (empty($rapportExist)) {

                require base_path("vendor/autoload.php");
                $mail = new PHPMailer(true);     // Passing `true` enables exceptions
        
                try {
        
                    // Email server settings
                    $mail->SMTPDebug = 0;
                    $mail->isSMTP();
                    $mail->Host = $serveurEmail[0]->host;             //  smtp host
                    $mail->SMTPAuth = true;
                    $mail->Username = $cabinet[0]->emailContact;   //  sender username
                    $mail->Password = $cabinet[0]->cleContact;       // sender password
                    $mail->SMTPSecure = $serveurEmail[0]->smtpSecure;                  // encryption - ssl/tls
                    $mail->Port = $serveurEmail[0]->smtpPort;                        // port - 587/465
                    $mail->SMTPOptions = array(
                        'ssl' => array(
                            'verify_peer' => false,
                            'verify_peer_name' => false,
                            'allow_self_signed' => true
                        )
                    );
        
                    $mail->setFrom($cabinet[0]->emailContact, $cabinet[0]->nomCabinet);
                    //$mail->addAddress(Auth::user()->email);

                    if (Auth::user()->role == 'Administrateur') {
                        // S'il est admin → renvoi à lui-même
                        $mail->addAddress(Auth::user()->email);
                    } else {
                        // Sinon → renvoi aux admins
                        $admins = User::where('role', 'Administrateur')->get();
                        foreach ($admins as $admin) {
                            $mail->addAddress($admin->email);
                        }
                    } 
                    
                    
        
                    $body = "       
                            <h3> Statistique par statut : </h3>
                            <table  border='1' cellpadding='10' cellspacing='0'>
                                <tr>
                                    <th>Tâches validées</th>
                                    <th>Tâches encours</th>
                                    <th>Tâches hors délais</th>
                                    <th>Fréquence du rapport</th>
                                </tr>
                                <tr>
                                    <td>".$Tvalider."</td>
                                    <td>".$Tencours."</td>
                                    <td>".$ThorsDelais."</td>
                                    <td>".$cabinet[0]->frequenceRapport."</td>
                                </tr>                          
                            </table>
                        ";
                    $mail->isHTML(true);                // Set email content format to HTML
                    $mail->Subject ='RAPPORT DE TÂCHES DU DERNIER TRIMESTRE';
                    $mail->CharSet = "UTF-8";
                    $mail->Encoding = 'base64';
                    $mail->Body = $body;
        
                    // $mail->AltBody = plain text version of email body;
        
                    if (!$mail->send()) {
                        
                    } else {
                        
                        $newRapport = new RapportTaches;
                        $newRapport->valider = $Tvalider;
                        $newRapport->encour = $Tencours;
                        $newRapport->horsDelais = $ThorsDelais;
                        $newRapport->suspendu = $Tsuspendus;
                        $newRapport->dateRapport = $dateTrimestreDernierDB;
                        $newRapport->idUser = Auth::user()->id;
                        $newRapport->slug = uniqid() . '' . rand(1234, 3458);
                        $newRapport->save();
                                    
                    }
    
                } catch (Exception $e) {}
    
            }
        }

        /// procedure sur requetes

        $procedure_requete = DB::table('procedure_requetes')->get();
        $today = date('Y-m-d');
        
        foreach ($procedure_requete as $c) {
            $dateArriver = date('Y-m-d', strtotime($c->dateArriver . "+ 3 days"));
        
            // 🔔 Condition : si la requête est arrivée aujourd’hui et qu’elle n’a pas encore été notifiée
            if ($today == $dateArriver && (is_null($c->rappel) || trim($c->rappel) == '')) {
        
                $slug = $c->slug;
        
                // 🔸 Notifier les administrateurs
                $users = DB::select("SELECT id FROM users WHERE role = 'Administrateur'");
                foreach ($users as $user) {
                    DB::table('notifications')->insert([
                        'categorie'   => 'Requete',
                        'messages'    => ' Une requête a été déposée il y a trois jours. Veuillez intenter une action',
                        'etat'        => 'masquer',
                        'idRecepteur' => 'admin',
                        'idAdmin'     => $user->id,
                        'slug'        => $slug,
                        'a_biper'     => 'non',
                        'urlName'     => 'detailRequete',
                        'urlParam'    => $slug
                    ]);
                }
        
                // 🔸 Notifier tous les personnels
                $personnels = DB::table('personnels')->get();
                foreach ($personnels as $personnel) {
                    DB::table('notifications')->insert([
                        'categorie'   => 'Requete',
                        'messages'    => ' Une requête a été déposée il y a trois jours. Veuillez intenter une action',
                        'etat'        => 'masquer',
                        'idRecepteur' => $personnel->idPersonnel,
                        'slug'        => $slug,
                        'a_biper'     => 'non',
                        'urlName'     => 'detailRequete',
                        'urlParam'    => $slug
                    ]);
                }
        
                // ✅ Mise à jour du champ rappel
                DB::update("UPDATE procedure_requetes SET rappel = 'oui' WHERE slug = ?", [$slug]);
                
            }
        // $newNotifs = DB::select("select * from notifications where etat='masquer' and idRecepteur='admin' and idAdmin=? order by id DESC",[Auth::user()->id]);
            // dd($newNotifs);
    
        }

        ///  facture 


        $today = date('Y-m-d'); // Définir la date du jour
        $factureEcheance = DB::table('factures')->get();
        $facturesDuJour = [];

        foreach ($factureEcheance as $c) {

            $dateRappel = date('Y-m-d', strtotime($c->dateEcheance . ' + 0 days'));

            // Vérifier si la facture est concernée aujourd'hui
            if ($today == $dateRappel && $c->rappel == 'non' && $c->notification == 'envoyer') {

                // Ajouter au tableau pour dump après
                $facturesDuJour[] = $c; 

                // === Ton code d'envoi d'email ===
                $slug =  $c->slug;
                $cabinet = DB::select("select * from cabinets"); 
                $serveurEmail = DB::select("select * from serveur_mails");
                $clientFacture = DB::select("select * from clients,factures where clients.idClient=factures.idClient and factures.rappel!='oui' and factures.statut='En retard' and factures.slug=?",[$slug]);

                if (!empty($clientFacture[0]->emailFacture)) {  

                    require base_path("vendor/autoload.php");
                    $mail = new PHPMailer(true);

                    try {
                        $mail->SMTPDebug = 0;
                        $mail->isSMTP();
                        $mail->Host =  $serveurEmail[0]->host;
                        $mail->SMTPAuth = true;
                        $mail->Username = $cabinet[0]->emailFinance;
                        $mail->Password = $cabinet[0]->cleFinance;
                        $mail->SMTPSecure = $serveurEmail[0]->smtpSecure;
                        $mail->Port = $serveurEmail[0]->smtpPort;
                        $mail->SMTPOptions = [
                            'ssl' => [
                                'verify_peer' => false,
                                'verify_peer_name' => false,
                                'allow_self_signed' => true
                            ]
                        ];

                        $mail->setFrom($cabinet[0]->emailFinance, $cabinet[0]->nomCabinet);
                        $mail->addAddress($clientFacture[0]->emailFacture, $cabinet[0]->emailFinance);
                        $mail->addAddress($cabinet[0]->emailFinance, $cabinet[0]->emailFinance);

                        $body = "
                            <div class='container'>
                                <p>Madame/Monsieur</p><br>
                                <p>Sauf erreur ou omission de notre part, la facture N° ".$clientFacture[0]->idFacture."-".date('m/Y', strtotime($clientFacture[0]->dateFacture)).", n'a pas fait l'objet de règlement à ce jour.</p>
                                <p>Nous vous prions d'y procéder selon les modes de règlement y indiqués.</p>
                                <p>Nous vous remercions pour votre confiance.</p>
                                <br><br><br>
                                ".$cabinet[0]->signature."
                            </div>
                        ";
                        $mail->isHTML(true);
                        $mail->Subject ='RELANCE FACTURE N° ' .$clientFacture[0]->idFacture.'-'.date('m/Y', strtotime($clientFacture[0]->dateFacture));
                        $mail->CharSet = "UTF-8";
                        $mail->Encoding = 'base64';
                        $mail->Body = $body;

                        if ($mail->send()) {
                            DB::update("update factures set rappel='oui' where slug=?",[$slug]);
                        }

                    } catch (Exception $e) {
                        // Tu peux log l'erreur ici
                    }
                }
            }
        }

        /// courrier Arrive 

        DB::statement("SET lc_time_names = 'fr_FR'");
        $sem = date('W');
        $sem2 = $sem + 1;
        $today = date("Y-m-d");

        $taches = DB::table('taches')->get();
        $courrierArriver = DB::select("select * from courier_arrivers");
      
        $admins = DB::select("select * from users where role='Administrateur'");


        foreach ($courrierArriver as $c) {
            $dateRappel = date('Y-m-d', strtotime($c->created_at . ' + 2 days'));
            if ($today == $dateRappel && $c->statut == 'Lu') {
                foreach ($admins as $key => $value) {
                    $data = [
                        'categorie' => 'Rappel Courrier',
                        'messages' => "Aucune action n'a été prise pour ce courrier.",
                        'etat' => "masquer",
                        'idRecepteur' => "admin",
                        'slug' => uniqid() . '' . rand(1234, 3458),
                        'urlName' => "detailCourierArriver",
                        'a_biper' => "non",
                        'urlParam' => $c->slug,
                        'idAdmin' => $value->id,
                    ];
    
                    DB::table('notifications')->insert($data);
                }
                
            }
            if ($today == $dateRappel && $c->statut == 'Reçu') {


               foreach ($admins as $key => $value) {
                    $data = [
                    'categorie' => 'Rappel Courrier',
                    'messages' => "Vous avez un courrier non lu.",
                    'etat' => "masquer",
                    'idRecepteur' => "admin",
                    'slug' => uniqid() . '' . rand(1234, 3458),
                    'a_biper' => "non",
                    'urlName' => "detailCourierArriver",
                    'urlParam' => $c->slug,
                     'idAdmin' => $value->id,
                    ];
    
                    DB::table('notifications')->insert($data);
                }
            }
        }


        /* end nouveau */







        return response()->json(['message' => 'Récapitulatif des audiences envoyé avec succès.']);
    }

    // Fonction permettante d'envoyer la notification de rappel d'ajouter un suivi pour les audiences passées sans suivi a la date d'envoi
    public function sendFollowUpReminderEmail()
    {
        // Recuperer toutes les audiences passées sans suivi à la date d'envoi
        $today = now()->toDateString();
        $audiencesWithoutFollowUp = DB::select("
            SELECT DISTINCT a.*
            FROM audiences a
            WHERE a.idAudience NOT IN (SELECT idAudience FROM suivit_audiences)
            AND DATE(a.prochaineAudience) = ?
            AND (a.isChild IS NULL OR a.isChild != 'oui')
        ", [$today]);

        $emailBody = "<h3>Rappel des audiences passées sans suivi pour la date du " . now()->format('d/m/Y') . "</h3>";
        if (empty($audiencesWithoutFollowUp) == true) {

            $emailBody .= "<p>Aucune audience passée sans suivi aujourd'hui.</p>";
            $emailBody .= '<div style="text-align:right;margin-top:20px;">
                <em>Envoyé depuis <a href="https://smartylex.com" target="_blank" style="color:#007bff;text-decoration:none;">smartylex.com</a></em>
            </div>';
        }else{
            $emailBody .= '<table border="1" cellpadding="5" cellspacing="0" style="width:100%">
            <thead>
            <tr>
                <th>N°</th>
                <th>N°RG</th>
                <th>Objet</th>
                <th>Niveau Procédural</th>
                <th>Date Audience</th>
            </tr>
            </thead>
            <tbody>';

            foreach ($audiencesWithoutFollowUp as $i => $audience) {
                $niveauLabel = $audience->niveauProcedural == "1ère instance" ?
                    '<small style="background:#28a745;color:#fff;padding:2px 6px;border-radius:3px;">'.$audience->niveauProcedural.'</small>' :
                    ($audience->niveauProcedural == "Appel" ?
                    '<small style="background:#ffc107;color:#212529;padding:2px 6px;border-radius:3px;">'.$audience->niveauProcedural.'</small>' :
                    '<small style="background:#dc3545;color:#fff;padding:2px 6px;border-radius:3px;">'.$audience->niveauProcedural.'</small>');

                $emailBody .= '<tr>
                    <td>'.($i+1).'</td>
                    <td>'.$audience->numRg.'</td>
                    <td>'.$audience->objet.'</td>
                    <td>'.$niveauLabel.'</td>
                    <td>'.date('d/m/Y', strtotime($audience->prochaineAudience)).'</td>
                </tr>';
            }
            $emailBody .= '</tbody></table>';

            $emailBody .= '<div style="text-align:right;margin-top:20px;">
                <em>Envoyé depuis <a href="https://smartylex.com" target="_blank" style="color:#007bff;text-decoration:none;">smartylex.com</a></em>
            </div>';
    }
        $users = DB::table('users')->pluck('email')->toArray();
        foreach ($users as $toEmail) {
            Mail::send([], [], function ($message) use ($toEmail, $emailBody) {
            $message->to($toEmail)
                ->subject("Rappel: Audiences sans suivi du " . now()->format('d/m/Y'))
                ->html($emailBody);
            });
        } 


        
        return response()->json(['message' => 'Rappel des audiences sans suivi envoyé avec succès.']);
    }

    public function NotifSuivi(Request $request)
    {
        $aujourdhui = date('Y-m-d');

        // Récupérer les suivis du jour
        $suivis = DB::select("
            SELECT * FROM suivit_audiences
            WHERE DATE(dateProchaineAudience) = ?
        ", [$aujourdhui]);
       
    

        // Récupérer la liste du personnel
        $personnels = DB::select("SELECT * FROM users");

        if (empty($suivis)) {
            // Créer une notification pour chaque utilisateur si aucun suivi n’a été fait
            foreach ($personnels as $p) {
                DB::insert("
                    INSERT INTO notifications (categorie, messages, etat, idRecepteur, slug, a_biper, urlName, urlParam)
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?)
                ", [
                    'Audience',
                    'Aucun suivi n’a été fait aujourd’hui.',
                    'masquer',
                    $p->idPersonnel ?? $p->id, // sécurité si la colonne est 'id'
                    $request->_token . rand(1234, 3458),
                    'non',
                    'detailAudience',
                    null
                ]);
            }

            return response()->json([
                'status' => 'info',
                'message' => 'Aucun suivi n’a été fait aujourd’hui.',
                'data' => []
            ]);
        }

        // Si des suivis existent, on les renvoie
        return response()->json([
            'status' => 'success',
            'message' => 'Suivis du jour récupérés avec succès.',
            'data' => $suivis
        ]);
    }



    // public function sendFacture(Request $request)
    // {
    //     $today = date('Y-m-d'); 
    //     $factureEcheance = DB::table('factures')->get();
    //     $facturesEnvoyees = []; 
    //     $facturesIgnorees = []; // Pour voir ce qui a été ignoré

    //     Log::info("Début du traitement des rappels de factures pour la date: " . $today);

    //     foreach ($factureEcheance as $c) {

    //         $dateRappel = date('Y-m-d', strtotime($c->dateEcheance . ' + 0 days'));

    //         // 1. Vérifier si la facture est concernée aujourd'hui
    //         if ($today == $dateRappel && $c->rappel == 'non' && $c->notification == 'envoyer') {

    //             $slug =  $c->slug;
    //             $cabinet = DB::select("select * from cabinets");
    //             $serveurEmail = DB::select("select * from serveur_mails");
                
    //             // 2. Récupérer les détails de la facture et du client
    //             $clientFacture = DB::select("
    //                 SELECT clients.*, factures.idFacture, factures.dateFacture, factures.emailFacture, factures.slug
    //                 FROM factures
    //                 JOIN clients ON clients.idClient = factures.idClient
    //                 WHERE factures.rappel = 'non' AND factures.slug = ?
    //             ", [$slug]);

    //             if (!empty($clientFacture) && !empty($clientFacture[0]->emailFacture)) {

    //                 $factureDetails = $clientFacture[0];

    //                 require base_path("vendor/autoload.php");
    //                 $mail = new PHPMailer(true);

    //                 try {
    //                     // ... (La configuration SMTP est inchangée)
    //                     $mail->SMTPDebug = 0;
    //                     $mail->isSMTP();
    //                     $mail->Host =  $serveurEmail[0]->host;
    //                     $mail->SMTPAuth = true;
    //                     $mail->Username = $cabinet[0]->emailFinance;
    //                     $mail->Password = $cabinet[0]->cleFinance;
    //                     $mail->SMTPSecure = $serveurEmail[0]->smtpSecure;
    //                     $mail->Port = $serveurEmail[0]->smtpPort;
    //                     $mail->SMTPOptions = [
    //                         'ssl' => [
    //                             'verify_peer' => false,
    //                             'verify_peer_name' => false,
    //                             'allow_self_signed' => true
    //                         ]
    //                     ];

    //                     $mail->setFrom($cabinet[0]->emailFinance, $cabinet[0]->nomCabinet);
    //                     $mail->addAddress($factureDetails->emailFacture);
    //                     $mail->addAddress($cabinet[0]->emailFinance); 

    //                     $body = "
    //                         <div class='container'>
    //                             <p>Madame/Monsieur</p><br>
    //                             <p>Sauf erreur ou omission de notre part, la facture N° ".$factureDetails->idFacture."-".date('m/Y', strtotime($factureDetails->dateFacture)).", arrive à échéance aujourd'hui.</p>
    //                             <p>Nous vous prions d'y procéder selon les modes de règlement y indiqués.</p>
    //                             <p>Nous vous remercions pour votre confiance.</p>
    //                             <br><br><br>
    //                             ".$cabinet[0]->signature."
    //                         </div>
    //                     ";
    //                     $mail->isHTML(true);
    //                     $mail->Subject ='ÉCHÉANCE FACTURE N° ' .$factureDetails->idFacture.'-'.date('m/Y', strtotime($factureDetails->dateFacture));
    //                     $mail->CharSet = "UTF-8";
    //                     $mail->Encoding = 'base64';
    //                     $mail->Body = $body;

    //                     if ($mail->send()) {
    //                         DB::update("update factures set rappel='oui' where slug=?", [$slug]);
    //                         Log::info("Facture " . $factureDetails->idFacture . " envoyée et mise à jour.");
                            
    //                         $facturesEnvoyees[] = [
    //                             'idFacture' => $factureDetails->idFacture,
    //                             'slug' => $slug,
    //                             'client_email' => $factureDetails->emailFacture,
    //                             'status' => 'Email sent and DB updated'
    //                         ];
    //                     }

    //                 } catch (Exception $e) {
    //                     // ⚠️ Log l'erreur SMTP
    //                     Log::error("Erreur d'envoi SMTP pour la facture " . $factureDetails->idFacture . ": " . $e->getMessage());
    //                     $facturesEnvoyees[] = [
    //                         'idFacture' => $factureDetails->idFacture,
    //                         'slug' => $slug,
    //                         'client_email' => $factureDetails->emailFacture,
    //                         'status' => 'Email failed: ' . $e->getMessage()
    //                     ];
    //                 }
    //             } else {
    //                 // Facture non trouvée ou email manquant
    //                 $facturesIgnorees[] = ['slug' => $c->slug, 'raison' => 'Facture non trouvée ou email client manquant après vérification.'];
    //             }
    //         } else {
    //             // Facture ignorée car les conditions de rappel ne sont pas remplies
    //             $facturesIgnorees[] = ['slug' => $c->slug, 'raison' => 'Conditions de date/rappel/notification non remplies.'];
    //         }
    //     }

    //     Log::info("Fin du traitement. " . count($facturesEnvoyees) . " e-mails envoyés.");

    //     // Renvoyer les données au format JSON
    //     return response()->json([
    //         'message' => 'Traitement des rappels de factures terminé.',
    //         'factures_traitees' => $facturesEnvoyees,
    //         'factures_ignorees_total' => count($facturesIgnorees),
    //         'count' => count($facturesEnvoyees)
    //     ]);
    // }
}