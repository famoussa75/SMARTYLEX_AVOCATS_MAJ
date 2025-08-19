<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SuivitAudience extends Model
{
    protected $primaryKey = 'idSuivit';
    protected $fillable = [
        'idSuivit',
        'idAudience',
        'dateAudience',
        'dateProchaineAudience',
        'heure',
        'TypeDecision',
        'decision',
        'extrait',
        'heureDebut',
        'heureFin',
        'president',
        'greffier',
        'rappelLettre',
        'rappelSignification',
        'email',
        'suiviPar',
        'slug',
        'rappelProchaineAudience',
    ];
    use HasFactory;
}
