<?php

namespace App\Http\Controllers;

use App\Models\clients;
use App\Models\Affaire;
use App\Models\Personnels;
use App\Models\Taches;
use App\Models\RapportTaches;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail; 
use App\Jobs\CourierArriverController;

use DateTime;


use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;


class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {


        $courierTrasmis = DB::select('select clients.idClient,clients.*, courier_arrivers.*,courier_arrivers.slug as slugCourrier from clients, courier_arrivers where clients.idClient = courier_arrivers.idClient and  courier_arrivers.statutCourierTrasmise !="oui" and courier_arrivers.statutCourierTrasmise !="Trasmis" ');
       

        if( $courierTrasmis){

            foreach($courierTrasmis as $courierTrasmis){
                $slug = $courierTrasmis->slugCourrier;

                try {

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
                        ->where('courier_arrivers.slug',  $slug)
                        ->first();

                       // dd($courierClient);
            
                    if (!$courierClient) {
                        \Log::warning("Aucune donnée client/courrier trouvée avec slug : {$slug}");
                        return;
                    }
            
                    // Récupération des fichiers liés
                    $courierFiles = DB::select("SELECT * FROM fichiers WHERE slugSource = ?", [$slug]);
            
                    // Configurations
                    $cabinet = DB::table('cabinets')->first();
                    $serveurEmail = DB::table('serveur_mails')->first();
            
                    if (!$cabinet || !$serveurEmail) {
                        \Log::error("Configuration manquante pour le cabinet ou le serveur mail.");
                        return;
                    }
            
                    // Infos client
                    $email  = $courierClient->emailClient;
                    $objet  = $courierClient->objetCourier;
                    $prenom = $courierClient->clientPrenom;
                    $nom    = $courierClient->nomClient;
            
                    if (!$email) {
                        \Log::warning("Aucune adresse email trouvée pour le client avec slug : {$slug}");
                        return;
                    }
            
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
            
                    // Attachments + Images
                    $inlineImagesHtml = '';
                    foreach ($courierFiles as $index => $file) {
                        $fullPath = public_path($file->path);
                        $filename = $file->filename ?? basename($file->path);
            
                        if (file_exists($fullPath)) {
                            $mail->addAttachment($fullPath, $filename);
            
                            $ext = strtolower(pathinfo($fullPath, PATHINFO_EXTENSION));
                            if (in_array($ext, ['jpg', 'jpeg', 'png', 'gif', 'webp'])) {
                                $cid = "img{$index}";
                                $mail->addEmbeddedImage($fullPath, $cid, $filename);
                                $inlineImagesHtml .= "<p><img src=\"cid:$cid\" style=\"max-width:300px; height:auto;\" /></p>";
                            }
                        } else {
                            \Log::warning("Fichier introuvable pour attachement : $fullPath");
                        }
                    }
            
                    // Corps du mail
                    $body = "
                        <div>
                            <p>Madame / Monsieur <strong>$prenom $nom</strong>,</p>
                            <p>Nous vous informons que le courrier intitulé « <strong>$objet</strong> » a été envoyé avec les documents ci-joints.</p>
                            $inlineImagesHtml
                            <p>Cordialement,<br>{$cabinet->nomCabinet}<br>{$cabinet->signature}</p>
                        </div>
                    ";
            
                    $mail->isHTML(true);
                    $mail->Subject = "Notification d'envoi de courrier : $objet";
                    $mail->CharSet = 'UTF-8';
                    $mail->Encoding = 'base64';
                    $mail->Body = $body;
                    $mail->AltBody = "Bonjour $prenom $nom,\n\nLe courrier intitulé \"$objet\" vous a été envoyé avec ses pièces jointes.\n\nCordialement,\n{$cabinet->nomCabinet}";
            
                    $mail->send();

                    // ✅ Mise à jour du champ rappel
                    DB::update("UPDATE courier_arrivers SET statutCourierTrasmise = 'Trasmis' WHERE slug = ?", [$slug]);
                    
        
            
                    \Log::info("Notification envoyée avec succès à $email pour le courrier : $objet.");
                } catch (Exception $e) {
                    \Log::error("Exception lors de l'envoi du mail : " . $e->getMessage());
                }
            }
        }

        



       
      


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
                        'slug' => $request->_token . "" . rand(1234, 3458),
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
                    'slug' => $request->_token . "" . rand(1234, 3458),
                    'a_biper' => "non",
                    'urlName' => "detailCourierArriver",
                    'urlParam' => $c->slug,
                     'idAdmin' => $value->id,
                    ];
    
                    DB::table('notifications')->insert($data);
                }
            }
        }

        
        
        $procedure_requete = DB::table('procedure_requetes')->get();
        $today = date('d-m-Y');
        
        foreach ($procedure_requete as $c) {
            $dateArriver = date('d-m-Y', strtotime($c->dateArriver . "+ 3 days"));
        
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

        // si aucun suivi n’est renseigné, envoyer une notification demandant de compléter le suivi


        $procedure_requete = DB::table('suivit_audiences')->get();
        $today = date('d-m-Y');
        
        // 1. Récupère tous les slugs déjà notifiés (dans urlParam)
        $slugsNotifies = DB::table('notifications')->pluck('urlParam')->toArray();
        
        foreach ($procedure_requete as $c) {
            $dateProchaineAudience = date('d-m-Y', strtotime($c->dateProchaineAudience));
        
           if( $today== $dateProchaineAudience  && $c->TypeDecision == 'renvoi'){

            if (in_array($c->slug, $slugsNotifies) && (is_null($c->rappelProchaineAudience) || trim($c->rappelProchaineAudience) == '') ) {
    
                $slug = $c->slug;
    
                // 🔸 Notifier les administrateurs
                $users = DB::select("SELECT id FROM users WHERE role = 'Administrateur'");
                foreach ($users as $user) {
                    DB::table('notifications')->insert([
                        'categorie'   => 'Audience',
                        'messages'    => ' Une Audience a été renvoyée. Veuillez faire un suivi',
                        'etat'        => 'masquer',
                        'idRecepteur' => 'admin',
                        'idAdmin'     => $user->id,
                        'slug'        => $slug,
                        'a_biper'     => 'non',
                        'urlName'     => 'detailAudience',
                        'urlParam'    => $slug
                    ]);
                }
    
                // 🔸 Notifier tous les personnels
                $personnels = DB::table('personnels')->get();
                foreach ($personnels as $personnel) {
                    DB::table('notifications')->insert([
                        'categorie'   => 'Audience',
                        'messages'    => 'Une Audience a été renvoyée. Veuillez faire un suivi',
                        'etat'        => 'masquer',
                        'idRecepteur' => $personnel->idPersonnel,
                        'slug'        => $slug,
                        'a_biper'     => 'non',
                        'urlName'     => 'detailRequete',
                        'urlParam'    => $slug
                    ]);
                }


            // ✅ Mise à jour du champ rappel
            DB::update("UPDATE suivit_Audiences SET rappelProchaineAudience = 'oui' WHERE slug = ?", [$slug]);
            }
            else{

            }

           }
        
            // Si ce slug n’a pas encore été notifié
          
        }
        


        $demain = date('Y-m-d', strtotime('+1 days'));
        
       // rappel des deadlines des tâches par email.
       $rappelTaches1 =  DB::SELECT("select tache_personnels.slug as slugPersonne ,tache_personnels.rappel,taches.slugFille,taches.titre,taches.description,taches.dateFin, taches.*, personnels.prenom ,personnels.email from taches,tache_personnels,personnels where taches.idTache = tache_personnels.idTache and tache_personnels.idPersonnel = personnels.idPersonnel and taches.statut !='validée' and dateFin =?",[$demain]);
      
       //dd($rappelTaches1);

        foreach ($rappelTaches1 as $c) {
            $dateFin = date('Y-m-d', strtotime($c->dateFin)); // La date de fin de la tâche
           // dd( $dateFin);

            
            $cabinet = DB::select("select * from cabinets"); 
            $serveurEmail = DB::select("select * from serveur_mails");
            $rappelTaches =  DB::SELECT("select tache_personnels.slug as slugPersonne ,tache_personnels.rappel, taches.slugFille,taches.titre,taches.description,taches.dateFin , personnels.prenom ,personnels.email from taches,tache_personnels,personnels where taches.idTache = tache_personnels.idTache and tache_personnels.idPersonnel = personnels.idPersonnel and taches.statut !='validée' and (tache_personnels.rappel IS NULL OR tache_personnels.rappel != 'envoyé') and  dateFin =?",[$demain]);
            //dd($rappelTaches);
       
            if ($rappelTaches) {


               // dd($rappelTaches);
                
                foreach ($rappelTaches as $rappel) {
                    try {
                        $mail = new PHPMailer(true);
                
                        // Récupération des données
                        $to = $rappel->email;
                        $objet = $rappel->description;
                        $prenom = $rappel->prenom;
                        $titre = $rappel->titre;
                        $dateFin = date('d/m/Y', strtotime($rappel->dateFin));
                
                        // Config SMTP
                        $mail->SMTPDebug = 0;
                        $mail->isSMTP();
                        $mail->Host = $serveurEmail[0]->host;
                        $mail->SMTPAuth = true;
                        $mail->Username = $cabinet[0]->emailFinance;
                        $mail->Password = $cabinet[0]->cleFinance;
                        $mail->SMTPSecure = $serveurEmail[0]->smtpSecure;
                        $mail->Port = $serveurEmail[0]->smtpPort;
                        $mail->SMTPOptions = [
                            'ssl' => [
                                'verify_peer' => false,
                                'verify_peer_name' => false,
                                'allow_self_signed' => true,
                            ]
                        ];
                
                        // Destinataire
                        $mail->setFrom($cabinet[0]->emailFinance, $cabinet[0]->nomCabinet);
                        $mail->addAddress($to, $prenom);
                        $mail->addAddress($cabinet[0]->emailFinance); // copie interne optionnelle
                
                        // Corps du mail
                        $body = "
                            <div style='font-family: Arial, sans-serif;'>
                                <p>Bonjour <strong>$prenom</strong>,</p>
                                <p>Ceci est un rappel pour la tâche suivante :</p>
                                <ul>
                                    <li><strong>Titre :</strong> $titre</li>
                                    <li><strong>Date de fin :</strong> $dateFin</li>
                                </ul>
                                <p>Merci.</p>
                                <br><br>
                                {$cabinet[0]->signature}
                            </div>
                        ";
                
                        $mail->isHTML(true);
                        $mail->CharSet = "UTF-8";
                        $mail->Encoding = 'base64';
                        $mail->Subject = $objet;
                        $mail->Body = $body;
                
                        if ($mail->send()) {
                            // Optionnel : mettre à jour rappel
                            DB::update("UPDATE tache_personnels SET rappel = 'envoyé' WHERE slug = ?", [$rappel->slugPersonne]);
                        } else {
                            Log::error("Échec envoi rappel tâche à $to");
                        }
                
                    } catch (Exception $e) {
                        Log::error("Erreur envoi mail PHPMailer : " . $e->getMessage());
                    }
                }
                
              
       
              // dd(' Trouvé', $rappelTaches);
            }
            else{
               // dd('non trouve', $rappelTaches);
            }
       }
       

      
        
        $factureEcheance = DB::table('factures')->get();

        foreach ($factureEcheance as $c) {

            $dateRappel = date('Y-m-d', strtotime($c->dateEcheance . ' + 30 days'));
            if ($today == $dateRappel && $c->rappel == 'non' && $c->notification == 'envoyer' ) {

                $slug =  $c->slug;
                $cabinet = DB::select("select * from cabinets"); 
                $serveurEmail = DB::select("select * from serveur_mails");
                $clientFacture = DB::select("select * from clients,factures where clients.idClient=factures.idClient and factures.rappel!='oui' and factures.statut='En retard' and factures.slug=?",[$slug]);
        
                if (empty($clientFacture[0]->emailFacture)) {
                   
                }else{  
        
                require base_path("vendor/autoload.php");
                $mail = new PHPMailer(true);     // Passing `true` enables exceptions
        
                try {
        
                    // Email server settings
                    $mail->SMTPDebug = 0;
                    $mail->isSMTP();
                    $mail->Host =  $serveurEmail[0]->host;               //  smtp host
                    $mail->SMTPAuth = true;
                    $mail->Username = $cabinet[0]->emailFinance;   //  sender username
                    $mail->Password = $cabinet[0]->cleFinance;       // sender password
                    $mail->SMTPSecure = $serveurEmail[0]->smtpSecure;                  // encryption - ssl/tls
                    $mail->Port = $serveurEmail[0]->smtpPort;                        // port - 587/465
                    $mail->SMTPOptions = array(
                        'ssl' => array(
                            'verify_peer' => false,
                            'verify_peer_name' => false,
                            'allow_self_signed' => true
                        )
                    );
        
                    $mail->setFrom($cabinet[0]->emailFinance, $cabinet[0]->nomCabinet);
                    $mail->addAddress($clientFacture[0]->emailFacture,$cabinet[0]->emailFinance);
                    $mail->addAddress($cabinet[0]->emailFinance,$cabinet[0]->emailFinance);
                  
        
                    $body = "       
                        <div class='container'>
                            <p>Madame/Monsieur</p><br>
                            <p>Sauf erreur ou ommission de notre part, la facture N° ".$clientFacture[0]->idFacture."-".date('m/Y', strtotime($clientFacture[0]->dateFacture)).", n'a pas fait l'objet de règlement à ce jour.</p>
                            <p>Nous vous prions d'y procéder selon les modes de règlement y indiqués.</p>
                            <p>Nous vous remercions pour votre confiance.</p>
                            <br><br><br>
                        
                            ".$cabinet[0]->signature."
                        </div>
                
                        ";
                        $mail->isHTML(true);                // Set email content format to HTML
                        $mail->Subject ='RELANCE FACTURE N° ' .$clientFacture[0]->idFacture.'-'.date('m/Y', strtotime($clientFacture[0]->dateFacture));
                        $mail->CharSet = "UTF-8";
                        $mail->Encoding = 'base64';
                        $mail->Body = $body;
            
                        // $mail->AltBody = plain text version of email body;
            
                        if (!$mail->send()) {
                            
                        } else {
                            
                            DB::update("update factures set rappel='oui' where slug=?",[$slug]);
                                  
                        }
                    } catch (Exception $e) {
                      
                    }
                }
            }
        }


        foreach ($taches as $t) {

            $statut = $t->statut;
            $idTache = $t->idTache;
            $today = date('Y-m-d');
            $dateCreationTache = $t->dateFin;
            $dateRappelTache = date('Y-m-d', strtotime($dateCreationTache . ' - 2 days'));
            $slug = $t->slug;

            if ($statut == 'En cours' && $today > $dateCreationTache) {

                DB::table('taches')
                    ->where('slug', $slug)
                    ->update([
                        'statut' => 'Hors Délais',
                    ]);

                $personInteresser = DB::select("select * from tache_personnels where idTache=?",[$idTache]);

                foreach ($personInteresser as $p) {

                    $data = [

                        'categorie' => 'Tâche',
                        'messages' => "Une de vos tâches est en 'Hors délais' .",
                        'etat' => "masquer",
                        'a_biper' => "non",
                        'idRecepteur' =>  $p->idPersonnel,
                        'slug' => $request->_token . "" . rand(1234, 3458),
                        'urlName' => "infosTask",
                        'urlParam' => $slug,
                    ];

                    DB::table('notifications')->insert($data);
                }


                foreach ($admins as $key => $value) {
                    $data = [

                    'categorie' => 'Tâche',
                    'messages' => "Une tache n'a pas été executer à temps .",
                    'etat' => "masquer",
                    'a_biper' => "non",
                    'idRecepteur' => 'admin',
                    'slug' => $request->_token . "" . rand(1234, 3458),
                    'urlName' => "infosTask",
                    'urlParam' => $slug,
                    'idAdmin' => $value->id,
                    ];
    
                    DB::table('notifications')->insert($data);
                }
            }

            if ($statut == 'En cours' && $today == $dateRappelTache) {


                $personInteresser = DB::select("select * from tache_personnels,personnels where personnels.idPersonnel=tache_personnels.idPersonnel and tache_personnels.rappel!='oui' and tache_personnels.idTache=?", [$idTache]);

                foreach ($personInteresser as $p) {

                    $data = [

                        'categorie' => 'Tâche',
                        'messages' => "Une de vos tâches expire dans 2jours .",
                        'etat' => "masquer",
                        'a_biper' => "non",
                        'idRecepteur' =>  $p->idPersonnel,
                        'slug' => $request->_token . "" . rand(1234, 3458),
                        'urlName' => "infosTask",
                        'urlParam' => $slug,
                    ];

                    DB::table('notifications')->insert($data);
                    DB::update("update tache_personnels set rappel='oui' where idPersonnel=?", [$p->idPersonnel]);

                }


            }
        }

        DB::delete("delete from notifications where etat='vue'");

        if (Session::has('idPersonnel')) {
            foreach (Session::get('idPersonnel') as $Personnel) {
                $id = $Personnel->idPersonnel;
            }

           
            //Selection en tant que collaborateurs


            $tachePerso = DB::select("
            
            select titre,dateDebut,dateFin,taches.statut,taches.slug,nom,prenom,nomAffaire,taches.idTache,taches.idClient,taches.idAffaire from taches,clients,affaires,tache_personnels where taches.idTache = tache_personnels.idTache and tache_personnels.idPersonnel=$id AND taches.idClient=clients.idClient AND taches.idAffaire=affaires.idAffaire
                UNION
            select titre,dateDebut,dateFin,taches.statut,taches.slug,taches.idTache ,nom is NULL,prenom is NULL ,nomAffaire is NULL,taches.idClient is NULL,taches.idAffaire is NULL  from taches,clients,affaires,tache_personnels where taches.idTache = tache_personnels.idTache and tache_personnels.idPersonnel=$id AND taches.idClient='Cabinet' AND taches.idAffaire='Cabinet'
    
            ");


            $score = DB::select('select score from personnels where personnels.idPersonnel=?', [$id]);
            $clientsPerso = DB::select('select * from clients,affectation_personnels where clients.idClient=affectation_personnels.idClient and affectation_personnels.idPersonnel=?', [$id]);
            $AffairesPerso = DB::select('select * from affaires,affectation_personnels where affaires.idClient=affectation_personnels.idClient and affectation_personnels.idPersonnel=?', [$id]);
            $clients = DB::select('select * from clients');
            $courrierArriver = DB::select('select * from courier_arrivers');
            $courrierDepart = DB::select('select * from courier_departs');

            // Calcul des dates de début et de fin avec heure précise pour la période de vendredi à vendredi
            $dernierVendredi = (new DateTime('last friday'))->format('Y-m-d') . ' 12:00:00';
            $prochainVendredi = (new DateTime('next friday'))->format('Y-m-d') . ' 11:59:59';

            $audiences = DB::select("
                SELECT DISTINCT
                    DATE_FORMAT(dateProchaineAudience, '%W %e %M %Y') AS semaine,
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
                    DATE_FORMAT(dateLimite, '%W %e %M %Y') AS semaine,
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
                    DATE_FORMAT(datePremiereComp, '%W %e %M %Y') AS semaine,
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


            
            $users = DB::select('select * from users,personnels where users.email = personnels.email');
            $cabinet =  DB::select("select parties.idPartie,nom,prenom,email,emailEntreprise,affaires.slug as affaireslug,nomAffaire,affaires.idAffaire,denomination,clients.slug as clientslug,clients.idClient,role,autreRole,idAudience from parties,clients,affaires where parties.idClient=clients.idClient and parties.idAffaire=affaires.idAffaire");
            $personne_adverses = DB::select("select * from personne_adverses,parties where parties.idPartie=personne_adverses.idPartie");
            $entreprise_adverses = DB::select("select * from entreprise_adverses,parties where parties.idPartie=entreprise_adverses.idPartie");
            $autreRoles = DB::select("select * from parties,audiences where audiences.idAudience=parties.idAudience");
            
            return view('start.home', compact('tachePerso', 'score', 'clientsPerso', 'AffairesPerso', 'courrierArriver', 'courrierDepart', 'clients', 'audiences', 'users','cabinet','personne_adverses','entreprise_adverses','autreRoles'));
            
        } else {

            $dateActuelle = date('Y-m-d');
            $cabinet = DB::select("select * from cabinets"); 
            $serveurEmail = DB::select("select * from serveur_mails");

            $Tvalider = count(DB::select("select * from taches where statut='validée'"));
            $ThorsDelais = count(DB::select("select * from taches where statut='Hors Délais'"));
            $Tencours = count(DB::select("select * from taches where statut='En cours'"));
            $Tsuspendus = count(DB::select("select * from taches where statut='suspendu'"));


            
            // envoi de rapport journaliere
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
                        $mail->addAddress(Auth::user()->email);
                      
            
                        $body = "       
                             <h3> Statistique par statut : </h3>
                             <table  border='1' cellpadding='10' cellspacing='0'>
                                 <tr>
                                     <th>Tâches validées</th>
                                     <th>Tâches encours</th>
                                     <th>Tâches hors délais</th>
                                     <th>Tâches suspendus</th>
                                 </tr>
                                 <tr>
                                     <td>".$Tvalider."</td>
                                     <td>".$Tencours."</td>
                                     <td>".$ThorsDelais."</td>
                                     <td>".$Tsuspendus."</td>
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
                             $newRapport->save();
                                      
                            }
     
                        } catch (Exception $e) {}
     
                 }
            }

             // envoi de rapport mensuel
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
                        $mail->addAddress(Auth::user()->email);
                      
            
                        $body = "       
                             <h3> Statistique par statut : </h3>
                             <table  border='1' cellpadding='10' cellspacing='0'>
                                 <tr>
                                     <th>Tâches validées</th>
                                     <th>Tâches encours</th>
                                     <th>Tâches hors délais</th>
                                     <th>Tâches suspendus</th>
                                 </tr>
                                 <tr>
                                     <td>".$Tvalider."</td>
                                     <td>".$Tencours."</td>
                                     <td>".$ThorsDelais."</td>
                                     <td>".$Tsuspendus."</td>
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
                             $newRapport->save();
                                      
                            }
     
                        } catch (Exception $e) {}
     
                 }
            }

             // envoi de rapport trimestriel
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
                        $mail->addAddress(Auth::user()->email);
                      
            
                        $body = "       
                             <h3> Statistique par statut : </h3>
                             <table  border='1' cellpadding='10' cellspacing='0'>
                                 <tr>
                                     <th>Tâches validées</th>
                                     <th>Tâches encours</th>
                                     <th>Tâches hors délais</th>
                                     <th>Tâches suspendus</th>
                                 </tr>
                                 <tr>
                                     <td>".$Tvalider."</td>
                                     <td>".$Tencours."</td>
                                     <td>".$ThorsDelais."</td>
                                     <td>".$Tsuspendus."</td>
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
                             $newRapport->save();
                                      
                            }
     
                        } catch (Exception $e) {}
     
                 }
            }
         
            //selection en tant qu'administrateurs
            $personnels = DB::select('select * from personnels');
    
            $personnelsGraph = DB::select('select * from personnels ORDER BY score Desc limit 5');
            $Tvalider = count(DB::select("select * from taches where statut='validée'"));
            $ThorsDelais = count(DB::select("select * from taches where statut='Hors Délais'"));
            $Tencours = count(DB::select("select * from taches where statut='En cours'"));
            $Tsuspendus = count(DB::select("select * from taches where statut='suspendu'"));
            $affaires = DB::select('select * from affaires');
            $courrierArriver = count(DB::select('select * from courier_arrivers'));
            $courrierDepart = count(DB::select('select * from courier_departs'));
            $Tcourier = $courrierArriver + $courrierDepart;
            $clients = DB::select('select * from clients');
            $users = DB::select('select * from users,personnels where users.email = personnels.email');
            $lastTache = DB::select('select * from taches order by idTache desc limit 1');
            $lastAffaire = DB::select('select * from affaires order by idAffaire desc limit 1');
            $lastAudience = DB::select('select * from audiences order by idAudience desc limit 1');
            $lastClient = DB::select('select * from clients order by idClient desc limit 1');


           // Calcul des dates de début et de fin avec heure précise pour la période de vendredi à vendredi
           $dernierVendredi = (new DateTime('last friday'))->format('Y-m-d') . ' 12:00:00';
           $prochainVendredi = (new DateTime('next friday'))->format('Y-m-d') . ' 11:59:59';

           $audiences = DB::select("
               SELECT DISTINCT
                   DATE_FORMAT(dateProchaineAudience, '%W %e %M %Y') AS semaine,
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
                   DATE_FORMAT(dateLimite, '%W %e %M %Y') AS semaine,
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
                   DATE_FORMAT(datePremiereComp, '%W %e %M %Y') AS semaine,
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

            $cabinet =  DB::select("select parties.idPartie,nom,prenom,email,emailEntreprise,affaires.slug as affaireslug,nomAffaire,affaires.idAffaire,denomination,clients.slug as clientslug,clients.idClient,role,autreRole,idAudience from parties,clients,affaires where parties.idClient=clients.idClient and parties.idAffaire=affaires.idAffaire");
            $personne_adverses = DB::select("select * from personne_adverses,parties where parties.idPartie=personne_adverses.idPartie");
            $entreprise_adverses = DB::select("select * from entreprise_adverses,parties where parties.idPartie=entreprise_adverses.idPartie");
            $autreRoles = DB::select("select * from parties,audiences where audiences.idAudience=parties.idAudience");


            return view('start.home', compact('Tcourier','personnels', 'personnelsGraph', 'affaires', 'clients', 'users', 'Tvalider', 'ThorsDelais', 'Tencours', 'Tsuspendus', 'lastTache', 'lastAffaire', 'lastAudience', 'lastClient', 'audiences','personne_adverses','entreprise_adverses','cabinet','autreRoles'));
        }
    }

    /**
     * Afficher the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
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