<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailFactures extends Model
{
    protected $primaryKey = 'idDetailFacture';
    protected $fillable = [
        'idDetailFacture',
        'idFacture',
        'designation',
        'prix',
        'slug',
    ];
    use HasFactory;
}
