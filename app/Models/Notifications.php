<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notifications extends Model
{
    use HasFactory;
    protected $primaryKey = 'id';
    protected $fillable = [
        'categorie',
        'messages',
        'etat',
        'idRecepteur',
        'a_biper',
        'slug',
        'urlName',
        'urlParam',
        'idAdmin',
    ];
    use HasFactory;
}