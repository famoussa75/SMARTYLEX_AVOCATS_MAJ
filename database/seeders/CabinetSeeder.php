<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class CabinetSeeder extends Seeder
{
    public function run()
    {
        DB::table('cabinets')->insert([
            //'id' => Str::uuid(),
            'nomCabinet' => 'Cabinet Juridique ASK AVOCAT',
            'nomCourt' => 'ASK AVOCAT',
            'emailContact' => 'contact@smartylex.com',
            'cleContact' => 'cle-contact-123',
            'adresseCabinet' => '123 Rue de la Loi, Dakar',
            'tel1' => '+221 33 123 45 67',
            'tel2' => '+221 77 123 45 67',
            'siteweb' => 'https://smartylex.com',
            'nif' => 'NIF123456789',
            'numTva' => 'TVA987654321',
            'termesFacture' => 'Paiement sous 30 jours',
            'monnaieParDefaut' => 'XOF',
            'logo' => 'logo.png',
            'slogan' => 'Votre partenaire juridique',
            'numToge' => 'TOGE-001',
            'totalComptes' => '5',
            'emailAudience' => 'audience@smartylex.com',
            'cleAudience' => 'cle-audience-456',
            'piedPage' => '© 2024 CJ Alpha',
            'emailFinance' => 'finance@smartylex.com',
            'cleFinance' => 'cle-finance-789',
            'signature' => 'signature.png',
            'rapportTache' => 'Rapport mensuel',
            'frequenceRapport' => 'Mensuel',
            'plan' => 'Premium',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
