<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contredits extends Model
{
    use HasFactory;
    protected $primaryKey = 'idContredit';
    protected $fillable = [
        'idContredit',
        'idActe',
        'numConcerner',
        'numDecisConcerner',
        'dateContredit',
        'dateDecision',
        'siegeSocial',
        'slug',
    ];
}
