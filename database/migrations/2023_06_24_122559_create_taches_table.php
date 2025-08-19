<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTachesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('taches', function (Blueprint $table) {
            $table->charset = 'utf8';
            $table->collation = 'utf8_unicode_ci';

            $table->increments('idTache');
            $table->unsignedInteger('idAffaire')->nullable();
            $table->unsignedInteger('idClient')->nullable();
            $table->unsignedInteger('idTypeTache');
            $table->foreign('idAffaire')->references('idAffaire')->on('affaires')->onDelete('cascade');
            $table->foreign('idClient')->references('idClient')->on('clients')->onDelete('cascade');
            $table->foreign('idTypeTache')->references('idTypeTache')->on('type_taches')->onDelete('cascade');
            $table->text('titre');
            $table->text('description')->nullable();
            $table->string('dateDebut');
            $table->string('dateFin');
            $table->bigInteger('point');
            $table->string('statut');
            $table->string('categorie');
            $table->string('priorite');
            $table->string('courrierTache')->nullable();
            $table->string('audTache')->nullable();
            $table->string('idSuivit')->nullable();
            $table->string('idSuivitRequete')->nullable();
            $table->text('slugFille')->nullable();
            $table->text('created_by')->nullable();
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
        Schema::dropIfExists('taches');
    }
}
