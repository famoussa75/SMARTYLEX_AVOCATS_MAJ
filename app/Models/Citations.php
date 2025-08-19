<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Citations extends Model
{
    use HasFactory;
    protected $primaryKey = 'idCitation';
    protected $fillable = [
        'idCitation',
        'idActe',
        'dateSignification',
        'personneCharger',
        'numRg',
        'idHuissier',
        'dateCitation',
        'dateAudience',
        'lieuAudience',
        'slug',
    ];
}
