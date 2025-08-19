<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TierceOppostions extends Model
{
    use HasFactory;
    protected $primaryKey = 'idTierceOpp';
    protected $fillable = [
        'idTierceOpp',
        'idActe',
        'dateActe',
        'dateProchaineAud',
        'numDecision',
        'slug',
    ];
}
