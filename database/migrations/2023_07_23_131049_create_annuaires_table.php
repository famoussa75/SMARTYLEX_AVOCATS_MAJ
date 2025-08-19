<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('annuaires', function (Blueprint $table) {

            $table->charset = 'utf8';
            $table->collation = 'utf8_unicode_ci';

            $table->increments('id');
            $table->text('societe')->nullable();  
            $table->text('prenom_et_nom')->nullable();  
            $table->text('poste_de_responsabilite')->nullable(); 
            $table->text('telephone')->nullable(); 
            $table->text('email')->nullable();
            $table->unsignedInteger('idClient')->nullable();
            $table->foreign('idClient')->references('idClient')->on('clients')->onDelete('cascade');

            $table->timestamps();
            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('annuaires');
    }
};
