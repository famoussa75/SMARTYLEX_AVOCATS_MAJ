<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fichiers extends Model
{
    use HasFactory;
    protected $primaryKey = 'idFichier';
    protected $fillable = [
        'idFichier',
        'nomOriginal',
        'path',
        'slugSource',
        'filename',
        'slug',
    ];
}
