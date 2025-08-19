<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TacheFilles extends Model
{
    use HasFactory;
    protected $primaryKey = 'idTacheFille';
    protected $fillable = [
        'idTacheFille',
        'idTache',
        'slugTache',
        'idClient',
        'idAffaire',
        'idTypeTache',
        'titre',
        'description',
        'dateDebut',
        'dateFin',
        'point',
        'statut',
        'categorie',
        'priorite',
        'niveau', // fille ou parent
        'slug', // transfert de slug de la table fille a la table parente
    ];

    public function TacheFilleTable()
    {
        return $this->hasMany(TachePersonnelFilles::class);
    }

    public function Tache()
    {
        return $this->belongsTo(Taches::class);
    }

}
