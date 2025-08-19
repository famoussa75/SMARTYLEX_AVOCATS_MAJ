<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NatureActions extends Model
{
    use HasFactory;
    protected $primaryKey = 'idNatureAction';
    protected $fillable = [
        'idNatureAction',
        'natureAction',
        'delaiAction',
        'depart',
        'matiereConcerne',
        'baseLegale',
        'slug'
    ];
}
