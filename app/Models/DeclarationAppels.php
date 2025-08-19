<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeclarationAppels extends Model
{
    use HasFactory;
    protected $primaryKey = 'idDeclaration';
    protected $fillable = [
        'idDeclaration',
        'idActe',
        'numRg',
        'numJugement',
        'dateAppel',
        'slug',
    ];
}
