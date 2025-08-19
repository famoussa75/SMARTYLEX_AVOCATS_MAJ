<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PartiesRequetes extends Model
{
    use HasFactory;
    protected $primaryKey = 'idPartie';
      protected $fillable = [
        'idPartie',
        'idRequete',
        'role',
        'autreRole',
        'idClient',
        'idAffaire',
        'typeAvocat',
        'slug',
    ];
}
