<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Affaires extends Model
{
    use HasFactory;
    protected $primaryKey = 'idAffaire';
    protected $fillable = [
        'idAffaire',
        'idClient',
        'nomAffaire',
        'type',
        'dateOuverture',
        'etat',
        'slug',
        
    ];
}
