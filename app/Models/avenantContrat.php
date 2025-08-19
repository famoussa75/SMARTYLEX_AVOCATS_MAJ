<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class avenantContrat extends Model
{
    use HasFactory;
    protected $primaryKey = 'idAvenant';
    protected $fillable = [
        'idAvenant',
        'idPersonnelCabinet',
        'idPersonnelClient',
        'dateAvenant',
        'nature',
        'slug',
       
    ];
}
