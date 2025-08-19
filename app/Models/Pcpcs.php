<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pcpcs extends Model
{
    use HasFactory;
    protected $primaryKey = 'idPcpc';
    protected $fillable = [
        'idPcpc',
        'idActe',
        'reference',
        'datePcpc',
        'dateProchaineAud',
        'slug',
    ];
}
