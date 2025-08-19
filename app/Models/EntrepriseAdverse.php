<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EntrepriseAdverse extends Model
{
    use HasFactory;
    protected $primaryKey = 'idEntreprise';
    protected $fillable = [
        'idEntreprise',
        'idPartie',
        'denomination',
        'numRccm',
        'siegeSocial',
        'formeLegal',
        'representantLegal',
        'slug',
    ];
}
