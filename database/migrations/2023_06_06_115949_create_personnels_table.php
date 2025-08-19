<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePersonnelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('personnels', function (Blueprint $table) {
            $table->charset = 'utf8';
            $table->collation = 'utf8_unicode_ci';

            $table->increments('idPersonnel');
            $table->string('matricules');
            $table->string('ssn')->nullable();
            $table->string('prenom');
            $table->string('nom');
            $table->string('sexe');
            $table->string('fonction');
            $table->string('adresse');
            $table->text('nomPersonneUrgence')->nullable();
            $table->string('telPersonneUrgence')->nullable();
            $table->string('dateNaissance')->nullable();
            $table->string('telephone');
            $table->string('salaire')->nullable();
            $table->string('numeroUrgence')->nullable();
            $table->string('email');
            $table->string('photo')->nullable();
            $table->bigInteger('score')->nullable();
            $table->string('initialPersonnel');
            $table->text('slug');
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
        Schema::dropIfExists('personnels');
    }
}
