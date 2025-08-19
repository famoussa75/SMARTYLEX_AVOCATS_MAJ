<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrdonnanceRenvois extends Model
{
    use HasFactory;
    protected $primaryKey = 'idOrd';
    protected $fillable = [
        'idOrd',
        'idActe',
        'numOrd',
        'cabinetIns',
        'typeProcedure',
        'chefAccusation',
        'slug',
        
    ];
}
