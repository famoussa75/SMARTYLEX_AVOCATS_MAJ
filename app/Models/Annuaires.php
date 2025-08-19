<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Annuaires extends Model
{
    use HasFactory;
    protected $primaryKey = 'id';
    protected $fillable = [
        'id',
        'societe',
        'prenom_et_nom',
        'poste_de_responsabilite',
        'telephone',
        'email',        
        'idClient',        
    ];
}
