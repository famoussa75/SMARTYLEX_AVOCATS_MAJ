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
        Schema::create('citations', function (Blueprint $table) {
            $table->charset = 'utf8';
            $table->collation = 'utf8_unicode_ci';

            $table->increments('idCitation');
            $table->unsignedInteger('idActe');
            $table->foreign('idActe')->references('idActe')->on('acte_introductifs')->onDelete('cascade');
            $table->string('dateSignification');
            $table->text('personneCharger');
            $table->unsignedInteger('idHuissier')->nullable();
            $table->foreign('idHuissier')->references('idHss')->on('huissiers')->onDelete('cascade');
            $table->string('numRg');
            $table->string('dateCitation')->nullable();
            $table->string('dateAudience')->nullable();
            $table->text('lieuAudience')->nullable();
            $table->text('slug')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('citations');
    }
};
