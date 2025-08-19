<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContraditoiresLiers extends Model
{
    protected $table = 'contraditoire_liers';
    protected $primaryKey = 'idContraditoireLier';
    protected $fillable = [
        'idContraditoireLier',
        'contraditoires',
        'slugProcedure',
        'slug',
    ];
    use HasFactory;
}
