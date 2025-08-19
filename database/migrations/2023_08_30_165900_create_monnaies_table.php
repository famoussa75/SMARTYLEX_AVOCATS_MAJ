<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;


return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('monnaies', function (Blueprint $table) {
            $table->charset = 'utf8';
            $table->collation = 'utf8_unicode_ci';
            
            $table->increments('idMonnaie');
            $table->text('description')->nullable();
            $table->text('symbole')->nullable();
            $table->text('tauxEchangeGn')->nullable();
            $table->double('valeurTaux')->nullable();
            $table->timestamps();
        });

            // Insérez des données dans la table
            DB::table('monnaies')->insert([
                'description' => 'GNF',
                'symbole' => 'GNF',
                'tauxEchangeGn' => 'GNF/GNF',
                'valeurTaux' => 1,
            ]);

            DB::table('monnaies')->insert([
                'description' => 'EURO',
                'symbole' => '€',
                'tauxEchangeGn' => 'EURO/GNF',
                'valeurTaux' => 9389.73,
            ]);

            DB::table('monnaies')->insert([
                'description' => 'USD',
                'symbole' => '$',
                'tauxEchangeGn' => 'USD/GNF',
                'valeurTaux' => 8593.57,
            ]);

            DB::table('monnaies')->insert([
                'description' => 'FCFA',
                'symbole' => 'FCFA',
                'tauxEchangeGn' => 'FCFA/GNF',
                'valeurTaux' => 14.20,
            ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('monnaies');
    }
};