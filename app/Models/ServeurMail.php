<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServeurMail extends Model
{
    use HasFactory;
    protected $primaryKey = 'idServeur';
    protected $fillable = [
        'idServeur',
        'nom',
        'host',
        'smtpSecure',
        'smtpPort',
    ];
}
