<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PvInterrogatoires extends Model
{
    use HasFactory;
    protected $primaryKey = 'idPv';
    protected $fillable = [
        'idPv',
        'idActe',
        'dateAudition',
        'identiteOPJ',
        'infractions',
        'dateAudience',
        'slug',
    ];
}
