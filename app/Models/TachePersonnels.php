<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TachePersonnels extends Model
{
    use HasFactory;
    protected $primaryKey = 'idTachePersonnel';
    protected $fillable = [
        'idTachePersonnel',
        'idTache',
        'idPersonnel',
        'fonction',
        'rappel',
        'slug',
    ];

    public function Tache()
    {
        return $this->belongsTo(Taches::class);
    }
}
