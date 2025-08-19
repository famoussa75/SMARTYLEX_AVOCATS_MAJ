<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePersonneAdversesRequetesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('personne_adverses_requetes', function (Blueprint $table) {
            $table->charset = 'utf8';
            $table->collation = 'utf8_unicode_ci';
            
            $table->increments('idPersonneAdverse');
            $table->unsignedInteger('idPartie');
            $table->foreign('idPartie')->references('idPartie')->on('parties_requetes')->onDelete('cascade');
            $table->string('prenom');
            $table->string('nom');
            $table->string('telephone')->nullable();
            $table->string('nationalite');
            $table->string('profession')->nullable();
            $table->string('dateNaissance')->nullable();
            $table->string('lieuNaissance')->nullable();
            $table->string('pays');
            $table->string('domicile');
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
        Schema::dropIfExists('personne_adverses_requetes');
    }
}
