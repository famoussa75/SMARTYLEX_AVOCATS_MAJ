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
        Schema::create('suivit_audience_appels', function (Blueprint $table) {
            $table->charset = 'utf8';
            $table->collation = 'utf8_unicode_ci';

            $table->increments('idSuivitAppel');
            $table->unsignedInteger('idAudience');
            $table->foreign('idAudience')->references('idAudience')->on('audiences')->onDelete('cascade');
            $table->text('acte');
            $table->string('dateActe')->nullable();
            $table->string('dateReception')->nullable();
            $table->text('dateLimite')->nullable();
           $table->time('heure')->nullable();
            $table->string('email')->nullable();
            $table->text('slug')->nullable();
            $table->text('suiviPar')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('suivit_audience_appels');
    }
};
