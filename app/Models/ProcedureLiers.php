<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProcedureLiers extends Model
{
    protected $table = 'procedure_liers'; 
    protected $primaryKey = 'idProcedureLier';
    protected $fillable = [
        'idProcedureLier',
        'typeProcedure',
        'slugProcedure',
        'slugSource',
        'slug',
    ];
    use HasFactory;
}
