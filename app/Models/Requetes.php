<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Requetes extends Model
{
    use HasFactory;
    protected $primaryKey = 'idRequete';
    protected $fillable = [
        'idRequete',
        'idActe',
        'numRg',
        'dateRequete',
        'dateArriver',
        'juriductionPresidentielle',
        'slug',
    ];
}
