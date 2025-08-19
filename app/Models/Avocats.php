<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Avocats extends Model
{
    protected $primaryKey = 'idAvc';
    protected $fillable = [
        'idAvc',
        'prenomAvc',
        'nomAvc',
        'telAvc_1',
        'telAvc_2',
        'emailAvc',
        'adresseAvc',
        'annee_entrer',
        'slug',
    ];

    use HasFactory;
}