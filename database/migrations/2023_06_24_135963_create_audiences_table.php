<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAudiencesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('audiences', function (Blueprint $table) {
            $table->charset = 'utf8';
            $table->collation = 'utf8_unicode_ci';
            
            $table->increments('idAudience');
            $table->unsignedInteger('idAffaire')->nullable();
            $table->unsignedInteger('idClient')->nullable();
            $table->foreign('idAffaire')->references('idAffaire')->on('affaires')->onDelete('cascade');
            $table->foreign('idClient')->references('idClient')->on('clients')->onDelete('cascade');
            $table->string('juridiction');
            $table->string('dateCreation');
            $table->string('niveauProcedural');
            $table->text('nature');
            $table->text('pieceInstruction')->nullable();
            $table->text('objet');
            $table->string('numRg')->nullable();
            $table->string('statut')->nullable();
            $table->text('createur')->nullable();
            $table->unsignedInteger('isChild')->nullable();
            $table->unsignedInteger('slugJonction')->nullable();
            $table->text('slug')->nullable();
            $table->text('prochaineAudience')->nullable();
           $table->time('heure')->nullable();
            $table->text('typeProcedure')->nullable();
            $table->text('orientation')->nullable();
            $table->text('requeteLier')->nullable();
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
        Schema::dropIfExists('audiences');
    }
}
