<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Factures extends Model
{
    protected $primaryKey = 'idFacture';
    protected $fillable = [
        'idFacture',
        'typeFacture',
        'idClient',
        'idAffaire',
        'dateFacture',
        'dateEcheance',
        'montantHT',
        'montantTVA',
        'montantTTC',
        'statut',
        'monnaie',
        'notification',
        'rappel',
        'motif_remboursement',
        'motif_rejetProforma',
        'slug',
    ];
    use HasFactory;
}
