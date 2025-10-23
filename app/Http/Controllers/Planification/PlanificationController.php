<?php

namespace App\Http\Controllers\Planification;

use App\Http\Controllers\Controller;
use App\Models\Audiences;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

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
        

            $toEmail = "daboabou845@gmail.com";
            Mail::send([], [], function ($message) use ($toEmail, $emailBody) {
            $message->to($toEmail)
            ->subject("Récapitulatif des audiences prévues pour demain")
            ->html($emailBody);
            });
        return response()->json(['message' => 'Récapitulatif des audiences envoyé avec succès.']);
    }
}


