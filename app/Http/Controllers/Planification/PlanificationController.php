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
        $date = now()->addDay()->format('d/m/Y');
        $audiences = DB::select("
            SELECT idAudience, subquery.numRg, subquery.objet, subquery.niveauProcedural, CONCAT(subquery.nom, ' - ', subquery.adresse) AS juridiction_info, subquery.slugAud, subquery.statutAud, isChild, prochaineAudience,
            GROUP_CONCAT(
            CASE
            WHEN denomination IS NOT NULL THEN denomination
            WHEN prenom IS NOT NULL AND nom IS NOT NULL THEN CONCAT(prenom, ' ', nom)
            ELSE ''
            END
            SEPARATOR ', '
            ) AS parties
            FROM (
            SELECT MAX(idAudience) as idAudience, MAX(numRg) as numRg, MAX(objet) as objet, MAX(niveauProcedural) as niveauProcedural,
            MAX(juriductions.nom) as nom, MAX(juriductions.adresse) as adresse, slugAud, statutAud, MAX(isChild) as isChild, MAX(prochaineAudience) as prochaineAudience,
            MAX(prenom) as prenom, MAX(subquery_internal.nom) as nom, MAX(denomination) as denomination
            FROM (
            SELECT  audiences.idAudience, audiences.slug AS slugAud, numRg, objet, niveauProcedural, prenom, clients.nom, denomination, NULL as numRccm, NULL as formeLegal, audiences.statut as statutAud, audiences.isChild, audiences.prochaineAudience,
            audiences.juridiction,
            juriductions.nom as juridiction_nom, juriductions.adresse
            FROM audiences
            JOIN parties ON audiences.idAudience = parties.idAudience
            LEFT JOIN clients ON parties.idClient = clients.idClient
            LEFT JOIN juriductions ON juriductions.id = audiences.juridiction

            UNION

            SELECT audiences.idAudience, audiences.slug AS slugAud, numRg, objet, niveauProcedural, prenom, personne_adverses.nom, NULL as denomination, NULL as numRccm, NULL as formeLegal, audiences.statut as statutAud, audiences.isChild, audiences.prochaineAudience,
            audiences.juridiction,
            juriductions.nom as juridiction_nom, juriductions.adresse
            FROM audiences
            JOIN parties ON audiences.idAudience = parties.idAudience
            JOIN personne_adverses ON parties.idPartie = personne_adverses.idPartie
            LEFT JOIN juriductions ON juriductions.id = audiences.juridiction

            UNION

            SELECT audiences.idAudience, audiences.slug AS slugAud, numRg, objet, niveauProcedural, NULL as prenom, NULL as nom, denomination, numRccm, formeLegal, audiences.statut as statutAud, audiences.isChild, audiences.prochaineAudience,
            audiences.juridiction,
            juriductions.nom as juridiction_nom, juriductions.adresse
            FROM audiences
            JOIN parties ON audiences.idAudience = parties.idAudience
            JOIN entreprise_adverses ON parties.idPartie = entreprise_adverses.idPartie
            LEFT JOIN juriductions ON juriductions.id = audiences.juridiction
            ) AS subquery_internal
            GROUP BY subquery_internal.slugAud, subquery_internal.statutAud
            ) AS subquery
            WHERE (isChild IS NULL OR isChild != 'oui')
            AND DATE(prochaineAudience) = ?
            GROUP BY subquery.idAudience, subquery.numRg, subquery.objet, subquery.niveauProcedural, subquery.nom, subquery.adresse, subquery.slugAud, subquery.statutAud, subquery.isChild, subquery.prochaineAudience
            ORDER BY idAudience ASC
        ", [$tomorrow]);

        $emailBody = "<h3>Récapitulatif des audiences prévues pour le " . $date . "</h3>";
        if (empty($audiences)) {
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

            $toEmail = "daboabou845@gmail.com";
            Mail::send([], [], function ($message) use ($toEmail, $emailBody) {
            $message->to($toEmail)
            ->subject("Récapitulatif des audiences prévues pour demain")
            ->html($emailBody);
            });
        }
        return response()->json(['message' => 'Récapitulatif des audiences envoyé avec succès.']);
    }
}





        // Logique pour envoyer l'email de récapitulatif des audiences
        // Cela pourrait inclure la récupération des audiences prévues pour le lendemain
        // et l'envoi d'un email aux utilisateurs concernés.

        // Exemple de code (pseudo-code) :
        // $audiences = Audience::whereDate('prochaineAudience', '=', now()->addDay()->toDateString())->get();
        // Mail::to($user->email)->send(new RecapEmail($audiences));