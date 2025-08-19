<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Requisitoires extends Model
{
    use HasFactory;
    protected $primaryKey = 'idRequisitoire';
    protected $fillable = [
        'idRequisitoire',
        'idActe',
        'numInstruction',
        'procureur',
        'chefAccusation',
        'slug',
    ];
}
