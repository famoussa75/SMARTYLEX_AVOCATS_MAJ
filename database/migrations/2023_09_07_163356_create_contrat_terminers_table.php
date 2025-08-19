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
        Schema::create('contrat_terminers', function (Blueprint $table) {
            $table->charset = 'utf8';
            $table->collation = 'utf8_unicode_ci';

            $table->increments('idContratTerminer');
            $table->unsignedInteger('idPersonnelCabinet')->nullable();
            $table->unsignedInteger('idPersonnelClient')->nullable();
            $table->foreign('idPersonnelCabinet')->references('idPersonnel')->on('personnels');
            $table->foreign('idPersonnelClient')->references('idPersonnelClient')->on('personnel_clients');
            $table->text('dateTerminer');
            $table->text('motif')->nullable();
            $table->text('slug')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contrat_terminers');
    }
};
