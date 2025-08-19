<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class contratTerminer extends Model
{
    use HasFactory;
    protected $primaryKey = 'idContratTerminer';
    protected $fillable = [
        'idContratTerminer',
        'idPersonnelCabinet',
        'idPersonnelClient',
        'dateTerminer',
        'motif',
        'slug',
       
    ];
}
