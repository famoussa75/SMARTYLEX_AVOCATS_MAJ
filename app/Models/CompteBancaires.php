<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompteBancaires extends Model
{
    use HasFactory;
    protected $primaryKey = 'idCompteBank';
    protected $fillable = [
        'idCompteBank',
        'idCabinet',
        'nomBank',
        'devise',
        'codeBank',
        'codeGuichet',
        'numCompte',
        'cleRib',
        'iban',
        'codeBic',
       
    ];
}
