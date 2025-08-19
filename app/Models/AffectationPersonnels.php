<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AffectationPersonnels extends Model
{
    use HasFactory;
    protected $primaryKey = 'idAffectation';
    protected $fillable = [
        'idAffectation',
        'idClient',
        'idPersonnel',
        'slug',
    ];
}
