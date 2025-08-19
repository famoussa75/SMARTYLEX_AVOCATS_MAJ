<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class clients extends Model
{
    use HasFactory;
    protected $primaryKey = 'idClient';
    protected $fillable = [
        'idClient',
        'typeClient',
        'prenom',
        'nom',
        'adresse',
        'email',
        'telephone',
        'idRepresentant',
        'adresseEntreprise',
        'emailEntreprise',
        'telephoneEntreprise',
        'emailFacture',
        'denomination',
        'capitalSocial',
        'rccm',
        'nif',
        'cnss',
        'logo',
        'slug',
    ];

}
