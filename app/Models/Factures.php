<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Factures extends Model
{
    protected $primaryKey = 'idFacture';
    protected $fillable = [
        'idFacture',
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
        'slug',
    ];
    use HasFactory;
}
