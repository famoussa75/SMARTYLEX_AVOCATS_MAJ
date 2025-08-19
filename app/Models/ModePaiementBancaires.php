<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ModePaiementBancaires extends Model
{
    protected $primaryKey = 'idModePaiementBank';
    protected $fillable = [
        'idModePaiementBank',
        'idFacture',
        'idCompteBank',
        'slug',
    ];
    use HasFactory;
}
