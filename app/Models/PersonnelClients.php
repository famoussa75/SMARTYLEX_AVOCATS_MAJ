<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PersonnelClients extends Model
{
    use HasFactory;
    protected $primaryKey = 'idClient';
    protected $fillable = [
        'idClient',
        'matricule',
        'prenomEtNom',
        'statutContrat',
        'filiation',
        'sexe',
        'prefix',
        'statutMatrimonial',
        'dateNaissance',
        'lieuNaissance',
        'paysNaissance',
        'residence',
        'telephone',
        'numPiece',
        'naturePiece',
        'dateExPiece',
        'nationalite',
        'profession',
        'fonction',
        'departement',
        'grade',
        'dateEmbauche',
        'typeContrat',
        'dureeContrat',
        'dureePeriodeEssai',
        'lieuExecutionContrat',
        'prorogationRenouvelement',
        'dateFinContrat',
        'motifFinContrat',
        'numSecuriteSociale',
        'datePremiereImmatriculation',
        'salaireBrut',
        'salaireBase',
        'primePanier',
        'primeLogement',
        'primeTransport',
        'primeCherteVie',
        'primeSalissure',
        'primeRisque',
        'primeEloignement',
        'primeResponsabilite',
        'primeAnciennete',
        'dateSignatureContrat',
        'lieuSignature',
        'slug',
    ];
}
