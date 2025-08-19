<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pourvois extends Model
{
    use HasFactory;
    protected $primaryKey = 'idPourvoi';
    protected $fillable = [
        'idPourvoi',
        'idActe',
        'numPourvoi',
        'numDecision',
        'datePourvoi',
        'dateDecision',
        'slug',
    ];
}
