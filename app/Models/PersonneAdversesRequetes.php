<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PersonneAdversesRequetes extends Model
{
    use HasFactory;
    protected $primaryKey = 'idPersonneAdverse';
    protected $fillable = [
        'idPersonneAdverse',
        'idPartie',
        'prenom',
        'nom',
        'telephone',
        'nationalite',
        'profession',
        'dateNaissance',
        'lieuNaissance',
        'pays',
        'domicile',
        'slug',
    ];
}
