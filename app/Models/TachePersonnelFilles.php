<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TachePersonnelFilles extends Model
{
    use HasFactory;
    protected $primaryKey = 'idTachePersFille';
    protected $fillable = [
        'idTachePersFille',
        'idTacheFille',
        'idPersonnel',
        'slug',
    ];

    public function TacheFilleTable()
    {
        return $this->belongsTo(TacheFilles::class);
    }
}
