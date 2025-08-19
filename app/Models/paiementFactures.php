<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class paiementFactures extends Model
{
    use HasFactory;
    protected $primaryKey = 'idPaiementFacture';
    protected $fillable = [
        'idPaiementFacture',
        'idFacture',
        'datePaiement',
        'montantPayer',
        'montantRestant',
        'methodePaiement',
        'banqueCheque',
        'numeroCheque',
        'dateVirement',
        'statut',
        'slug',
        
    ];
}
