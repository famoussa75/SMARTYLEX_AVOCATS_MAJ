<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AutreActes extends Model
{
    use HasFactory;
    protected $primaryKey = 'idAutreActe';
    protected $fillable = [
        'idAutreActe',
        'idActe',
        'mention',
        'valeur',
        'slug',
    ];
}
