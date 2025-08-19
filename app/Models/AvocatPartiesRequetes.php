<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AvocatPartiesRequetes extends Model
{
    use HasFactory;
    protected $primaryKey = 'idAvocatPartie';
    protected $fillable = [
        'idAvocatPartie',
        'idPartie',
        'idAvocat',
        'slug',
        
    ];
}
