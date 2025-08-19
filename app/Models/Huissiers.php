<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Huissiers extends Model
{
    protected $primaryKey = 'idHss';
    protected $fillable = [
        'idHss',
        'prenomHss',
        'nomHss',
        'telHss_1',
        'telHss_2',
        'emailHss',
        'adresseHss',
        'rattachement',
        'slug',
    ];


    use HasFactory;
}