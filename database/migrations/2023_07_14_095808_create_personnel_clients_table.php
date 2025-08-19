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
        Schema::create('personnel_clients', function (Blueprint $table) {
            $table->charset = 'utf8';
            $table->collation = 'utf8_unicode_ci';

            $table->increments('idPersonnelClient');
            $table->unsignedInteger('idClient');
            $table->foreign('idClient')->references('idClient')->on('clients')->onDelete('cascade');
            $table->text('matricule')->nullable();
            $table->text('prenomEtNom')->nullable();
            $table->text('statutContrat')->nullable();
            $table->text('filiation')->nullable();
            $table->text('sexe')->nullable();
            $table->text('prefix')->nullable();
            $table->text('statutMatrimonial')->nullable();
            $table->text('dateNaissance')->nullable();
            $table->text('lieuNaissance')->nullable();
            $table->text('paysNaissance')->nullable();
            $table->text('residence')->nullable();
            $table->text('telephone')->nullable();
            $table->text('numPiece')->nullable();
            $table->text('naturePiece')->nullable();
            $table->text('dateExPiece')->nullable();
            $table->text('nationalite')->nullable();
            $table->text('profession')->nullable();
            $table->text('fonction')->nullable();
            $table->text('departement')->nullable();
            $table->text('grade')->nullable();
            $table->text('dateEmbauche')->nullable();
            $table->text('typeContrat')->nullable();
            $table->text('dureeContrat')->nullable();
            $table->text('dureePeriodeEssai')->nullable();
            $table->text('lieuExecutionContrat')->nullable();
            $table->text('prorogationRenouvelement')->nullable();
            $table->text('dateFinContrat')->nullable();
            $table->text('motifFinContrat')->nullable();
            $table->text('numSecuriteSociale')->nullable();
            $table->text('datePremiereImmatriculation')->nullable();
            $table->text('salaireBrut')->nullable();
            $table->text('salaireBase')->nullable();
            $table->text('primePanier')->nullable();
            $table->text('primeLogement')->nullable();
            $table->text('primeTransport')->nullable();
            $table->text('primeCherteVie')->nullable();
            $table->text('primeSalissure')->nullable();
            $table->text('primeRisque')->nullable();
            $table->text('primeEloignement')->nullable();
            $table->text('primeResponsabilite')->nullable();
            $table->text('primeAnciennete')->nullable();
            $table->text('dateSignatureContrat')->nullable();
            $table->text('lieuSignature')->nullable();
           
            $table->text('slug')->nullable();  
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('personnel_clients');
    }
};
