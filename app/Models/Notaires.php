<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notaires extends Model
{
    use HasFactory;
    protected $primaryKey = 'idNtr';
    protected $fillable = [
        'idNtr',
        'prenomNtr',
        'nomNtr',
        'telNtr_1',
        'telNtr_2',
        'emailNtr',
        'adresseNtr',
        'slug',
    ];
}
