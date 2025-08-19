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
        Schema::create('compte_bancaires', function (Blueprint $table) {
            $table->charset = 'utf8';
            $table->collation = 'utf8_unicode_ci';

            $table->increments('idCompteBank');
            $table->unsignedInteger('idCabinet');
            $table->foreign('idCabinet')->references('id')->on('cabinets');
            $table->text('nomBank')->nullable();
            $table->text('devise')->nullable();
            $table->text('codeBank')->nullable();
            $table->text('codeGuichet')->nullable();
            $table->text('numCompte')->nullable();
            $table->text('cleRib')->nullable();
            $table->text('iban')->nullable();
            $table->text('codeBic')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('compte_bancaires');
    }
};
