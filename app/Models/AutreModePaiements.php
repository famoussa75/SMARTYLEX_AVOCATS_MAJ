<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AutreModePaiements extends Model
{
    protected $primaryKey = 'idAutreMode';
    protected $fillable = [
        'idAutreMode',
        'idFacture',
        'descMode',
        'slug',
    ];
    use HasFactory;
}
