<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SuivitRequete extends Model
{
    protected $primaryKey = 'idSuivit';
    protected $fillable = [
        'idSuivit',
        'idRequete',
        'ordonnance',
        'reference',
        'dateDecision',
        'dateReception',
        'reponse',
        'rappel',
        'suiviPar',
        'slug',
    ];
    use HasFactory;
}
