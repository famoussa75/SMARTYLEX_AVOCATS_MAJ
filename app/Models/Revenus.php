<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Revenus extends Model
{
    protected $primaryKey = 'idRevenus';
    protected $fillable = [
        'idRevenus',
        'montant',
        'slug',
    ];
    use HasFactory;
}
