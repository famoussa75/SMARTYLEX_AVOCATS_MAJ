<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class contratSigners extends Model
{
    use HasFactory;
    protected $primaryKey = 'idContratSigner';
    protected $fillable = [
        'idContratSigner',
        'idPersonnelCabinet',
        'idPersonnelClient',
        'dateSignature',
        'accordConf',
        'dateAccord',
        'slug',
       
    ];
}
