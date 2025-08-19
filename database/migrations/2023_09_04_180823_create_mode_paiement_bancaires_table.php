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
        Schema::create('mode_paiement_bancaires', function (Blueprint $table) {
            $table->charset = 'utf8';
            $table->collation = 'utf8_unicode_ci';

            $table->increments('idModePaiementBank');
            $table->unsignedInteger('idFacture');
            $table->unsignedInteger('idCompteBank');
            $table->foreign('idFacture')->references('idFacture')->on('factures')->onDelete('cascade');
            $table->foreign('idCompteBank')->references('idCompteBank')->on('compte_bancaires');
            $table->text('slug')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mode_paiement_bancaires');
    }
};
