<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RapportTaches extends Model
{
    use HasFactory;
    protected $primaryKey = 'idRapport';
    protected $fillable = [
        'idRapport',
        'idUser',
        'valider',
        'encour',
        'horsDelais',
        'suspendu',
        'dateRapport',
        'slug',
    ];
}
