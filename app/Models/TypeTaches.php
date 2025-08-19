<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TypeTaches extends Model
{
    use HasFactory;
    protected $primaryKey = 'idTypeTache';
    protected $fillable = [
        'idTypeTache',
        'descriptionType',
        'slug',
    ];
}
