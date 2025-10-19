<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class monnaie extends Model
{
    use HasFactory;
    protected $primaryKey = 'idMonnaie';
    protected $fillable = [
        'idMonnaie',
        'description',
        'symbole',
        'tauxEchangeGn',
        'valeurTaux',
      
    ];
}
