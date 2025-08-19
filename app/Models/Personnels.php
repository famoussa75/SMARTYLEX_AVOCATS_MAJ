<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Le model de la classe Personnels dans la base de donnees
 */
class Personnels extends Model
{
    use HasFactory;
    protected $primaryKey = 'idPersonnel';
    protected $fillable = [
        'idPersonnel',
        'matricules',
        'prenom',
        'nom',
        'sexe',
        'fonction',
        'adresse',
        'dateNaissance',
        'telephone',
        'salaire',
        'numeroUrgence',
        'email',
        'photo',
        'score',
        'initialPersonnel',
        'ssn',
        'nomPersonneUrgence',
        'telPersonneUrgence',
        'slug'
    ];
}
