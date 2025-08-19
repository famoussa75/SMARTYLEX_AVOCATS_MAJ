<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SuivitAudienceAppel extends Model
{
    use HasFactory;

    protected $primaryKey = 'idSuivitAppel';
    protected $fillable = [
        'idSuivitAppel',
        'idAudience',
        'acte',
        'dateActe',
        'dateReception',
        'dateLimite',
        'heure',
        'suiviPar',
        'slug',
    ];
}
