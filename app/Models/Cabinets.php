<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cabinets extends Model
{
    use HasFactory;
    protected $primaryKey = 'id';
    protected $fillable = [
        'id',
        'nomCabinet',
        'nomCourt',
        'emailContact',
        'cleContact',
        'emailAudience',
        'cleAudience',
        'emailFinance',
        'cleFinance',
        'piedPage',
        'adresseCabinet',
        'tel1',
        'tel2',
        'siteweb',
        'nif',
        'termesFacture',
        'numTva',
        'numToge',
        'monnaieParDefaut',
        'logo',
        'slogan',
        'totalComptes',
        'rapportTache',
        'frequenceRapport',
        'signature',
        'plan',
    ];
}
