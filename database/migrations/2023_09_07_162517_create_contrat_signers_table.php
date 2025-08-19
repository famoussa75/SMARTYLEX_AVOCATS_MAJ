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
        Schema::create('contrat_signers', function (Blueprint $table) {
            $table->charset = 'utf8';
            $table->collation = 'utf8_unicode_ci';

            $table->increments('idContratSigner');
            $table->unsignedInteger('idPersonnelCabinet')->nullable();
            $table->unsignedInteger('idPersonnelClient')->nullable();
            $table->foreign('idPersonnelCabinet')->references('idPersonnel')->on('personnels');
            $table->foreign('idPersonnelClient')->references('idPersonnelClient')->on('personnel_clients');
            $table->text('dateSignature');
            $table->text('accordConf')->nullable();
            $table->text('dateAccord')->nullable();
            $table->text('slug')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contrat_signers');
    }
};
