<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourierDepart extends Model
{
    protected $primaryKey = 'idCourierDep';
    protected $fillable = [

        'idCourierDep',
        'destinataire',
        'objet',
        'dateCourier',
        'idPersonnel',
        'expediteur',
        'idClient',
        'numCourier',
        'idAffaire',
        'dateEnvoi',
        'dateReception',
        'numeroRecu',
        'statut',
        'niveau',
        'consignes',
        'accuse_reception',
        'nomPersonne',
        'telephonePersonne',
        'partieAdverse',
        'motif',
        'jugement',
        'courAppel',
        'dateProcesVerbal',
        'typeModel',
        'signataire',
        'confidentialite',
        'slug',
    ];
    use HasFactory;
}