<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Audiences extends Model
{
    use HasFactory;
    protected $primaryKey = 'idAudience';
    protected $fillable = [
        'idAudience',
        'juridiction',
        'idAffaire',
        'idClient',
        'dateCreation',
        'niveauProcedural',
        'objet',
        'nature',
        'pieceInstruction',
        'numRg',
        'statut',
        'createur',
        'isChild',
        'slugJonction',
        'prochaineAudience',
        'heure',
        'typeProcedure',
        'orientation',
        'requeteLier',
        'slug',
    ];
}
