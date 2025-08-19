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
        Schema::create('paiement_factures', function (Blueprint $table) {
            $table->charset = 'utf8';
            $table->collation = 'utf8_unicode_ci';

            $table->increments('idPaiementFacture');
            $table->unsignedInteger('idFacture')->nullable();
            $table->foreign('idFacture')->references('idFacture')->on('factures')->onDelete('cascade');
            $table->text('datePaiement');
            $table->double('montantPayer');
            $table->double('montantRestant')->nullable();
            $table->text('methodePaiement')->nullable();
            $table->text('banqueCheque')->nullable();
            $table->text('numeroCheque')->nullable();
            $table->text('dateVirement')->nullable();
            $table->text('statut')->nullable();
            $table->text('slug')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('paiement_factures');
    }
};
