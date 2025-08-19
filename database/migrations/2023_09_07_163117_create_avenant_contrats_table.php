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
        Schema::create('avenant_contrats', function (Blueprint $table) {
            $table->charset = 'utf8';
            $table->collation = 'utf8_unicode_ci';

            $table->increments('idAvenant');
            $table->unsignedInteger('idPersonnelCabinet')->nullable();
            $table->unsignedInteger('idPersonnelClient')->nullable();
            $table->foreign('idPersonnelCabinet')->references('idPersonnel')->on('personnels');
            $table->foreign('idPersonnelClient')->references('idPersonnelClient')->on('personnel_clients');
            $table->text('dateAvenant');
            $table->text('nature')->nullable();
            $table->text('slug')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('avenant_contrats');
    }
};
