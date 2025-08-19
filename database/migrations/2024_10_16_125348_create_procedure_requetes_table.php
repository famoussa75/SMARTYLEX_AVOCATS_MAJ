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
        Schema::create('procedure_requetes', function (Blueprint $table) {
            $table->charset = 'utf8';
            $table->collation = 'utf8_unicode_ci';

            $table->increments('idProcedure');
            $table->unsignedInteger('idAudience')->nullable();
            $table->foreign('idAudience')->references('idAudience')->on('audiences')->onDelete('cascade');
            $table->text('typeRequete')->nullable();
            $table->text('juridictionPresidentielle')->nullable();
            $table->unsignedInteger('idAvocatRequete')->nullable();
            $table->foreign('idAvocatRequete')->references('idAvc')->on('avocats')->onDelete('cascade');
            $table->text('identiteRequerent')->nullable();
            $table->date('dateRequete')->nullable();
            $table->text('demandeRequete')->nullable();
            $table->string('dateArriver')->nullable();
            $table->string('numRgRequete')->nullable();
            $table->string('juridiction');
            $table->text('objet');
            $table->text('requeteLier')->nullable();
            $table->text('createur')->nullable();
            $table->text('statut')->nullable();
            $table->text('rappel')->nullable();
            $table->text('natureObligation')->nullable();
            $table->text('designationBien')->nullable();
            $table->text('montantReclamer')->nullable();
            $table->text('slug')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('procedure_requetes');
    }
};
