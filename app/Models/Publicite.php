<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Publicite extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'titre',
        'image',
        'lien',
        'statut',
        'debut',
        'fin'
    ];

    protected $casts = [
        'debut' => 'date',
        'fin' => 'date'
    ];
}