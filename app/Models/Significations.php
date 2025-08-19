<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Significations extends Model
{
    use HasFactory;
    protected $primaryKey = 'idSignification';
    protected $fillable = [
        'idSignification',
        'numJugement',
        'dateSignification',
        'idHss',
        'recepteur',
        'reserve',
        'slugAudience',
        'slug',
    ];
}
