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
        Schema::create('paiements', function (Blueprint $table) {
            $table->charset = 'utf8';
            $table->collation = 'utf8_unicode_ci';

            $table->increments('idPaiement');
            $table->unsignedInteger('idFacture');
            $table->foreign('idFacture')->references('idFacture')->on('factures')->onDelete('cascade');
            $table->string('methode');
            $table->string('numCompte')->nullable();
            $table->double('montantPayer');
            $table->double('reste');
            $table->text('slug')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('paiements');
    }
};
