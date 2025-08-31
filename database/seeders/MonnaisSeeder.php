<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class MonnaisSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
            // Insérez des données dans la table
            DB::table('monnaies')->insert([
                //'id' => Str::uuid(),
                'description' => 'GNF',
                'symbole' => 'GNF',
                'tauxEchangeGn' => 'GNF/GNF',
                'valeurTaux' => 1,
            'created_at' => now(),
            'updated_at' => now(),
            ]);

            DB::table('monnaies')->insert([
                //'id' => Str::uuid(),
                'description' => 'EURO',
                'symbole' => '€',
                'tauxEchangeGn' => 'EURO/GNF',
                'valeurTaux' => 9389.73,
            'created_at' => now(),
            'updated_at' => now(),
            ]);

            DB::table('monnaies')->insert([
                //'id' => Str::uuid(),
                'description' => 'USD',
                'symbole' => '$',
                'tauxEchangeGn' => 'USD/GNF',
                'valeurTaux' => 8593.57,
            'created_at' => now(),
            'updated_at' => now(),
            ]);

            DB::table('monnaies')->insert([
                //'id' => Str::uuid(),
                'description' => 'FCFA',
                'symbole' => 'FCFA',
                'tauxEchangeGn' => 'FCFA/GNF',
                'valeurTaux' => 14.20,
            'created_at' => now(),
            'updated_at' => now(),
            ]);
    }
}
