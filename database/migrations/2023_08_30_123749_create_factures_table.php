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
        Schema::create('factures', function (Blueprint $table) {

            $table->charset = 'utf8';
            $table->collation = 'utf8_unicode_ci';

            $table->increments('idFacture');
            $table->unsignedInteger('idClient');
            $table->unsignedInteger('idAffaire');
            $table->foreign('idClient')->references('idClient')->on('clients')->onDelete('cascade');
            $table->foreign('idAffaire')->references('idAffaire')->on('affaires')->onDelete('cascade');
            $table->text('dateFacture');
            $table->date('dateEcheance');
            $table->double('montantHT');
            $table->double('montantTVA');
            $table->double('montantTTC');
            $table->text('statut');
            $table->text('monnaie');
            $table->text('notification')->nullable();
            $table->text('rappel')->nullable();
            $table->text('slug')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('factures');
    }
};
