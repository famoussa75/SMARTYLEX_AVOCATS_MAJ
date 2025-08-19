<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Representants extends Model
{
    use HasFactory;
    protected $primaryKey = 'idRepresentant';
    protected $fillable = [
        'idRepresentant',
        'prenom',
        'nom',
        'email',
        'telephone',
        'slug',
    ];
}
