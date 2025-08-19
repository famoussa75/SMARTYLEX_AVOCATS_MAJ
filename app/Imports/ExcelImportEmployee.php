<?php

namespace App\Imports;

use App\Models\PersonnelClients;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ExcelImportEmployee implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        
        return new PersonnelClients([

            'idClient' => $_REQUEST['idClient'],
            'matricule'=> $row['matricule'],
            'prenomEtNom'   => $row['prenom_et_nom'],
            'statutContrat'   => $row['statut_actuel_du_contrat'],
            'filiation'   => $row['filiation'],
            'sexe'   => $row['sexe'],
            'prefix'   => $row['prefix'],
            'statutMatrimonial'   => $row['statut_matrimonial'],
            'dateNaissance'   =>  $row['date_de_naissance'],
            'lieuNaissance'   => $row['lieu_de_naissance'],
            'paysNaissance'   => $row['pays_de_naissance'],
            'residence'   => $row['residence'],
            'telephone'   => $row['telephone'],
            'numPiece'   => $row['numero_piece_identification'],
            'naturePiece'   => $row['nature_de_la_piece_identification'],
            'dateExPiece'   => $row['date_validite'],
            'nationalite'   => $row['nationalite'],
            'profession'   => $row['profession'],
            'fonction'   => $row['fonction'],
            'departement'   => $row['departement'],
            'grade'   => $row['grade'],
            'dateEmbauche'   => $row['date_embauche'],
            'typeContrat'   => $row['type_contrat'],
            'dureeContrat'   => $row['duree_du_contrat'],
            'dureePeriodeEssai'   => $row['duree_de_la_periode_essai'],
            'lieuExecutionContrat'   => $row['lieu_execution_du_contrat'],
            'prorogationRenouvelement'   => $row['prorogation_renouvelement'],
            'dateFinContrat'   => $row['date_de_fin_du_contrat'],
            'motifFinContrat'   => $row['motif_de_fin_de_contrat'],
            'numSecuriteSociale'   => $row['numero_securite_sociale'],
            'datePremiereImmatriculation'   => $row['date_de_premiere_immatriculation_sec_soc'],
            'salaireBrut'   => $row['salaire_brut'],
            'salaireBase'   => $row['salaire_de_base'],
            'primePanier'   => $row['prime_de_panier'],
            'primeLogement'   => $row['prime_de_logement'],
            'primeTransport'   => $row['prime_de_transport'],
            'primeCherteVie'   => $row['prime_de_cherte_de_vie'],
            'primeSalissure'   => $row['prime_de_salissure'],
            'primeRisque'   => $row['prime_de_risque'],
            'primeEloignement'   => $row['prime_eloignement'],
            'primeResponsabilite'   => $row['prime_de_resposabilite'],
            'primeAnciennete'   => $row['prime_anciennete'],
            'dateSignatureContrat'   => $row['date_de_signature_du_contrat'],
            'lieuSignature'   => $row['lieu_de_signature'],
            'slug'   => rand(1000, 100432),
        ]);
    }
}
