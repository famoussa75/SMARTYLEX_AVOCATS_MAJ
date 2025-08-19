<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Assignations extends Model
{
    use HasFactory;
    protected $primaryKey = 'idAssignation';
    protected $fillable = [
        'idAssignation',
        'idActe',
        'numRg',
        'idHuissier',
        'recepteurAss',
        'datePremiereComp',
        'dateAssignation',
        'dateEnrollement',
        'mentionParticuliere',
        'slug',
        
    ];
}
