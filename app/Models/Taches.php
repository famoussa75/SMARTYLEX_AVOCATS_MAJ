<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Taches extends Model
{
    use HasFactory;
    protected $primaryKey = 'idTache';
    protected $fillable = [
        'idTache',
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
        'slugFille',
        'courrierTache',
        'audTache',
        'idSuivit',
        'created_by',
        'slug',
    ];

    public function TacheFille()
    {
        return $this->hasMany(TacheFilles::class);
    }
    public function Traitement()
    {
        return $this->hasMany(TraitementTaches::class);
    }
    public function TachePersonnel()
    {
        return $this->hasMany(TachePersonnels::class);
    }
}
