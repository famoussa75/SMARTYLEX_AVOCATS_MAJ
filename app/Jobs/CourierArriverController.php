<?php

// app/Jobs/CourierArriverController.php

namespace App\Jobs;

use Illuminate\Support\Facades\DB;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Models\CourierArriver;

use PHPMailer\PHPMailer\PHPMailer;

class CourierArriverController implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $slug;

    public function __construct($slug)
    {
        $this->slug = $slug;
    }

    public function handle()
    {
        try {
            // Récupération du courrier
            $courier = CourierArriver::where('slug', $this->slug)->first();
    
            if (!$courier) {
                \Log::warning("Aucun courrier trouvé avec le slug : {$this->slug}");
                return;
            }
    
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
                ->where('courier_arrivers.slug', $this->slug)
                ->first();
    
            if (!$courierClient) {
                \Log::warning("Aucune donnée client/courrier trouvée avec slug : {$this->slug}");
                return;
            }
    
            // Récupération des fichiers liés
            $courierFiles = DB::select("SELECT * FROM fichiers WHERE slugSource = ?", [$this->slug]);
    
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
                \Log::warning("Aucune adresse email trouvée pour le client avec slug : {$this->slug}");
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

    
            \Log::info("Notification envoyée avec succès à $email pour le courrier : $objet.");
        } catch (Exception $e) {
            \Log::error("Exception lors de l'envoi du mail : " . $e->getMessage());
        }
    }
    
}
