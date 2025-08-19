<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ActeIntroductifs extends Model
{
    use HasFactory;
    protected $primaryKey = 'idActe';
    protected $fillable = [
        'idActe',
        'typeActe',
        'idNatureAction',
        'idAudience',
        'slug',
    ];
}
