<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourierArriver extends Model
{
    protected $primaryKey = 'idCourierArr';
    protected $fillable = [
        'idCourierArr',
        'expediteur',
        'dateCourier',
        'dateArriver',
        'numero',
        'objet',
        'idClient',
        'idAffaire',
        'statut',
        'niveau',
        'confidentialite',
        'slug',
        'signifie',
        'statutCourierTrasmise',
    ];
    use HasFactory;
}