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
        Schema::create('cabinets', function (Blueprint $table) {
            $table->charset = 'utf8';
            $table->collation = 'utf8_unicode_ci';

            $table->increments('id');
            $table->text('nomCabinet');  
            $table->text('nomCourt')->nullable();  
            $table->text('emailContact')->nullable(); 
            $table->text('cleContact')->nullable(); 
            $table->text('adresseCabinet')->nullable(); 
            $table->text('tel1')->nullable(); 
            $table->text('tel2')->nullable(); 
            $table->text('siteweb')->nullable(); 
            $table->text('nif')->nullable(); 
            $table->text('numTva')->nullable();
            $table->text('termesFacture')->nullable();
            $table->text('monnaieParDefaut')->nullable();
            $table->text('logo')->nullable();
            $table->text('slogan')->nullable();
            $table->text('numToge')->nullable();
            $table->text('totalComptes')->nullable();
            $table->text('emailAudience')->nullable();
            $table->text('cleAudience')->nullable();
            $table->text('piedPage')->nullable();
            $table->text('emailFinance')->nullable();
            $table->text('cleFinance')->nullable();
            $table->text('signature')->nullable();
            $table->text('rapportTache')->nullable();
            $table->text('frequenceRapport')->nullable();
            $table->text('plan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cabinets');
    }
};
