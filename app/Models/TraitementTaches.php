<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TraitementTaches extends Model
{
    use HasFactory;
    protected $primaryKey = 'idTraitement';
    protected $fillable = [
        'idTraitement',
        'idTache',
        'idPersonnel',
        'description',
        'type',
        'uniteTime',
        'timesheet',
        'initialAdmin',
        'slug',
    ];

    public function Tache()
    {
        return $this->belongsTo(Taches::class);
    }
}
