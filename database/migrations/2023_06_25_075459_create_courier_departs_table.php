<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCourierDepartsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('courier_departs', function (Blueprint $table) {
            $table->charset = 'utf8';
            $table->collation = 'utf8_unicode_ci';

            $table->increments('idCourierDep');
            $table->unsignedInteger('idAffaire')->nullable();
            $table->unsignedInteger('idClient')->nullable();
            $table->unsignedInteger('idPersonnel');
            $table->foreign('idAffaire')->references('idAffaire')->on('affaires')->onDelete('cascade');
            $table->foreign('idClient')->references('idClient')->on('clients')->onDelete('cascade');
            $table->foreign('idPersonnel')->references('idPersonnel')->on('personnels')->onDelete('cascade');
            $table->text('objet');
            $table->string('destinataire');
            $table->string('dateCourier');
            $table->string('dateEnvoi')->nullable();
            $table->string('dateReception')->nullable();
            $table->text('expediteur');
            $table->bigInteger('numCourier');
            $table->string('numeroRecu')->nullable();
            $table->string('courrierTache')->nullable();
            $table->string('statut');
            $table->string('niveau');
            $table->text('consignes')->nullable();
            $table->text('accuse_reception')->nullable();
            $table->text('nomPersonne')->nullable();
            $table->text('telephonePersonne')->nullable();
            $table->text('partieAdverse')->nullable();
            $table->text('motif')->nullable();
            $table->text('jugement')->nullable();
            $table->text('courAppel')->nullable();
            $table->text('dateProcesVerbal')->nullable();
            $table->text('typeModel')->nullable();
            $table->text('signataire')->nullable();
            $table->string('confidentialite')->nullable();
            $table->text('slug')->nullable();
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('courier_departs');
    }
}
