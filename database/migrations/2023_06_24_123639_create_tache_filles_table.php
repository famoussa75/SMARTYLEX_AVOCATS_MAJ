<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTacheFillesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tache_filles', function (Blueprint $table) {
            $table->charset = 'utf8';
            $table->collation = 'utf8_unicode_ci';

            $table->increments('idTacheFille');
           
            $table->unsignedInteger('idAffaire')->nullable();
            $table->unsignedInteger('idClient')->nullable();
            $table->unsignedInteger('idTypeTache');
            $table->unsignedInteger('idTache')->nullable();
            $table->text('slugTache')->nullable();
            $table->foreign('idTache')->references('idTache')->on('taches')->onDelete('cascade');
            $table->foreign('idAffaire')->references('idAffaire')->on('affaires')->onDelete('cascade');
            $table->foreign('idClient')->references('idClient')->on('clients')->onDelete('cascade');
            $table->foreign('idTypeTache')->references('idTypeTache')->on('type_taches');
            $table->text('titre');
            $table->text('description')->nullable();
            $table->string('dateDebut')->nullable();
            $table->string('dateFin')->nullable();
            $table->bigInteger('point');
            $table->string('statut');
            $table->string('categorie');
            $table->string('priorite');
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
        Schema::dropIfExists('tache_filles');
    }
}
