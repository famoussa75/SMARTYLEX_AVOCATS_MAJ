<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CitationDirectes extends Model
{
    use HasFactory;
    protected $primaryKey = 'idCitation';
    protected $fillable = [
        'idCitation',
        'idActe',
        'saisi',
        'dateHeureAud',
        'idHuissier',
        'recepteurCitation',
        'dateSignification',
        'mentionParticuliere',
        'chefAccusation',
        'slug',
    ];
}
