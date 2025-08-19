<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Paiements extends Model
{
    protected $primaryKey = 'idPaiement';
    protected $fillable = [
        'idPaiement',
        'idFacture',
        'methode',
        'numCompte',
        'montantPayer',
        'reste',
        'slug',
    ];
    use HasFactory;
}
