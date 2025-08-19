<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Oppositions extends Model
{
    use HasFactory;
    protected $primaryKey = 'idOpposition';
    protected $fillable = [
        'idOpposition',
        'idActe',
        'dateActe',
        'dateProchaineAud',
        'numDecision',
        'numRg',
        'idHuissier',
        'recepteurAss',
        'datePremiereComp',
        'dateEnrollement',
        'mentionParticuliere',
        'slug',
    ];
}
