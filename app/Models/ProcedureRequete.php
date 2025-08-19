<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProcedureRequete extends Model
{
    use HasFactory;
    protected $primaryKey = 'idProcedure';
    protected $fillable = [
        'idProcedure',
        'idAudience',
        'typeRequete',
        'juridictionPresidentielle',
        'identiteRequerent',
        'idAvocatRequete',
        'dateRequete',
        'demandeRequete',
        'juridiction',
        'objet',
        'requeteLier',
        'statut',
        'numRgRequete',
        'natureObligation',
        'designationBien',
        'montantReclamer',
        'createur',
        'slug',
    ];
}
