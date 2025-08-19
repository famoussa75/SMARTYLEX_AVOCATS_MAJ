<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Parties extends Model
{
    use HasFactory;
    protected $primaryKey = 'idPartie';
      protected $fillable = [
        'idPartie',
        'idAudience',
        'role',
        'autreRole',
        'idClient',
        'idAffaire',
        'typeAvocat',
        'slug',
    ];
}
